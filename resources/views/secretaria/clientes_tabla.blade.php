<div style="max-height:500px; overflow-y:auto;" class="table-responsive">
  @if($clientes->count()>0)
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Contacto</th>
        </tr>
      </thead>
      <tbody>
        @foreach($clientes as $clien)
          @if($clien->id==$selected)
          <tr id="{{$clien->id}}" class="client clientSelected">
          @else
          <tr id="{{$clien->id}}" class="client clientNoSelected">
          @endif
            <td>{{$clien->nombre}}</td>
            <td>{{$clien->ap_paterno." ".$clien->ap_materno}}</td>
            <td>{{$clien->contacto}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <h5 align="center"><i>No hay registro de clientes...</i></h5>
  @endif
</div>
<script type="text/javascript">
  $(".client").click(function(){
    $(".clientSelected").removeClass("clientSelected").addClass("clientNoSelected")
    $(this).addClass("clientSelected")
    $(this).removeClass("clientNoSelected")
    $("input[name='cliente']").val($(this).attr("id"))
  })
</script>
