<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Validator;

class ClientesController extends Controller
{
    public function RegistrarCliente(Request $r){
      if ($r->isMethod("POST")) {
        $rules=[
          "client_name"=>"required",
          "ap_paterno"=>"required",
          "ap_materno"=>"required",
          "contacto"=>"required"
        ];
        $trad=[
          "client_name.required"=>"Indique el nombre!",
          "ap_paterno.required"=>"Indique el apellido paterno!",
          "ap_materno.required"=>"Indique el apellido materno!",
          "contacto.required"=>"Indique un número de contacto!"
        ];
        $vR=Validator::make($r->all(),$rules,$trad);
        if($vR->fails()){
          return ["msgs"=>$vR->messages()];
        }
        $count=Cliente::where("nombre",$r->input("client_name"))
        ->where("ap_paterno",$r->input("ap_paterno"))
        ->where("ap_materno",$r->input("ap_materno"))->count();
        if ($count>0) {
          return ["msgs"=>["existe"=>"El cliente ya está registrado!"]];
        }

        $cliente=new Cliente();
        $cliente->nombre=$r->input("client_name");
        $cliente->ap_paterno=$r->input("ap_paterno");
        $cliente->ap_materno=$r->input("ap_materno");
        $cliente->contacto=$r->input("contacto");
        $cliente->save();

        $selectedClient=-666;
        if($r->id){
          $selectedClient=$r->id;
        }
        return view("secretaria.clientes_tabla")
        ->with("clientes",Cliente::all())
        ->with("selected",$selectedClient);
      }
      return "What happened here? :/";
    }
}
