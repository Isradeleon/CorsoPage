@extends('menu_layouts.menu_base')

@section('the_css')
<style media="screen">
.itemPick{
  width: 270px;
  height: 240px;
}
.photos_item{
  margin-bottom: 20px;
}
#photos_section{
  overflow-y: auto;
  max-height: 310px;
}
</style>
<link rel="stylesheet" href="/js/jquery-ui-1.12.1/jquery-ui.css">
@endsection

@section('menus')
  @include('secretaria.menussecre')
@endsection

@section('content')
  <h4>
    <a href="/casas_venta"><span class="glyphicon glyphicon-arrow-left"></span> Volver a Casas en venta</a>
  </h4>
  <h2>Edición</h2>
  <hr>
  <h4>Fotografías.</h4>
  <br>
  <div class="row">
    <form class="form-horizontal" enctype="multipart/form-data" action="/agregar_fotos" method="post">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <input type="hidden" name="id" value="{{$casa->id}}">
      <div class="col-md-10 col-lg-8">
        <div class="form-group">
          <div class="col-md-6">
            <label id="thefile" style="font-size: 15px; color:#111;" class="btn btn-default btn-block">
              <span id="m" style="font-weight: normal;">Imagenes <span class="glyphicon glyphicon-folder-open"></span></span>
              <input multiple accept=".jpg, .jpeg, .png" type="file" id="the_files" name="the_files[]" style="display: none;">
            </label>
            <button type="submit" class="btn btn-primary btn-block">Subir Imagenes</button>
            @if(Session::has("msgs") && Session::get("msgs")->has("the_files"))
            <h5 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("the_files")[0]}}</h5>
            @elseif(Session::has("msgsP"))
            <h5 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgsP")[0]}}</h5>
            @endif
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="row">
    <div id="photos_section">
      @foreach($casa->fotos as $foto)
      <div align="center" class="photos_item col-xs-12 col-md-6 col-lg-4">
        <div class="itemPick" style="background:url({{$foto->string_foto}}); background-position:center center; background-size: auto 250px;"></div>
        <div style="width:270px;">
          <div style="padding:0;" class="col-xs-12">
            <form action="/eliminar_foto" method="POST">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <input type="hidden" name="id_casa" value="{{$casa->id}}">
              <input type="hidden" name="id_foto" value="{{$foto->id}}">
              <button cuucu=7 house-id="{{$casa->id}}" type="submit" style="border-radius:0;" class="btn btn-block btn-warning delete_picture" data-toggle="modal" data-target="#ModalPictures"><span class="glyphicon glyphicon-trash"></span></button>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <br>
  <h4>Evaluación del precio.</h4>
  <br>
  <div class="row">
    <form class="form-horizontal" action="/evaluar_precio" method="post">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <input type="hidden" name="id" value="{{$casa->id}}">
      <div class="col-md-10 col-lg-8">
        <div class="form-group">
          <label for="precio_evaluado" class="col-md-4 control-label">Precio evaluado</label>
          <div class="col-md-6">
            @if($casa->precio_evaluado)
              <input placeholder="Formato aceptado: 0.00" value="{{old('precio_evaluado') ? old('precio_evaluado') : $casa->precio_evaluado}}" type="text" class="form-control" name="precio_evaluado">
            @else
              <input placeholder="Formato aceptado: 0.00" value="{{old('precio_evaluado')}}" type="text" class="form-control" name="precio_evaluado">
            @endif
            @if(Session::has("msgs") && Session::get("msgs")->has("precio_evaluado"))
            <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("precio_evaluado")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="fecha_ultima_evaluacion" class="col-md-4 control-label">Fecha</label>
          <div class="col-md-6">
            @if($casa->precio_evaluado)
              <input id="datePickerUI" class="form-control" type="date" name="fecha_ultima_evaluacion" value="{{old('fecha_ultima_evaluacion') ? old('fecha_ultima_evaluacion') : $casa->fecha_ultima_evaluacion}}">
            @else
              <input id="datePickerUI" class="form-control" type="date" name="fecha_ultima_evaluacion" value="{{old('fecha_ultima_evaluacion')}}">
            @endif
            @if(Session::has("msgs") && Session::get("msgs")->has("fecha_ultima_evaluacion"))
            <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("fecha_ultima_evaluacion")[0]}}</h6>
            @endif
            <br>
            <button type="submit" class="btn btn-success btn-block">Guardar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <br>
  <h4>Datos de la propiedad.</h4>
  <br>
  <div class="row">
    <form id="formulary" enctype="multipart/form-data" class="form-horizontal" action="/editar_casa" method="post" role="form">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <input type="hidden" name="id" value="{{$casa->id}}">
      <input type="hidden" name="lat" value="{{old('lat') ? old('lat') : $casa->eje_x_mapa}}">
      <input type="hidden" name="lng" value="{{old('lng') ? old('lng') : $casa->eje_y_mapa}}">
      <input type="hidden" name="calle" value="{{old('calle') ? old('calle') : $casa->calle_o_avenida}}">
      <input type="hidden" name="colonia" value="{{old('colonia') ? old('colonia') : $casa->colonia}}">
      <input type="hidden" name="ciudad" value="{{old('ciudad') ? old('ciudad') : $casa->ciudad}}">
      <div class="col-md-6 col-lg-4">
        <div class="form-group">
          <label for="num_ext" class="col-md-4 control-label">No. Externo</label>
          <div class="col-md-8">
            <input value="{{old('num_ext') ? old('num_ext') : $casa->numero_exterior}}" type="text" class="form-control" name="num_ext">
            @if(Session::has("msgs") && Session::get("msgs")->has("num_ext"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("num_ext")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="num_int" class="col-md-4 control-label">No. Interno</label>
          <div class="col-md-8">
            @if($casa->numero_interior)
              <input value="{{old('num_int') ? old('num_int') : $casa->numero_interior}}" type="text" class="form-control" name="num_int">
            @else
              <input value="{{old('num_int')}}" type="text" class="form-control" name="num_int">
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="superficie" class="col-md-4 control-label">Superficie</label>
          <div class="col-md-8">
            <input value="{{old('superficie') ? old('superficie') : $casa->superficie}}" type="text" class="form-control" name="superficie">
            @if(Session::has("msgs") && Session::get("msgs")->has("superficie"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("superficie")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="habitaciones" class="col-md-4 control-label">Habitaciones</label>
          <div class="col-md-8">
            <input value="{{old('habitaciones') ? old('habitaciones') : $casa->num_habitaciones}}" type="number" min="0" class="form-control" name="habitaciones">
            @if(Session::has("msgs") && Session::get("msgs")->has("habitaciones"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("habitaciones")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="banos" class="col-md-4 control-label">Baños</label>
          <div class="col-md-8">
            <input value="{{old('banos') ? old('banos') : $casa->num_banos}}" type="number" min="0" class="form-control" name="banos">
            @if(Session::has("msgs") && Session::get("msgs")->has("banos"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("banos")[0]}}</h6>
            @endif
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-6">
        <div class="form-group">
          <label for="precio_estimado" class="col-md-4 control-label">Precio estimado</label>
          <div class="col-md-8">
            <input value="{{old('precio_estimado') ? old('precio_estimado') : $casa->precio_estimado}}" id="precio_estimado" placeholder="Formato aceptado: 0.00" type="text" class="form-control" name="precio_estimado">
            @if(Session::has("msgs") && Session::get("msgs")->has("precio_estimado"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("precio_estimado")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="detalles" class="col-md-4 control-label">Detalles</label>
          <div class="col-md-8">
            <textarea style="resize:none;" name="detalles" rows="3" maxlength="200" class="form-control">{{old('detalles') ? old('detalles') : $casa->detalles}}</textarea>
            @if(Session::has("msgs") && Session::get("msgs")->has("detalles"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("detalles")[0]}}</h6>
            @endif
          </div>
        </div>

        <br>
        <div class="form-group">
          <div class="col-md-8 col-md-offset-4">
            <button type="submit" id="send_button" class="btn btn-info btn-block">Guardar</button>
          </div>
          <div style="display:none;" id="little_message" class="col-md-8 col-md-offset-4">
            <h5 style="color:#d33;" align="center">Llene todos los datos de la propiedad.</h5>
          </div>
        </div>
      </div>
    </form>
  </div>
  <br>
  <div class="row">
    <div class="col-lg-8 col-lg-offset-1">
      <div id="messageError" style="margin-bottom:0; border-radius:0; border:0; color:white; background-color:#444; display:none;" class="thumbnail">
        <h4 align="center">Aumente el zoom a 17!</h4>
      </div>
      <div id="messageError2" style="margin-bottom:0; border-radius:0; border:0; color:white; background-color:#444; display:none;" class="thumbnail">
        <h4 align="center">Solo en Torreón, Gómez Palacio o Lerdo</h4>
      </div>
      <div style="width:100%;height:400px;" id="the_map"></div>
      <div class="row">
        <h4 style="font-weight:bold;" align="center" id="currentZoom">Zoom: 13</h4>
      </div>
    </div>
  </div>
  <div class="row">
    <br><br><br>
  </div>
@endsection

@section("the_js")
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqiB2cyhlFaZJmw6_x1Cz7-AvGH5dkTLU&callback=initMap&language=ES" async defer></script>

<script type="text/javascript">
function setMarker(map,m){
  $(function(){
    var lat=parseFloat($("input[name='lat']").val())
    var lng=parseFloat($("input[name='lng']").val())
    var url="https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng
    map.setZoom(18);
    map.setCenter({lat:lat,lng:lng})

    $.ajax({
      url:url,method:"get"
    }).done(function(res){
      m.setPosition({lat:lat,lng:lng})
      m.setMap(map)
      map.markers.push(m)
      map.currentMark=res
    });
  })
}
</script>
<script type="text/javascript">
function theFunction(map){
  $(function(){
    $("#send_button").click(function(e){
      e.preventDefault()
      e.stopPropagation()
      if(map.currentMark){
        var res=map.currentMark
          var calle=res.results[0].address_components[1].short_name
          var colonia=res.results[1].address_components[0].short_name
          var ciudad=res.results[res.results.length-3].formatted_address
          var lat=String(map.markers[0].position.lat());
          var lng=String(map.markers[0].position.lng());

          $("input[name='calle']").val(calle)
          $("input[name='colonia']").val(colonia)
          $("input[name='ciudad']").val(ciudad)
          $("input[name='lat']").val(lat)
          $("input[name='lng']").val(lng)
          $("#formulary").submit();
          console.log(ciudad);
      }else{
        $("#little_message").slideDown();
        console.log(map.getZoom())
      }
    })
  })
  $('#thefile').change(function () {
      var file = $(this).children('input[type=file]')[0].files[0];
      if(file){
          $(this).children('#m').css("color","white")
          $(this).children('#m').html("Archivos <span class='glyphicon glyphicon-ok'></span>");
          $(this).attr('class',"btn btn-success btn-block");
      }
      else{
        $(this).children('#m').html('Imagenes <span class="glyphicon glyphicon-folder-open"></span>');
        $(this).attr('class',"btn btn-default btn-block");
        $(this).children('#m').css("color","#111")
      }
    });
}
function initMap(){
  var mapOptions = {
        center: {lat: 25.540892617643575, lng: -103.43353271484375},
        zoom: 13,
        maxZoom:19,
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
  map.markers=[]
  google.maps.event.addListener(map, "zoom_changed", function() {
      $("#currentZoom").text("Zoom: "+map.getZoom());
      var obj=$("#messageError")
      if(obj.css("display")!="none" && map.getZoom()>=17){
        obj.slideUp();
      }
  })
  google.maps.event.addListener(map,'click',function(e){
    if(map.getZoom()>=17){
      var lat=e.latLng.lat()
      var lng=e.latLng.lng()
      console.log(lat);
      console.log(lng);

      var url="https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng

      $.ajax({
        url:url,method:"get"
      }).done(function(res){
        if(res.results[res.results.length-3].formatted_address=="Torreón, Coah., México" ||
            res.results[res.results.length-3].formatted_address=="Gómez Palacio, Dgo., México" ||
            res.results[res.results.length-3].formatted_address=="Lerdo, Dgo., México"){
            for(i=0; i<map.markers.length; i++){
              map.markers[i].setMap(null);
            }
            map.markers=[]
            var m = new google.maps.Marker({
              position:{
                lat:e.latLng.lat(),lng:e.latLng.lng()
              },
              map:map
            });
            map.markers.push(m)
            map.currentMark=res
            console.log(map.currentMark);
        }else{
          var obj=$("#messageError2")
          if(obj.css("display")=="none"){
            obj.slideDown().delay(2000).slideUp();
          }
        }
      });

    }else{
      var obj=$("#messageError")
      if(obj.css("display")=="none"){
        obj.slideDown();
      }
    }
	});
  theFunction(map)
  var marker=new google.maps.Marker();
  setMarker(map,marker)
}
</script>
<script src="/js/jquery-ui-1.12.1/jquery-ui.js"></script>
<script>
  $(function(){
    $("#datePickerUI").datepicker({
      dateFormat: "yy-mm-dd",
      dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
      dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
      monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
      monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
    })
  })
</script>
@endsection
