<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Cita;
use App\Venta;

class VendedorController extends Controller
{
    public function HistorialVentas(Request $r){
      return view("vendedor.historial_ventas")
      ->with("ventas",Auth::user()->vendedor->ventas()->whereIn("status",[2,3])->get());
    }

    public function VentasTramite(Request $r){
      return view("vendedor.ventas_tramite")
      ->with("ventas",Auth::user()->vendedor->ventas()->where("status",1)->get());
    }

    public function HistorialCitas(Request $r){
      $c=Carbon::now("America/Monterrey");
      $c->second(0)->minute(0)->hour(0);
      $c2=Carbon::now("America/Monterrey");
      $c2->second(0)->minute(0)->hour(0);

      return view("vendedor.historial_citas")
      ->with("today",$c2->toDateTimeString())
      ->with("citas",Auth::user()->vendedor->citas()
      ->whereIn("status",[2,3])->Orwhere("fecha_hora","<",$c->toDateTimeString())
      ->orderBy("fecha_hora","desc")->get());
    }

    public function CancelarCita(Request $r){
      $cita=Cita::find($r->id);
      if ($cita) {
        if ($cita->status==1) {
          $cita->status=3;
          $cita->update();
        }
      }
      return back();
    }

    public function CitaExitosa(Request $r){
      $cita=Cita::find($r->id);
      if ($cita) {
        if ($cita->status==1) {
          $cita->status=2;
          $cita->update();
        }
      }
      return back();
    }

    public function CitasPendientes(Request $r){
      $c=Carbon::now("America/Monterrey");
      $c->second(0)->minute(0)->hour(0);
      $c2=Carbon::now("America/Monterrey");
      $c2->second(0)->minute(0)->hour(0);
      $c3=Carbon::now("America/Monterrey");
      $c3->second(0)->minute(0)->hour(0)->addDay();
      return view("vendedor.citas_pendientes")
      ->with("today",$c2->toDateTimeString())
      ->with("todayUp",$c3->toDateTimeString())
      ->with("citas", Auth::user()->vendedor->citas()
      ->where("status",1)->orderBy("tipo_cita","desc")
      ->where("fecha_hora",">",$c->toDateTimeString())
      ->get());
    }
}
