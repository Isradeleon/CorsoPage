<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gerente;
use App\User;
use App\Secretaria;
use Session;
use Hash;
use Validator;
use App\Vendedor;
use App\Venta;
use App\Cita;

class GerenteController extends Controller
{
    public function sendEmail(Request $r){
      $rules=[
        "nombre"=>"required",
        "correo"=>"required",
        "mensaje"=>"required"
      ];
      $trad=[
        "nombre.required"=>"Indique su nombre!",
        "correo.required"=>"Indique su correo electrónico!",
        "mensaje.required"=>"Indique su mensaje!"
      ];
      $vR=Validator::make($r->all(),$rules,$trad);
      if ($vR->fails()) {
        return back()->with("msgCorreoE",1)->withInput();
      }
      $dataUser = ['nombre'=>$r['nombre'],
        'correo'=>$r['correo'],
        'mensaje'=>$r['mensaje']
      ];
      \Mail::send('Templates.email_msg',['data' => $dataUser],function($message) use ($dataUser){
          $message->from($dataUser['correo'],"Grupo Corso.");
          $message->subject("Cliente envía un mensaje.");
          $message->to('Cesar_gus_123@hotmail.com');
      });
      return redirect("/")->with("msgCorreo",1);
    }
}
