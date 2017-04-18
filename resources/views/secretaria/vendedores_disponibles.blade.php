<div style="max-height:500px; overflow-y:auto;" class="table-responsive">
  @if($vendedores->count()>0)
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Contacto</th>
        </tr>
      </thead>
      <tbody>
        @foreach($vendedores as $v)
          @if($v->id==$selected)
          <tr id="{{$v->id}}" class="employee employeeSelected">
          @else
          <tr id="{{$v->id}}" class="employee employeeNoSelected">
          @endif
            <td>{{$v->nombre}}</td>
            <td>{{$v->ap_paterno." ".$v->ap_materno}}</td>
            <td>{{$v->contacto}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <h5 align="center"><i>No hay vendedores disponibles...</i></h5>
  @endif
</div>
<script type="text/javascript">
$(function(){
  $(".employee").click(function(){
    $(".employeeSelected").removeClass("employeeSelected").addClass("employeeNoSelected")
    $(this).addClass("employeeSelected")
    $(this).removeClass("employeeNoSelected")
    $("input[name='vendedor']").val($(this).attr("id"))
  })
})
</script>
