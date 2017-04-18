<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Email</title>
   <style>
	 .titulo{
		 font-family: sans-serif;
		 text-align: center;
		 padding: 20px;
	 }
	 .div_contenido{
		 font-family: sans-serif;
		 text-align: center;
     padding:20px;
   }
   </style>
</head>
<body>
	<div class="titulo" >
		<h1>Grupo Corso</h1>
		<h2>Mensaje recibido desde la página principal.</h2>
	</div>
	<div class=".div_contenido">
	    <h3 align="center">
				<b>Remitente:</b> {{$data['nombre']}}
	    </h3>
	    <h3 align="center">
				<b>Correo:</b> {{$data['correo']}}
	    </h3>
      <h4>Mensaje:</h4>
      <p>{{$data["mensaje"]}}</p>
	</div>
</body>
</html>
