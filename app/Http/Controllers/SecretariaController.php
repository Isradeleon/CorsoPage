<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Secretaria;
use Session;
use Hash;
use Validator;
use App\Vendedor;

class SecretariaController extends Controller
{
    public function Vista(Request $r)
    {
        return view('secretaria.registro_vendedor');
    }


     public function modificarvendedor(Request $request)
    {


        if ($request->isMethod("GET"))
        {
            return view('secretaria.tabla');
        }

        $rules = ["email"=>"required|email|unique:users",
        "nombre"=>"required",
        "ap_paterno"=>"required",
        "ap_materno"=>"required",
        "direccion"=>"required",
        "rfc"=>"required",
        "curp"=>"required",
        "contacto"=>"required"];

        $validacion=Validator::make($request->all(),$rules);
        $vendedor=Vendedor::find($request['id']);
        $vendedor->nombre=$request['nombre'];
        $vendedor->ap_paterno=$request['ap_paterno'];
        $vendedor->ap_materno=$request['ap_materno'];
        $vendedor->direccion=$request['direccion'];
        $vendedor->rfc=$request['rfc'];
        $vendedor->curp=$request['curp'];
        $vendedor->contacto=$request['contacto'];
        $vendedor->update();
        return redirect ('/secretaria_tabla');




    }
}
