@extends('menu_layouts.menu_base')

@section('menus')
  @include('gerente.menusgerente')
@endsection

@section('content')
<br>
<h2>Bienvenid@ al sistema.</h2>
<h3>
  <b>{{Auth::user()->tipo_usuario==1 ? "Gerente" : (Auth::user()->tipo_usuario==2 ? "Secretari@" : "Vendedor")}}:</b>
  {{Auth::user()->tipo_usuario==1 ? Auth::user()->gerente->nombre." ".Auth::user()->gerente->ap_paterno." ".Auth::user()->gerente->ap_materno :
  (Auth::user()->tipo_usuario==2 ? Auth::user()->secretaria->nombre." ".Auth::user()->secretaria->ap_paterno." ".Auth::user()->secretaria->ap_materno :
  Auth::user()->vendedor->nombre." ".Auth::user()->vendedor->ap_paterno." ".Auth::user()->vendedor->ap_materno)}}.
</h3>
<hr>
<br>
<h4><b>Grupo Corso.</b></h4>
<blockquote><i>"Comprometidos con ofrecer las mejores propiedades a los mejores precios."</i></blockquote>
@endsection
