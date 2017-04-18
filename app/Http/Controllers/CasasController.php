<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Casa;
use App\Foto;
use Validator;
use Session;

class CasasController extends Controller
{
  public function AgregarFotos(Request $r){
    if($r->isMethod("POST")){
      $trad = [
        "the_files.required"=>"Selecciona las imagenes!",
        "the_files.*.image"=>"Solo se aceptan imagenes!"
      ];
      $rules=[
        "the_files"=>"required",
        "the_files.*"=>"required|image"];
      $vRes=Validator::make($r->all(),$rules,$trad);
      if ($vRes->fails()) {
        return back()->withInput()->with("msgs", $vRes->messages())
        ->with("id_casa",$r->input("id"));
      }
      $casa=Casa::find($r->input("id"));
      $sources=[];
      foreach ($r->file("the_files") as $file) {
        $original=basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
        $name=md5($original.microtime());
        $newname= $name.'.'.$file->getClientOriginalExtension();
        $src="public/img/casas_reg/".$newname;
        $file->move(
            base_path() . '/public/img/casas_reg/', $newname
        );
        $sources[]=$src;
      }

      foreach ($sources as $src) {
        $pick=new Foto();
        $pick->string_foto=$src;
        $pick->casa_id=$casa->id;
        $pick->save();
      }
      return back()->with("id_casa",$r->input("id"));
    }
    return redirect("/casas_venta");
  }

  public function EliminarFoto(Request $r){
    if($r->isMethod("POST")){
      $casa=Casa::find($r->input("id_casa"));
      if ($casa->fotos->count()>1) {
        $foto=Foto::find($r->input("id_foto"));
        $file=basename($foto->string_foto);
        Storage::disk("images")->delete("casas_reg/".$file);
        $foto->delete();
      }else{
        return back()->with("msgsP",["La casa no puede quedarse sin imágenes!"])
        ->with("id_casa",$r->input("id_casa"));
      }
    }
    return back()->with("id_casa",$r->input("id_casa"));
  }

  public function EvaluarPrecio(Request $r){
    if($r->isMethod("POST")){
      if ($r->input("precio_evaluado") && $r->input("fecha_ultima_evaluacion")) {
        $rules=["id"=>"required"];
        $vRes=Validator::make($r->all(),$rules);
        if($vRes->fails()){
          return back()->withInput()->with("msgs", $vRes->messages())
          ->with("id_casa",$r->input("id"));
        }

        $trad = ["precio_evaluado.regex"=>"Formato inválido"];
        $rules=["precio_evaluado"=>"regex:/^\d*(\.\d{1,2})?$/"];
        $vRes=Validator::make($r->all(),$rules,$trad);
        if ($vRes->fails()) {
          return back()->withInput()->with("msgs", $vRes->messages())
          ->with("id_casa",$r->input("id"));
        }

        $casa=Casa::find($r->input("id"));
        $casa->precio_evaluado=$r->input("precio_evaluado");
        $casa->fecha_ultima_evaluacion=$r->input("fecha_ultima_evaluacion");
        $casa->update();
      }else{
        return back()->with("id_casa",$r->input("id"));
      }
    }
    return redirect("/casas_venta");
  }

  public function EditarCasa(Request $r){
    if ($r->isMethod("GET") && Session::has("id_casa")) {
      $id=Session::get("id_casa");
      $casa = Casa::find($id);
      return view("secretaria.editar_casa")->with("casa",$casa);
    }else if($r->isMethod("POST")){
      $rules=["id"=>"required",
        "calle"=>"required", "colonia"=>"required", "ciudad"=>"required",
        "lat"=>"required","lng"=>"required"];
      $vRes=Validator::make($r->all(),$rules);
      if($vRes->fails()){
        return back()->withInput()->with("msgs", $vRes->messages())
        ->with("id_casa",$r->input("id"));
      }

      $casa=Casa::find($r->input("id"));
      $casa->calle_o_avenida=$r->input("calle");
      $casa->colonia=$r->input("colonia");
      $casa->ciudad=$r->input("ciudad");
      $casa->eje_x_mapa=$r->input("lat");//lat
      $casa->eje_y_mapa=$r->input("lng");//lng

      if ($r->input("num_int")) {
        $casa->numero_interior=$r->input("num_int");
      }
      if ($r->input("num_ext")) {
        $casa->numero_exterior=$r->input("num_ext");
      }
      if ($r->input("superficie")) {
        $casa->superficie=$r->input("superficie");
      }
      if ($r->input("detalles")) {
        $casa->detalles=$r->input("detalles");
      }
      if ($r->input("precio_estimado")) {
        $trad = ["precio_estimado.regex"=>"Formato inválido!"];
        $rules=["precio_estimado"=>"regex:/^\d*(\.\d{1,2})?$/"];
        $vRes=Validator::make($r->all(),$rules,$trad);
        if($vRes->fails()){
          return back()->withInput()->with("msgs", $vRes->messages())
          ->with("id_casa",$r->input("id"));
        }
        $casa->precio_estimado=$r->input("precio_estimado");
      }
      if ($r->input("habitaciones")) {
        $trad = ["habitaciones.integer"=>"Número no válido",
                  "habitaciones.min"=>"No números negativos!"];
        $rules=["habitaciones"=>"integer|min:1"];
        $vRes=Validator::make($r->all(),$rules,$trad);
        if($vRes->fails()){
          return back()->withInput()->with("msgs", $vRes->messages())
          ->with("id_casa",$r->input("id"));
        }
        $casa->num_habitaciones=$r->input("habitaciones");
      }
      if ($r->input("banos")) {
        $trad = ["banos.integer"=>"Número no válido",
                  "banos.min"=>"No números negativos!"];
        $rules=["banos"=>"integer|min:1"];
        $vRes=Validator::make($r->all(),$rules,$trad);
        if($vRes->fails()){
          return back()->withInput()->with("msgs", $vRes->messages())
          ->with("id_casa",$r->input("id"));
        }
        $casa->num_banos=$r->input("banos");
      }
      $casa->update();
    }
    return redirect("/casas_venta");
  }

  public function EditarCasaId(Request $r,$id){
    if($r->isMethod("GET")){
      return redirect("/editar_casa")->with("id_casa",$id);
    }
    return redirect("/");
  }

  public function CasaPorId(Request $r){
    if($r->isMethod("POST")){
        return Casa::findOrFail($r->input('id'));
    }else{
        return redirect("/");
    }
  }

  public function CasaFotos(Request $r){
    if($r->isMethod("POST")){
        return Casa::findOrFail($r->input('id'))->fotos;
    }else{
        return redirect("/");
    }
  }

  public function VerCasasEnVenta(Request $r){
    return view("casas.ver_casas")->with("casas",Casa::where("disponibilidad",1)->get())
    ->with("tipo_casas",1);
  }

  public function VerCasasEnTramite(Request $r){
    return view("casas.ver_casas")->with("casas",Casa::where("disponibilidad",2)->get())
    ->with("tipo_casas",2);
  }

  public function VerCasasVendidas(Request $r){
    return view("casas.ver_casas")->with("casas",Casa::where("disponibilidad",3)->get())
    ->with("tipo_casas",3);
  }

  public function RegistrarCasa(Request $peticion){
      if($peticion->method() == "POST") {
        $rules=[
          "calle"=>"required", "colonia"=>"required", "ciudad"=>"required",
          "lat"=>"required","lng"=>"required",
          "num_ext"=>"required","superficie"=>"required",
          "habitaciones"=>"required|integer|min:1","banos"=>"required|integer|min:1",
          "the_files"=>"required","the_files.*"=>"image",
          "precio_estimado"=>"required|regex:/^\d*(\.\d{1,2})?$/",
          "detalles"=>"required"];
        $trad = [
          "num_ext.required" => "Indica el No. Externo",
          "superficie.required"=>"Completa el campo Superficie",
          "the_files.required"=>"Selecciona al menos una imagen!",
          "the_files.*.image"=>"Solo se aceptan imagenes!",
          "precio_estimado.required"=>"Indica el precio estimado!",
          "precio_estimado.regex"=>"Formato inválido!",
          "detalles.required"=>"Indica más detalles!",
          "habitaciones.required"=>"Indica un # de habitaciones",
          "banos.required"=>"Indica un # de baños"];

        $vRes=Validator::make($peticion->all(),$rules,$trad);

        if($vRes->fails()){
          return back()->withInput()->with("msgs", $vRes->messages());
        }

        $casa=new Casa();
        $casa->numero_exterior=$peticion->input("num_ext");
        if($peticion->input("num_int"))
          $casa->numero_interior=$peticion->input("num_int");
        $casa->calle_o_avenida=$peticion->input("calle");
        $casa->colonia=$peticion->input("colonia");
        $casa->superficie=$peticion->input("superficie");
        $casa->eje_x_mapa=$peticion->input("lat");//lat
        $casa->eje_y_mapa=$peticion->input("lng");//lng
        $casa->num_habitaciones=$peticion->input("habitaciones");
        $casa->num_banos=$peticion->input("banos");
        $casa->detalles=$peticion->input("detalles");
        $casa->precio_estimado=$peticion->input("precio_estimado");
        $casa->disponibilidad=1;
        $casa->ciudad=$peticion->input("ciudad");
        $casa->save();

        $sources=[];
        foreach ($peticion->file("the_files") as $file) {
          $original=basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
          $name=md5($original.microtime());
          $newname= $name.'.'.$file->getClientOriginalExtension();
          $src="public/img/casas_reg/".$newname;
          $file->move(
              base_path() . '/public/img/casas_reg/', $newname
          );
          $sources[]=$src;
        }

        foreach ($sources as $src) {
          $pick=new Foto();
          $pick->string_foto=$src;
          $pick->casa_id=$casa->id;
          $pick->save();
        }

        return redirect("/casas_venta");
      }else if($peticion->isMethod("GET")){
        return view("secretaria.registra_casa");
      }else{
        return redirect('/');
      }
  }
}
