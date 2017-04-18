@extends('menu_layouts.menu_base')

@section("the_css")
<style media="screen">
#datesSection{
  padding:5px;
}
.card{
  border-radius: 0;
  margin:0;
  padding:10px;
}
.description{
  border-radius: 0;
  margin:0;
  padding:10px;
}
.dateCard:hover{
  cursor:pointer;
  background: #eee;
}
</style>
@endsection

@section('menus')
  @include('secretaria.menussecre')
@endsection

@section('content')
<h2>Registro de citas</h2>
<hr>
@if($citas->count()>0)
<div style="padding:10px;" class="row">
  <div class="col-xs-12 col-sm-10 col-md-8 col-lg-7">
    <div class="form-group">
      <label>Status de cita:</label>
      <select style="border-radius:0;" class="form-control" id="statusFilter">
        <option value="0">Todas las citas</option>
        <option value="1">Pendientes</option>
        <option value="2">Exitosas</option>
        <option value="3">Canceladas</option>
      </select>
    </div>
    <div class="form-group">
      <label>Fecha de cita:</label>
      <select style="border-radius:0;" class="form-control" id="dateFilter">
        <option value="0">Todas las fechas</option>
        <option value="1">Este Mes</option>
        <option value="2">Este Año</option>
      </select>
    </div>
  </div>
</div>
@endif
<section id="datesSection">
@if($citas->count()>0)
  @foreach($citas as $cita)
  <div class="fullCard sf0 sf{{$cita->status}}
    {{(new Carbon\Carbon($cita->fecha_hora))->hour(0)->month == Carbon\Carbon::now('America/Monterrey')->hour(0)->month &&
    (new Carbon\Carbon($cita->fecha_hora))->hour(0)->year == Carbon\Carbon::now('America/Monterrey')->hour(0)->year ? 'df1 df2 df0' : (
    (new Carbon\Carbon($cita->fecha_hora))->hour(0)->year == Carbon\Carbon::now('America/Monterrey')->hour(0)->year ? 'df2 df0' : 'df0')}}">
    <div data-cita-id="{{$cita->id}}" class="thumbnail card dateCard">
      <div class="row">
        <div style="padding:5px;" align="center" class="col-xs-12 col-md-2">
          @if($cita->status==1)
          <span><span class="glyphicon glyphicon-warning-sign"></span> <b class="hidden-sm">Pendiente</b></span>
          @elseif($cita->status==2)
          <span style="color:#5CB85C;"><span class="glyphicon glyphicon-ok"></span> <b class="hidden-sm">Exitosa</b></span>
          @else
          <span style="color:#D9534F;"><span class="glyphicon glyphicon-remove"></span> <b class="hidden-sm">Cancelada</b></span>
          @endif
        </div>
        <div style="padding:5px;" align="center" class="col-xs-12 col-md-6">
          <span><i>Cliente:</i> {{$cita->cliente->nombre." "
            .$cita->cliente->ap_paterno." "
            .$cita->cliente->ap_materno}}</span>
        </div>
        <div style="padding:5px; font-style:italic;" align="center" class="col-xs-12 col-md-4">
            {{date_format(date_create($cita->fecha_hora), "Y-m-d")
            ." ".date_format(date_create($cita->fecha_hora), "g:i a")}}
        </div>
      </div>
    </div>
    <div style="display:none;" id="desc{{$cita->id}}" class="thumbnail description">
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <img style="border:2px solid lightgray;" class="img-responsive" src="{{$cita->casa->fotos[0]->string_foto}}" alt="">
        </div>
        <div style="padding:13px 23px 13px 23px;" class="col-md-6 col-xs-12">
          @if($cita->tipo_cita==1)
          <h4>Visita a propiedad</h4>
          @else
          <h4>Entrega de documentos. Folio: {{$cita->venta_docs_id}}.</h4>
          @endif
          <p><b>Agendó: </b>{{$cita->secretaria->nombre." "
          .$cita->secretaria->ap_paterno." ".$cita->secretaria->ap_materno."."}}</p>
          <p><b>Vendedor: </b>{{$cita->vendedor->nombre." "
          .$cita->vendedor->ap_paterno." ".$cita->vendedor->ap_materno."."}}</p>
          <p><b>Direccion: </b>{{"#".$cita->casa->numero_exterior. ($cita->casa->numero_interior ? " Int. ".$cita->casa->numero_interior:"")
          .", ".$cita->casa->calle_o_avenida
          .", Col. ".$cita->casa->colonia."."}}</p>
          <p><b>{{$cita->casa->ciudad}}.</b></p>

          @if($cita->status==1)
            @if($today >= $cita->fecha_hora)
            <button data-cita-id="{{$cita->id}}" type="button" class="btn btn-success btn-sm successDate" name="button" data-toggle="modal" data-target="#citaModalS"><span class="glyphicon glyphicon-ok"></span> <b>Exitosa</b></button>
            @endif
          <button data-cita-id="{{$cita->id}}" type="button" class="btn btn-warning btn-sm cancelDate" name="button" data-toggle="modal" data-target="#citaModalC"><span class="glyphicon glyphicon-remove"></span> <b>Cancelada</b></button>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endforeach
@else
<h4 align="center"><i>No hay citas registradas.</i></h4>
@endif
</section>
<br>

<!-- Modal DATE SUCCESS-->
<div class="modal fade" id="citaModalS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Cita exitosa</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <div class="modal-body">
        <div id="citaDatosS">
          <h4 align="center">¿Segur@ de establecer como exitosa?</h4>
          <br>
          <form action="/cita_exitosa" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="id" id="input_success" value="">
            <button type="submit" style="border-radius:0;" class="btn btn-block btn-success"><span class="glyphicon glyphicon-ok"></span> <b>Guardar</b></button>
          </form>
          <br>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" style="border-radius:0;" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal DATE CANCEL-->
<div class="modal fade" id="citaModalC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Cancelar cita</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <div class="modal-body">
        <div id="citaDatosC">
          <h4 align="center">¿Segur@ de cancelar esta cita?</h4>
          <br>
          <form action="/cancelar_cita" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="id" id="input_cancel" value="">
            <button type="submit" style="border-radius:0;" class="btn btn-block btn-warning"><span class="glyphicon glyphicon-remove"></span> <b>Cancelar cita</b></button>
          </form>
          <br>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" style="border-radius:0;" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section("the_js")
<script type="text/javascript">
$(function(){
  $("#dateFilter").change(function(){
    var df=".df"+$("#dateFilter").val();
    var sf=".sf"+$("#statusFilter").val();

    $(".fullCard").not(sf).hide('3000');
    $(".fullCard").not(df).hide('3000');
    $(".fullCard").filter(sf).filter(df).show('3000');
  })
  $("#statusFilter").change(function(){
    var df=".df"+$("#dateFilter").val();
    var sf=".sf"+$("#statusFilter").val();

    $(".fullCard").not(sf).hide('3000');
    $(".fullCard").not(df).hide('3000');
    $(".fullCard").filter(df).filter(sf).show('3000');
  })
})
</script>
<script type="text/javascript">
$(function(){
  $(".successDate").click(function(){
    $("#input_success").val($(this).attr("data-cita-id"));
  })
  $(".cancelDate").click(function(){
    $("#input_cancel").val($(this).attr("data-cita-id"));
  })
})
</script>
<script type="text/javascript">
$(function(){
  $(".card").click(function(){
    //Graphical issue to show that something is selected
    $("#desc"+$(this).attr("data-cita-id")).slideToggle(300);
  })
})
</script>
@endsection
