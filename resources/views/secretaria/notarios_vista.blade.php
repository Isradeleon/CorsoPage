<div id="formNotarioData" style="padding:10px 30px; display:none;">
  <h4>Datos notario</h4>
  <input type="hidden" id="id_venta_notario" value="{{$venta}}">
  <h5 align="center" class="errorMsg" id="existeError" style="display:none; margin:7px 2px 0px 2px; color:#D9534F;"></h5>
  <div class="form-group">
    <label for="nombre">Nombre</label>
    <input maxLength="40" class="form-control formNotario" type="text" name="nombre" id="nombre" value="">
    <h5 align="center" class="errorMsg" id="nombreError" style="display:none; margin:7px 0px 0px 0px; color:#D9534F;"></h5>
  </div>
  <div class="form-group">
    <label for="ap_paterno">Apellido paterno</label>
    <input maxLength="40" class="form-control formNotario" type="text" name="ap_paterno" id="ap_paterno" value="">
    <h5 align="center" class="errorMsg" id="ap_paternoError" style="display:none; margin:7px 0px 0px 0px; color:#D9534F;"></h5>
  </div>
  <div class="form-group">
    <label for="ap_materno">Apellido materno</label>
    <input maxLength="40" class="form-control formNotario" type="text" name="ap_materno" id="ap_materno" value="">
    <h5 align="center" class="errorMsg" id="ap_maternoError" style="display:none; margin:7px 0px 0px 0px; color:#D9534F;"></h5>
  </div>
  <div class="form-group">
    <label for="cedula">Cédula</label>
    <input maxLength="40" class="form-control formNotario" type="text" name="cedula" id="cedula" value="">
    <h5 align="center" class="errorMsg" id="cedulaError" style="display:none; margin:7px 0px 0px 0px; color:#D9534F;"></h5>
  </div><br>
  <div class="form-group">
    <button type="button" class="btn btn-success btn-block" name="button" id="btnSubmmitNotario"><b>Guardar datos</b></button>
  </div>
</div>
<br>
<div>
  <button id="btnAddN" type="button" name="button" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> <b>Nuevo</b></button>
</div>
<br>
<div id="notariosTabla">
  @include("secretaria.notarios_tabla")
</div>
<script type="text/javascript">
$(function(){
  $("#btnSubmmitNotario").click(function(){
    var nombre=$("#nombre").val();
    var ap_paterno=$("#ap_paterno").val();
    var ap_materno=$("#ap_materno").val();
    var cedula=$("#cedula").val();
    $(".errorMsg").hide().empty();

    var id=$("#id_venta_notario").val()

    $.ajax({
      url:"/registra_notario",method:"post",
      data:{
        _token:"{{csrf_token()}}",
        nombre:nombre,
        ap_paterno:ap_paterno,
        ap_materno:ap_materno,
        cedula:cedula,
        id:id
      }
    }).done(function(res){
      if (res.msgs) {
        if (res.msgs.nombre) {
          $("#nombreError").text(res.msgs.nombre[0]);
          $("#nombreError").slideDown(200);
        }
        if (res.msgs.ap_paterno) {
          $("#ap_paternoError").text(res.msgs.ap_paterno[0]);
          $("#ap_paternoError").slideDown(200);
        }
        if (res.msgs.ap_materno) {
          $("#ap_maternoError").text(res.msgs.ap_materno[0]);
          $("#ap_maternoError").slideDown(200);
        }
        if (res.msgs.cedula) {
          $("#cedulaError").text(res.msgs.cedula[0]);
          $("#cedulaError").slideDown(200);
        }
        if (res.msgs.existe) {
          $("#existeError").text(res.msgs.existe);
          $("#existeError").slideDown(200);
        }
      }else{
        $("#formNotarioData").slideUp(300);
        $(".formNotario").val("");
        $(".errorMsg").hide().empty();
        $("#btnAddN").html('<span class="glyphicon glyphicon-plus"></span> <b>Nuevo</b>');
        $("#btnAddN").attr("class","btn btn-info");

        $("#notariosTabla").hide().empty();
        $("#notariosTabla").html(res);
        $("#notariosTabla").show(500);
      }
    })
  })
})
</script>
<script type="text/javascript">
$(function(){
  $("#btnAddN").click(function(){
    if ($("#formNotarioData").css("display")=="none") {
      $("#btnAddN").html('<span class="glyphicon glyphicon-ban-circle"></span> <b>Cancelar</b>');
      $("#btnAddN").attr("class","btn btn-danger");
      $(".formNotario").val("");
      $(".errorMsg").hide().empty();
    }else{
      $("#btnAddN").html('<span class="glyphicon glyphicon-plus"></span> <b>Nuevo</b>');
      $("#btnAddN").attr("class","btn btn-info");
    }

    $("#formNotarioData").slideToggle(300);
  })
})
</script>
