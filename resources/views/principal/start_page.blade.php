<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Grupo Corso</title>
    <link rel="icon" href="public/img/logoDeCorso.JPG">
    <!-- Bootstrap Core CSS -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 50px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    .section{
      background: #ddd;
    }
    #google_maps{
      margin-bottom: 0;
    }
    #msgArea{
      resize: none;
    }
    #picturesField{
      width: 100%;
      overflow-y: auto;
      max-height:660px;
      padding: 10px;
      border-top: 1px solid #ddd;
    }
    .housePhoto{
      margin-bottom: 20px;
    }
    .itemHousePhoto{
      border: 1px solid #ddd;
      height: 240px;
      width: 240px;
    }
    .itemHousePhotoB{
      border: 1px solid #ddd;
      height: 200px;
      width: 200px;
    }
    .itemHousePhoto:hover{
      cursor:pointer;
    }
    .itemHousePhotoB:hover{
      cursor:pointer;
    }

    .desc_type{
      padding:10px;
    }
    .img_type{
      width:280px;
      height: 200px;
    }
    .panel_type{
      border-radius: 0;
      width: 280px;
      box-shadow: 5px 5px #444;
    }

    .desc_typeB{
      padding:10px;
    }
    .img_typeB{
      width:200px;
      height: 150px;
    }
    .panel_typeB{
      border-radius: 0;
      width: 200px;
      box-shadow: 5px 5px #444;
    }

    .gallery_item{
      margin-bottom: 30px;
    }
    .itemImage{
      height: 210px;
      width: 240px;
      padding:10px;
    }
    .itemImageB{
      height: 180px;
      width: 200px;
      padding:10px;
    }

    .buttonR:hover{
      cursor: pointer;
    }
    .selected{
      color:white;
    }
    .vendida{
      font-size:16px;
      color:#666;
      text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
      text-align: center;
    }
    #start{
      min-height: 100vh;
      background-image: url('public/img/back2.jpeg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      color:#111;
      background-position: center center;
      background-size: cover;
      text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;
    }
    #payments{
      min-height: 100vh;
      background-image: url('public/img/back1.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      color:#111;
      background-position: center center;
      background-size: cover;
      text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Navegación</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand buttonR" data-pointer="start"><span>Grupo Corso</span></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="buttonR" data-pointer="gallery_section"><span>Casas</span></a>
                    </li>
                    <li>
                        <a class="buttonR" data-pointer="payments"><span>Tipos de pago</span></a>
                    </li>
                    <li>
                        <a class="buttonR" data-pointer="contact"><span>Contacto</span></a>
                    </li>
                    <li>
                        <a class="buttonR" data-pointer="google_maps"><span>Encuéntranos</span></a>
                    </li>
                    <li>
                        <a href="/status_folio">Trámite</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  @if(\Auth::check())
                    <li><a href="/inicio"><span class="glyphicon glyphicon-user"></span> Admin</a></li>
                  @else
                    <li><a href="/login"><span class="glyphicon glyphicon-user"></span> Login</a></li>
                  @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div id="msgCorreo" style="display:none;">
      <h4 align="center">Su correo se ha enviado con éxito!</h4>
    </div>
    <section id="start" style="padding-bottom:70px; padding-top:80px;" align="center" class="section jumbotron col-xs-12">
      <div id="titleFirst">
        <div align="center">
          <img class="img-responsive" style="border-radius:100%; max-height:200px;" src="/public/img/logo-corso.jpg">
        </div>
        <br>
        <h1>Grupo Corso</h1>
        <h3>Grupo mobiliario emergente en la Comarca Lagunera.</h3>
      </div>
    </section>

    <section style="padding-top:30px; padding-bottom:50px;" class="col-xs-12" id="gallery_section">
      <div>
        <div class="col-xs-12 col-md-8 col-md-offset-2">
          <h1 align="center">Algunas de nuestras casas</h1>
          <hr>
          <div align="center">
            <button style="border-radius:0; margin:5px;" class="btn btn-default filter-button" data-filter="all">Mostrar todas</button>
            <button style="border-radius:0; margin:5px;" class="btn btn-default filter-button" data-filter="T">Torreón</button>
            <button style="border-radius:0; margin:5px;" class="btn btn-default filter-button" data-filter="G">Gómez Palacio</button>
            <button style="border-radius:0; margin:5px;" class="btn btn-default filter-button" data-filter="L">Lerdo</button>
          </div>
          <br><br>
          <div>
            <div id="gallery_images" class="">
              @if(App\Casa::get()->count()>0)
                @foreach(App\Casa::paginate(9) as $casa)
                <div align="center" class="gallery_item hidden-xs col-md-6 col-lg-4 filter {{substr($casa->ciudad,0,1)}}">
                  <div class="itemImage"
                  style="background-image:url('{{$casa->fotos()->orderBy('id')->first()->string_foto}}');
                  background-position:center center; background-size: auto 220px;">
                    @if($casa->disponibilidad == 3)
                      <h5 class="vendida"><span class="pull-left"><span class="glyphicon glyphicon-usd"></span> Vendida</span></h5>
                    @endif
                  </div>
                  <div style="width:240px;">
                    <div style="padding:0;" class="col-xs-12">
                      <button house-id="{{$casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-default btn_pictures" data-toggle="modal" data-target="#ModalPictures"><span class="glyphicon glyphicon-camera"></span></button>
                    </div>
                  </div>
                </div>

                <div align="center" class="gallery_item col-xs-12 hidden-sm hidden-md hidden-lg filter {{substr($casa->ciudad,0,1)}}">
                  <div class="itemImageB"
                  style="background-image:url('{{$casa->fotos()->orderBy('id')->first()->string_foto}}');
                  background-position:center center; background-size: auto 190px;">
                    @if($casa->disponibilidad == 3)
                      <h5 class="vendida"><span class="pull-left"><span class="glyphicon glyphicon-usd"></span> Vendida</span></h5>
                    @endif
                  </div>
                  <div style="width:200px;">
                    <div style="padding:0;" class="col-xs-12">
                      <button house-id="{{$casa->id}}" type="button" style="border-radius:0;" class="btn btn-block btn-default btn_pictures" data-toggle="modal" data-target="#ModalPictures"><span class="glyphicon glyphicon-camera"></span></button>
                    </div>
                  </div>
                </div>
                @endforeach
              @else
              <div>
                <h4 align="center"><i>Estamos trabajando en esta sección!</i></h4>
                <br><br>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <section style="padding-bottom:80px;" class="section jumbotron col-xs-12" id="payments">
      <div class="container">
        <h2 align="center">Tipos de pago</h2>
        <br>
        <div class="hidden-xs col-sm-12">
          <div align="center" class="col-xs-12 col-lg-4">
            <div align="center" class="panel panel_type">
              <div style="background:url('public/img/infonavit.png');
              background-position:center center; background-size: auto 215px;" class="img_type"></div>
              <br>
              <div class="desc_type">
                <p>Aceptamos tu crédito INFONAVIT.</p>
              </div>
            </div>
          </div>

          <div align="center" class="col-xs-12 col-lg-4">
            <div align="center" class="panel panel_type">
              <div style="background:url('public/img/fovissste.png');
              background-position:center center; background-size: auto 215px;" class="img_type"></div>
              <br>
              <div class="desc_type">
                <p>Aceptamos crédito FOVISSSTE.</p>
              </div>
            </div>
          </div>

          <div align="center" class="col-xs-12 col-lg-4">
            <div align="center" class="panel panel_type">
              <div style="background:url('public/img/trato.jpg');
              background-position:center center; background-size: auto 300px;" class="img_type"></div>
              <br>
              <div class="desc_type">
                <p>O podemos negociar directamente.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
          <div align="center" class="col-xs-12 col-lg-4">
            <div align="center" class="panel panel_typeB">
              <div style="background:url('public/img/infonavit.png');
              background-position:center center; background-size: auto 155px;" class="img_typeB"></div>
              <br>
              <div class="desc_type">
                <p>Aceptamos tu crédito INFONAVIT.</p>
              </div>
            </div>
          </div>

          <div align="center" class="col-xs-12 col-lg-4">
            <div align="center" class="panel panel_typeB">
              <div style="background:url('public/img/fovissste.png');
              background-position:center center; background-size: auto 155px;" class="img_typeB"></div>
              <br>
              <div class="desc_type">
                <p>Aceptamos crédito FOVISSSTE.</p>
              </div>
            </div>
          </div>

          <div align="center" class="col-xs-12 col-lg-4">
            <div align="center" class="panel panel_typeB">
              <div style="background:url('public/img/trato.jpg');
              background-position:center center; background-size: auto 240px;" class="img_typeB"></div>
              <br>
              <div class="desc_type">
                <p>O podemos negociar directamente.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="contact" style="padding-top:30px; padding-bottom:60px;" class="col-xs-12">
      <div class="container">
        <h2 align="center">Contacta con nosotros<br><small>Grupo Corso.</small></h2>
        <div id="msgCorreoE" style="display:none;">
          <h4 align="center"><span style="color:#D9534F;">Llene todos los campos para el envío del correo!</span></h4>
        </div>
        <br>
        <div class="col-xs-12">
          <div class="col-lg-5 col-lg-offset-1 col-sm-7 col-xs-12">
            <form action="/sendEmail" method="post">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="form-group">
                <input style="border-radius:0;" type="text" name="nombre" class="form-control" placeholder="Nombre..." value="{{old('nombre')}}">
              </div>
              <div class="form-group">
                <input style="border-radius:0;" type="email" name="correo" class="form-control" placeholder="Correo electrónico..." value="{{old('correo')}}">
              </div>
              <div class="form-group">
                <textarea style="border-radius:0;" id="msgArea" placeholder="Escribe tu mensaje..." name="mensaje" class="form-control" rows="6">{{old('mensaje')}}</textarea>
              </div>
              <div class="form-group">
                <button type="submit" style="border-radius:0;" class="btn btn-block btn-primary" name="button">Enviar</button>
              </div>
            </form>
          </div>
          <div style="padding:10px; border-left:1px solid lightgray;" class="col-lg-6 col-sm-5 col-xs-12">
            <p><b>Facebook: {{App\Dato::first() && App\Dato::first()->facebook ? App\Dato::first()->facebook : "#"}}.</b></p>
            <br>
            <p><b><span class="glyphicon glyphicon-envelope"></span>: {{App\Dato::first() && App\Dato::first()->correo ? App\Dato::first()->correo : "#"}}</b></p>
            <br>
            <p><b><span class="glyphicon glyphicon-phone"></span>: {{App\Dato::first() && App\Dato::first()->telefono ? App\Dato::first()->telefono : "#"}}.</b></p>
          </div>
        </div>
      </div>
    </section>

    <section id="google_maps" class="section col-xs-12 jumbotron">
      <h2 align="center">Nuestra ubicación<br><small>¡Ven a hablar en persona con nosotros!</small></h2>
      <br>
      <div style="width:100%;height:360px; border:5px solid #444;" id="the_map"></div>
      <br><br>
      <div class="footer">
        <div align="center">
          <a href="https://www.facebook.com/Grupo-CORSO-1223183361034009/" style="border-radius:100%;" class="btn btn-default btn-sm"><i class="fa fa-facebook"></i></a>
        </div>
        <h4 align="center">© GRUPO CORSO.<br><small>Venta de bienes raices.</small></h4>
      </div>
    </section>

    <!-- Modal imagenes -->
    <div class="modal fade" id="ModalPictures" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel"><b>Imágenes</b> <span class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button></span></h4>
          </div>
          <br>
          <div class="modal-body">
            <div align="center" style="display:none; width:100%;" id="specificPictureField">
              <img style="border:4px #D9534F solid;" id="specificPicture" class="img-responsive" src="">
            </div>
            <br>
            <div id="picturesField"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery Version 1.11.1 -->
    <script src="public/js/jquery.js"></script>

    @if(Session::has("msgCorreo"))
    <script type="text/javascript">
      $(function(){
        $("#msgCorreo").show().delay("10000").slideUp(1000);
      })
    </script>
    @elseif(Session::has("msgCorreoE"))
    <script type="text/javascript">
      $(function(){
        $("#msgCorreoE").show();
        $('html, body').animate({
          scrollTop: $("#contact").offset().top-50 }, 1000);
      })
    </script>
    @endif

    <!-- Bootstrap Core JavaScript -->
    <script src="public/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function(){
      $("#ModalPictures").on("show.bs.modal", function () {
          $("#picturesField").hide().empty();
          $("#specificPictureField").hide()
          $("#specificPicture").attr("src","")
      });
      $(".btn_pictures").click(function(){
        var id=$(this).attr("house-id");
        $.ajax({
          method:"POST",
          url:"/pedir_fotos",
          data:{
            _token:'{{csrf_token()}}',
            id:id
          }
        }).done(function(res){
          for(var photo in res){
            var div=$("<div>");
            div.attr("align","center");
            div.attr("class","housePhoto hidden-xs col-sm-6 col-lg-4");
            var divImage=$("<div>");
            divImage.attr("class","itemHousePhoto");
            divImage.attr("the_source",res[photo].string_foto)
            divImage.css("background","url("+res[photo].string_foto+")");
            divImage.css("background-position","center center");
            divImage.css("background-size","auto 250px");
            div.append(divImage);

            var div2=$("<div>");
            div2.attr("align","center");
            div2.attr("class","housePhoto col-xs-12 hidden-sm hidden-md hidden-lg");
            var divImage2=$("<div>");
            divImage2.attr("class","itemHousePhotoB");
            divImage2.attr("the_source",res[photo].string_foto)
            divImage2.css("background","url("+res[photo].string_foto+")");
            divImage2.css("background-position","center center");
            divImage2.css("background-size","auto 210px");
            div2.append(divImage2);

            $("#picturesField").append(div);
            $("#picturesField").append(div2);
          }

          $(".itemHousePhoto").click(function(){
            $("#specificPictureField").hide()
            $("#specificPicture").attr("src",$(this).attr("the_source"))
            $("#specificPictureField").slideDown(200)
          });
          $(".itemHousePhotoB").click(function(){
            $("#specificPictureField").hide()
            $("#specificPicture").attr("src",$(this).attr("the_source"))
            $("#specificPictureField").slideDown(200)
          });
          $("#picturesField").slideDown();
        });
      });
    });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqiB2cyhlFaZJmw6_x1Cz7-AvGH5dkTLU&callback=initMap&language=ES" async defer></script>

    <script type="text/javascript">
    function initMap(){
      var mapOptions = {
            center: {lat: 25.540234349280425, lng: -103.44439029693604},
            zoom: 16,
            maxZoom:19,
            minZoom:11,
            scrollwheel:false,
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP
            },
            streetViewControl:false,
            mapTypeControl:false
      };
      map = new google.maps.Map(document.getElementById("the_map"),mapOptions);
      var m = new google.maps.Marker({
        position:map.getCenter(),
        animation: google.maps.Animation.BOUNCE,
        map:map
      });
      google.maps.event.addListener(map,'click',function(e){
        var lat=e.latLng.lat()
        var lng=e.latLng.lng()
        console.log(lat);
        console.log(lng);
      });
    }
    </script>

    <script type="text/javascript">
    $(document).ready(function(){
      $(".filter-button").click(function(){
          var value = $(this).attr('data-filter');
          if(value == "all") {
              $('.filter').show('1000');
          } else {
              $(".filter").not('.'+value).hide('3000');
              $('.filter').filter('.'+value).show('3000');
          }
      });
    });
    </script>
    <script type="text/javascript">
      $(function(){
        $(".buttonR").click(function() {
          var element=$(this).attr("data-pointer");
          $(".selected").removeClass("selected");
          $(this).children("span").addClass("selected");
          $('html, body').animate({
            scrollTop: $("#"+element).offset().top-50 }, 700);
          });
      })
    </script>
</body>

</html>
