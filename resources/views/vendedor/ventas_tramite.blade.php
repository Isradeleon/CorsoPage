@extends('menu_layouts.menu_base')

@section("the_css")
<style media="screen">
.citas_item{
  margin-bottom: 30px;
}
.itemCard{
  height: 170px;
  width: 230px;
}
#picturesField{
  width: 100%;
  overflow-y: auto;
  padding: 10px;
  border-top: 1px solid #ddd;
}

.housePhoto{
  margin-bottom: 20px;
}
.itemHousePhoto{
  border: 1px solid #ddd;
  height: 240px;
  width: 240px;
}
.itemHousePhotoB{
  border: 1px solid #ddd;
  height: 200px;
  width: 200px;
}
.itemHousePhoto:hover{
  cursor:pointer;
}
.itemHousePhotoB:hover{
  cursor:pointer;
}

.saleIndicator{
  font-size:18px;
  color:#5CB85C;
  text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
  text-align: center;
}
</style>
@endsection

@section('menus')
  @include('vendedor.menusvendedor')
@endsection

@section('content')
<h2>Ventas en trámite</h2>
<hr>
<div class="row">
  <div id="datesSection">
    @if($ventas->count()>0)
      @foreach($ventas as $venta)
      <div align="center" class="citas_item col-xs-12 col-md-6 col-lg-4">
        <div class="itemCard"
        style="padding:10px; background:url({{$venta->casa->fotos[0]->string_foto}});
        background-position:center center; background-size: auto 175px; border:1px lightgray solid; border-bottom:0;">
        @if($venta->monto_cubierto)
          <span class="pull-left saleIndicator"><span class="glyphicon glyphicon-usd"></span> Monto cubierto</span>
        @else
          <span class="pull-left saleIndicator"><span class="glyphicon glyphicon-usd"></span></span>
        @endif
        </div>

        <div id="cita{{$venta->id}}" style="width:230px; padding:0; display:none;">
          <div style="padding:10px; border:1px lightgray solid;" class="col-xs-12">
            <h4><b>Cliente:</b> {{$venta->cliente->nombre." "
              .$venta->cliente->ap_paterno." ".$venta->cliente->ap_materno}}.</h4>
            <p>
              <b><span class="glyphicon glyphicon-earphone"></span></b> {{$venta->cliente->contacto}}.
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
            <br>
            <div align="left" style="padding:10px;">
              <h4 align="center"><b>Documentos</b></h4>
              @if($venta->documento->acta_nacimiento)
              <p><button type="button" class="btn btn-default btn-xs btnDoc" name="button" data-document="{{$venta->documento->acta_nacimiento}}" data-id-venta="{{$venta->id}}" data-doc-title="Acta de nacimiento." data-toggle="modal" data-target="#modalDoc"><span class="glyphicon glyphicon-picture"></span></button>
                <b>Acta de nacimiento.</b>
              </p>
              @else
              <p><b><span class="glyphicon glyphicon-unchecked"></span> Acta de nacimiento pendiente.</b></p>
              @endif

              @if($venta->documento->ine)
              <p><button type="button" class="btn btn-default btn-xs btnDoc" name="button" data-document="{{$venta->documento->ine}}" data-id-venta="{{$venta->id}}" data-doc-title="INE." data-toggle="modal" data-target="#modalDoc"><span class="glyphicon glyphicon-picture"></span></button>
                <b>INE.</b>
              </p>
              @else
              <p><b><span class="glyphicon glyphicon-unchecked"></span> INE pendiente.</b></p>
              @endif

              @if($venta->monto_cubierto)
                @if($venta->documento->escrituras)
                <p><button type="button" class="btn btn-default btn-xs btnDoc" name="button" data-document="{{$venta->documento->escrituras}}" data-id-venta="{{$venta->id}}" data-doc-title="Escrituras." data-toggle="modal" data-target="#modalDoc"><span class="glyphicon glyphicon-picture"></span></button>
                  <b>Escrituras.</b>
                </p>
                @else
                <p><b><span class="glyphicon glyphicon-unchecked"></span> Escrituras pendientes.</b></p>
                @endif
                <p>
                  <i>Notario:</i>
                  {{$venta->notario ? $venta->notario->nombre." "
                  .$venta->notario->ap_paterno." ".$venta->notario->ap_materno."." : "Pendiente."}}
                </p>

                @if($venta->notario && $venta->documento->escrituras)
                <br>
                <p align="center" style="color:#5CB85C;"><b><i><span class="glyphicon glyphicon-exclamation-sign"></span> La venta ya puede concretarse!</i></b></p>
                @endif
              @endif
            </div>
            <br>
            <p>
              Venta registrada por <b>{{$venta->secretaria->nombre." "
              .$venta->secretaria->ap_paterno." ".$venta->secretaria->ap_materno}}</b>.
              <br>El día <b>{{date_format(date_create($venta->created_at),"Y-m-d")}}</b> <br>A las <b>{{date_format(date_create($venta->created_at),"g:i a")}}</b>
            </p>
          </div>
        </div>

        <div style="width:230px;">
          <div style="padding:0;" class="col-xs-12">
            <button data-venta-id="cita{{$venta->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-success btnDetallesVenta">
              <b>Folio: {{$venta->id}}</b>
            </button>
          </div>
        </div>

        <div style="width:230px;">
          <div style="padding:0;" class="col-xs-9">
            <button house-id="{{$venta->casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-default btn_details"  data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-map-marker"></span> Ubicación...</button>
          </div>
          <div style="padding:0;" class="col-xs-3">
            <button house-id="{{$venta->casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-default btn_pictures" data-toggle="modal" data-target="#ModalPictures"><span class="glyphicon glyphicon-camera"></span></button>
          </div>
        </div>

      </div>
      @endforeach
    @else
    <h4 align="center"><i>No hay ventas en trámite.</i></h4>
    @endif
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

<!-- Modal casa ****************-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Info</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <div class="modal-body">
        <h5>Ubicación:</h5>
        <div style="width:100%;height:300px;" id="the_map"></div>
        <div id="houseDetails" style="display:none;">
          <h5><b>Dirección: </b><span id="houseDomicile"></span><br><span id="houseCity"></span></h5>
          <br>
          <div style="text-align:center;">
            <h4>Detalles de la propiedad:</h4>
            <h5><b>Superficie: </b><span id="houseMeasurement"></span></h5>
            <h5><b>Habitaciones: </b><span id="houseRooms"></span> <b>Baños: </b><span id="houseBaths"></span></h5>
            <p id="houseMoreDetails"></p>
          </div>
          <br>
          <div style="text-align:center;">
            <h4><span class="glyphicon glyphicon-usd"></span> Costos:</h4>
            <h5><b>Precio estimado: </b>$<span id="housePrice">500000.00</span></h5>
            <div id="houseEField" style="display:none;">
              <h5><b>Precio evaluado: </b>$<span id="housePriceE"></span></h5>
              <h5><b>Ultima evaluación: </b><span id="houseEDate"></span></h5>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal imagenes -->
<div class="modal fade" id="ModalPictures" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Imágenes</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <br>
      <div class="modal-body">
        <div align="center" style="display:none; width:100%;" id="specificPictureField">
          <img style="border:4px #D9534F solid;" id="specificPicture" class="img-responsive" src="">
        </div>
        <br>
        <div id="picturesField"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
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

<script>
$(function(){
  $(".btnDetallesVenta").click(function(){
    $("#"+$(this).attr("data-venta-id")).slideToggle(200);
  })
})
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqiB2cyhlFaZJmw6_x1Cz7-AvGH5dkTLU&callback=initMap&language=ES" async defer></script>
<script type="text/javascript">
function the_Ofunction(map){
  $(function(){
    $("#myModal").on("shown.bs.modal", function () {
        google.maps.event.trigger(map, "resize");
        map.setCenter({lat: 25.539275981526448, lng: -103.43739777803421});
    });

    $("#myModal").on("hide.bs.modal", function () {
        $("#houseDetails").hide();
        $("#houseEField").hide();
        for(i=0; i<map.markers.length; i++){
          map.markers[i].setMap(null);
        }
        map.markers=[]
    });

    $(".btn_details").click(function(){
      var id=$(this).attr("house-id");
      $.ajax({
          method:"POST",
          url:"/pedir_casa",
          data:{
              _token:'{{csrf_token()}}',
              id:id
          }
      }).done(function (res){
          console.log(res)
          var lat=parseFloat(res.eje_x_mapa)
          var lng=parseFloat(res.eje_y_mapa)
          console.log(lat)
          console.log(lng)
          var m = new google.maps.Marker();
          m.setPosition({lat:lat,lng:lng})
          m.setMap(map)
          map.markers.push(m)
          var domicile="#"+res.numero_exterior;
          if(res.numero_interior){
            domicile+=" Int. "+res.numero_interior;
          }
          domicile+=", "+res.calle_o_avenida;
          domicile+=", Col. "+res.colonia+".";
          $("#houseDomicile").text(domicile);
          $("#houseCity").text(res.ciudad);
          $("#houseMeasurement").text(res.superficie);
          $("#houseRooms").text(res.num_habitaciones);
          $("#houseBaths").text(res.num_banos);
          $("#houseMoreDetails").text(res.detalles);
          $("#houseDetails").slideDown();
          console.log(res);
          if (res.precio_evaluado) {
            $("#housePriceE").text(res.precio_evaluado);
            $("#houseEDate").text(res.fecha_ultima_evaluacion);;
            $("#houseEField").show();
          }
      });

    });

  })
}

$(document).ready(function(){
  $("#ModalPictures").on("show.bs.modal", function () {
      $("#picturesField").hide().empty();
      $("#specificPictureField").hide()
      $("#specificPicture").attr("src","")
  });
  $(".btn_pictures").click(function(){
    var id=$(this).attr("house-id");
    $.ajax({
      method:"POST",
      url:"/pedir_fotos",
      data:{
        _token:'{{csrf_token()}}',
        id:id
      }
    }).done(function(res){
      for(var photo in res){
        var div=$("<div>");
        div.attr("align","center");
        div.attr("class","housePhoto hidden-xs col-sm-6 col-lg-4");
        var divImage=$("<div>");
        divImage.attr("class","itemHousePhoto");
        divImage.attr("the_source",res[photo].string_foto)
        divImage.css("background","url("+res[photo].string_foto+")");
        divImage.css("background-position","center center");
        divImage.css("background-size","auto 250px");
        div.append(divImage);

        var div2=$("<div>");
        div2.attr("align","center");
        div2.attr("class","housePhoto col-xs-12 hidden-sm hidden-md hidden-lg");
        var divImage2=$("<div>");
        divImage2.attr("class","itemHousePhotoB");
        divImage2.attr("the_source",res[photo].string_foto)
        divImage2.css("background","url("+res[photo].string_foto+")");
        divImage2.css("background-position","center center");
        divImage2.css("background-size","auto 210px");
        div2.append(divImage2);

        $("#picturesField").append(div);
        $("#picturesField").append(div2);
      }

      $(".itemHousePhoto").click(function(){
        $("#specificPictureField").hide()
        $("#specificPicture").attr("src",$(this).attr("the_source"))
        $("#specificPictureField").slideDown(200)
      });
      $(".itemHousePhotoB").click(function(){
        $("#specificPictureField").hide()
        $("#specificPicture").attr("src",$(this).attr("the_source"))
        $("#specificPictureField").slideDown(200)
      });
      $("#picturesField").slideDown();
    });
  });
});

function initMap(){
  var mapOptions = {
        center: {lat: 25.539275981526448, lng: -103.43739777803421},
        zoom: 11,
        maxZoom:20,
        minZoom:11,
        scrollwheel:false,
        zoomControl: true,
  	    zoomControlOptions: {
  	        position: google.maps.ControlPosition.LEFT_TOP
  	    },
  	    streetViewControl:true,
        mapTypeControl:false
  };
  map = new google.maps.Map(document.getElementById("the_map"),mapOptions);
  map.markers=[];
  the_Ofunction(map);
}
</script>
@endsection
