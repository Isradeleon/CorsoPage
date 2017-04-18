<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notario;
use App\Venta;
use Validator;

class NotarioController extends Controller
{
    public function RegistrarNotario(Request $r){
      if ($r->isMethod("POST")) {
        $rules=[
          "nombre"=>"required",
          "ap_paterno"=>"required",
          "ap_materno"=>"required",
          "cedula"=>"required|unique:notarios"
        ];
        $trad=[
          "nombre.required"=>"Indique el nombre!",
          "ap_paterno.required"=>"Indique el apellido paterno!",
          "ap_materno.required"=>"Indique el apellido materno!",
          "cedula.required"=>"Indique la cédula!",
          "cedula.unique"=>"La cédula profesional ya está registrada!"
        ];
        $vR=Validator::make($r->all(),$rules,$trad);
        if($vR->fails()){
          return ["msgs"=>$vR->messages()];
        }

        $not=new Notario();
        $not->nombre=$r->input("nombre");
        $not->ap_paterno=$r->input("ap_paterno");
        $not->ap_materno=$r->input("ap_materno");
        $not->cedula=$r->input("cedula");
        $not->save();

        return view("secretaria.notarios_tabla")
        ->with("notarios",Notario::get())
        ->with("selected",Venta::find($r->id)->notario)
        ->with("venta",$r->id);
      }
      return "What happened here? :/";
    }

    public function PedirVistaNotarios(Request $r){
      return view("secretaria.notarios_vista")
      ->with("notarios",Notario::get())
      ->with("selected",Venta::find($r->id)->notario)
      ->with("venta",$r->id);
    }
}
