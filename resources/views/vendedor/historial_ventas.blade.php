@extends('menu_layouts.menu_base')

@section("the_css")
<style media="screen">
#salesSection{
  overflow-y: auto;
  max-height: 1100px;
  padding:10px;
}
.card{
  border-radius: 0;
  margin:0;
  padding:10px;
  background: #eee;
  color:#212121;
}
.description{
  border-radius: 0;
  margin:0;
  padding:10px;
}
.saleCard:hover{
  cursor:pointer;
  background: #ddd;
}
</style>
@endsection

@section('menus')
  @include('vendedor.menusvendedor')
@endsection

@section('content')
<h3>Historial de ventas</h3>
<hr>
@if($ventas->count()>0)
<div style="padding:10px;" class="row">
  <div class="col-xs-12 col-sm-10 col-md-8 col-lg-7">
    <div class="form-group">
      <label>Status de venta:</label>
      <select style="border-radius:0;" class="form-control" id="statusFilter">
        <option value="0">Todas las ventas</option>
        <option value="2">Concretadas</option>
        <option value="3">Canceladas</option>
      </select>
    </div>
    <div class="form-group">
      <label>Inicio de trámite:</label>
      <select style="border-radius:0;" class="form-control" id="dateFilter">
        <option value="0">Todas las fechas</option>
        <option value="1">Este Mes</option>
        <option value="2">Este Año</option>
      </select>
    </div>
  </div>
</div>
@endif
<section id="salesSection">
@if($ventas->count() > 0)
  @foreach($ventas as $venta)
  <div class="fullCard sf0 sf{{$venta->status}}
    {{(new Carbon\Carbon($venta->fecha_inicio))->hour(0)->month == Carbon\Carbon::now('America/Monterrey')->hour(0)->month &&
    (new Carbon\Carbon($venta->fecha_inicio))->hour(0)->year == Carbon\Carbon::now('America/Monterrey')->hour(0)->year ? 'df1 df2 df0' : (
    (new Carbon\Carbon($venta->fecha_inicio))->hour(0)->year == Carbon\Carbon::now('America/Monterrey')->hour(0)->year ? 'df2 df0' : 'df0')}}">
    <div data-venta-id="{{$venta->id}}" class="thumbnail card saleCard">
      <div class="row">
        <div style="padding:5px;" align="center" class="col-xs-12 col-md-3">
          <span><b>Folio {{$venta->id}}</b></span>
        </div>
        <div style="padding:5px;" align="center" class="col-xs-12 col-md-6">
          <span><i>Cliente:</i> <b>{{$venta->cliente->nombre." "
            .$venta->cliente->ap_paterno." "
            .$venta->cliente->ap_materno}}</b></span>
        </div>
        <div style="padding:5px;" align="center" class="col-xs-12 col-md-3">
          @if($venta->status==1)
          <span style="color:#428BCA;"><span class="glyphicon glyphicon-exclamation-sign"></span> <b>En trámite</b></span>
          @elseif($venta->status==2)
          <span style="color:#5CB85C;"><span class="glyphicon glyphicon-ok-sign"></span> <b>Concretada</b></span>
          @else
          <span style="color:#D9534F;"><span class="glyphicon glyphicon-remove-sign"></span> <b>Cancelada</b></span>
          @endif
        </div>
      </div>
    </div>
    <div style="display:none;" id="desc{{$venta->id}}" class="thumbnail description">
      <div class="row">
        <div style="padding:13px 23px 13px 23px;" class="col-md-6 col-xs-12">
          <img style="border:2px solid lightgray;" class="img-responsive" src="{{$venta->casa->fotos[0]->string_foto}}" alt="">
          @if($venta->casa->precio_evaluado)
          <span style="margin:2px;" class="badge">Evaluado: ${{$venta->casa->precio_evaluado}}</span>
          @else
          <span style="margin:2px;" class="badge">No evaluado: ${{$venta->casa->precio_estimado}}</span>
          @endif
          <br><br>
          <p><b>Direccion:</b> {{"#".$venta->casa->numero_exterior. ($venta->casa->numero_interior ? " Int. ".$venta->casa->numero_interior:"")
            .", ".$venta->casa->calle_o_avenida
            .", Col. ".$venta->casa->colonia."."}}
          </p>
          <p>
            <b>{{$venta->casa->ciudad}}.</b>
          </p>

          @if($venta->monto_cubierto && $venta->status==2)
          <!-- ESCRITURAS DE LA CASA -->
          <div align="center">
            <br>
            <h4><b>Escrituras de la propiedad.</b></h4>
            <!-- Escrituras imagen -->
                <p><button type="button" class="btn btn-default btn-xs btnDoc" name="button" data-type="3" data-document="{{$venta->documento->escrituras}}" data-id-venta="{{$venta->id}}" data-doc-title="Escrituras de propiedad." data-toggle="modal" data-target="#modalDoc"><span class="glyphicon glyphicon-picture"></span></button>
                  <b>Escrituras.</b>
                </p>
              <br>
            <!-- Notario -->
            <p>
              <i>Notario:</i>
              {{$venta->notario->nombre." "
              .$venta->notario->ap_paterno." ".$venta->notario->ap_materno."."}}
            </p>
            <br>
          </div>
          @endif
          <!--******************-->
        </div>
        <div style="padding:13px 23px 13px 23px;" class="col-md-6 col-xs-12">
          <h5 align="right"><i>Inició: {{date_format(date_create($venta->fecha_inicio), "Y/m/d")}}</i></h5>
          <h5 align="right"><i>Se cerró: {{date_format(date_create($venta->fecha_cierre), "Y/m/d")}}</i></h5>

          <p><b>Contacto cliente:</b> {{$venta->cliente->contacto}}.</p>
          <p><b>Registró:</b> {{$venta->secretaria->nombre." "
            .$venta->secretaria->ap_paterno." "
            .$venta->secretaria->ap_materno."."}}
            el día <i>{{date_format(date_create($venta->created_at), "Y-m-d")}}</i>
            a las <i>{{date_format(date_create($venta->created_at), "g:i a")}}.</i>
          </p>
          <br>
          @if($venta->tipo_pago==1)
            <h4><b>Tipo pago:</b> INFONAVIT.</h4>
          @elseif($venta->tipo_pago==2)
            <h4><b>Tipo pago:</b> FOVISSSTE.</h4>
          @else
            <h4><b>Tipo pago:</b> Trato directo.</h4>
          @endif
          <p><b>Referencia:</b> {{$venta->n_credito_o_banco}}.</p>
          <p><b>Monto:</b> <span style="font-size:13px;" class="badge">$ {{$venta->monto}}</span></p>
          @if($venta->monto_cubierto)
          <p><span style="color:#5CB85C;"><span class="glyphicon glyphicon-ok"></span> <b>Cubierto y registrado el <i>{{date_format(date_create($venta->monto_cubierto), "Y/m/d")}}</i>.</b></span></p>
          @endif
          <br>
          <h4><b>Documentos del cliente:</b></h4>
          <div>

              @if($venta->documento->acta_nacimiento)
              <p><button type="button" class="btn btn-default btn-xs btnDoc" name="button" data-type="1" data-document="{{$venta->documento->acta_nacimiento}}" data-id-venta="{{$venta->id}}" data-doc-title="Acta de nacimiento." data-toggle="modal" data-target="#modalDoc"><span class="glyphicon glyphicon-picture"></span></button>
                <b>Acta de nacimiento.</b>
              </p>
              @else
              <p><b><span class="glyphicon glyphicon-unchecked"></span> Acta de nacimiento.</b></p>
              @endif

              @if($venta->documento->ine)
              <p><button type="button" class="btn btn-default btn-xs btnDoc" name="button" data-type="2" data-document="{{$venta->documento->ine}}" data-id-venta="{{$venta->id}}" data-doc-title="INE." data-toggle="modal" data-target="#modalDoc"><span class="glyphicon glyphicon-picture"></span></button>
                <b>INE.</b>
              </p>
              @else
              <p><b><span class="glyphicon glyphicon-unchecked"></span> INE.</b></p>
              @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
@else
  <h4 align="center"><i>No hay ventas que mostrar.</i></h4>
@endif
</section>
<br>

<!-- Modal document -->
<div class="modal fade" id="modalDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b id="modalDocTitle"></b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <div class="modal-body">
        <div align="center" id="imageField">
          <img id="imageToShow" class="img-responsive" src="" alt="">
        </div>
        <div style="display:none;" id="formField"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section("the_js")
<script type="text/javascript">
$(function(){
  $("#modalDoc").on("show.bs.modal", function () {
    $("#formField").hide().empty();
  });
  $(".btnDoc").click(function(){
    $("#imageToShow").attr("src",$(this).attr("data-document"));
    $("#modalDocTitle").text($(this).attr("data-doc-title"));
  })
})
</script>

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
  $(".card").click(function(){
    //Graphical issue to show that something is selected
    $("#desc"+$(this).attr("data-venta-id")).slideToggle(300);
  })
})
</script>
@endsection
