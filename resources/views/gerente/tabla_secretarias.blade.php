@if(App\Secretaria::get()->count() > 0)
<table class="display table table-condensed" width="100%">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Direccion</th>
      <th>RFC</th>
      <th>CURP</th>
      <th>Fecha nac</th>
      <th>Config</th>
    </tr>
  </thead>
  <tbody>
    @foreach(App\Secretaria::get() as $i => $secre)
    <tr>
      <td style="vertical-align:middle;">{{$secre->nombre}}</td>
      <td style="vertical-align:middle;">{{$secre->ap_paterno." ".$secre->ap_materno}}</td>
      <td style="vertical-align:middle;">{{$secre->direccion}}</td>
      <td style="vertical-align:middle;">{{$secre->rfc}}</td>
      <td style="vertical-align:middle;">{{$secre->curp}}</td>
      <td style="vertical-align:middle;">{{$secre->fecha_nacimiento}}</td>
      <td style="vertical-align:middle;">
      <button title="Editar!" data-id="{{$secre->id}}" style="border-radius:0;" type="button" class="btn btn-sm btn-default btnEdit" data-toggle="modal" data-target="#firstModal"><span class="glyphicon glyphicon-pencil"><br></span></button>
        <br>
        <button title="Eliminar!" data-id="{{$secre->id}}" type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-danger btnDelete" style="border-radius:0;"><span class="glyphicon glyphicon-trash"></span><br>
        </button>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@else
<h3 align="center"><i>No hay registros que mostrar.</i></h3>
@endif
