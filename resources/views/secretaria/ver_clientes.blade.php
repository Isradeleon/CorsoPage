@extends('menu_layouts.menu_base')

@section('the_css')
<link rel="stylesheet" href="public/js/jquery-ui-1.12.1/jquery-ui.css">
@endsection

@section('menus')
  @include('secretaria.menussecre')
@endsection

@section('content')
<h3>Registros de clientes</h3>
<hr>
<div id="tableWithData" class="table-responsive" style="max-height:500px; overflow-y:auto;">
  @include("secretaria.tabla_clientes")
</div>

<!-- MODAL PARA CLIENTES -->
<div class="modal fade" id="firstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Datos cliente</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></span></h4>
      </div>
      <br>
      <div class="modal-body">
        <div style="padding:5px" id="dataArea">
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
        <div id="dataToDelete" style="display:none;">
          <div style="padding:0px 10px 10px 10px;">
            <input class="spanInput" type="hidden" id="spanID" value="">
            <p><b>Nombre completo: </b><span class="spanInput" id="spanNombre"></span></p>
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
    var id=$(this).attr('data-id');
    $.ajax({
        method:"POST",
        url:"/pedir_cliente",
        data:{
            _token:'{{csrf_token()}}',
            id:id
        }
    }).done(function (res){
        $("#spanID").val(res.id);
        $("#spanNombre").text(res.nombre+" "+res.ap_paterno+" "+res.ap_materno)
        $("#spanCon").text(res.contacto)
        $("#dataToDelete").slideDown(200)
    })
  });

  $('.btnEdit').click(function(){
      var id=$(this).attr('data-id');
      $.ajax({
          method:"POST",
          url:"/pedir_cliente",
          data:{
              _token:'{{csrf_token()}}',
              id:id
          }
      }).done(function (res){
          $("input[name='id']").val(res.id);
          $("input[name='nombre']").val(res.nombre)
          $("input[name='ap_paterno']").val(res.ap_paterno)
          $("input[name='ap_materno']").val(res.ap_materno)
          $("input[name='contacto']").val(res.contacto)
          $("#dataArea").slideDown(200)
      })
  });
}

$(function(){
  $("#btnDeleteSend").click(function(){
    var id=$("#spanID").val();
    $.ajax({
      url:"/eliminar_cliente",method:"post",
      data:{
        _token:"{{csrf_token()}}",
        id:id
      }
    }).done(function(res){
      $("#tableWithData").hide().empty();
      $("#tableWithData").html(res);
      $("#tableWithData").show(500);
      $("#msgSuccessD").hide().slideDown(300);

      $("#dataToDelete").slideUp(200);
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
    var contacto=$("input[name='contacto']").val();
    $.ajax({
      url:"/editar_cliente",method:"post",
      data:{
        _token:"{{csrf_token()}}",
        id:id,
        nombre:nombre,
        ap_paterno:ap_paterno,
        ap_materno:ap_materno,
        contacto:contacto
      }
    }).done(function(res){
      $("#tableWithData").hide().empty();
      $("#tableWithData").html(res);
      $("#tableWithData").show(500);
      $("#msgSuccess").hide().slideDown(300);
      setEvents();
    });
  });
})
</script>

<!-- first script -->
<script type="text/javascript">
$(function(){
  $("#firstModal").on("show.bs.modal",function(){
    $("#dataArea").hide();
    $("#msgSuccess").hide();
    $(".formInput").val("");
  });

  $("#deleteModal").on("show.bs.modal",function(){
    $("#dataToDelete").hide();
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
      dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
      dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
      monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
      monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
    })
  })
</script>
@endsection
