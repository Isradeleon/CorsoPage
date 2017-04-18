@extends('menu_layouts.menu_base')

@section("the_css")
<style media="screen">
.citas_item{
  margin-bottom: 30px;
}
.itemCard{
  height: 170px;
  width: 220px;
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
  font-size:23px;
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
<h2>Citas pendientes</h2>
<hr>
<h4>Mostrando el icono <span class="glyphicon glyphicon-usd saleIndicator"></span> cuando la cita se asocia a una venta.</h4>
<br>
<div class="row">
  <div id="datesSection">
    @if($citas->count()>0)
      @foreach($citas as $cita)
      <div align="center" class="citas_item col-xs-12 col-md-6 col-lg-4">
        <div class="itemCard"
        style="padding:10px; background:url({{$cita->casa->fotos[0]->string_foto}});
        background-position:center center; background-size: auto 175px; border:1px lightgray solid; border-bottom:0;">
        @if($cita->tipo_cita==2)
          <span class="glyphicon glyphicon-usd pull-left saleIndicator"></span>
        @endif
        </div>

        <div id="cita{{$cita->id}}" style="width:220px; padding:0; display:none;">
          <div style="padding:10px; border:1px lightgray solid;" class="col-xs-12">
            @if($cita->tipo_cita==1)
            <h4><b>Visita</b></h4>
            @else
            <h4><b>Entrega de docs</b></h4>
            @endif
            @if($cita->tipo_cita==2)
            <p><b>Venta asociada: </b>{{$cita->venta_docs_id}}</p>
            @endif
            <p><b>Cliente: </b>{{$cita->cliente->nombre." "
              .$cita->cliente->ap_paterno." ".$cita->cliente->ap_materno}}<br>{{$cita->cliente->contacto}} <span class="glyphicon glyphicon-earphone"></span></p>
            <p><b>Agendó: </b>{{$cita->secretaria->nombre." "
              .$cita->secretaria->ap_paterno." ".$cita->secretaria->ap_materno}}</p>
            @if($cita->fecha_hora >= $today && $cita->fecha_hora < $todayUp)
              <br>
              <button data-cita-id="{{$cita->id}}" type="button" class="btn btn-success btn-sm btn-block successDate" name="button" data-toggle="modal" data-target="#citaModalS"><span class="glyphicon glyphicon-ok"></span> <b>Exitosa</b></button>
            @endif
            <br>
            <button data-cita-id="{{$cita->id}}" type="button" class="btn btn-warning btn-sm btn-block cancelDate" name="button" data-toggle="modal" data-target="#citaModalC"><span class="glyphicon glyphicon-remove"></span> <b>Cancelada</b></button>
            <br>
          </div>
        </div>
        <div style="width:220px;">
          <div style="padding:0;" class="col-xs-12">
            <button data-cita-id="cita{{$cita->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-primary btnDetallesCita">
              <b>{{date_format(date_create($cita->fecha_hora),"Y-m-d")}}</b> A las <b>{{date_format(date_create($cita->fecha_hora),"g:i a")}}</b>
            </button>
          </div>
        </div>

        <div style="width:220px;">
          <div style="padding:0;" class="col-xs-9">
            <button house-id="{{$cita->casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-default btn_details"  data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-map-marker"></span> Ubicación...</button>
          </div>
          <div style="padding:0;" class="col-xs-3">
            <button house-id="{{$cita->casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-default btn_pictures" data-toggle="modal" data-target="#ModalPictures"><span class="glyphicon glyphicon-camera"></span></button>
          </div>
        </div>

      </div>
      @endforeach
    @else
    <h4 align="center"><i>No hay citas pendientes.</i></h4>
    @endif
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
  $(".successDate").click(function(){
    $("#input_success").val($(this).attr("data-cita-id"));
  })
  $(".cancelDate").click(function(){
    $("#input_cancel").val($(this).attr("data-cita-id"));
  })
})
</script>
<script>
$(function(){
  $(".btnDetallesCita").click(function(){
    $("#"+$(this).attr("data-cita-id")).slideToggle(200);
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
