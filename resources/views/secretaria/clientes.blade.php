<div id="formClientData" style="padding:10px 30px; display:none;">
  <h4>Datos del cliente</h4>
  <h5 align="center" class="errorMsg" id="existeError" style="display:none; margin:7px 2px 0px 2px; color:#D9534F;"></h5>
  <div class="form-group">
    <label for="client_name">Nombre</label>
    <input maxLength="40" class="form-control formForClient" type="text" name="client_name" id="client_name" value="">
    <h5 align="center" class="errorMsg" id="client_nameError" style="display:none; margin:7px 0px 0px 0px; color:#D9534F;"></h5>
  </div>
  <div class="form-group">
    <label for="ap_paterno">Apellido paterno</label>
    <input maxLength="40" class="form-control formForClient" type="text" name="ap_paterno" id="ap_paterno" value="">
    <h5 align="center" class="errorMsg" id="ap_paternoError" style="display:none; margin:7px 0px 0px 0px; color:#D9534F;"></h5>
  </div>
  <div class="form-group">
    <label for="ap_materno">Apellido materno</label>
    <input maxLength="40" class="form-control formForClient" type="text" name="ap_materno" id="ap_materno" value="">
    <h5 align="center" class="errorMsg" id="ap_maternoError" style="display:none; margin:7px 0px 0px 0px; color:#D9534F;"></h5>
  </div>
  <div class="form-group">
    <label for="contacto">Contacto</label>
    <input maxLength="40" class="form-control formForClient" type="text" name="contacto" id="contacto" value="">
    <h5 align="center" class="errorMsg" id="contactoError" style="display:none; margin:7px 0px 0px 0px; color:#D9534F;"></h5>
  </div><br>
  <div class="form-group">
    <button type="button" class="btn btn-success btn-block" name="button" id="btnSubmmitClient"><b>Guardar datos</b></button>
  </div>
</div>
<br>
<div>
  <button id="btnAddClient" type="button" name="button" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> <b>Nuevo</b></button>
</div>
<br>
<div id="clientsTable">
  @include("secretaria.clientes_tabla")
</div>
<script type="text/javascript">
$(function(){
  $("#btnSubmmitClient").click(function(){
    var client_name=$("#client_name").val();
    var ap_paterno=$("#ap_paterno").val();
    var ap_materno=$("#ap_materno").val();
    var contacto=$("#contacto").val();
    $(".errorMsg").hide().empty();

    var id=$("input[name='cliente']").val();

    $.ajax({
      url:"/registrar_cliente",method:"post",
      data:{
        _token:"{{csrf_token()}}",
        client_name:client_name,
        ap_paterno:ap_paterno,
        ap_materno:ap_materno,
        contacto:contacto,
        id:id
      }
    }).done(function(res){
      if (res.msgs) {
        if (res.msgs.client_name) {
          $("#client_nameError").text(res.msgs.client_name[0]);
          $("#client_nameError").slideDown(200);
        }
        if (res.msgs.ap_paterno) {
          $("#ap_paternoError").text(res.msgs.ap_paterno[0]);
          $("#ap_paternoError").slideDown(200);
        }
        if (res.msgs.ap_materno) {
          $("#ap_maternoError").text(res.msgs.ap_materno[0]);
          $("#ap_maternoError").slideDown(200);
        }
        if (res.msgs.contacto) {
          $("#contactoError").text(res.msgs.contacto[0]);
          $("#contactoError").slideDown(200);
        }
        if (res.msgs.existe) {
          $("#existeError").text(res.msgs.existe);
          $("#existeError").slideDown(200);
        }
      }else{
        $("#formClientData").slideUp(300);
        $(".formForClient").val("");
        $(".errorMsg").hide().empty();
        $("#btnAddClient").html('<span class="glyphicon glyphicon-plus"></span> <b>Nuevo</b>');
        $("#btnAddClient").attr("class","btn btn-info");

        $("#clientsTable").hide().empty();
        $("#clientsTable").html(res);
        $("#clientsTable").show(500);
      }
    })
  })
})
</script>
<script type="text/javascript">
$(function(){
  $("#btnAddClient").click(function(){
    if ($("#formClientData").css("display")=="none") {
      $("#btnAddClient").html('<span class="glyphicon glyphicon-ban-circle"></span> <b>Cancelar</b>');
      $("#btnAddClient").attr("class","btn btn-danger");
      $(".formForClient").val("");
      $(".errorMsg").hide().empty();
    }else{
      $("#btnAddClient").html('<span class="glyphicon glyphicon-plus"></span> <b>Nuevo</b>');
      $("#btnAddClient").attr("class","btn btn-info");
    }

    $("#formClientData").slideToggle(300);
  })
})
</script>
