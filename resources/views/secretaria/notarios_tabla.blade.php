<style media="screen">
.notarioNoSelected:hover{
  cursor:pointer;
  background-color: #E8E8E8;
}
.notarioSelected{
  background: #428BCA;
  color:white;
}
</style>
<div style="max-height:500px; overflow-y:auto;" class="table-responsive">
  @if($notarios->count()>0)
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Cédula</th>
        </tr>
      </thead>
      <tbody>
        @foreach($notarios as $not)
          @if($selected && $not->id==$selected->id)
          <tr id="{{$not->id}}" class="notario notarioSelected">
          @else
          <tr id="{{$not->id}}" class="notario notarioNoSelected">
          @endif
            <td>{{$not->nombre}}</td>
            <td>{{$not->ap_paterno." ".$not->ap_materno}}</td>
            <td>{{$not->cedula}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
</div>
<br>
<form action="/notario_venta" method="post">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  <input type="hidden" name="venta" value="{{$venta}}">
  <input type="hidden" name="notario" value="">
  <div style="display:none;" id="btnNot">
    <button type="submit" class="btn btn-success btn-block" name="button"><span class="glyphicon glyphicon-list-alt"></span> <b>Registrar notario</b></button>
  </div>
</form>
  @else
    <h5 align="center"><i>No hay registro de notarios.</i></h5>
  @endif

<script type="text/javascript">
  $(".notario").click(function(){
    $(".notarioSelected").removeClass("notarioSelected").addClass("notarioNoSelected")
    $(this).addClass("notarioSelected")
    $(this).removeClass("notarioNoSelected")
    $("input[name='notario']").val($(this).attr("id"))
    $("#btnNot").slideDown(300)
  })
</script>
