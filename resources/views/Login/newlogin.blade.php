<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Grupo Corso - Login</title>
    <link rel="icon" href="public/img/logoDeCorso.JPG">

    <!-- Bootstrap Core CSS -->
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
        <h4><span class="glyphicon glyphicon-tasks"></span> Acceso al sistema.</h4>
        <a href="/"><span class="glyphicon glyphicon-home"></span> Ir a la página principal</a>
      </div>
    </div>
    <div class="container">
      <div style="padding:20px;" align="center" class="col-xs-12 col-md-6">
        <br>
        <h3 style="color:#D9534F;"><span class="glyphicon glyphicon-alert"></span></h3>
        <h3>Atención!</h3><br>
        <h4>Este login es exclusivo para personal de la empresa.</h4><br>
      </div>
      <div style="border-left:1px solid lightgray;" class="col-xs-12 col-md-6 col-lg-5">
        <h3>Datos de acceso</h3>
        <hr>
        <form action="/" method="post">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="form-group">
            <label for="email"><span class="glyphicon glyphicon-user"></span> Correo electrónico:</label>
            <input autofocus placeholder="ejemplo@correo.com" class="form-control" type="email" name="email" value="{{old('email')}}">
            @if(Session::has("msgs") && Session::get("msgs")->has("email"))
              <h5 align="center" style="color:#D9534F;">{{Session::get("msgs")->get("email")[0]}}</h5>
            @elseif(Session::has("msgE"))
              <h5 align="center" style="color:#D9534F;">{{Session::get("msgE")}}</h5>
            @endif
          </div>
          <div class="form-group">
            <label for="email"><span class="glyphicon glyphicon-lock"></span> Clave de acceso:</label>
            <input class="form-control" type="password" name="password" value="{{old('password')}}">
            @if(Session::has("msgs") && Session::get("msgs")->has("password"))
              <h5 align="center" style="color:#D9534F;">{{Session::get("msgs")->get("password")[0]}}</h5>
            @elseif(Session::has("msgP"))
              <h5 align="center" style="color:#D9534F;">{{Session::get("msgP")}}</h5>
            @endif
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary" name="button"><span class="glyphicon glyphicon-ok"></span> Acceder</button>
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
