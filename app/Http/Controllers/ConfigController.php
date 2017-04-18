<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dato;

class ConfigController extends Controller
{
  public function EditarDatos(Request $request) {
    if ($request->isMethod("GET")) {
      return view("gerente.configuracion")
      ->with("dato",Dato::get()->first());
    }
    $dato=Dato::get()->first();
    if (!$dato) {
      $dato=new Dato();
      $dato->correo = $request['correo'];
      $dato->telefono = $request['telefono'];
      $dato->facebook = $request['facebook'];
      $dato->save();
    }else{
      if ($request['correo']) {
        $dato->correo = $request['correo'];
      }
      if ($request['telefono']) {
        $dato->telefono = $request['telefono'];
      }
      if ($request['facebook']) {
        $dato->facebook = $request['facebook'];
      }
      $dato->update();
    }
    return redirect("/editar_datos")
    ->with('msg',"Información actualizada!");
  }
}
