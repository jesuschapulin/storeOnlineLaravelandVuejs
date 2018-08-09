<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Ususarios;
use Illuminate\Support\Facades\DB;
use Image;
class logginController extends Controller{
    public function check_usuario(Request $request){
    	$email=$request->email;
    	$password=$request->password;
        try{
            $array = DB::table('ususarios')->select('id_usuario','nickname','id_tipo_usuario')->where(function($query) use($email,$password){
                $query  ->where('email','=',$email)
                        ->where('password','=',$password);
            })->first();
        	if($array==null){
                return response()->json(['messageError'=>'usuario o contraseña incorrectos']);
            }else{
        	   return response()->json(['id_usuario'=>$array->id_usuario,
                                         'nickname'=>$array->nickname,
                                         'id_tipo_usuario'=>$array->id_tipo_usuario,
                                         'state'=>'success'
                                        ]);
            }
        }catch(\Illuminate\Database\QueryException $e){
                dd($e);

        }catch(PDOException $e){
            dd($e);
        }

		

    }
    public function register_user(Request $request){
        $email=$request->email;
        $nickname=$request->nickname;
        $password=$request->password;
        $type_user="1";
        try{
            $emailDuplicate = DB::table('ususarios')->where('email',$email)->first();
            $nicknameDuplicate = DB::table('ususarios')->where('nickname',$nickname)->first();
            if($emailDuplicate!=null){
                return response()->json(['message'=>'email ya esta registrado, use uno diferente']);
            }
            if($nicknameDuplicate!=null){
                return response()->json(['message'=>'nickname ya esta registrado, use uno diferente']);
            }
            if($emailDuplicate==null && $nicknameDuplicate==null){
                Ususarios::create([
                    'nombre'=>'',
                    'ap_paterno'=>'',
                    'ap_materno'=>'',
                    'email' => $email,
                    'telefono'=>'',
                    'nickname' => $nickname,
                    'password' => $password,
                    'id_tipo_usuario' =>$type_user,
                    'imagen'=>'',
                    'facebook'=>'',
                    'twitter'=>'',
                    'buyer_state'=>'false',
                ]);

                $array = DB::table('ususarios')->select('id_usuario','nickname','id_tipo_usuario')->where(function($query) use($email,$password){
                    $query  ->where('email','=',$email)
                            ->where('password','=',$password);
                })->get();
                return response()->json(['id_usuario'=>$array[0]->id_usuario,
                                     'nickname'=>$array[0]->nickname,
                                     'id_tipo_usuario'=>$array[0]->id_tipo_usuario,
                                     'state'=>'success'
                                    ]);
            }
        }catch (\Illuminate\Database\QueryException $e) {
                dd($e);

        } catch (PDOException $e) {
            dd($e);
        }

    }
    public function getUser(Request $request){
        try{
            $user=$request->user;
            $usuario = DB::table('ususarios')->where(function($query) use($user){
                            $query  ->where('id_usuario','=',$user);
                        })->first();
        
            return response()->json($usuario);
        }catch (\Illuminate\Database\QueryException $e) {
                dd($e);

        } catch (PDOException $e) {
            dd($e);
        }
    }
    public function updateUser(Request $request){
        try{
            $id_usuario=$request->id_usuario;
            $originalName=$request->originalName;
            $nombre=$request->nombre;
            $ap_materno=$request->ap_materno;
            $ap_paterno=$request->ap_paterno;
            $email=$request->email;
            $telefono=$request->telefono;
            $nickname=$request->nickname;
            $password=$request->password;
            $message=$request->message;
            if($message=="sameImage"){
                DB::table('ususarios')
                                ->where('id_usuario','=',$id_usuario)
                                ->update([
                                            'nombre' => $nombre,
                                            'ap_paterno' => $ap_paterno,
                                            'ap_materno' => $ap_materno,
                                            'email' => $email,
                                            'telefono'=>$telefono,
                                            'nickname'=>$nickname,
                                            'password'=>$password
                                ]);
                return response()->json(['messageSuccess'=>'usuario actualizado exitosamente']);
            }else if($request->hasFile('imageUsuario')){
                $archivo=$request->file('imageUsuario');
                $filename=time().'.'.$archivo->getClientOriginalExtension();
                $img=Image::make($archivo);
                if($img!=null){
                    $img->resize(655,368);
                    $img->save(public_path('/images/users/'.$filename));
                    DB::table('ususarios')
                                ->where('id_usuario','=',$id_usuario)
                                ->update([
                                            'nombre' => $nombre,
                                            'ap_paterno' => $ap_paterno,
                                            'ap_materno' => $ap_materno,
                                            'email' => $email,
                                            'telefono'=>$telefono,
                                            'nickname'=>$nickname,
                                            'password'=>$password,
                                            'imagen'=>$filename
                                ]);
                    return response()->json(['messageSuccess'=>'usuario actualizado exitosamente con imagen nueva']);
                }
            }
            

        }catch (\Illuminate\Database\QueryException $e) {
                dd($e);

        } catch (PDOException $e) {
            dd($e);
        }
    }
}
