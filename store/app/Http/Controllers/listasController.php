<?php

namespace App\Http\Controllers;
use App\Listas;
use App\Productos_listas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class listasController extends Controller{
 	public function getLists(Request $request){
 		$id_usuario=$request->id_usuario;
 		$array = DB::table('listas')->where(function($query) use($id_usuario){
                $query  ->where('id_usuario','=',$id_usuario)
                        ->where('estado','=','pendiente');
            })->get();
 		return response()->json($array);
 	}
 	public function getProductosList(Request $request){
 		$inventarios="";
 		$id_usuario=$request->id_usuario;
 		$id_lista=$request->id_lista;
 		$array=DB::table('listas')
 			->join('ususarios','ususarios.id_usuario','=','listas.id_usuario')
            ->join('productos_listas','productos_listas.id_lista', '=', 'listas.id_lista')
            ->join('inventarios', 'inventarios.id_inventario', '=', 'productos_listas.id_inventario')
            ->join('productos', 'productos.id_producto', '=', 'inventarios.id_producto')
            ->select('listas.id_lista','ususarios.nickname','productos.nombre as producto','productos.precio_unitario as precio','productos_listas.cantidad','productos_listas.total','listas.subtotal as totalNeto')
            	->where(function($query) use($id_lista, $id_usuario){
            	$query->where('listas.id_lista','=',$id_lista)
            			->where('ususarios.id_usuario','=',$id_usuario);
            })
            ->get();
 		return response()->json($array);
 	}
 	public function createList(Request $request){
 		$id_usuario=$request->id_usuario;
 		$id_producto=$request->id_producto;
 		$cantidad=$request->cantidad;
 		$nameList=$request->nameList;
 		try{
 			$nameListDuplicate = DB::table('listas')->select('nombre')->where(function($query) use($id_usuario,$nameList){
                $query  ->where('nombre','=',$nameList)
                        ->where('id_usuario','=',$id_usuario);
            })->first();
            if($nameListDuplicate==null){
                $id_inventario=DB::table('inventarios')->where('id_producto',$id_producto)->select('id_inventario')->first();
 				$precioProducto=DB::table('productos')->where('id_producto',$id_producto)->select('precio_unitario')->first();
                Listas::create([
                    'nombre' => $nameList,
                    'id_usuario' => $id_usuario,
                    'total' => '0',
                    'subtotal' =>'0',
                    'estado'=>'pendiente'
                ]);
                $listas=DB::table('listas')->select('id_lista')->where(function($query) use($id_usuario,$nameList){
	                $query  ->where('nombre','=',$nameList)
	                        ->where('id_usuario','=',$id_usuario);
	            })->first();
	            $id_lista=$listas->id_lista;
	            $newTotal=$cantidad*$precioProducto->precio_unitario;
            	Productos_listas::create([
                    'id_inventario' => $id_inventario->id_inventario,
                    'cantidad' =>$cantidad,
                    'total' => $newTotal,
                    'id_lista' =>$id_lista
                ]);
                $stateList=DB::table('listas')->where('id_lista',$id_lista)->select('total','subtotal')->first();
	        	$totalList=$stateList->total;
	        	$subtotalList=$stateList->subtotal;
	        	$totalListFinal=($totalList+$newTotal);
	        	$subtotalListFinal=$totalListFinal;
	        	DB::table('listas')
	            ->where('id_lista', $id_lista)
	            ->update(['total' => $totalListFinal,
	        				'subtotal'=>$subtotalListFinal
	        	]);
                return response()->json(['messageSuccess'=>'Lista creada Exitosamente']);
            }
            else{
            	return response()->json(['messageError'=>'El nombre ya esta registrado, use uno diferente']);
            }
 		}catch(\Illuminate\Database\QueryException $e){
                dd($e);

        } catch (PDOException $e) {
            dd($e);
        }
 	}
 	public function addProductList(Request $request){
 		$id_usuario=$request->id_usuario;
 		$id_lista=$request->id_lista;
 		$id_producto=$request->id_producto;
 		$total=$request->total;
 		$cantidad=$request->cantidad;
 		try{
 			$id_inventario=DB::table('inventarios')->where('id_producto',$id_producto)->select('id_inventario')->first();
 			$precioProducto=DB::table('productos')->where('id_producto',$id_producto)->select('precio_unitario')->first();
 			$state_productosListas=DB::table('productos_listas')->where(function($query) use($id_lista,$id_inventario){
                $query  ->where('id_lista','=',$id_lista)
                        ->where('id_inventario','=',$id_inventario->id_inventario);
            })->first();
            if($state_productosListas!=null){
            	$id_productos_listas=$state_productosListas->id_productos_listas;
            	$cantidad_table=$state_productosListas->cantidad;
            	$total_table=$state_productosListas->total;
            	$cantidadFinal=$cantidad+$cantidad_table;
            	$totalFinal=$cantidadFinal*$precioProducto->precio_unitario;
            	DB::table('productos_listas')
	            ->where('id_productos_listas', $id_productos_listas)
	            ->update(['cantidad' => $cantidadFinal,
	        				'total'=>$totalFinal
	        	]);
	        	$stateList=DB::table('listas')->where('id_lista',$id_lista)->select('total','subtotal')->first();
	        	$totalList=$stateList->total;
	        	$subtotalList=$stateList->subtotal;
	        	$totalListFinal=($totalList-$total_table)+$totalFinal;
	        	$subtotalListFinal=$totalListFinal;
	        	DB::table('listas')
	            ->where('id_lista', $id_lista)
	            ->update(['total' => $totalListFinal,
	        				'subtotal'=>$subtotalListFinal
	        	]);
	        	return response()->json(['messageSuccess'=>'Lista actualizada exitosamente']);
            }else{
            	$newTotal=$cantidad*$precioProducto->precio_unitario;
            	Productos_listas::create([
                    'id_inventario' => $id_inventario->id_inventario,
                    'cantidad' =>$cantidad,
                    'total' => $newTotal,
                    'id_lista' =>$id_lista
                ]);
                $stateList=DB::table('listas')->where('id_lista',$id_lista)->select('total','subtotal')->first();
	        	$totalList=$stateList->total;
	        	$subtotalList=$stateList->subtotal;
	        	$totalListFinal=($totalList+$newTotal);
	        	$subtotalListFinal=$totalListFinal;
	        	DB::table('listas')
	            ->where('id_lista', $id_lista)
	            ->update(['total' => $totalListFinal,
	        				'subtotal'=>$subtotalListFinal
	        	]);
	        	return response()->json(['messageSuccess'=>'Lista actualizada exitosamente']);
            }

 		}catch(\Illuminate\Database\QueryException $e){
                dd($e);

        } catch (PDOException $e) {
            dd($e);
        }
 	}
}
