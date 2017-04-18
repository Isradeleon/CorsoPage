<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Status</title>
    <style media="screen">
      body{
        font-family: sans-serif;
        padding:20px;
        border:1px solid black;
        margin:0;
      }
    </style>
  </head>
  <body>
    <h1 align="center">Grupo Corso.</h1>
    <h2 align="center">Status de venta.</h2>
    <h2 align="center">Cliente: {{$venta->cliente->nombre." ".
    $venta->cliente->ap_paterno." ".$venta->cliente->ap_materno}}.</h2>
    <h3>
      <b>Monto: ${{$venta->monto}}</b> <span style="color:#5CB85C;">-
      Cubierto y registrado el {{date_format(date_create($venta->monto_cubierto), "Y-m-d")}}.</span>
    </h3>
    <h3>Datos del vendedor</h3>
    <p>
      <b>Nombre completo:</b> {{$venta->vendedor->nombre." ".
      $venta->vendedor->ap_paterno." ".$venta->vendedor->ap_materno}}.
    </p>
    <p>
      <b>Contacto:</b> {{$venta->vendedor->contacto}}.
    </p>
    <br>
    <h3>Datos del registro</h3>
    <p><b>Registró:</b> {{$venta->secretaria->nombre." "
      .$venta->secretaria->ap_paterno." "
      .$venta->secretaria->ap_materno."."}}
      El día <i>{{date_format(date_create($venta->created_at), "Y-m-d")}}</i>
      a las <i>{{date_format(date_create($venta->created_at), "g:i a")}}.</i>
    </p>
    <br>
    <h3>Datos de la propiedad</h3>
    <img style="height:200px; border:1px solid black;" src="{{public_path().$venta->casa->fotos[0]->string_foto}}" alt="">
    <p><b>Direccion:</b> {{"#".$venta->casa->numero_exterior. ($venta->casa->numero_interior ? " Int. ".$venta->casa->numero_interior:"")
      .", ".$venta->casa->calle_o_avenida
      .", Col. ".$venta->casa->colonia."."}}
    </p>
    <p>
      <b>{{$venta->casa->ciudad}}.</b>
    </p>
    <br><br><br>
    <div align="center">
      <h3>Documentos registrados exitosamente:</h3>
      <p><b>Acta de nacimiento.</b></p>
      @if($venta->documento->acta_nacimiento)
      <img style="height:200px; border:1px solid black;" src="{{public_path().$venta->documento->acta_nacimiento}}" alt="">
      @else
      <p>Pendiente.</p>
      @endif

      <p><b>INE.</b></p>
      @if($venta->documento->ine)
      <img style="height:200px; border:1px solid black;" src="{{public_path().$venta->documento->ine}}" alt="">
      @else
      <p>Pendiente.</p>
      @endif

      @if($venta->monto_cubierto)
        <p><b>Escrituras</b></p>
        @if($venta->documento->escrituras)
        <img style="height:200px; border:1px solid black;" src="{{public_path().$venta->documento->escrituras}}" alt="">
        @else
        <p>Pendiente.</p>
        @endif

        <p><b>Notario:</b> {{$venta->notario ? $venta->notario->nombre." "
        .$venta->notario->ap_paterno." "
        .$venta->notario->ap_materno : "Pendiente"}}.</p>
      @endif
    </div>
  </body>
</html>
