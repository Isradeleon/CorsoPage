@extends('menu_layouts.menu_base')

@section('the_css')
<link rel="stylesheet" href="public/js/jquery-ui-1.12.1/jquery-ui.css">
@endsection

@section('menus')
  @include('gerente.menusgerente')
@endsection

@section('content')
<h3>Vendedores registrados</h3>
<hr>
<div id="sellersTable" class="table-responsive" style="max-height:500px; overflow-y:auto;">
  @include("gerente.tabla_vendedores")
</div>

<!-- MODAL FOR SELLERS -->
<div class="modal fade" id="sellerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Datos del vendedor</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <br>
      <div class="modal-body">
        <div style="padding:5px" id="sellerArea">
          <input type="hidden" name="id" value="" class="formInput">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input maxLength="40" type="text" name="nombre" value="" class="form-control formInput">
          </div>
          <div class="form-group">
            <label for="ap_paterno">Apellido paterno</label>
            <input maxLength="40" type="text" name="ap_paterno" value="" class="form-control formInput">
          </div>
          <div class="form-group">
            <label for="ap_materno">Apellido materno</label>
            <input maxLength="40" type="text" name="ap_materno" value="" class="form-control formInput">
          </div>
          <div class="form-group">
            <label for="direccion">Direccion</label>
            <input maxLength="90" type="text" name="direccion" value="" class="form-control formInput">
          </div>
          <div class="form-group">
            <label for="rfc">RFC</label>
            <input maxLength="13" type="text" name="rfc" value="" class="form-control formInput">
          </div>
          <div class="form-group">
            <label for="curp">CURP</label>
            <input maxLength="18" type="text" name="curp" value="" class="form-control formInput">
          </div>
          <div class="form-group">
            <label for="fecha_nac">Fecha de nacimiento</label>
            <input onkeydown="return false;" max="{{Carbon\Carbon::now('America/Monterrey')->subYears(20)->toDateString()}}" id="datePickerUI" type="date" name="fecha_nac" value="" class="form-control formInput">
          </div>
          <div class="form-group">
            <label for="contacto">Contacto</label>
            <input maxLength="40" type="text" name="contacto" value="" class="form-control formInput">
          </div>
          <div class="from-group">
            <button type="button" id="btnEditSend" class="btn btn-success btn-block" name="button"><b>Guardar</b></button>
          </div>
          <div style="display:none;" id="msgSuccess">
            <h5 align="center" style="color:#5CB85C;"><span class="glyphicon glyphicon-ok"></span> Se guardaron los cambios</h5>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL FOR DELETE ACTION -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>¿Está usted segur@ la siguiente baja?</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <br>
      <div class="modal-body">
        <div id="sellerToDelete" style="display:none;">
          <div id="sellerData" style="padding:0px 10px 10px 10px;">
            <input class="spanInput" type="hidden" id="spanID" value="">
            <p><b>Nombre completo: </b><span class="spanInput" id="spanNombre"></span></p>
            <p><b>Fecha nacimiento: </b><span class="spanInput" id="spanFecha"></span></p>
            <p><b>Direccion: </b><span class="spanInput" id="spanDir"></span></p>
            <p><b>RFC: </b><span class="spanInput" id="spanRFC"></span></p>
            <p><b>CURP: </b><span class="spanInput" id="spanCURP"></span></p>
            <p><b>Contacto: </b><span class="spanInput" id="spanCon"></span></p>
          </div>
          <br>
          <button type="button" class="btn btn-danger btn-block" id="btnDeleteSend" name="button">Eliminar</button>
        </div>
        <div style="display:none;" id="msgSuccessD">
          <h5 align="center" style="color:#D9534F;"><span class="glyphicon glyphicon-exclamation-sign"></span> Registro eliminado con éxito</h5>
          <br>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('the_js')
<script type="text/javascript">
var setEvents=function(){
  $(".btnDelete").click(function(){
    var id=$(this).attr('data-seller-id');
    $.ajax({
        method:"POST",
        url:"/pedir_vendedor",
        data:{
            _token:'{{csrf_token()}}',
            id:id
        }
    }).done(function (res){
        $("#spanID").val(res.id);
        $("#spanNombre").text(res.nombre+" "+res.ap_paterno+" "+res.ap_materno)
        $("#spanDir").text(res.direccion)
        $("#spanRFC").text(res.rfc)
        $("#spanCURP").text(res.curp)
        $("#spanFecha").text(res.fecha_nacimiento)
        $("#spanCon").text(res.contacto)
        $("#sellerToDelete").slideDown(200)
    })
  });

  $('.btnEdit').click(function(){
      var id=$(this).attr('data-seller-id');
      $.ajax({
          method:"POST",
          url:"/pedir_vendedor",
          data:{
              _token:'{{csrf_token()}}',
              id:id
          }
      }).done(function (res){
          $("input[name='id']").val(res.id);
          $("input[name='nombre']").val(res.nombre)
          $("input[name='ap_paterno']").val(res.ap_paterno)
          $("input[name='ap_materno']").val(res.ap_materno)
          $("input[name='direccion']").val(res.direccion)
          $("input[name='rfc']").val(res.rfc)
          $("input[name='curp']").val(res.curp)
          $("input[name='fecha_nac']").val(res.fecha_nacimiento)
          $("input[name='contacto']").val(res.contacto)
          $("#sellerArea").slideDown(200)
      })
  });
}

$(function(){
  $("#btnDeleteSend").click(function(){
    var id=$("#spanID").val();
    $.ajax({
      url:"/eliminar_vendedor",method:"post",
      data:{
        _token:"{{csrf_token()}}",
        id:id
      }
    }).done(function(res){
      $("#sellersTable").hide().empty();
      $("#sellersTable").html(res);
      $("#sellersTable").show(500);
      $("#msgSuccessD").hide().slideDown(300);

      $("#sellerToDelete").slideUp(200);
      $(".spanInput").empty();
      $(".spanID").val("");
      setEvents();
    });
  });

  $("#btnEditSend").click(function(){
    var id=$("input[name='id']").val();
    var nombre=$("input[name='nombre']").val();
    var ap_paterno=$("input[name='ap_paterno']").val();
    var ap_materno=$("input[name='ap_materno']").val();
    var direccion=$("input[name='direccion']").val();
    var rfc=$("input[name='rfc']").val();
    var curp=$("input[name='curp']").val();
    var fecha_nac=$("input[name='fecha_nac']").val();
    var contacto=$("input[name='contacto']").val();
    $.ajax({
      url:"/editar_vendedor",method:"post",
      data:{
        _token:"{{csrf_token()}}",
        id:id,
        nombre:nombre,
        ap_paterno:ap_paterno,
        ap_materno:ap_materno,
        direccion:direccion,
        rfc:rfc,
        curp:curp,
        fecha_nac:fecha_nac,
        contacto:contacto
      }
    }).done(function(res){
      $("#sellersTable").hide().empty();
      $("#sellersTable").html(res);
      $("#sellersTable").show(500);
      $("#msgSuccess").hide().slideDown(300);
      setEvents();
    });
  });
})
</script>

<!-- first script -->
<script type="text/javascript">
$(function(){
  $("#sellerModal").on("show.bs.modal",function(){
    $("#sellerArea").hide();
    $("#msgSuccess").hide();
    $(".formInput").val("");
  });

  $("#deleteModal").on("show.bs.modal",function(){
    $("#sellerToDelete").hide();
    $("#msgSuccessD").hide();
    $(".spanInput").empty();
    $(".spanID").val("");
  });
  setEvents();
})
</script>

<script src="public/js/jquery-ui-1.12.1/jquery-ui.js"></script>
<script>
  $(function(){
    $("#datePickerUI").datepicker({
      dateFormat: "yy-mm-dd",
      maxDate:"{{Carbon\Carbon::now('America/Monterrey')->subYears(20)->toDateString()}}",
      dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
      dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
      monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
      monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
    })
  })
</script>
@endsection
