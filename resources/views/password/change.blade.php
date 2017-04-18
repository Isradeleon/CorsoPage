@extends('menu_layouts.menu_base')

@section('menus')
  @if(Auth::user()->tipo_usuario==1)
    @include('gerente.menusgerente')
  @elseif(Auth::user()->tipo_usuario==2)
    @include('secretaria.menussecre')
  @else
    @include('vendedor.menusvendedor')
  @endif
@endsection

@section('content')
<div class="col-lg-6">
  <div style="padding:10px;">
    <h3>Cambio de contraseña</h3>
    @if(Session::has("success"))
    <h4 style="color:#5CB85C;"><b>{{Session::get("success")}}</b></h4>
    @endif
    <hr>
    <form class="" action="/cambiar_pass" method="post">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="form-group">
        <label for="">Contraseña nueva:</label>
        <input maxLength="60" class="form-control" type="password" name="pass" value="">
      </div>
      @if(Session::has("msgs") && Session::get("msgs")->has("pass"))
      <h5 align="center" style="color:#D9534F;">{{Session::get("msgs")->get("pass")[0]}}</h5>
      @endif
      <div class="form-group">
        <label for="">Confirmar contraseña:</label>
        <input maxLength="60" class="form-control" type="password" name="pass2" value="">
      </div>
      @if(Session::has("msgs") && Session::get("msgs")->has("pass2"))
      <h5 align="center" style="color:#D9534F;">{{Session::get("msgs")->get("pass2")[0]}}</h5>
      @endif
      <br>
      <div class="form-group">
        <button class="btn btn-success btn-block" type="submit" name="button">Cambiar contraseña</button>
      </div>
    </form>
  </div>
</div>

@endsection
