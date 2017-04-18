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
.waiting{
  cursor: progress;
}
</style>
<link rel="stylesheet" href="public/js/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
@endsection

@section('menus')
  @include('secretaria.menussecre')
@endsection

@section('content')
  <h3><span class="glyphicon glyphicon-usd"></span> Registrar una venta</h3>
  <hr>
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="form-group">
          <form id="formVenta" action="/registro_venta_def" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group">
              <label for="tipo_pago">Tipo de pago</label>
              <select autofocus style="border-radius:0;" class="form-control" name="tipo_pago" id="tipo_pago">
                <option value="1">INFONAVIT</option>
                <option value="2">FOVISSSTE</option>
                <option value="3">Trato directo</option>
              </select>
            </div>
            <div class="form-group">
              <label for="n_credito_o_banco">REFERENCIA (Crédito o cuenta bancaria)</label>
              <input maxLength="90" type="text" style="border-radius:0;" class="form-control" name="n_credito_o_banco" value="">
              <h5 style="color:#D9534F; display:none;" class="errorMsg" id="errorRef" align="center"></h5>
            </div>
            <input type="hidden" name="date_time" id="date_time" value="">
            <input type="hidden" name="vendedor" value="{{old('vendedor')}}">
            <input type="hidden" name="casa" value="{{old('casa')}}">
            <input type="hidden" name="cliente" value="{{old('cliente')}}">
          </form>
        </div>
        <div class="form-group">
          <label for="date_time">Fecha en que inicio el trámite</label>
          <br><br>
          <div class="row">
              <div class="col-xs-12 col-lg-9">
                  <div id="datetimepicker1"></div>
              </div>
              <div class="col-xs-8 col-xs-offset-2 col-lg-offset-0 col-lg-3">
                <div id="datosCitaCasa">
                  <div style="margin:10px;" align="center">
                    <button type="button" style="border-radius:0;" id="seeSellers" class="btn btn-success btn-block" name="button" data-toggle="modal" data-target="#myModal">Vendedor</button>
                  </div>
                  <h6 style="color:#D9534F; display:none;" class="errorMsg" id="errorVendedor" align="center"></h6>
                  <div style="margin:10px;" align="center">
                    <button type="button" style="border-radius:0;" id="seeHouses" class="btn btn-info btn-block" name="button" data-toggle="modal" data-target="#modalHouses">Propiedad</button>
                  </div>
                  <h6 style="color:#D9534F; display:none;" class="errorMsg" id="errorCasa" align="center"></h6>
                  <div style="margin:10px; margin-bottom:0;" align="center">
                    <button type="button" style="border-radius:0;" id="seeClients" class="btn btn-warning btn-block" name="button" data-toggle="modal" data-target="#modalClients">Cliente</button>
                  </div>
                  <h6 style="color:#D9534F; display:none;" class="errorMsg" id="errorCliente" align="center"></h6>
                </div>
                <br>
                <div style="margin:10px;" align="center">
                  <button type="button" style=" border-radius:0;" id="btnSendVenta" class="btn btn-default btn-block" name="button" ><b>Registrar</b></button>
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

  <!-- Modal SEND THE SALE -->
  <div class="modal fade" id="modalSendSale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"><b>Registro de venta</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></span></h4>
        </div>
        <div class="modal-body">
          <div id="sendSaleArea" style="display:none;"></div>
        </div>
        <div class="modal-footer">
          <button style="border-radius:0;" type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
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
  $("#modalSendSale").on("show.bs.modal", function () {
    $("#sendSaleArea").hide().empty();
  });
  $("#btnSendVenta").click(function(){
    var tipo_pago=$("select[name='tipo_pago']").val();
    var cliente=$("input[name='cliente']").val();
    var casa=$("input[name='casa']").val();
    var vendedor=$("input[name='vendedor']").val();
    var n_credito_o_banco=$("input[name='n_credito_o_banco']").val();
    var date_time=$("input[name='date_time']").val();
    $(document.body).addClass("waiting");
    $.ajax({
      url:"registrar_venta",method:"post",
      data:{
        _token:"{{csrf_token()}}",
        tipo_pago:tipo_pago,
        n_credito_o_banco:n_credito_o_banco,
        casa:casa,
        cliente:cliente,
        vendedor:vendedor,
        date_time:date_time
      }
    }).done(function(res){
      $(document.body).removeClass("waiting")
      if (res.msgs) {
        if (res.msgs.n_credito_o_banco) {
          $("#errorRef").text(res.msgs.n_credito_o_banco[0]);
          $("#errorRef").slideDown(200);
        }
        if (res.msgs.cliente) {
          $("#errorCliente").text(res.msgs.cliente[0]);
          $("#errorCliente").slideDown(200);
        }
        if (res.msgs.casa) {
          $("#errorCasa").text(res.msgs.casa[0]);
          $("#errorCasa").slideDown(200);
        }
        if (res.msgs.vendedor) {
          $("#errorVendedor").text(res.msgs.vendedor[0]);
          $("#errorVendedor").slideDown(200);
        }
      }else{
        $(".errorMsg").slideUp(200);
        $("#modalSendSale").modal("show");
        $("#sendSaleArea").html(res)
        $("#sendSaleArea").show()
        console.log(res);
      }
    })
  })
})
</script>

<script type="text/javascript">
//Script for the automatic selection of the type of date and the inputs verificator
$(function(){
  $("#modalSendSale").modal({show:false})
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
    $.ajax({
      url:"/casas_disponibles",
      method:"post",
      data:{
        _token:"{{csrf_token()}}",
        date:$("#date_time").val(),
        id:id,
        imASale:1
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
    $.ajax({
      url:"/vendedores_disponibles",
      method:"post",
      data:{
        _token:"{{csrf_token()}}",
        date:$("#date_time").val(),
        id:id,
        imASale:1
      }
    }).done(function(res){
      $("#sellersArea").html(res)
      $("#sellersArea").show(500)
    });
    console.log($("#date_time").val())
  });

  //datetimepicker config ---------
  $("#date_time").val("{{Carbon\Carbon::now('America/Monterrey')->hour(0)->minute(0)->second(0)}}")
  $('#datetimepicker1').datetimepicker({
    inline:true,sideBySide: true,locale:'es',format:"dd/MM/yyyy",
    defaultDate:"{{Carbon\Carbon::now('America/Monterrey')->hour(0)->minute(0)->second(0)}}",
    maxDate:"{{Carbon\Carbon::now('America/Monterrey')}}",
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
        nextCentury: 'Siglo siguiente'
    }
  });
  $("#datetimepicker1").on("dp.change",function(e){
    $("#date_time").val(e.date)
    console.log($("#date_time").val())
  });
});
</script>
@endsection
