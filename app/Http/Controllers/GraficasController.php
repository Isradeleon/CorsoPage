<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cita;
use App\Venta;
use Carbon\Carbon;

class GraficasController extends Controller
{
    public function VentasG(Request $r){
      if ($r->isMethod("GET")) {
        return view("gerente.ventas_grafica");
      }
      $c=Carbon::now("America/Monterrey");
      $c->day(1)->hour(0)->minute(0)->second(0);
      $c2=Carbon::now("America/Monterrey");
      $c2->hour(0)->minute(0)->second(0);
      return Venta::where("fecha_inicio",">=",$c->toDateTimeString())
      ->where("fecha_inicio","<=",$c2->toDateTimeString())
      ->get()->groupBy("status");
    }

    public function VentasGYear(Request $r){
      $c=Carbon::now("America/Monterrey");
      $c->month(1)->day(1)->hour(0)->minute(0)->second(0);
      $c2=Carbon::now("America/Monterrey");
      $c2->hour(0)->minute(0)->second(0);
      return Venta::where("fecha_inicio",">=",$c->toDateTimeString())
      ->where("fecha_inicio","<=",$c2->toDateTimeString())
      ->get()->groupBy("status");
    }

    public function CitasG(Request $r){
      if ($r->isMethod("GET")) {
        return view("gerente.citas_grafica");
      }
      $c=Carbon::now("America/Monterrey");
      $c->day(1)->hour(0)->minute(0)->second(0);
      $c2=Carbon::now("America/Monterrey");
      $c2->hour(0)->minute(0)->second(0);
      return Cita::where("fecha_hora",">=",$c->toDateTimeString())
      ->where("fecha_hora","<=",$c2->toDateTimeString())
      ->get()->groupBy("status");
    }

    public function CitasGYear(Request $r){
      $c=Carbon::now("America/Monterrey");
      $c->month(1)->day(1)->hour(0)->minute(0)->second(0);
      $c2=Carbon::now("America/Monterrey");
      $c2->hour(0)->minute(0)->second(0);
      return Cita::where("fecha_hora",">=",$c->toDateTimeString())
      ->where("fecha_hora","<=",$c2->toDateTimeString())
      ->get()->groupBy("status");
    }
}
