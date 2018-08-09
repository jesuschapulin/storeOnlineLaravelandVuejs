<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Productos;
use App\Inventario;
use App\Categorias_productos;
use Illuminate\Support\Facades\DB;
use Image;

class productosController extends Controller{
    public function get_productos(){
    	return Productos::orderBy('id_producto','DESC')->get();
    }
    public function get_categoria(Request $request){
        $id_categoria=$request->id_categoria;
        $categorias = DB::table('categorias_productos')->select('descripcion')->where(function($query) use($id_categoria){
                            $query  ->where('id_categoria_productos','=',$id_categoria);
                        })->first();
        
        return response()->json(['descripcion'=>$categorias->descripcion]);
        
    }
    public function getProductsDash(){
        $array=DB::table('inventarios')
            ->join('productos','productos.id_producto','=','inventarios.id_producto')
            ->select('productos.id_producto','productos.nombre','productos.precio_unitario','productos.precio_volumen','productos.id_categorias_productos','productos.gramage','productos.tipo_peso','productos.imagen','inventarios.cantidad_disponible')
            ->get();
        return response()->json($array);
    }
    public function getCategorias(){
        return Categorias_productos::orderBy('descripcion')->get();
    }
    public function registerNewProduct(Request $request){
        try{
        	$nombre=$request->nombre;
            $precio_unitario=$request->precio_unitario;
            $precio_volumen=$request->precio_volumen;
            $categoria=$request->categoria;
            $gramage=$request->gramage;
            $tipo_peso=$request->tipo_peso;
            if($request->hasFile('imageProduct')){
                $archivo=$request->file('imageProduct');
                $filename=time().'.'.$archivo->getClientOriginalExtension();
                $img=Image::make($archivo);
                if($img!=null){
                    $array = DB::table('productos')->select('id_producto','nombre')->where(function($query) use($nombre){
                            $query  ->where('nombre','=',$nombre);
                        })->first();
                    if($array==null){
                        $categorias = DB::table('categorias_productos')->select('id_categoria_productos')->where(function($query) use($categoria){
                            $query  ->where('descripcion','=',$categoria);
                        })->first();
                        $id_categoria=$categorias->id_categoria_productos;
                        $img->resize(655,368);
                        $img->save(public_path('/images/'.$filename));
                        Productos::create([
                            'nombre' => $nombre,
                            'precio_unitario' => $precio_unitario,
                            'precio_volumen' => $precio_volumen,
                            'id_categorias_productos' =>$id_categoria,
                            'gramage'=>$gramage,
                            'imagen'=>$filename,
                            'tipo_peso'=>$tipo_peso
                        ]);
                        $producto = DB::table('productos')->select('id_producto')->where(function($query) use($nombre){
                            $query  ->where('nombre','=',$nombre);
                        })->first();
                        $id_producto=$producto->id_producto;
                        Inventario::create([
                            'id_producto' => $id_producto,
                            'cantidad_registro' => '0',
                            'cantidad_disponible' => '0',
                            'id_usuario' =>'0'
                        ]);
                        return response()->json(['messageSuccess'=>'producto creado exitosamente']);
                    }else{
                        return response()->json(['messageError'=>'el nombre del producto ya esta registrado, use uno diferente']);
                    }
                }
            }else{
                return response()->json(['messageError'=>'selecciona una imagen']);
            }
        }catch(\Illuminate\Database\QueryException $e){
                dd($e);

        }catch(PDOException $e){
            dd($e);
        }
    }
    public function updateProduct(Request $request){
        try{
            $originalName=$request->originalName;
            $nombre=$request->nombre;
            $precio_unitario=$request->precio_unitario;
            $precio_volumen=$request->precio_volumen;
            $categoria=$request->categoria;
            $gramage=$request->gramage;
            $tipo_peso=$request->tipo_peso;
            $message=$request->message;
            if($message=='sameImage'){
                $producto = DB::table('productos')->select('id_producto')->where(function($query) use($originalName){
                            $query  ->where('nombre','=',$originalName);
                        })->first();
                $id_producto=$producto->id_producto;
                if($id_producto){
                    $categorias = DB::table('categorias_productos')->select('id_categoria_productos')->where(function($query) use($categoria){
                            $query  ->where('descripcion','=',$categoria);
                        })->first();
                    $id_categoria=$categorias->id_categoria_productos;
                    if($id_categoria){

                        $productosTable = DB::table('productos')->select('imagen')->where(function($query) use($id_producto){
                                        $query  ->where('id_producto','=',$id_producto);
                                    })->first();
                        $filename=$productosTable->imagen;
                        if($filename){
                            DB::table('productos')
                                ->where('id_producto','=',$id_producto)
                                ->update([
                                            'nombre' => $nombre,
                                            'precio_unitario' => $precio_unitario,
                                            'precio_volumen' => $precio_volumen,
                                            'id_categorias_productos' =>$id_categoria,
                                            'gramage'=>$gramage,
                                            'imagen'=>$filename,
                                            'tipo_peso'=>$tipo_peso
                                ]);
                            return response()->json(['messageSuccess'=>'producto actualizado']);
                        }
                        else{
                            return response()->json(['messageError'=>'imagen vacia']);
                        }
                    }else{
                        return response()->json(['messageError'=>'categoria vacia']);
                    }
                }else{
                    return response()->json(['messageError'=>'id_producto vacio']);
                }
            }
            else if($request->hasFile('imageProduct')){
                $archivo=$request->file('imageProduct');
                $filename=time().'.'.$archivo->getClientOriginalExtension();
                $img=Image::make($archivo);
                if($img!=null){
                    $productosTable = DB::table('productos')->select('id_producto')->where(function($query) use($originalName){
                            $query  ->where('nombre','=',$originalName);
                        })->first();
                    $id_producto=$productosTable->id_producto;
                    if($nombre==$originalName){
                        $categorias = DB::table('categorias_productos')->select('id_categoria_productos')->where(function($query) use($categoria){
                            $query  ->where('descripcion','=',$categoria);
                        })->first();
                        $id_categoria=$categorias->id_categoria_productos;
                        $img->resize(655,368);
                        $img->save(public_path('/images/'.$filename));
                        DB::table('productos')
                                ->where('id_producto','=',$id_producto)
                                ->update([
                                            'nombre' => $nombre,
                                            'precio_unitario' => $precio_unitario,
                                            'precio_volumen' => $precio_volumen,
                                            'id_categorias_productos' =>$id_categoria,
                                            'gramage'=>$gramage,
                                            'imagen'=>$filename,
                                            'tipo_peso'=>$tipo_peso
                                ]);
                        return response()->json(['messageSuccess'=>'producto actualizado con imagen nueva']);
                    }else{
                        $productosTable = DB::table('productos')->select('id_producto','nombre')->where(function($query) use($nombre){
                            $query  ->where('nombre','=',$nombre);
                        })->first();
                        $nameProduct=$productosTable->nombre;
                        if($nameProduct==null){
                            DB::table('productos')
                                ->where('id_producto','=',$id_producto)
                                ->update([
                                            'nombre' => $nombre,
                                            'precio_unitario' => $precio_unitario,
                                            'precio_volumen' => $precio_volumen,
                                            'id_categorias_productos' =>$id_categoria,
                                            'gramage'=>$gramage,
                                            'imagen'=>$filename,
                                            'tipo_peso'=>$tipo_peso
                                ]);
                            return response()->json(['messageSuccess'=>'producto actualizado con nombre nuevo']);
                        }else{
                            return response()->json(['messageError'=>'El nombre ya lo tiene asignado otro producto, modifiquelo para guardar']);
                        }
                        
                    }
                }
            }else{
                return response()->json(['messageError'=>'selecciona una imagen']);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
                dd($e);

        }catch(PDOException $e){
            dd($e);
        }  

    }
    public function createCategoria(Request $request){
        $nombre=$request->nombre;
        $categoriasTable = DB::table('categorias_productos')->select('id_categoria_productos')->where(function($query) use($nombre){
                            $query  ->where('descripcion','=',$nombre);
                        })->first();
        if($categoriasTable==null){
            if($request->hasFile('imageCategoria')){
                    $archivo=$request->file('imageCategoria');
                    $filename=time().'.'.$archivo->getClientOriginalExtension();
                    $img=Image::make($archivo);
                    if($img!=null){
                        try{
                            $img->resize(655,368);
                            $img->save(public_path('/images/logos/'.$filename));
                            Categorias_productos::create([
                                    'descripcion' => $nombre,
                                    'imagen' => $filename,
                                ]);
                            return response()->json(['messageSuccess'=>'imagen llena']);
                        }
                        catch(\Illuminate\Database\QueryException $e){
                                dd($e);

                        }catch(PDOException $e){
                            dd($e);
                        } 
                    }
            }else{
                return response()->json(['messageError'=>'imagen vacia']);   
            }
        }else{
            return response()->json(['messageError'=>'esta categoria ya existe, ingresa otro nombre']);
        }
    }
}
