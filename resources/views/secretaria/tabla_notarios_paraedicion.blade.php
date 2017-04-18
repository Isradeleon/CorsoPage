@if(App\Notario::get()->count() > 0)
<table class="display table table-condensed" width="100%">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Cedula</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach(App\Notario::get() as $i => $not)
    <tr>
      <td style="vertical-align:middle;">{{$not->nombre}}</td>
      <td style="vertical-align:middle;">{{$not->ap_paterno." ".$not->ap_materno}}</td>
      <td style="vertical-align:middle;">{{$not->cedula}}</td>
      <td style="vertical-align:middle;"><button data-id="{{$not->id}}" style="border-radius:0;" type="button" class="btn btn-sm btn-default btnEdit" data-toggle="modal" data-target="#firstModal"><span class="glyphicon glyphicon-pencil"><br></span></button>
        <br>
        <button data-id="{{$not->id}}" type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-danger btnDelete" style="border-radius:0;"><span class="glyphicon glyphicon-trash"></span><br>
        </button>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@else
<h3 align="center"><i>No hay registros que mostrar.</i></h3>
@endif
