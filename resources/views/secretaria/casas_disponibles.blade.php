
<style type="text/css">
#gallery_images{
  width: 100%;
  padding: 10px;
  border-top: 1px solid #ddd;
}
.gallery_item{
  margin-bottom: 30px;
}
.gallery_item:hover{

}
.itemImage{
  height: 180px;
  width: 210px;
  padding:5px;
}
.selThisPick:hover{
  cursor: pointer;
  border: solid 4px #D9534F;
}
.selectedPick{
  border: solid 6px #D9534F;
}
.housePhoto{
  margin-bottom: 20px;
}
.itemHousePhoto{
  border: 1px solid #ddd;
  height: 240px;
  width: 240px;
}
.itemHousePhoto:hover{
  cursor:pointer;
}
.filter-button{
  margin: 5px;
}
.detallesCasa{
  width:210px; border:1px solid lightgray; display:none;
  padding:10px 5px 5px 5px; font-size: 13px;
}
.houseIndicator{
  text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
  color:#D9534F;
  font-size:17px;
  margin-left: 5px;
  background:white; border:2px solid #D9534F; border-radius: 100%;
}
</style>

<section id="gallery_section">
  <div class="row">
    <h2 align="center">En venta</h2>
    <div align="center">
      @if($casas->count()>0)
        <button class="btn btn-default filter-button" data-filter="all">Mostrar todas</button>
        <button class="btn btn-default filter-button" data-filter="T">Torreón</button>
        <button class="btn btn-default filter-button" data-filter="G">Gómez Palacio</button>
        <button class="btn btn-default filter-button" data-filter="L">Lerdo</button>
      @else
        <hr>
        <h4 align="center"><i>No hay casas disponibles.</i></h4>
      @endif
    </div>
    <br><br>
    <div id="gallery_images" class="">
      @foreach($casas as $casa)
        <div align="center" class="gallery_item col-xs-12 col-md-6 col-lg-4 filter {{substr($casa->ciudad,0,1)}}">
          @if($casa->id==$selectedHouse)
            <div house-to-see="{{$casa->id}}" class="selectedPick itemImage"
            style="background:url({{$casa->fotos[0]->string_foto}});
            background-position:center center; background-size: auto 190px;">
              <h6>
                <span id="houseIndicator{{$casa->id}}" class="glyphicon glyphicon-ok houseIndicator pull-left"></span>
                <span style="background:white; color:black;" class="badge pull-right">@if($casa->precio_evaluado) ${{$casa->precio_evaluado}} @else Estimado ${{$casa->precio_estimado}} @endif </span>
              </h6>
            </div>
          @else
            <div house-to-see="{{$casa->id}}" class="selThisPick itemImage"
            style="background:url({{$casa->fotos[0]->string_foto}});
            background-position:center center; background-size: auto 190px;">
              <h6>
                <span id="houseIndicator{{$casa->id}}" style="display:none;" class="glyphicon glyphicon-ok houseIndicator pull-left"></span>
                <span style="background:white; color:black;" class="badge pull-right">@if($casa->precio_evaluado) ${{$casa->precio_evaluado}} @else Estimado ${{$casa->precio_estimado}} @endif </span>
              </h6>
            </div>
          @endif
          <div class="detallesCasa" id="detalle{{$casa->id}}">
            <p><b>Ciudad: </b>{{$casa->ciudad}}</p>
            <p><b>Direccion: </b>{{"#".$casa->numero_exterior. ($casa->numero_interior ? " Int. ".$casa->numero_interior:"")
            .", ".$casa->calle_o_avenida
            .", Col. ".$casa->colonia."."}}</p>
            <br>
            <p><b>Superficie: </b>{{$casa->superficie}}</p>
            <p><b>Habitaciones: </b>{{$casa->num_habitaciones}} <b>Baños: </b>{{$casa->num_banos}}</p>
            <br>
            <p><b>Detalles:</b><br>{{$casa->detalles}}</p>
            @if($casa->precio_evaluado)
              <br>
              <p><b>Fecha de evaluación:</b><br>{{$casa->fecha_ultima_evaluacion}}</p>
            @endif
          </div>
          <div style="width:210px;">
            <div style="padding:0;" class="col-xs-12">
              <button house-id="{{$casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-default btn_detalles">Detalles</button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
  $(".itemImage").click(function(){
    var id=$(this).attr("house-to-see")
    $(".selectedPick").removeClass("selectedPick").addClass("selThisPick");
    $(this).removeClass("selThisPick").addClass("selectedPick");
    $(".houseIndicator").hide();
    $("#houseIndicator"+id).show();
    $("input[name='casa']").val(id)
  });

  $(".filter-button").click(function(){
      var value = $(this).attr('data-filter');
      if(value == "all") {
          $('.filter').show('1000');
      } else {
          $(".filter").not('.'+value).hide('3000');
          $('.filter').filter('.'+value).show('3000');
      }
  });

  $(".btn_detalles").click(function(){
    var id=$(this).attr("house-id")
    $("#detalle"+id).slideToggle(300);
  });
});
</script>
