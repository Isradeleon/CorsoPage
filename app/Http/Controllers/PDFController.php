<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Cliente;
use App\Venta;

class PDFController extends Controller
{
    public function GeneratePDF(Request $r){
      if ($r->isMethod("GET")) {
        return view("cliente.ingresa_folio");
      }
      $rules = [
        "nombre"=>"required",
        "ap_paterno"=>"required",
        "ap_materno"=>"required",
        "folio"=>"required"
      ];
      $trad = [
        "nombre.required"=>"Indique su nombre!",
        "ap_materno.required"=>"Indique su apellido materno!",
        "ap_paterno.required"=>"Indique su apellido paterno!",
        "folio.required"=>"Indique su número de folio!"
      ];
      $vR = \Validator::make($r->all(),$rules,$trad);
      if($vR->fails()){
        return back()->with('msgs',$vR->messages())->withInput();
      }

      $venta = Venta::whereHas('cliente', function ($query) use($r) {
          $query->where("nombre",$r->nombre)
          ->where("ap_paterno",$r->ap_paterno)
          ->where("ap_materno",$r->ap_materno);
      })->find($r->folio);

      if ($venta) {
        return "Estamos trabajando en esta sección!";
      }
      return back()->with('error',"Ha habido un error con los datos!")->withInput();
    }
}
