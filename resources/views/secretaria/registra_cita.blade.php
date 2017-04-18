@extends('menu_layouts.menu_base')

@section("the_css")
<style type="text/css">
.selectedDay{
  font-weight: bold;
  color:white;
  background: #9E9E9E;
}
.selectedDay div{
  background: #9E9E9E;
}
.employeeNoSelected:hover{
  cursor:pointer;
  background-color: #E8E8E8;
}
.employeeSelected{
  background: #428BCA;
  color:white;
}
.clientNoSelected:hover{
  cursor:pointer;
  background-color: #E8E8E8;
}
.clientSelected{
  background: #428BCA;
  color:white;
}
.saleNoSelected:hover{
  cursor:pointer;
  background-color: #E8E8E8;
}
.saleSelected{
  background: #5CB85C;
  color:white;
}
</style>
<link rel="stylesheet" href="public/js/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
@endsection

@section('menus')
  @include('secretaria.menussecre')
@endsection

@section('content')
  <h3>Registro de citas</h3>
  <hr>
  <div class="row">
    <div class="col-lg-11 col-xs-12">
      <div class="row">
        <div class="form-group">
          <form id="formCita" action="/registrar_cita" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <label for="tipo_cita">Propósito</label>
            <select autofocus style="border-radius:0;" class="form-control" name="tipo_cita" id="tipo_cita">
              <option value="1">Visitar una propiedad</option>
              @if(Session::has("docsCita"))
                <option selected value="2">Entrega de documentos</option>
              @else
                <option value="2">Entrega de documentos</option>
              @endif
            </select>
            <input type="hidden" name="date_time" id="date_time" value="">
            <input type="hidden" name="vendedor" value="{{old('vendedor')}}">
            <input type="hidden" name="casa" value="{{old('casa')}}">
            <input type="hidden" name="cliente" value="{{old('cliente')}}">
            <input type="hidden" name="venta" value="">
          </form>
        </div><br>
        <div class="form-group">
          <label for="date_time">Fecha y hora de la cita</label>
          <br><br>
          <div class="row">
              <div class="col-xs-12 col-lg-9">
                  <div id="datetimepicker1"></div>
              </div>
              <div class="col-xs-8 col-xs-offset-2 col-lg-offset-0 col-lg-3">
                <div id="datosCitaCasa" style="display:none;">
                  <div style="margin:10px;" align="center">
                    <button type="button" style=" border-radius:0;" id="seeSellers" class="btn btn-success btn-block" name="button" data-toggle="modal" data-target="#myModal">Vendedor</button>
                  </div>
                  @if(Session::has("eMsgs") && Session::get("eMsgs")->has("vendedor"))
                    <h6 style="color:#D9534F;" align="center">{{Session::get("eMsgs")->get("vendedor")[0]}}</h6>
                  @endif
                  <div style="margin:10px;" align="center">
                    <button type="button" style=" border-radius:0;" id="seeHouses" class="btn btn-info btn-block" name="button" data-toggle="modal" data-target="#modalHouses">Propiedad</button>
                  </div>
                  @if(Session::has("eMsgs") && Session::get("eMsgs")->has("casa"))
                    <h6 style="color:#D9534F;" align="center">{{Session::get("eMsgs")->get("casa")[0]}}</h6>
                  @endif
                  <div style="margin:10px; margin-bottom:0;" align="center">
                    <button type="button" style=" border-radius:0;" id="seeClients" class="btn btn-warning btn-block" name="button" data-toggle="modal" data-target="#modalClients">Cliente</button>
                  </div>
                  @if(Session::has("eMsgs") && Session::get("eMsgs")->has("cliente"))
                    <h6 style="color:#D9534F;" align="center">{{Session::get("eMsgs")->get("cliente")[0]}}</h6>
                  @endif
                </div>
                <div id="datosCitaDocs" style="display:none;">
                  <div style="margin:10px;" align="center">
                    <button type="button" style=" border-radius:0;" id="seeSales" class="btn btn-success btn-block" name="button" data-toggle="modal" data-target="#modalSales">Venta</button>
                  </div>
                  @if(Session::has("eMsgs") && Session::get("eMsgs")->has("venta"))
                    <h6 style="color:#D9534F;" align="center">{{Session::get("eMsgs")->get("venta")[0]}}</h6>
                  @endif
                </div>
                <br>
                <div style="margin:10px;" align="center">
                  <button type="button" style=" border-radius:0;" id="btnSubmitCita" class="btn btn-default btn-block" name="button"><b>Registrar</b></button>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div><br>

  <!-- Modal SELLERS -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"><b>Vendedores disponibles</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></span></h4>
        </div>
        <div class="modal-body">
          <div id="sellersArea" style="display:none;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal HOUSES -->
  <div class="modal fade" id="modalHouses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"><b>Casas disponibles</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></span></h4>
        </div>
        <div class="modal-body">
          <div id="housesArea" style="display:none;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal CLIENTS -->
  <div class="modal fade" id="modalClients" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"><b>Datos de cliente</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></span></h4>
        </div>
        <div class="modal-body">
          <div id="clientsArea" style="display:none;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal SALES (VENTAS) **********************-->
  <div class="modal fade" id="modalSales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"><b>Ventas en trámite</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></span></h4>
        </div>
        <div class="modal-body">
          <div id="salesArea" style="display:none;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section("the_js")
<script src="public/js/moment-develop/min/moment.min.js"></script>
<script src="public/js/moment-develop/locale/es.js"></script>
<script src="public/js/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

<script>
$(function(){
  $("#btnSubmitCita").click(function(){
    $("#formCita").submit();
  })
})
</script>

<script type="text/javascript">
$(function(){
  //MODAL SALES CONFIG------
  $("#modalSales").on("hide.bs.modal", function () {
    if($("input[name='venta']").val()){
      $("#seeSales").html("Venta <span class='glyphicon glyphicon-ok'></span>");
    }else{
      $("#seeSales").html("Venta");
    }
  });
  $("#modalSales").on("show.bs.modal", function () {
    $("#salesArea").hide().empty();
  });
  $("#seeSales").click(function(){
    var id=$("input[name='venta']").val();
    $.ajax({
      url:"/pedir_ventas",
      method:"post",
      data:{
        _token:"{{csrf_token()}}",
        date:$("#date_time").val(),
        id:id
      }
    }).done(function(res){
      $("#salesArea").html(res)
      $("#salesArea").show(500)
    });
    console.log($("#date_time").val())
  });
})
</script>

<script type="text/javascript">
//Script for the automatic selection of the type of date and the inputs verificator
$(function(){
  if($("input[name='cliente']").val()){
    $("#seeClients").html("Cliente <span class='glyphicon glyphicon-ok'></span>");
  }else{
    $("#seeClients").html("Cliente");
  }
  if($("input[name='casa']").val()){
    $("#seeHouses").html("Propiedad <span class='glyphicon glyphicon-ok'></span>");
  }else{
    $("#seeHouses").html("Propiedad");
  }
  if($("input[name='vendedor']").val()){
    $("#seeSellers").html("Vendedor <span class='glyphicon glyphicon-ok'></span>");
  }else{
    $("#seeSellers").html("Vendedor");
  }
  if ($("#tipo_cita").val()==1) {
    $("#datosCitaDocs").hide();
    $("#datosCitaCasa").show();
  }else{
    $("#datosCitaCasa").hide();
    $("#datosCitaDocs").show();
  }

  $("#tipo_cita").change(function(){
    if ($(this).val()==1) {
      $("#datosCitaDocs").hide();
      $("#datosCitaCasa").show(200);
    }else{
      $("#datosCitaCasa").hide();
      $("#datosCitaDocs").show(200);
    }
  });
})
</script>

<script type="text/javascript">
$(function(){
  //MODAL CLIENTS CONFIG------
  $("#modalClients").on("hide.bs.modal", function () {
    if($("input[name='cliente']").val()){
      $("#seeClients").html("Cliente <span class='glyphicon glyphicon-ok'></span>");
    }else{
      $("#seeClients").html("Cliente");
    }
  });
  $("#modalClients").on("show.bs.modal", function () {
    $("#clientsArea").hide().empty();
  });
  $("#seeClients").click(function(){
    var id=$("input[name='cliente']").val();
    $.ajax({
      url:"/pedir_clientes",
      method:"post",
      data:{
        _token:"{{csrf_token()}}",
        date:$("#date_time").val(),
        id:id
      }
    }).done(function(res){
      $("#clientsArea").html(res)
      $("#clientsArea").show(500)
    });
    console.log($("#date_time").val())
  });
})
</script>

<script type="text/javascript">
$(function(){
  //HOUSES MODAL config
  $("#modalHouses").on("hide.bs.modal", function () {
    if($("input[name='casa']").val()){
      $("#seeHouses").html("Propiedad <span class='glyphicon glyphicon-ok'></span>");
    }else{
      $("#seeHouses").html("Propiedad");
    }
  });
  $("#modalHouses").on("show.bs.modal", function () {
      $("#housesArea").hide().empty();
  });
  $("#seeHouses").click(function(){
    var id=$("input[name='casa']").val()
    var date=$("#date_time").val();
    $.ajax({
      url:"/casas_disponibles",
      method:"post",
      data:{
        _token:"{{csrf_token()}}",
        date:date,
        id:id
      }
    }).done(function(res){
      $("#housesArea").html(res)
      $("#housesArea").show(500)
    });
    console.log($("#date_time").val())
  });
})
</script>

<script type="text/javascript">
$(function () {
  //first modal config
  $("#myModal").on("hide.bs.modal", function () {
      if($("input[name='vendedor']").val()){
        $("#seeSellers").html("Vendedor <span class='glyphicon glyphicon-ok'></span>");
      }else{
        $("#seeSellers").html("Vendedor");
      }
  });
  $("#myModal").on("show.bs.modal", function () {
      $("#sellersArea").hide().empty();
  });
  $("#seeSellers").click(function(){
    var id=$("input[name='vendedor']").val()
    var date=$("#date_time").val();
    $.ajax({
      url:"/vendedores_disponibles",
      method:"post",
      data:{
        _token:"{{csrf_token()}}",
        date:date,
        id:id
      }
    }).done(function(res){
      $("#sellersArea").html(res)
      $("#sellersArea").show(500)
    });
    console.log($("#date_time").val())
  });

  //datetimepicker config ---------
  $("#date_time").val("{{Carbon\Carbon::now('America/Monterrey')}}")
  $('#datetimepicker1').datetimepicker({
    inline:true,sideBySide: true,locale:'es',
    format:"dd/mm/yy h:MM",
    minDate:"{{Carbon\Carbon::now('America/Monterrey')}}",
    tooltips: {
        today: 'Hoy',
        clear: 'Limpiar seleccion',
        close: 'Cerrar',
        selectMonth: 'Seleccionar mes',
        prevMonth: 'Mes anterior',
        nextMonth: 'Mes siguiente',
        selectYear: 'Seleccionar año',
        prevYear: 'Año anterior',
        nextYear: 'Año siguiente',
        selectDecade: 'Seleccionar década',
        prevDecade: 'Década anterior',
        nextDecade: 'Década siguiente',
        prevCentury: 'Siglo anterior',
        nextCentury: 'Siglo siguiente',
        incrementHour: 'Aumentar horas',
        incrementMinute: 'Aumentar minutos',
        decrementHour: 'Disminuir horas',
        decrementMinute: 'Disminuir minutos',
        pickHour:"Elegir hora",
        pickMinute:"Elegir minuto",
        togglePeriod:"AM-PM"
    }
  });
  $("#datetimepicker1").on("dp.change",function(e){
    $("#date_time").val(e.date)
    $("#seeSellers").html("Vendedor");
    $("#seeHouses").html("Propiedad");
    $("input[name='vendedor']").val("");
    $("input[name='casa']").val("");
    console.log($("#date_time").val())
  });
  // console.log($("#datetimepicker1").data("date"))
});
</script>
@endsection
