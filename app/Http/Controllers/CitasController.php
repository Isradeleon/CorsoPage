<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Vendedor;
use App\Casa;
use App\Cita;
use App\Cliente;
use App\Venta;
use Validator;
use Auth;
use Session;

class CitasController extends Controller
{
    public function CitasRegistradas(Request $r){
      $c=Carbon::now("America/Monterrey");
      $c;
      if (Session::has("registered")) {
        return view("secretaria.citas_registradas")
        ->with("today",$c->toDateTimeString())
        ->with("citas",Cita::orderBy("created_at","desc")->get());
      }
      return view("secretaria.citas_registradas")
      ->with("today",$c->toDateTimeString())
      ->with("citas",Cita::orderBy("fecha_hora","desc")->get());
    }

    public function PedirVentas(Request $r){
      $selected=-666;
      if($r->id){
        $selected=$r->id;
      }
      return view("secretaria.ventas_pedidas")
      ->with("ventas",Venta::where("status",1)->get())
      ->with("selected",$selected);
    }
    public function PedirVistaClientes(Request $r){
      $selectedClient=-666;
      if($r->id){
        $selectedClient=$r->id;
      }
      return view("secretaria.clientes")
      ->with("clientes",Cliente::all())
      ->with("selected",$selectedClient);
    }

    public function CasasDisponibles(Request $r){
      $selectedHouse=-666;
      if($r->id){
        $selectedHouse=$r->id;
      }
      if ($r->imASale) {
        return view("secretaria.casas_disponibles")
        ->with("selectedHouse",$selectedHouse)
        ->with("casas",Casa::where("disponibilidad",1)->get());
      }
      $c=new Carbon($r->date);
      $c2=new Carbon($r->date);
      $c->second(0);
      $c2->second(0);

      $cAdd=self::returnAdd($c);
      $cSub=self::returnSub($c2);

      $casasDis= Casa::where("disponibilidad",1)->whereDoesntHave("citas",function($q) use($cAdd,$cSub){
        $q->whereBetween("fecha_hora",[$cSub,$cAdd])->where("status",1);
      })->get();

      return view("secretaria.casas_disponibles")
      ->with("selectedHouse",$selectedHouse)
      ->with("casas",$casasDis);
    }

    public function VendedoresDisponibles(Request $r){
      $selected=-666;
      if($r->id){
        $selected=$r->id;
      }
      if ($r->imASale) {
        return view("secretaria.vendedores_disponibles")
        ->with("vendedores",Vendedor::all())
        ->with("selected",$selected);
      }
      $c=new Carbon($r->date);
      $c2=new Carbon($r->date);
      $c->second(0);
      $c2->second(0);

      $cAdd=self::returnAdd($c);
      $cSub=self::returnSub($c2);

      $vendedoresDis= Vendedor::whereDoesntHave("citas",function($q) use($cAdd,$cSub){
        $q->whereBetween("fecha_hora",[$cSub,$cAdd])->where("status",1);
      })->get();

      return view("secretaria.vendedores_disponibles")
      ->with("vendedores",$vendedoresDis)
      ->with("selected",$selected);
    }

    //Necesarios para conservar la integridad de Carbon
    private function returnSub($carbon){
      return $carbon->subHour()->toDateTimeString();
    }
    private function returnAdd($carbon){
      return $carbon->addHour()->toDateTimeString();
    }

    public function RegistrarCita(Request $r){
      if($r->isMethod("POST")){
        $rules=[
          "date_time"=>"required",
          "tipo_cita"=>"required|numeric"
        ];
        $vR=Validator::make($r->all(),$rules);
        if ($vR->fails()) {
          return redirect("/registrar_cita");
        }

        switch ($r->input("tipo_cita")) {
          case 1:
            $rules=[
              "cliente"=>"required",
              "vendedor"=>"required",
              "casa"=>"required"
            ];
            $trad=[
              "cliente.required"=>"Seleccione un cliente!",
              "vendedor.required"=>"Seleccione un vendedor!",
              "casa.required"=>"Seleccione una casa!"
            ];
            $vR=Validator::make($r->all(),$rules,$trad);
            if ($vR->fails()) {
              return back()->with("eMsgs",$vR->messages())
              ->withInput($r->except("venta"));
            }

            $ca=new Carbon($r->date_time);
            $ca->addHour();
            $ca2=new Carbon($r->date_time);
            $ca2->subHour();
            $citaTest=Cita::where("vendedor_id",$r->vendedor)
            ->where("casa_id",$r->casa)
            ->where("cliente_id",$r->cliente)
            ->where("status",1)
            ->where("fecha_hora","<=",$ca->toDateTimeString())
            ->where("fecha_hora",">=",$ca2->toDateTimeString())
            ->count();

            if ($citaTest>0) {
              return redirect("/citas_registradas");
            }

            $cita=new Cita();
            $cita->vendedor_id=$r->input("vendedor");
            $cita->cliente_id=$r->input("cliente");
            $cita->casa_id=$r->input("casa");
            $cita->secretaria_id=Auth::user()->secretaria->id;
            $cita->tipo_cita=1;
            $cita->status=1;
            $cita->fecha_hora=(new Carbon($r->date_time))->second(0)->toDateTimeString();
            $cita->save();
            //AQUI SE REDIRIGIRÁ HACIA LOS REGISTROS DE CITAS
            return redirect("/citas_registradas")
            ->with("registered",1);
          break;

          case 2:
            $rules=[
              "venta"=>"required"
            ];
            $trad=[
              "venta.required"=>"Seleccione la venta!"
            ];
            $vR=Validator::make($r->all(),$rules,$trad);
            if ($vR->fails()) {
              return back()->with("eMsgs",$vR->messages())
              ->with("docsCita",1);
            }

            $venta=Venta::find($r->venta);
            if (!$venta) {
              return redirect("/citas_registradas");
            }

            $ca=new Carbon($r->date_time);
            $ca->addHour();
            $ca2=new Carbon($r->date_time);
            $ca2->subHour();
            $citaTest=Cita::where("venta_docs_id",$venta->id)
            ->where("fecha_hora","<=",$ca->toDateTimeString())
            ->where("fecha_hora",">=",$ca2->toDateTimeString())
            ->where("status",1)
            ->count();
            if ($citaTest>0) {
              return redirect("/citas_registradas");
            }

            $cita=new Cita();
            $cita->vendedor_id=$venta->vendedor->id;
            $cita->cliente_id=$venta->cliente->id;
            $cita->casa_id=$venta->casa->id;
            $cita->secretaria_id=Auth::user()->secretaria->id;
            $cita->tipo_cita=2;
            $cita->status=1;
            $cita->venta_docs_id=$venta->id;
            $cita->fecha_hora=(new Carbon($r->date_time))->second(0)->toDateTimeString();
            $cita->save();
            //AQUI SE REDIRIGIRÁ HACIA LOS REGISTROS DE CITAS 2
            return redirect("/citas_registradas")
            ->with("registered",1);
          break;

          default:
            return redirect("/registrar_cita");
          break;
        }
      }else if($r->isMethod("GET")){
        return view("secretaria.registra_cita");
      }
      return redirect("/");
    }
}
