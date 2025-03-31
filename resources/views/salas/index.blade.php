@extends('layout.app')
@section('content')
<div>
  <h2 class="text-center">
      Listado de Salas
  </h2>
  <a href="{{ route('salas.create') }}" class="btn btn-danger ">Crear nueva sala</a><br>
  <div class="mt-4 border">
   
      <table class="table table-bordered table-hover">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>NOMBRE</th>
                  <th>DIRECCIÓN</th>
                  <th>CAPACIDAD</th>
                  <th>ESTADO</th>
                  <th>PROGRAMACIÓN</th>
                  <th>EDITAR</th>
                  <th>ELIMINAR</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($salas as $sala)
                  <tr>
                      <td>{{ $sala->id_sala }}</td>
                      <td>{{ $sala->nombre }}</td>
                      <td>{{ $sala->ubicacion }}</td>
                      <td>{{ $sala->capacidad }}</td>
                      <td>{{ $sala->status }}</td>
                      <td>{{ $sala->hora_inicio }} - {{ $sala->hora_fin }}</td>
                      <td><a class="btn btn-danger" href="{{route('salas.edit', $sala->id_sala)}}">Editar</a></td>
                      <td><a class="btn btn-danger delete-button" data-id="{{ $sala->id_sala }}" href="#">Eliminar</a></td>
                  </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</div>
<script>
  document.querySelectorAll('.delete-button').forEach(button => {
      button.addEventListener('click', function() {
          const id = this.dataset.id;
          const url = '{{ route('salas.eliminar' , '*') }}'.replace('*', id);
          console.log(url);
          Swal.fire({
              title: '¿Estás seguro de eliminar este sala?',
              text: "No podrás revertir esto.",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, eliminarlo!'
          }).then((result) => {
              if (result.isConfirmed) {
                  // Aquí puedes enviar una solicitud AJAX o enviar un formulario para eliminar el registro.
                  // Ejemplo con fetch:
                  fetch(url, {
                      method: 'DELETE',
                      headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}',
                          'Content-Type': 'application/json'
                      }
                  }).then(response => {
                      if (response.ok) {
                          Swal.fire(
                              'Eliminado!',
                              'La sala ha sido eliminada.',
                              'success'
                          ).then(() => {
                              // Recargar la página o actualizar la tabla.
                              location.reload();
                          });
                      } else {
                          Swal.fire(
                              'Error!',
                              'Hubo un problema al eliminar el usuario.',
                              'error'
                          );
                      }
                  });

              }
          })
      });
  });
</script>
@endsection