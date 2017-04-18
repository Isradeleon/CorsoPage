<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*Route::get("/teest",function(){
  return App\Venta::get();
});*/
Route::get("/s_d/{userid}/{tokenid}/{token}/{dateid}","MobileController@successful_date");
Route::get("/c_d/{userid}/{tokenid}/{token}/{dateid}","MobileController@cancel_date");
Route::get("/check_date/{dateid}","MobileController@check_date");

Route::get("/logout_m/{tokenid}","MobileController@logout_mobile");

Route::get("/casas_m1/{userid}/{tokenid}/{token}","MobileController@casas_mobile_1");
Route::get("/casas_m2/{userid}/{tokenid}/{token}","MobileController@casas_mobile_2");
Route::get("/casas_m3/{userid}/{tokenid}/{token}","MobileController@casas_mobile_3");

Route::get("/ventas_m1/{userid}/{tokenid}/{token}","MobileController@ventas_mobile_1");
Route::get("/citas_m1/{userid}/{tokenid}/{token}","MobileController@citas_mobile_1");

Route::get("/ventas_m2/{userid}/{tokenid}/{token}","MobileController@ventas_mobile_2");
Route::get("/citas_m2/{userid}/{tokenid}/{token}","MobileController@citas_mobile_2");

Route::get('/l_m/{email}/{password}','MobileController@login_mobile');

Route::get('/config-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return "Cache configured!";
});

Route::get('/', function () {
    return view('principal.start_page');
});

Route::match(["GET","POST"],'/status_folio', "PDFController@GeneratePDF");
Route::post("/sendEmail","GerenteController@sendEmail");

//Ruta para pedir fotos decasa
Route::post("/pedir_fotos","CasasController@CasaFotos");
//Rutas para logeado
Route::group(['middleware' => ['auth']], function () {
  //Ruta cambio contra
  Route::match(["GET","POST"],"/cambiar_pass","LoginController@CambiarPass");

  //Ruta de inicio
  Route::get('/inicio','InicioController@ChecarTipo');
  //Rutas de casas, todos pueden verlas con estar logeados
  Route::get("/casas_venta","CasasController@VerCasasEnVenta");
  Route::get("/casas_tramite","CasasController@VerCasasEnTramite");
  Route::get("/casas_vendidas","CasasController@VerCasasVendidas");
  Route::post("/pedir_casa","CasasController@CasaPorId");

    //Middleware necesario para que solo secretarias y gerentes puedan registrar vendedores rutas
    Route::group(['middleware'=>"mgensec"],function(){
        Route::match(["GET","POST"],'/registrar_vendedor',
          'RegisterController@RegistroVendedor');
        Route::match(["GET","POST"],'/editar_vendedor',
          'EditarController@EditarVendedor');

        Route::post('/eliminar_vendedor',
          'EditarController@EliminarVendedor');

        Route::post("/pedir_vendedor",'EditarController@PedirVendedor');
    });

    //Rutas del gerente iran aqui dentro de este grupo:
    Route::group(['middleware'=>'mgen'],function(){
      Route::match(['GET','POST'],'/ventas_g','GraficasController@VentasG');
      Route::post('/ventas_gyear','GraficasController@VentasGYear');

      Route::match(['GET','POST'],'/citas_g','GraficasController@CitasG');
      Route::post('/citas_gyear','GraficasController@CitasGYear');

      Route::match(['GET','POST'],'/editar_datos','ConfigController@EditarDatos');

      //Apunta a registercontroller a la funcion de registro de gerentes Y REGRESO DE VISTAS
      Route::match(["GET","POST"],'/registrar_gerente','RegisterController@RegistroGerente');
      Route::match(["GET","POST"],'/registrar_secretaria','RegisterController@RegistroSecretaria');

      //Apuntan a editar para recuperar listas para el gerente
      Route::match(["GET","POST"],'/editar_gerente','EditarController@EditarGerente');
      Route::match(["GET","POST"],'/editar_secretaria','EditarController@EditarSecretaria');

      //Pedir datos para registrar
      Route::post("/pedir_gerente",'EditarController@PedirGerente');
      Route::post("/pedir_secretaria",'EditarController@PedirSecre');

      //Eliminar datos gerente
      Route::post("/eliminar_gerente",'EditarController@EliminarGerente');
      Route::post("/eliminar_secretaria",'EditarController@EliminarSecretaria');
    });

    //Rutas de la secretaria iran aqui dentro de este grupo:
    Route::group(['middleware'=>'msec'],function(){
      Route::match(["GET","POST"],'/editar_notario','EditarController@EditarNotario');
      Route::post("/pedir_notario",'EditarController@PedirNotario');
      Route::post("/eliminar_notario",'EditarController@EliminarNotario');

      Route::post("/venta_concretada","VentasController@VentaConcretada");
      Route::post("/notario_venta","VentasController@NotarioVenta");
      Route::post("/registra_notario","NotarioController@RegistrarNotario");
      Route::post("/pedir_notarios_vista","NotarioController@PedirVistaNotarios");

      Route::post("/monto_cubierto_v","VentasController@MontoCubierto");
      Route::post("/cancelar_venta","VentasController@CancelarVenta");
      Route::post("/subir_docs","VentasController@SubirDocs");
      Route::post("/editar_docs","VentasController@EditarDocs");
      Route::post("/check_status","VentasController@CheckStatus");

      Route::match(["GET","POST"],'/editar_cliente','EditarController@EditarCliente');
      Route::post("/pedir_cliente",'EditarController@PedirCliente');
      Route::post("/eliminar_cliente",'EditarController@EliminarCliente');

      Route::match(["GET","POST"],'/registrar_venta','VentasController@RegistrarVenta');
      Route::post('/registro_venta_def','VentasController@RegistroVentaDefinitivo');

      Route::post("/pedir_ventas","CitasController@PedirVentas");
      Route::post("/pedir_clientes","CitasController@PedirVistaClientes");

      Route::post("/registrar_cliente","ClientesController@RegistrarCliente");

      Route::match(["GET","POST"],'/registrar_cita','CitasController@RegistrarCita');
      Route::post("/vendedores_disponibles","CitasController@VendedoresDisponibles");
      Route::post("/casas_disponibles","CitasController@CasasDisponibles");

      Route::match(["GET","POST"],'/registrar_casa','CasasController@RegistrarCasa');

      Route::post("/eliminar_foto","CasasController@EliminarFoto");
      Route::post("/agregar_fotos","CasasController@AgregarFotos");

      Route::get("/editar_casa/{id}","CasasController@EditarCasaId");
      Route::match(["GET","POST"],"/editar_casa","CasasController@EditarCasa");
      Route::post("/evaluar_precio","CasasController@EvaluarPrecio");

      Route::get("/citas_registradas","CitasController@CitasRegistradas");
      Route::get("/ventas_registradas","VentasController@VentasRegistradas");
    });

    //Rutas del vendedor iran aqui dentro de este grupo:
    Route::group(['middleware'=>'mven'],function(){
      Route::get("/ventas_tramite","VendedorController@VentasTramite");
      Route::get("/historial_ventas","VendedorController@HistorialVentas");

      Route::get("/citas_pendientes","VendedorController@CitasPendientes");
      Route::get("/historial_citas","VendedorController@HistorialCitas");
    });

    Route::post("/cancelar_cita","VendedorController@CancelarCita");
    Route::post("/cita_exitosa","VendedorController@CitaExitosa");
});

Route::group(['middleware'=>'authoppo'],function(){
  Route::get('/login', function(){
    return view('Login.newlogin');
  });
  Route::post('/','LoginController@primeraPeticion');
});

Route::get('/logout','LoginController@Logout');

Route::get("/generate",function(){
  if (\App\User::get()->count()==0) {
    $user= new \App\User();
    $user->email="a@a.a";
    $user->password=\Hash::make("2310");
    $user->tipo_usuario=1;
    $user->movil=true;
    $user->save();

    $gte=new \App\Gerente();
    $gte->nombre="Gerente";
    $gte->ap_paterno="Super";
    $gte->ap_materno="Hardcore";
    $gte->direccion="calle Hardcore no se #4";
    $gte->rfc="123499989999";
    $gte->fecha_nacimiento="1997/01/01";
    $gte->usuario_id=$user->id;
    $gte->save();
  }
  return redirect("/");
});
