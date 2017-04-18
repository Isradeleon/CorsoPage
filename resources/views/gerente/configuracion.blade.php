@extends('menu_layouts.menu_base')

@section('menus')
  @include('gerente.menusgerente')
@endsection

@section('content')
<h2>Página de inicio.</h2>
<hr>
<h3>Información de contacto:</h3>
@if(Session::has("msg"))
  <h4 style="color:#5CB85C"><b>{{Session::get("msg")}}</b></h4>
@endif
<br>
<div class="col-md-6 col-xs-12">
  <form class="form" method="post" action="/editar_datos">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="form-group">
      <label for="correo" class="control-label">Correo:</label>
      <input value="{{$dato ? $dato->correo : '' }}" type="text" class="form-control" name="correo">
    </div>
    <div class="form-group">
      <label for="telefono" class="control-label">Telefono:</label>
      <input value="{{$dato ? $dato->telefono : '' }}" type="text" class="form-control" name="telefono">
    </div>
    <div class="form-group">
      <label for="facebook" class="control-label">Facebook de contacto:</label>
      <input value="{{$dato ? $dato->facebook : '' }}" type="text" class="form-control" name="facebook">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-block btn-info"><i class="fa fa-floppy-o"></i> Guardar</button>
    </div>
  </form>
</div>
@endsection
