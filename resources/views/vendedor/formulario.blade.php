<div class="row">
  <form action="/registrar_vendedor" method="post">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="col-md-4">
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input maxLength="40" class="form-control" type="text" name="nombre" value="{{old('nombre')}}">
      </div>
      <div class="form-group">
        <label for="ap_paterno">Apellido paterno:</label>
        <input maxLength="40" class="form-control" type="text" name="ap_paterno" value="{{old('ap_paterno')}}">
      </div>
      <div class="form-group">
        <label for="ap_materno">Apellido materno:</label>
        <input maxLength="40" class="form-control" type="text" name="ap_materno" value="{{old('ap_materno')}}">
      </div>
      <div class="form-group">
        <label for="contacto">Contacto:</label>
        <input maxLength="40" class="form-control" type="text" name="contacto" value="{{old('contacto')}}">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input maxLength="40" class="form-control" type="email" name="email" value="{{old('email')}}">
      </div>
      <div class="form-group">
        <label for="fecha_nac">Fecha de nacimiento</label>
        <input onkeydown="return false;" max="{{Carbon\Carbon::now('America/Monterrey')->subYears(20)->toDateString()}}" id="datePickerUI" class="form-control" type="date" name="fecha_nac" value="{{old('fecha_nac')}}">
      </div>
    </div>

    <div class="col-md-5 col-md-offset-1">
      <div class="form-group">
        <label for="direccion">Direccion domicilio:</label>
        <input maxLength="90" class="form-control" type="text" name="direccion" value="{{old('direccion')}}">
      </div>
      <div class="form-group">
        <label for="rfc">RFC:</label>
        <input maxLength="13" class="form-control" type="text" name="rfc" value="{{old('rfc')}}">
      </div>
      <div class="form-group">
        <label for="curp">CURP:</label>
        <input maxLength="18" class="form-control" type="text" name="curp" value="{{old('curp')}}">
      </div>
      <br>
      <div class="form-group">
        <button class="btn btn-info btn-block" type="submit" name="button"><b>REGISTRAR</b></button>
      </div>
      @if(Session::has('error'))
        <div style="background-color:#e33;" class="thumbnail">
          @foreach(Session::get('error') as $m)
            <h5 style="color:white;"align="center">{{$m}}</h5>
          @endforeach
        </div>
      @elseif(Session::has('usuario_reg'))
        <div class="thumbnail">
          <h5 align="center">Se han enviado los datos de acceso a <b>{{Session::get('usuario_reg')}}</b>!</h5>
        </div>
      @endif
    </div>
  </form>
</div>
<br>
