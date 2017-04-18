@if(App\Vendedor::get()->count() > 0)
<table class="display table table-condensed" width="100%">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Direccion</th>
      <th>RFC</th>
      <th>CURP</th>
      <th>Fecha nac</th>
      <th>Contacto</th>
      <th>Config</th>
    </tr>
  </thead>
  <tbody>
    @foreach(App\Vendedor::get() as $i => $vendedor)
    <tr>
      <td style="vertical-align:middle;">{{$vendedor->nombre}}</td>
      <td style="vertical-align:middle;">{{$vendedor->ap_paterno." ".$vendedor->ap_materno}}</td>
      <td style="vertical-align:middle;">{{$vendedor->direccion}}</td>
      <td style="vertical-align:middle;">{{$vendedor->rfc}}</td>
      <td style="vertical-align:middle;">{{$vendedor->curp}}</td>
      <td style="vertical-align:middle;">{{$vendedor->fecha_nacimiento}}</td>
      <td style="vertical-align:middle;">{{$vendedor->contacto}}</td>
      <td style="vertical-align:middle;">
      <button title="Editar!" data-seller-id="{{$vendedor->id}}" style="border-radius:0;" type="button" class="btn btn-sm btn-default btnEdit" data-toggle="modal" data-target="#sellerModal"><span class="glyphicon glyphicon-pencil"><br></span></button>
        <br>
        <button title="Eliminar!" data-seller-id="{{$vendedor->id}}" type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-danger btnDelete" style="border-radius:0;"><span class="glyphicon glyphicon-trash"></span><br>
        </button>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@else
<h3 align="center"><i>No hay registros que mostrar.</i></h3>
@endif
