<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status venta</title>
    <link rel="icon" href="public/img/logoDeCorso.JPG">

    <link href="public/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/font-awesome.min.css">
  </head>
  <body>
    <div style="background:#ddd; padding:30px;" class="jumbotron">
      <div align="center" class="container">
        <div align="center">
          <img class="img-responsive" style="max-height:50px; border-radius:100%;" src="public/img/logo-corso.jpg" alt="">
          <h3>Grupo Mobiliario Corso.</h3>
        </div>
        <h4><span class="glyphicon glyphicon-list-alt"></span> Consulta de status.</h4>
        <a href="/"><span class="glyphicon glyphicon-home"></span> Ir a la página principal</a>
      </div>
    </div>
    <div class="container">
      <div style="padding:20px;" align="center" class="col-xs-12 col-md-5">
        <br>
        <h3 style="color:#D9534F;"><span class="glyphicon glyphicon-alert"></span></h3>
        <h3>Atención!</h3><br>
        <h4>Asegúrese que sus datos concuerdan con los proporcionados a la empresa.</h4><br>
      </div>

      <div style="border-left:1px solid lightgray; margin-bottom:20px;" class="col-xs-12 col-md-6 col-lg-5">
        <h3>Datos del cliente</h3>
        @if(Session::has("error"))
          <h4 style="color:#D9534F;">{{Session::get("error")}}</h4>
        @endif
        <hr>
        <form action="/status_folio" method="post">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input autofocus class="form-control" type="text" name="nombre" value="{{old('nombre')}}">
          </div>
          @if(Session::has("msgs") && Session::get("msgs")->has("nombre"))
            <h5 align="center" style="color:#D9534F;">{{Session::get("msgs")->get("nombre")[0]}}</h5>
          @endif
          <div class="form-group">
            <label for="ap_paterno">Apellido paterno:</label>
            <input class="form-control" type="text" name="ap_paterno" value="{{old('ap_paterno')}}">
          </div>
          @if(Session::has("msgs") && Session::get("msgs")->has("ap_paterno"))
            <h5 align="center" style="color:#D9534F;">{{Session::get("msgs")->get("ap_paterno")[0]}}</h5>
          @endif
          <div class="form-group">
            <label for="ap_materno">Apellido materno:</label>
            <input class="form-control" type="text" name="ap_materno" value="{{old('ap_materno')}}">
          </div>
          @if(Session::has("msgs") && Session::get("msgs")->has("ap_materno"))
            <h5 align="center" style="color:#D9534F;">{{Session::get("msgs")->get("ap_materno")[0]}}</h5>
          @endif
          <div class="form-group">
            <label for="folio"><span class="glyphicon glyphicon-barcode"></span> Folio:</label>
            <input class="form-control" type="text" name="folio" value="{{old('folio')}}">
          </div>
          @if(Session::has("msgs") && Session::get("msgs")->has("folio"))
            <h5 align="center" style="color:#D9534F;">{{Session::get("msgs")->get("folio")[0]}}</h5>
            <br>
          @endif
          <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary" name="button"><span class="glyphicon glyphicon-ok"></span> Enviar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- jQuery Version 1.11.1 -->
    <script src="public/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="public/js/bootstrap.min.js"></script>
  </body>
</html>
