<div style="max-height:500px; overflow-y:auto;" class="table-responsive">
  @if($ventas->count()>0)
    <table class="table table-condensed">
      <thead>
        <tr>
          <!-- CAMBIAR LOS DATOS DE LAS VENTAS PARA ADAPTARLOS -->
          <th>Folio</th>
          <th>Cliente</th>
          <th>Vendedor</th>
          <th>Tipo pago</th>
          <th>Inicio trámite</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ventas as $v)
          @if($v->id==$selected)
          <tr id="{{$v->id}}" class="sale saleSelected">
          @else
          <tr id="{{$v->id}}" class="sale saleNoSelected">
          @endif
            <td><b>{{$v->id}}</b></td>
            <td>{{$v->cliente->nombre." ".$v->cliente->ap_paterno." ".$v->cliente->ap_materno}}</td>
            <td>{{$v->vendedor->nombre." ".$v->vendedor->ap_paterno." ".$v->vendedor->ap_materno}}</td>
            @if($v->tipo_pago==1)
              <td>INFONAVIT</td>
            @elseif($v->tipo_pago==2)
              <td>FOVISSSTE</td>
            @else
              <td>Contado</td>
            @endif
            <td>{{$v->fecha_inicio}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <h5 align="center"><i>No hay registro de ventas...</i></h5>
  @endif
</div>
<script type="text/javascript">
$(function(){
  $(".sale").click(function(){
    $(".saleSelected").removeClass("saleSelected").addClass("saleNoSelected")
    $(this).addClass("saleSelected")
    $(this).removeClass("saleNoSelected")
    $("input[name='venta']").val($(this).attr("id"))
  })
})
</script>
