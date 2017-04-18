@extends('menu_layouts.menu_base')

@section("the_css")
<style type="text/css">
#gallery_section{
}
#picturesField{
  width: 100%;
  padding: 10px;
  overflow-y: auto;
  border-top: 1px solid #ddd;
}
.gallery_item{
  margin-bottom: 30px;
}
.itemImage{
  height: 210px;
  width: 280px;
}
.itemImageB{
  height: 160px;
  width: 200px;
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

.filter-button{
  margin: 5px 5px;
}
</style>
@endsection

@section('menus')
  @if(Auth::user()->tipo_usuario==1)
    @include('gerente.menusgerente')
  @elseif(Auth::user()->tipo_usuario==2)
    @include('secretaria.menussecre')
  @else
    @include('vendedor.menusvendedor')
  @endif
@endsection

@section('content')
<section id="gallery_section">
  <div class="row">
    <h1 align="center">@if($tipo_casas==1) Casas en venta @elseif($tipo_casas==2) En trámite @else Casas vendidas @endif</h1>
    <div align="center">
      @if($casas->count()>0)
      <button style="border-radius:0;" class="btn btn-default filter-button" data-filter="all">Mostrar todas</button>
      <button style="border-radius:0;" class="btn btn-default filter-button" data-filter="T">Torreón</button>
      <button style="border-radius:0;" class="btn btn-default filter-button" data-filter="G">Gómez Palacio</button>
      <button style="border-radius:0;" class="btn btn-default filter-button" data-filter="L">Lerdo</button>
      @else
      <hr>
      <h3><i>No hay registros que mostrar.</i></h3>
      @endif
    </div>
    <br><br>
    <div class="row">
      <div id="gallery_images" class="">
        @foreach($casas as $casa)
          <div align="center" class="gallery_item hidden-xs col-md-6 col-lg-4 filter {{substr($casa->ciudad,0,1)}}">
            <div class="itemImage"
            style="background:url({{$casa->fotos[0]->string_foto}});
            background-position:center center; background-size: auto 220px;"></div>
            <div style="width:280px;">
              <div style="padding:0;" class="col-xs-12">
                <button house-id="{{$casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-danger btn_pictures" data-toggle="modal" data-target="#ModalPictures"><span class="glyphicon glyphicon-camera"></span></button>
              </div>
            </div>
            @if(Auth::user()->tipo_usuario==2 && $casa->disponibilidad==1)
            <div style="width:280px;">
              <div style="padding:0;" class="col-xs-9">
                <button house-id="{{$casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-success btn_details" data-toggle="modal" data-target="#myModal">Detalles...</button>
              </div>
              <div style="padding:0;" class="col-xs-3">
                <a href="/editar_casa/{{$casa->id}}" style="border-radius:0;" class="btn btn-block btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
              </div>
            </div>
            @else
            <div style="width:280px;">
              <div style="padding:0;" class="col-xs-12">
                <button house-id="{{$casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-success btn_details" data-toggle="modal" data-target="#myModal">Detalles...</button>
              </div>
            </div>
            @endif
          </div>

          <div align="center" class="gallery_item col-xs-12 hidden-sm hidden-md hidden-lg filter {{substr($casa->ciudad,0,1)}}">
            <div class="itemImageB"
            style="background:url({{$casa->fotos[0]->string_foto}});
            background-position:center center; background-size: auto 165px;"></div>
            <div style="width:200px;">
              <div style="padding:0;" class="col-xs-12">
                <button house-id="{{$casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-danger btn_pictures" data-toggle="modal" data-target="#ModalPictures"><span class="glyphicon glyphicon-camera"></span></button>
              </div>
            </div>
            @if(Auth::user()->tipo_usuario==2 && $casa->disponibilidad==1)
            <div style="width:200px;">
              <div style="padding:0;" class="col-xs-9">
                <button house-id="{{$casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-success btn_details" data-toggle="modal" data-target="#myModal">Detalles...</button>
              </div>
              <div style="padding:0;" class="col-xs-3">
                <a href="/editar_casa/{{$casa->id}}" style="border-radius:0;" class="btn btn-block btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
              </div>
            </div>
            @else
            <div style="width:200px;">
              <div style="padding:0;" class="col-xs-12">
                <button house-id="{{$casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-success btn_details" data-toggle="modal" data-target="#myModal">Detalles...</button>
              </div>
            </div>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
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
            <h5><b>Precio estimado: </b>$<span id="housePrice"></span></h5>
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
          $("#housePrice").text(res.precio_estimado);
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

<script type="text/javascript">
$(document).ready(function(){
  $(".filter-button").click(function(){
      var value = $(this).attr('data-filter');
      if(value == "all") {
          $('.filter').show('1000');
      } else {
          $(".filter").not('.'+value).hide('3000');
          $('.filter').filter('.'+value).show('3000');
      }
  });
});
</script>
@endsection
