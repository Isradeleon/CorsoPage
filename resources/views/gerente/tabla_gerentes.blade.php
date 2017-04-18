@if(App\Gerente::where("id","!=",Auth::user()->gerente->id)->count() > 0)
<table class="display table table-condensed" width="100%">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Direccion</th>
      <th>RFC</th>
      <th>Fecha nac</th>
      <th>Config</th>
    </tr>
  </thead>
  <tbody>
    @foreach(App\Gerente::where("id","!=",Auth::user()->gerente->id)->get() as $i => $geren)
    <tr>
      <td style="vertical-align:middle;">{{$geren->nombre}}</td>
      <td style="vertical-align:middle;">{{$geren->ap_paterno." ".$geren->ap_materno}}</td>
      <td style="vertical-align:middle;">{{$geren->direccion}}</td>
      <td style="vertical-align:middle;">{{$geren->rfc}}</td>
      <td style="vertical-align:middle;">{{$geren->fecha_nacimiento}}</td>
      <td style="vertical-align:middle;">
      <button title="Editar!" data-id="{{$geren->id}}" style="border-radius:0;" type="button" class="btn btn-sm btn-default btnEdit" data-toggle="modal" data-target="#firstModal"><span class="glyphicon glyphicon-pencil"><br></span></button>
        <br>
        <button title="Eliminar!" data-id="{{$geren->id}}" type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-danger btnDelete" style="border-radius:0;"><span class="glyphicon glyphicon-trash"></span><br>
        </button>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@else
<h3 align="center"><i>No hay registros que mostrar.</i></h3>
@endif
