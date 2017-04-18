@extends('menu_layouts.menu_base')

@section("the_css")
<link rel="stylesheet" href="public/js/jquery-ui-1.12.1/jquery-ui.css">
@endsection

@section('menus')
  @include('gerente.menusgerente')
@endsection

@section('content')
  <h2>Registrar gerente</h2>
  <hr>
  @include('gerente.formulario')
@endsection

@section("the_js")
<script src="public/js/jquery-ui-1.12.1/jquery-ui.js"></script>
<script>
  $(function(){
    $("#datePickerUI").datepicker({
      dateFormat: "yy-mm-dd",
      maxDate:"{{Carbon\Carbon::now('America/Monterrey')->subYears(20)->toDateString()}}",
      dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
      dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
      monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
      monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
    })
  })
</script>
@endsection
