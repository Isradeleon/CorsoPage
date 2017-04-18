<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gerente;
use App\Secretaria;
use App\Vendedor;
use App\Cliente;
use App\Notario;
use Auth;
use Validator; //just in case

class EditarController extends Controller
{
    public function PedirNotario(Request $r){
      if($r->isMethod("POST")){
        return Notario::find($r->id);
      }
      return redirect("?");
    }

    public function PedirCliente(Request $r){
      if($r->isMethod("POST")){
        return Cliente::find($r->id);
      }
      return redirect("?");
    }

    public function PedirGerente(Request $r){
      if($r->isMethod("POST")){
        return Gerente::find($r->id);
      }
      return redirect("?");
    }

    public function PedirSecre(Request $r){
      if($r->isMethod("POST")){
        return Secretaria::find($r->id);
      }
      return redirect("?");
    }

    public function PedirVendedor(Request $r){
      if($r->isMethod("POST")){
        return Vendedor::find($r->id);
      }
      return redirect("?");
    }

    public function EditarNotario(Request $r){
      if ($r->isMethod("POST")) {
        $not=Notario::find($r->id);
        if($r->nombre){
          $not->nombre=$r->nombre;
        }
        if($r->ap_paterno){
          $not->ap_paterno=$r->ap_paterno;
        }
        if($r->ap_materno){
          $not->ap_materno=$r->ap_materno;
        }
        if($r->cedula){
          $not->cedula=$r->cedula;
        }
        $not->update();
        return view("secretaria.tabla_notarios_paraedicion");
      }else if ($r->isMethod("GET")) {
        return view("secretaria.ver_notarios");
      }
      return redirect("/");
    }

    public function EditarGerente(Request $r){
      if ($r->isMethod("POST")) {
        $geren=Gerente::find($r->id);
        if($r->nombre){
          $geren->nombre=$r->nombre;
        }
        if($r->ap_paterno){
          $geren->ap_paterno=$r->ap_paterno;
        }
        if($r->ap_materno){
          $geren->ap_materno=$r->ap_materno;
        }
        if($r->rfc){
          $geren->rfc=$r->rfc;
        }
        if($r->direccion){
          $geren->direccion=$r->direccion;
        }
        if($r->fecha_nac){
          $geren->fecha_nacimiento=$r->fecha_nac;
        }
        $geren->update();
        return view("gerente.tabla_gerentes");
      }else if ($r->isMethod("GET")) {
        return view("gerente.ver_gerentes");
      }
      return redirect("/");
    }

    public function EditarSecretaria(Request $r){
      if ($r->isMethod("POST")) {
        $secre=Secretaria::find($r->id);
        if($r->nombre){
          $secre->nombre=$r->nombre;
        }
        if($r->ap_paterno){
          $secre->ap_paterno=$r->ap_paterno;
        }
        if($r->ap_materno){
          $secre->ap_materno=$r->ap_materno;
        }
        if($r->rfc){
          $secre->rfc=$r->rfc;
        }
        if($r->direccion){
          $secre->direccion=$r->direccion;
        }
        if($r->fecha_nac){
          $secre->fecha_nacimiento=$r->fecha_nac;
        }
        if($r->curp){
          $secre->curp=$r->curp;
        }
        $secre->update();
        return view("gerente.tabla_secretarias");
      }else if ($r->isMethod("GET")) {
        return view("gerente.ver_secretarias");
      }
      return redirect("/");
    }

    public function EditarVendedor(Request $r){
      if ($r->isMethod("POST")) {
        $vendedor=Vendedor::find($r->id);
        if($r->nombre){
          $vendedor->nombre=$r->nombre;
        }
        if($r->ap_paterno){
          $vendedor->ap_paterno=$r->ap_paterno;
        }
        if($r->ap_materno){
          $vendedor->ap_materno=$r->ap_materno;
        }
        if($r->rfc){
          $vendedor->rfc=$r->rfc;
        }
        if($r->direccion){
          $vendedor->direccion=$r->direccion;
        }
        if($r->fecha_nac){
          $vendedor->fecha_nacimiento=$r->fecha_nac;
        }
        if($r->curp){
          $vendedor->curp=$r->curp;
        }
        if($r->contacto){
          $vendedor->contacto=$r->contacto;
        }
        $vendedor->update();
        return view("gerente.tabla_vendedores");
      }else if ($r->isMethod("GET")) {
        switch(Auth::user()->tipo_usuario){
          case 1:
            return view("gerente.ver_vendedores");
          break;

          case 2:
            return view("secretaria.ver_vendedores");
          break;
        }
      }
      return redirect("/");
    }

    public function EditarCliente(Request $r){
      if ($r->isMethod("POST")) {
        $clien=Cliente::find($r->id);
        if($r->nombre){
          $clien->nombre=$r->nombre;
        }
        if($r->ap_paterno){
          $clien->ap_paterno=$r->ap_paterno;
        }
        if($r->ap_materno){
          $clien->ap_materno=$r->ap_materno;
        }
        if($r->contacto){
          $clien->contacto=$r->contacto;
        }
        $clien->update();
        return view("secretaria.tabla_clientes");
      }else if ($r->isMethod("GET")) {
        return view("secretaria.ver_clientes");
      }
      return redirect("/");
    }

    public function EliminarNotario(Request $r){
      $data=Notario::find($r->id);
      $data->cedula=null;
      $data->update();
      $data->delete();
      return view("secretaria.tabla_notarios_paraedicion");
    }

    public function EliminarCliente(Request $r){
      $data=Cliente::find($r->id);
      $data->delete();
      return view("secretaria.tabla_clientes");
    }

    public function EliminarGerente(Request $r){
      $data=Gerente::find($r->id);
      $data->rfc=null;
      $data->update();
      $data->user->email=null;
      $data->user->update();
      $data->user->delete();
      $data->delete();
      return view("gerente.tabla_gerentes");
    }

    public function EliminarSecretaria(Request $r){
      $data=Secretaria::find($r->id);
      $data->curp=null;
      $data->rfc=null;
      $data->update();
      $data->user->email=null;
      $data->user->update();
      $data->user->delete();
      $data->delete();
      return view("gerente.tabla_secretarias");
    }

    public function EliminarVendedor(Request $r){
      $data=Vendedor::find($r->id);
      $data->curp=null;
      $data->rfc=null;
      $data->update();
      $data->user->email=null;
      $data->user->update();
      $data->user->delete();
      $data->delete();
      return view("gerente.tabla_vendedores");
    }
}
