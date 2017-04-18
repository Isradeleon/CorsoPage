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
		<h2>Bienvenid@ al sistema {{$data['usuario']}}.</h2>
	</div>
	<div class=".div_contenido">
	    <h3 align="center">
				<b>Usuario:</b> {{$data['email']}}
	    </h3>
	    <h3 align="center">
				<b>Password:</b> {{$data['pass']}}
	    </h3>
	</div>
</body>
</html>
