@extends('menu_layouts.menu_base')

@section("the_css")
<style media="screen">
#salesSection{
  padding:5px;
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
  @include('secretaria.menussecre')
@endsection

@section('content')
<h3>Registro de ventas</h3>
<hr>
@if($ventas->count()>0)
<div style="padding:10px;" class="row">
  <div class="col-xs-12 col-sm-10 col-md-8 col-lg-7">
    <div class="form-group">
      <label>Status de venta:</label>
      <select style="border-radius:0;" class="form-control" id="statusFilter">
        <option value="0">Todas las ventas</option>
        <option value="1">En trámite</option>
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
          @if($venta->status==1 && $venta->monto_cubierto==null)
          <br>
          <button data-venta-id="{{$venta->id}}" type="button" class="btn btn-danger btn-block cancelSale" name="button" data-toggle="modal" data-target="#ventaModalC"><span class="glyphicon glyphicon-remove-sign"></span> Cancelada</button>
          <br>
          @elseif($venta->monto_cubierto)
          <!-- ESCRITURAS DE LA CASA -->
          <div align="center">
            <br>
            <h4><b>Escrituras de la propiedad.</b></h4>
            <!-- Escrituras imagen -->
              @if($venta->documento->escrituras==null && $venta->status==1)
              <form enctype="multipart/form-data" action="/subir_docs" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="id" value="{{$venta->id}}">
              @endif
                @if($venta->documento->escrituras)
                <p><button type="button" class="btn btn-default btn-xs btnDoc" name="button" data-type="3" data-document="{{$venta->documento->escrituras}}" data-id-venta="{{$venta->id}}" data-doc-title="Escrituras de propiedad." data-toggle="modal" data-target="#modalDoc"><span class="glyphicon glyphicon-picture"></span></button>
                  <b>Escrituras.</b>
                  @if(Session::has("msgs") && Session::get("msgs")->has("escrituras"))
                    <span style="color:#D9534F;">{{Session::get("msgs")->get("escrituras")[0]}}</span>
                  @endif
                </p>
                @elseif($venta->status==1)
                <p>
                  <label class="btn btn-warning btn-xs theFile">
                  <span id="m" style="font-weight: normal;"><span class="glyphicon glyphicon-folder-open"></span></span>
                  <input accept=".jpg, .png, .jpeg" type="file" name="escrituras" style="display: none;">
                  </label>
                  <b>Escrituras.</b>
                  @if(Session::has("msgs") && Session::get("msgs")->has("escrituras"))
                    <span style="color:#D9534F;">{{Session::get("msgs")->get("escrituras")[0]}}</span>
                  @endif
                </p>
                @endif
              @if($venta->documento->escrituras==null && $venta->status==1)
                <button type="submit" class="btn btn-success btn-sm" name="button">Subir archivos</button>
              </form>
              <br>
              @endif
              <br>
            <!-- Notario -->
            <p>
              <i>Notario:</i>
              {{$venta->notario ? $venta->notario->nombre." "
              .$venta->notario->ap_paterno." ".$venta->notario->ap_materno."." : "Pendiente."}}
            </p>
            @if($venta->status==1)
            <p>
              <button data-notario-v="{{$venta->id}}" type="button" class="btn btn-sm btn-info btnInNotario" data-toggle="modal" data-target="#modalNotario">
                Indicar notario
              </button>
            </p>
              @if($venta->notario && $venta->documento->escrituras)
              <br>
              <p>
                <button data-id-venta="{{$venta->id}}" style="border-radius:0;" class="btn btn-success btn-block btnConcretada" type="button" name="button" data-toggle="modal" data-target="#modalConcretada"><span class="glyphicon glyphicon-ok-circle"></span> <b>Registrar venta concretada</b></button>
              </p>
              @endif
            @endif
            <br>
          </div>
          @endif
          <!--******************-->
        </div>
        <div style="padding:13px 23px 13px 23px;" class="col-md-6 col-xs-12">
          <h5 align="right"><i>Inició: {{date_format(date_create($venta->fecha_inicio), "Y/m/d")}}</i></h5>
          @if($venta->fecha_cierre)
          <h5 align="right"><i>Se cerró: {{date_format(date_create($venta->fecha_cierre), "Y/m/d")}}</i></h5>
          @endif
          <h4><b>Vendedor:</b> {{$venta->vendedor->nombre." "
            .$venta->vendedor->ap_paterno." ".$venta->vendedor->ap_materno}}.
          </h4>
          <p><b>Contacto cliente:</b> {{$venta->cliente->contacto}}.</p>
          <p><b>Registró:</b> {{$venta->secretaria->nombre." "
            .$venta->secretaria->ap_paterno." "
            .$venta->secretaria->ap_materno}},
            el día <i>{{date_format(date_create($venta->created_at), "Y-m-d")}}</i>,
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
          <p><b>Referencia:</b> <span style="word-wrap:break-word;">{{$venta->n_credito_o_banco}}.</span></p>
          <p><b>Monto:</b> <span style="font-size:13px;" class="badge">$ {{$venta->monto}}</span></p>
          @if($venta->monto_cubierto)
          <p><span style="color:#5CB85C;"><span class="glyphicon glyphicon-ok"></span> <b>Cubierto y registrado el <i>{{date_format(date_create($venta->monto_cubierto), "Y/m/d")}}</i>.</b></span></p>
          @elseif($venta->status==1 && $venta->documento->acta_nacimiento && $venta->documento->ine)
          <p>
            <button data-venta-id="{{$venta->id}}" type="button" class="btn btn-success btn-sm successSale" name="button" data-toggle="modal" data-target="#ventaModalS">
            <span class="glyphicon glyphicon-ok"></span> Registrar monto cubierto</button>
          </p>
          @endif
          <br>
          <h4><b>Documentos del cliente:</b></h4>
          <div>
            @if($venta->documento->ine==null || $venta->documento->acta_nacimiento==null)
            <form enctype="multipart/form-data" action="/subir_docs" method="post">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <input type="hidden" name="id" value="{{$venta->id}}">
            @endif
              @if($venta->documento->acta_nacimiento)
              <p><button type="button" class="btn btn-default btn-xs btnDoc" name="button" data-type="1" data-document="{{$venta->documento->acta_nacimiento}}" data-id-venta="{{$venta->id}}" data-doc-title="Acta de nacimiento." data-toggle="modal" data-target="#modalDoc"><span class="glyphicon glyphicon-picture"></span></button>
                <b>Acta de nacimiento.</b>
                @if(Session::has("msgs") && Session::get("msgs")->has("acta"))
                  <span style="color:#D9534F;">{{Session::get("msgs")->get("acta")[0]}}</span>
                @endif
              </p>
              @elseif($venta->status==1)
              <p>
                <label class="btn btn-warning btn-xs theFile">
                <span id="m" style="font-weight: normal;"><span class="glyphicon glyphicon-folder-open"></span></span>
                <input accept=".jpg, .png, .jpeg" type="file" name="acta" style="display: none;">
                </label>
                <b>Acta de nacimiento.</b>
                @if(Session::has("msgs") && Session::get("msgs")->has("acta"))
                  <span style="color:#D9534F;">{{Session::get("msgs")->get("acta")[0]}}</span>
                @endif
              </p>
              @else
              <p><b><span class="glyphicon glyphicon-unchecked"></span> Acta de nacimiento.</b></p>
              @endif

              @if($venta->documento->ine)
              <p><button type="button" class="btn btn-default btn-xs btnDoc" name="button" data-type="2" data-document="{{$venta->documento->ine}}" data-id-venta="{{$venta->id}}" data-doc-title="INE." data-toggle="modal" data-target="#modalDoc"><span class="glyphicon glyphicon-picture"></span></button>
                <b>INE.</b>
                @if(Session::has("msgs") && Session::get("msgs")->has("ine"))
                  <span style="color:#D9534F;">{{Session::get("msgs")->get("ine")[0]}}</span>
                @endif
              </p>
              @elseif($venta->status==1)
              <p>
                <label class="btn btn-warning btn-xs theFile">
                <span id="m" style="font-weight: normal;"><span class="glyphicon glyphicon-folder-open"></span></span>
                <input accept=".jpg, .png, .jpeg" type="file" name="ine" style="display: none;">
                </label>
                <b>INE.</b>
                @if(Session::has("msgs") && Session::get("msgs")->has("ine"))
                  <span style="color:#D9534F;">{{Session::get("msgs")->get("ine")[0]}}</span>
                @endif
              </p>
              @else
              <p><b><span class="glyphicon glyphicon-unchecked"></span> INE.</b></p>
              @endif
            @if(($venta->documento->ine==null || $venta->documento->acta_nacimiento==null) && $venta->status==1)
              <button type="submit" class="btn btn-success btn-sm" name="button">Subir archivos</button>
            </form>
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

<!-- Modal NOTARIOS * * * * -->
<div class="modal fade" id="modalNotario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Notario.</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <div class="modal-body">
        <div id="notarioField"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<form class="" action="index.html" method="post">

</form>
<!-- Modal MONTO CUBIERTO-->
<div class="modal fade" id="ventaModalS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b><span class="glyphicon glyphicon-usd"></span> Monto cubierto.</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <div class="modal-body">
        <div id="citaDatosS">
          <h4 align="center">¿Se ha cubierto el monto de venta?</h4>
          <br>
            <form action="/monto_cubierto_v" method="post">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <input type="hidden" name="id" id="input_success" value="">
              <button type="submit" id="btnSucc" class="btn btn-block btn-success"><span class="glyphicon glyphicon-ok"></span> <b>Registrar</b></button>
            </form>
          <br>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal SALE CANCEL ************-->
<div class="modal fade" id="ventaModalC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Cancelar Venta</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <div class="modal-body">
        <h4 align="center">¿Segur@ de cancelar esta venta?</h4>
        <br>
        <form action="/cancelar_venta" method="post">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <input type="hidden" name="id" id="input_cancel" value="">
          <button type="submit" class="btn btn-block btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> <b>Cancelar venta</b></button>
        </form>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

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

<!-- Modal VENTA CONCRETADA-->
<div class="modal fade" id="modalConcretada" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b><span class="glyphicon glyphicon-usd"></span> Terminar el trámite.</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <div class="modal-body">
        <div id="citaDatosS">
          <h3 align="center">¿Desea terminar el trámite de esta venta?</h3>
          <h4 align="center"><b id="labelFolio"></b></h4>
          <br>
          <form action="/venta_concretada" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="id" id="input_concretada" value="">
            <button style="border-radius:0;" type="submit" class="btn btn-block btn-success"><span class="glyphicon glyphicon-ok-circle"></span> <b>Venta exitosa</b></button>
          </form>
          <br>
        </div>
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
  $(".btnConcretada").click(function(){
     $("#input_concretada").val($(this).attr("data-id-venta"));
     $("#labelFolio").text("Folio "+$(this).attr("data-id-venta"));
  })
})
</script>

<script type="text/javascript">
$(function(){
  $("#modalNotario").on("show.bs.modal",function(){
    $("#notarioField").hide().empty();
  });
  $(".btnInNotario").click(function(){
    var id=$(this).attr("data-notario-v");
    $.ajax({
      url:"/pedir_notarios_vista",method:"post",
      data:{
        _token:"{{csrf_token()}}",
        id:id
      }
    }).done(function(res){
      $("#notarioField").html(res);
      $("#notarioField").slideDown(300);
    })
  })
})
</script>

<script type="text/javascript">
$(function(){
  $("#modalDoc").on("show.bs.modal", function () {
    $("#formField").hide().empty();
  });
  $(".btnDoc").click(function(){
    $("#imageToShow").attr("src",$(this).attr("data-document"));
    $("#modalDocTitle").text($(this).attr("data-doc-title"));
    $.ajax({
      url:"/check_status",method:"post",
      data:{
        _token:"{{csrf_token()}}",
        id:$(this).attr("data-id-venta"),
        doc:$(this).attr("data-type")
      }
    }).done(function(res) {
      if (res.view) {
        $("#formField").html(res.view).slideDown(300)
      }
    })
  })
})
</script>

@if(Session::has("id"))
<script type="text/javascript">
$(function(){
  $("{{'#desc'.Session::get('id')}}").slideDown(300);
})
</script>
@endif

<script>
$(function(){
  $('.theFile').change(function () {
     var file = $(this).children('input[type=file]')[0].files[0];
     if(file){
         $(this).children('#m').html('<span class="glyphicon glyphicon-ok"></span>');
         $(this).attr('class',"btn btn-info btn-xs");
     }
     else{
       $(this).children('#m').html('<span class="glyphicon glyphicon-folder-open"></span>');
       $(this).attr('class',"btn btn-default btn-xs");
     }
   });
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
  $(".successSale").click(function(){
    $("#input_success").val($(this).attr("data-venta-id"));
  })
  $(".cancelSale").click(function(){
    $("#input_cancel").val($(this).attr("data-venta-id"));
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
