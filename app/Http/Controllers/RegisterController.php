<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gerente;
use App\Secretaria;
use App\Vendedor;
use Session;
use Hash;
use Auth;
use Validator;

class RegisterController extends Controller
{
    //Funcion para el registro de gerentes:
    public function RegistroGerente(Request $peticion) {
    	if($peticion->method() == "POST") {
        $rules = ["email"=>"required|email|unique:users",
        "nombre"=>"required",
        "ap_paterno"=>"required",
        "ap_materno"=>"required",
        "direccion"=>"required",
        "rfc"=>"required|min:10|max:13|unique:gerentes|regex:/^[a-zA-Z0-9]/",
        "fecha_nac"=>"required"];

        $traduccion = [
          "email.required" => "Debes completar el campo Email",
          "email.email" => "El campo Email debe ser válido",
          "email.unique" => "El email ingresado ya se encuentra registrado",
          "nombre.required"=>"Debes completar el campo Nombre",
          "ap_materno.required"=>"Debes completar el campo Apellido paterno",
          "ap_paterno.required"=>"Debes completar el campo Apellido materno",
          "rfc.required"=>"Debes completar el campo RFC",
          "rfc.unique"=>"El RFC ya está registrado!",
          "rfc.max" => "El limite de caracteres del campo :attribute son 13",
          "rfc.min" => "El minimo de caracteres del campo :attribute es  10",
          "rfc.regex"=>"El RFC solo admite numeros y letras!",
          "direccion.required"=>"Debes completar el campo Direccion",
          "fecha_nac.required"=>"Debes completar el campo fecha de nacimiento"];

          $resultado = Validator::make($peticion->all(),$rules,$traduccion);

          if($resultado->fails()){
            return back()->with('error',$resultado->messages()->all())->withInput();
          }
          else
          {
            $pass=str_random(10);
            $data = [
              'name' => $peticion['nombre'],
              'email' => $peticion['email'],
              'usuario'=> 'Gerente',
              'pass'=>$pass
            ];

            \Mail::send('Templates.email',['data' => $data],function($mail) use($data) {
              $mail->from('hello@app.com', 'Grupo Corso');
              $mail->subject('Usuario y password de acceso.');
              $mail->to($data['email'], $data['name']);
            });

            $usuario = new User;
            $usuario->usuario = 'Gerente';
            $usuario->email = $peticion['email'];
            $usuario->password = Hash::make($pass);
            $usuario->tipo_usuario=1;
            $usuario->remember_token = $peticion['_token'];
            $usuario->movil=false;
            $usuario->save();

            $gte=new Gerente;
            $gte->nombre=$peticion["nombre"];
            $gte->ap_paterno=$peticion["ap_paterno"];
            $gte->ap_materno=$peticion["ap_materno"];
            $gte->direccion=$peticion["direccion"];
            $gte->rfc=$peticion["rfc"];
            $gte->fecha_nacimiento=$peticion["fecha_nac"];
            $gte->usuario_id=$usuario->id;
            $gte->save();

            return back()->with('usuario_reg',$usuario->email);
          }
    	}else if($peticion->isMethod("GET")){
        return view("gerente.registro_gerente");
      }
      return redirect('/');
    }

    //Funcion para el registro de secretarias, solo hay que invocarla:
    public function RegistroSecretaria(Request $peticion) {
    	if($peticion->method() == "POST") {
        $rules = ["email"=>"required|email|unique:users",
        "nombre"=>"required",
        "ap_paterno"=>"required",
        "ap_materno"=>"required",
        "direccion"=>"required",
        "rfc"=>"required|min:10|max:13|unique:secretarias|regex:/^[a-zA-Z0-9]/",
        "curp"=>"required|min:17|max:18|unique:secretarias|regex:/^[a-zA-Z0-9]/",
        "fecha_nac"=>"required"];

        $traduccion = [
          "email.required" => "Debes completar el campo Email",
          "email.email" => "El campo Email debe ser válido",
          "email.unique" => "El email ingresado ya se encuentra registrado",
          "nombre.required"=>"Debes completar el campo Nombre",
          "ap_materno.required"=>"Debes completar el campo Apellido paterno",
          "ap_paterno.required"=>"Debes completar el campo Apellido materno",
          "rfc.required"=>"Debes completar el campo RFC",
          "rfc.unique"=>"El RFC ya está registrado!",
          "rfc.max" => "El limite de caracteres del campo :attribute son 13",
          "rfc.min" => "El minimo de caracteres del campo :attribute es 10",
          "rfc.regex"=>"El RFC solo admite numeros y letras!",
          "curp.required"=>"Debes completar el campo CURP",
          "curp.unique"=>"El CURP ya está registrado!",
          "curp.max" => "El limite de caracteres del campo :attribute son 18",
          "curp.min" => "CURP mínimo 17 caracteres!",
          "curp.regex"=>"El CURP solo admite numeros y letras!",
          "direccion.required"=>"Debes completar el campo Direccion",
          "fecha_nac.required"=>"Debes completar el campo fecha de nacimiento"];

          $resultado = Validator::make($peticion->all(),$rules,$traduccion);

          if($resultado->fails()){
            return back()->with('error',$resultado->messages()->all())->withInput();
          }
          else
          {
            $pass=str_random(10);
            $data = [
              'name' => $peticion['nombre'],
              'email' => $peticion['email'],
              'usuario'=> 'Secretari@',
              'pass'=>$pass
            ];

            \Mail::send('Templates.email',['data' => $data],function($mail) use($data) {
              $mail->from('hello@app.com', 'Grupo Corso');
              $mail->subject('Usuario y password de acceso.');
              $mail->to($data['email'], $data['name']);
            });

            $usuario = new User;
            $usuario->usuario = 'Secretaria';
            $usuario->email = $peticion['email'];
            $usuario->password = Hash::make($pass);
            $usuario->tipo_usuario=2;
            $usuario->remember_token = $peticion['_token'];
            $usuario->movil=false;
            $usuario->save();

            $secre=new Secretaria;
            $secre->nombre=$peticion["nombre"];
            $secre->ap_paterno=$peticion["ap_paterno"];
            $secre->ap_materno=$peticion["ap_materno"];
            $secre->direccion=$peticion["direccion"];
            $secre->rfc=$peticion["rfc"];
            $secre->curp=$peticion["curp"];
            $secre->fecha_nacimiento=$peticion["fecha_nac"];
            $secre->usuario_id=$usuario->id;
            $secre->save();

            return back()->with('usuario_reg',$usuario->email);
          }
    	}else if($peticion->isMethod("GET")){
        return view("gerente.registro_secretaria");
      }
      return redirect('/');
    }

    //Vendedores :D
    public function RegistroVendedor(Request $peticion) {
      if($peticion->method() == "POST") {
        $rules = ["email"=>"required|email|unique:users",
        "rfc"=>"required|min:1|max:18|unique:vendedores|regex:/^[a-zA-Z0-9]/",
        "curp"=>"required|min:1|max:18|unique:vendedores|regex:/^[a-zA-Z0-9]/",
        "nombre"=>"required",
        "ap_paterno"=>"required",
        "ap_materno"=>"required",
        "direccion"=>"required",
        "fecha_nac"=>"required",
        "contacto"=>"required"];

        $traduccion = [
          "email.required" => "Debes completar el campo Email",
          "email.email" => "El campo Email debe ser válido",
          "email.unique" => "El email ingresado ya se encuentra registrado",
          "nombre.required"=>"Debes completar el campo Nombre",
          "ap_materno.required"=>"Debes completar el campo Apellido paterno",
          "ap_paterno.required"=>"Debes completar el campo Apellido materno",
          "rfc.required"=>"Debes completar el campo RFC",
          "rfc.unique"=>"El RFC ya está registrado!",
          "rfc.max" => "El limite de caracteres del campo :attribute son 18",
          "rfc.min" => "El minimo de caracteres del campo :attribute es  1",
          "rfc.regex"=>"El RFC solo admite numeros y letras!",
          "curp.required"=>"Debes completar el campo CURP",
          "curp.unique"=>"El CURP ya está registrado!",
          "curp.max" => "El limite de caracteres del campo :attribute son 18",
          "curp.min" => "CURP mínimo 17 caracteres!",
          "curp.regex"=>"El CURP solo admite numeros y letras!",
          "direccion.required"=>"Debes completar el campo Direccion",
          "fecha_nac.required"=>"Debes completar el campo fecha de nacimiento",
          "contacto.required"=>"Debes indicar un número de contacto"];

          $resultado = Validator::make($peticion->all(),$rules,$traduccion);

          if($resultado->fails()){
            return back()->with('error',$resultado->messages()->all())->withInput();
          }
          else
          {
            $pass=str_random(10);
            $data = [
              'name' => $peticion['nombre'],
              'email' => $peticion['email'],
              'usuario'=> 'Vendedor',
              'pass'=>$pass
            ];

            \Mail::send('Templates.email',['data' => $data],function($mail) use($data) {
              $mail->from('hello@app.com', 'Grupo Corso');
              $mail->subject('Usuario y password de acceso.');
              $mail->to($data['email'], $data['name']);
            });

            $usuario = new User;
            $usuario->usuario = 'Vendedor';
            $usuario->email = $peticion['email'];
            $usuario->password = Hash::make($pass);
            $usuario->tipo_usuario=3;
            $usuario->remember_token = $peticion['_token'];
            $usuario->movil=true;
            $usuario->save();

            $vend=new Vendedor;
            $vend->nombre=$peticion["nombre"];
            $vend->ap_paterno=$peticion["ap_paterno"];
            $vend->ap_materno=$peticion["ap_materno"];
            $vend->direccion=$peticion["direccion"];
            $vend->rfc=$peticion["rfc"];
            $vend->curp=$peticion["curp"];
            $vend->contacto=$peticion["contacto"];
            $vend->fecha_nacimiento=$peticion["fecha_nac"];
            $vend->usuario_id=$usuario->id;
            $vend->save();

            return back()->with('usuario_reg',$usuario->email);
          }
    	}else if($peticion->isMethod("GET")){
        switch(Auth::user()->tipo_usuario){
          case 1:
            return view("gerente.registro_vendedor");
          break;

          case 2:
            return view("secretaria.registro_vendedor");
          break;
        }
      }
      return redirect('/');
    }
}
