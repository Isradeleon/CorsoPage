<br><br>
<form enctype="multipart/form-data" action="/editar_docs" method="post">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  <input type="hidden" name="id" value="{{$id}}">
  <div class="form-group">
    @if($doc==1)
      <label class="btn btn-default btn-block" id="theFileChange">
        <span id="m" style="font-weight: normal;"><span class="glyphicon glyphicon-folder-open"></span> Documento (jpg, png, etc.)</span>
        <input accept=".jpg, .png, .jpeg" type="file" name="acta" style="display: none;">
      </label>
    @elseif($doc==2)
      <label class="btn btn-default btn-block" id="theFileChange">
        <span id="m" style="font-weight: normal;"><span class="glyphicon glyphicon-folder-open"></span> Documento (jpg, png, etc.)</span>
        <input accept=".jpg, .png, .jpeg" type="file" name="ine" style="display: none;">
      </label>
    @else
      <label class="btn btn-default btn-block" id="theFileChange">
        <span id="m" style="font-weight: normal;"><span class="glyphicon glyphicon-folder-open"></span> Documento (jpg, png, etc.)</span>
        <input accept=".jpg, .png, .jpeg" type="file" name="escrituras" style="display: none;">
      </label>
    @endif
  </div>
  <div style="display:none;" id="btnSendFile" class="form-group">
    <button type="submit" name="button" class="btn btn-success btn-block">Cambiar archivo</button>
  </div>
</form>
<script type="text/javascript">
$(function() {
  $('#theFileChange').change(function () {
     var file = $(this).children('input[type=file]')[0].files[0];
     if(file){
       $("#btnSendFile").slideDown(200);
       $(this).children('#m').html('<span class="glyphicon glyphicon-ok"></span> Archivo');
       $(this).attr('class',"btn btn-info btn-block");
     }
     else{
       $("#btnSendFile").slideUp(200);
       $(this).children('#m').html('<span class="glyphicon glyphicon-folder-open"></span> Documento (jpg, png, etc.)');
       $(this).attr('class',"btn btn-default btn-block");
     }
   });
})
</script>
