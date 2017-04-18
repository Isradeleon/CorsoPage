<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;

class InicioController extends Controller
{
    public function ChecarTipo(Request $r){
      switch(Auth::user()->tipo_usuario){
        case 1:
          return view('gerente.inicio');
        break;

        case 2:
          return view('secretaria.inicio');
        break;

        case 3:
          return view('vendedor.inicio');
        break;
      }
    }
}
