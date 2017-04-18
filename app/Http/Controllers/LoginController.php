<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Validator;
use \Auth;
use Hash;

class LoginController extends Controller
{
    public function CambiarPass(Request $r){
      if ($r->isMethod("POST")) {
        $rules=[
          "pass"=>"required",
          "pass2"=>"same:pass"
        ];
        $trad=[
          "pass.required" => "Indique la contraseña!",
          "pass2.same" => "Las contraseñas deben coincidir!"
        ];
        $vR=Validator::make($r->all(),$rules,$trad);
        if ($vR->fails()) {
          return back()->with("msgs",$vR->messages());
        }
        Auth::user()->password=Hash::make($r->pass);
        Auth::user()->update();
        return back()->with("success","Contraseña actualizada!");
      }
      return view("password.change");
    }

    public function primeraPeticion(Request $r)
    {
      $rules=[
    		"email"=>"required|email",
    		"password"=>"required"
    	];
      $traduction = [
        "email.required" => "Ingrese su correo electrónico!",
        "email.email" => "Ingrese un correo válido!",
        "password.required" => "Ingrese la clave de acceso!"];
    	$result=Validator::make($r->all(),$rules,$traduction);
    	if ($result->fails()) {
    		return back()->with('msgs',$result->messages())
            ->withInput($r->except('password'));
    	}
    	$checkemail=User::where('email',$r->input('email'))->get()->count();
    	if ($checkemail==0) {
    		return back()->with('msgE',"El email no está registrado!")
            ->withInput($r->except('password'));
    	}
    	$userData=[
    		"email"=>$r->input('email'),
    		"password"=>$r->input('password')
    	];
    	if (Auth::attempt($userData)) {
    		return redirect('/inicio');
    	}
    	return back()->with('msgP',"Error de autenticación!")
        ->withInput($r->except('password'));
    }

    public function Logout()
    {
        \Auth::logout();
         session_start();
          session_destroy();
        return redirect('/');
    }
}
