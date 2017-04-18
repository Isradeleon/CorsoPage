<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Cita;
use App\Casa;
use App\Venta;
use App\Documento;
use App\Vendedor;
use Carbon\Carbon;
use App\Cliente;
use Auth;
use Storage;

class VentasController extends Controller
{
    public function VentaConcretada(Request $r){
      $venta=Venta::find($r->id);
      if ($venta) {
        $venta->status=2;
        $venta->fecha_cierre=Carbon::now("America/Monterrey")->toDateTimeString();
        $venta->casa->disponibilidad=3;
        $venta->casa->update();
        $venta->update();
      }
      return back()->with("id",$r->id);
    }

    public function NotarioVenta(Request $r){
      $venta=Venta::find($r->input("venta"));
      $venta->notario_id=$r->input("notario");
      $venta->update();
      return redirect("/ventas_registradas")->with("id",$r->input("venta"));
    }

    public function MontoCubierto(Request $r){
      $venta=Venta::find($r->id);
      if ($venta) {
        $venta->monto_cubierto=Carbon::now("America/Monterrey")->toDateTimeString();
        $venta->update();
      }
      return back()->with("id",$r->id);
    }

    public function CancelarVenta(Request $r){
      $venta=Venta::find($r->id);
      if ($venta) {
        $venta->status=3;
        $venta->fecha_cierre=Carbon::now("America/Monterrey")->toDateTimeString();
        $venta->casa->disponibilidad=1;
        $venta->casa->update();
        $venta->update();
      }
      $citas_cancelar=Cita::where("venta_docs_id",$venta->id)->where("status",1)->get();
      foreach ($citas_cancelar as $key => $val) {
        $val->status=3;
        $val->update();
      }
      return back()->with("id",$r->id);
    }

    public function CheckStatus(Request $r){
      $venta=Venta::find($r->id);
      if ($venta->status==1) {
        return ["view"=>view("secretaria.editar_archivo")->with("id",$venta->id)->with("doc",$r->doc)->render()];
      }
      return "Nope";
    }

    public function EditarDocs(Request $r){
      $rules=[
        "acta"=>"image",
        "ine"=>"image",
        "escrituras"=>"image"
      ];
      $trad=[
        "acta.image"=>"Solo se aceptan imagenes!",
        "ine.image"=>"Solo se aceptan imagenes!",
        "escrituras.image"=>"Solo se aceptan imagenes!"
      ];
      $vR=Validator::make($r->all(),$rules,$trad);
      if ($vR->fails()) {
        return back()->with("msgs",$vR->messages())->with("id",$r->id);
      }

      $venta=Venta::find($r->id);
      if ($r->file("acta")) {
        $imagen=$venta->documento->acta_nacimiento;
        $file=basename($imagen);
        Storage::disk("images")->delete("docs_reg/".$file);

        $original=basename($r->file("acta")->getClientOriginalName(), '.'.$r->file("acta")->getClientOriginalExtension());
        $name=md5($original.microtime());
        $newname= $name.'.'.$r->file("acta")->getClientOriginalExtension();
        $src="public/img/docs_reg/".$newname;
        $r->file("acta")->move(
            base_path() . '/public/img/docs_reg/', $newname
        );
        $venta->documento->acta_nacimiento=$src;
        $venta->documento->fecha_entrega_acta=Carbon::now("America/Monterrey")->toDateString();
        $venta->documento->update();
      }

      if ($r->file("ine")) {
        $imagen=$venta->documento->ine;
        $file=basename($imagen);
        Storage::disk("images")->delete("docs_reg/".$file);

        $original=basename($r->file("ine")->getClientOriginalName(), '.'.$r->file("ine")->getClientOriginalExtension());
        $name=md5($original.microtime());
        $newname= $name.'.'.$r->file("ine")->getClientOriginalExtension();
        $src="public/img/docs_reg/".$newname;
        $r->file("ine")->move(
            base_path() . '/public/img/docs_reg/', $newname
        );
        $venta->documento->ine=$src;
        $venta->documento->fecha_entrega_ine=Carbon::now("America/Monterrey")->toDateString();
        $venta->documento->update();
      }

      if ($r->file("escrituras")) {
        $imagen=$venta->documento->escrituras;
        $file=basename($imagen);
        Storage::disk("images")->delete("docs_reg/".$file);

        $original=basename($r->file("escrituras")->getClientOriginalName(), '.'.$r->file("escrituras")->getClientOriginalExtension());
        $name=md5($original.microtime());
        $newname= $name.'.'.$r->file("escrituras")->getClientOriginalExtension();
        $src="public/img/docs_reg/".$newname;
        $r->file("escrituras")->move(
            base_path() . '/public/img/docs_reg/', $newname
        );
        $venta->documento->escrituras=$src;
        $venta->documento->fecha_entrega_escrituras=Carbon::now("America/Monterrey")->toDateString();
        $venta->documento->update();
      }
      return back()->with("id",$r->id);
    }

    public function SubirDocs(Request $r){
      $rules=[
        "acta"=>"image",
        "ine"=>"image",
        "escrituras"=>"image"
      ];
      $trad=[
        "acta.image"=>"Solo se aceptan imagenes!",
        "ine.image"=>"Solo se aceptan imagenes!",
        "escrituras.image"=>"Solo se aceptan imagenes!"
      ];
      $vR=Validator::make($r->all(),$rules,$trad);
      if ($vR->fails()) {
        return back()->with("msgs",$vR->messages())->with("id",$r->id);
      }
      $venta=Venta::find($r->id);
      if ($r->file("acta")) {
        $original=basename($r->file("acta")->getClientOriginalName(), '.'.$r->file("acta")->getClientOriginalExtension());
        $name=md5($original.microtime());
        $newname= $name.'.'.$r->file("acta")->getClientOriginalExtension();
        $src="public/img/docs_reg/".$newname;
        $r->file("acta")->move(
            base_path() . '/public/img/docs_reg/', $newname
        );
        $venta->documento->acta_nacimiento=$src;
        $venta->documento->fecha_entrega_acta=Carbon::now("America/Monterrey")->toDateString();
        $venta->documento->update();
      }
      if ($r->file("ine")) {
        $original=basename($r->file("ine")->getClientOriginalName(), '.'.$r->file("ine")->getClientOriginalExtension());
        $name=md5($original.microtime());
        $newname= $name.'.'.$r->file("ine")->getClientOriginalExtension();
        $src="public/img/docs_reg/".$newname;
        $r->file("ine")->move(
            base_path() . '/public/img/docs_reg/', $newname
        );
        $venta->documento->ine=$src;
        $venta->documento->fecha_entrega_ine=Carbon::now("America/Monterrey")->toDateString();
        $venta->documento->update();
      }
      if ($r->file("escrituras")) {
        $original=basename($r->file("escrituras")->getClientOriginalName(), '.'.$r->file("escrituras")->getClientOriginalExtension());
        $name=md5($original.microtime());
        $newname= $name.'.'.$r->file("escrituras")->getClientOriginalExtension();
        $src="public/img/docs_reg/".$newname;
        $r->file("escrituras")->move(
            base_path() . '/public/img/docs_reg/', $newname
        );
        $venta->documento->escrituras=$src;
        $venta->documento->fecha_entrega_escrituras=Carbon::now("America/Monterrey")->toDateString();
        $venta->documento->update();
      }
      return redirect("ventas_registradas")->with("change",1)->with("id",$r->id);
    }

    public function VentasRegistradas(Request $r){
      return view("secretaria.ventas_registradas")
      ->with("ventas",Venta::orderBy("created_at","desc")->get());
    }

    public function RegistroVentaDefinitivo(Request $r){
      $rules=[
        "tipo_pago"=>"numeric"
      ];
      $vR=Validator::make($r->all(),$rules);
      if ($vR->fails()) {
        return redirect("/registrar_venta");
      }
      $rules=[
        "cliente"=>"required",
        "vendedor"=>"required",
        "casa"=>"required",
        "n_credito_o_banco"=>"required"
      ];
      $trad=[
        "cliente.required"=>"Seleccione un cliente!",
        "vendedor.required"=>"Seleccione un vendedor!",
        "casa.required"=>"Seleccione la propiedad!",
        "n_credito_o_banco.required"=>"Indique la referencia de crédito o cuenta bancaria del cliente!"
      ];
      $vR=Validator::make($r->all(),$rules,$trad);
      if ($vR->fails()) {
        return redirect("/registrar_venta");
      }

      $ventaExiste=Venta::where("casa_id",$r->casa)
      ->where("cliente_id",$r->cliente)
      ->where("status","!=",3)->count();

      if ($ventaExiste>0) {
        return redirect("/ventas_registradas");
      }

      $venta=new Venta();
      $venta->vendedor_id=$r->vendedor;
      $venta->casa_id=$r->casa;
      $venta->cliente_id=$r->cliente;
      $venta->n_credito_o_banco=$r->n_credito_o_banco;
      $venta->fecha_inicio=(new Carbon($r->date_time))->toDateString();
      $venta->status=1;
      $venta->tipo_pago=$r->tipo_pago;
      if ($venta->casa->precio_evaluado) {
        $venta->monto=$venta->casa->precio_evaluado;
      }else{
        $venta->monto=$venta->casa->precio_estimado;
      }
      $venta->secretaria_id=Auth::user()->secretaria->id;
      $venta->save();
      $venta->casa->disponibilidad=2;
      $venta->casa->update();
      foreach ($venta->casa->citas()->where("status",1)->get() as $key => $val) {
        $val->status=3;
        $val->update();
      }
      $documentos=new Documento();
      $documentos->venta_id=$venta->id;
      $documentos->save();
      //Aqui se redirigirá al registro de ventas
      return redirect("/ventas_registradas");
    }

    public function RegistrarVenta(Request $r){
      if ($r->isMethod("POST")) {
        $rules=[
          "tipo_pago"=>"numeric"
        ];
        $vR=Validator::make($r->all(),$rules);
        if ($vR->fails()) {
          return "??";
        }
        $rules=[
          "cliente"=>"required",
          "vendedor"=>"required",
          "casa"=>"required",
          "n_credito_o_banco"=>"required"
        ];
        $trad=[
          "cliente.required"=>"Seleccione un cliente!",
          "vendedor.required"=>"Seleccione un vendedor!",
          "casa.required"=>"Seleccione la propiedad!",
          "n_credito_o_banco.required"=>"Indique la referencia de crédito o cuenta bancaria del cliente!"
        ];
        $vR=Validator::make($r->all(),$rules,$trad);
        if ($vR->fails()) {
          return ["msgs"=>$vR->messages()];
        }

        $cantidadCitas=Cita::where("vendedor_id",$r->vendedor)
        ->where("casa_id",$r->casa)
        ->where("cliente_id",$r->cliente)
        ->where("status","!=",3)
        ->where("fecha_hora","<",(new Carbon($r->date_time))->toDateTimeString())->count();
        if ($cantidadCitas==0) {
          return view("secretaria.respuesta_venta")
          ->with("casa",Casa::find($r->casa))
          ->with("cliente",Cliente::find($r->cliente))
          ->with("vendedor",Vendedor::find($r->vendedor))
          ->with("fecha",$r->date_time)
          ->with("noCita",1);
        }

        $origi=Cita::where("casa_id",$r->casa)
        ->where("cliente_id",$r->cliente)
        ->where("status","!=",3)
        ->where("fecha_hora","<",(new Carbon($r->date_time))->toDateTimeString())
        ->orderBy("fecha_hora","asc")->get()->first()->vendedor;
        if ($origi->id != Vendedor::find($r->vendedor)->id) {
          return view("secretaria.respuesta_venta")
          ->with("casa",Casa::find($r->casa))
          ->with("cliente",Cliente::find($r->cliente))
          ->with("vendedor",Vendedor::find($r->vendedor))
          ->with("fecha",$r->date_time)
          ->with("noPrimera",1)
          ->with("origi",$origi);
        }

        return view("secretaria.respuesta_venta")
        ->with("casa",Casa::find($r->casa))
        ->with("cliente",Cliente::find($r->cliente))
        ->with("vendedor",Vendedor::find($r->vendedor))
        ->with("fecha",$r->date_time);
      }else if($r->isMethod("GET")){
        return view("secretaria.registra_venta");
      }
      return redirect("/");
    }
}
