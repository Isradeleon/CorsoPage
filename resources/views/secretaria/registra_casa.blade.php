@extends('menu_layouts.menu_base')

@section('menus')
  @include('secretaria.menussecre')
@endsection

@section('content')
  <h2>Registro de casas</h2>
  <hr>
  <div class="row">
    <form id="formulary" enctype="multipart/form-data" class="form-horizontal" action="/registrar_casa" method="post" role="form">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <input type="hidden" name="lat" value="{{old('lat')}}">
      <input type="hidden" name="lng" value="{{old('lng')}}">
      <input type="hidden" name="calle" value="{{old('calle')}}">
      <input type="hidden" name="colonia" value="{{old('colonia')}}">
      <input type="hidden" name="ciudad" value="{{old('ciudad')}}">
      <div class="col-md-6 col-lg-4">
        <div class="form-group">
          <label for="num_ext" class="col-md-4 control-label">No. Externo</label>
          <div class="col-md-8">
            <input maxLength="40" value="{{old('num_ext')}}" type="text" class="form-control" name="num_ext" autofocus>
            @if(Session::has("msgs") && Session::get("msgs")->has("num_ext"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("num_ext")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="num_int" class="col-md-4 control-label">No. Interno</label>
          <div class="col-md-8">
            <input maxLength="40" value="{{old('num_int')}}" type="text" class="form-control" name="num_int">
          </div>
        </div>
        <div class="form-group">
          <label for="superficie" class="col-md-4 control-label">Superficie</label>
          <div class="col-md-8">
            <input maxLength="40" value="{{old('superficie')}}" type="text" class="form-control" name="superficie">
            @if(Session::has("msgs") && Session::get("msgs")->has("superficie"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("superficie")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="habitaciones" class="col-md-4 control-label">Habitaciones</label>
          <div class="col-md-8">
            <input value="{{old('habitaciones')}}" type="number" min="1" class="form-control" name="habitaciones">
            @if(Session::has("msgs") && Session::get("msgs")->has("habitaciones"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("habitaciones")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="banos" class="col-md-4 control-label">Baños</label>
          <div class="col-md-8">
            <input value="{{old('banos')}}" type="number" min="1" class="form-control" name="banos">
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
            <input maxLength="40" value="{{old('precio_estimado')}}" id="precio_estimado" placeholder="Formato aceptado: 0.00" type="text" class="form-control" name="precio_estimado">
            @if(Session::has("msgs") && Session::get("msgs")->has("precio_estimado"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("precio_estimado")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="detalles" class="col-md-4 control-label">Detalles</label>
          <div class="col-md-8">
            <textarea style="resize:none;" name="detalles" rows="3" maxlength="190" class="form-control">{{old('detalles')}}</textarea>
            @if(Session::has("msgs") && Session::get("msgs")->has("detalles"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("detalles")[0]}}</h6>
            @endif
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-8 col-md-offset-4">
            <label id="thefile" style="font-size: 15px; color:#111;" class="btn btn-default btn-block">
              <span id="m" style="font-weight: normal;">Imagenes <span class="glyphicon glyphicon-folder-open"></span></span>
              <input multiple accept=".jpg, .jpeg, .png" type="file" id="the_files" name="the_files[]" style="display: none;">
            </label>
            @if(Session::has("msgs") && Session::get("msgs")->has("the_files"))
              <h6 style="color:#d33; margin-bottom:0;" align="center">{{Session::get("msgs")->get("the_files")[0]}}</h6>
            @endif
          </div>
        </div>
        <br>
        <div class="form-group">
          <div class="col-md-8 col-md-offset-4">
            <button type="submit" id="send_button" class="btn btn-info btn-block">Registrar</button>
          </div>
          <div style="display:none;" id="little_message" class="col-md-8 col-md-offset-4">
            <h5 style="color:#d33;" align="center">Indique la ubicación de la casa en el mapa.</h5>
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

@if(Session::has("msgs"))
<script type="text/javascript">
function hasMsgs(map,m){
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
@endif

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
  @if(Session::has("msgs"))
    var marker=new google.maps.Marker();
    hasMsgs(map,marker)
  @endif
}
</script>

@endsection
