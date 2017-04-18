<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Grupo Corso</title>

    <link rel="icon" href="/public/img/logoDeCorso.JPG">

    <!-- Bootstrap Core CSS -->
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/public/css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/public/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/public/css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/public/css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/public/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('the_css')
</head>
<body>

  @yield('the_body')

  <!-- jQuery -->
  <script src="/public/js/jquery.min.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="/public/js/bootstrap.js"></script>

  <!-- Metis Menu Plugin JavaScript -->
  <script src="/public/js/metisMenu.min.js"></script>

  <!-- Custom Theme JavaScript -->
  <script src="/public/js/startmin.js"></script>

  @yield('the_js')
</body>
</html>
