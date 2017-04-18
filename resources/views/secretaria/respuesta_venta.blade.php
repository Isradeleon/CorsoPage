<style media="screen">
.imageForSale{
  height: 220px;
  width: 250px;
  border: 5px solid lightgray;
}
</style>
<section>
  <div align="center">
    <div class="imageForSale"
    style="background:url({{$casa->fotos[0]->string_foto}});
    background-position:center center; background-size: auto 230px; padding:5px;">
      <h6>
        <span style="background:white; color:black;" class="badge pull-right">@if($casa->precio_evaluado) ${{$casa->precio_evaluado}} @else Estimado ${{$casa->precio_estimado}} @endif </span>
      </h6>
    </div>
  </div>
  <br>
  <div align="center">
    <p><b>{{"#".$casa->numero_exterior. ($casa->numero_interior ? " Int. ".$casa->numero_interior:"")
    .", ".$casa->calle_o_avenida
    .", Col. ".$casa->colonia."."}}<br>{{$casa->ciudad}}</b></p>
    <br>
    <p><b>Datos del cliente: </b>{{$cliente->nombre." ".$cliente->ap_paterno." ".$cliente->ap_materno}}, <b>Con: </b>{{$cliente->contacto}}.</p>
    <p><b>Datos del vendedor: </b>{{$vendedor->nombre." ".$vendedor->ap_paterno." ".$vendedor->ap_materno}}, <b>Con: </b>{{$vendedor->contacto}}.</p>
    <p><b>Fecha venta:</b> {{(new Carbon\Carbon($fecha))->toDateString()}}</p>
  </div>
  <br>
  @if(isset($noCita))
  <h5 style="color:#D9534F;" align="center"><span class="glyphicon glyphicon-exclamation-sign"></span> <b>Advertencia:</b> El vendedor y el cliente no tienen citas previas en esta propiedad!</h5>
  @elseif(isset($noPrimera))
  <h5 style="line-height:20px; color:#D9534F;" align="center">
    <span class="glyphicon glyphicon-exclamation-sign"></span> <b>Advertencia:</b> La primera visita exitosa a esta propiedad fue originalmente programada con:<br><br>
    <b>Vendedor:</b> {{$origi->nombre." ".$origi->ap_paterno." ".$origi->ap_materno}}, <b>Con: </b>{{$origi->contacto}}.
  </h5>
  @endif
  <br>
  <div align="center">
    <button style="border-radius:0;" class="btn btn-success btn-block" type="button" name="button" id="btnDef"><span class="glyphicon glyphicon-usd"></span> <b>Registrar venta</b></button>
  </div>
</section>
<script>
$(function(){
  $("#btnDef").click(function(){
    $("#formVenta").submit();
  })
})
</script>
