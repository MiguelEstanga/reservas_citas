@extends('layout.app')
@section('content')
    <div>
        <h2 class="text-center">
            Listado de Reservas
        </h2>
        <a href="{{ route('reservas.create') }}" class="btn btn-danger">Registrar</a>
        <div class="mt-4 border">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITULO</th>
                        <th>UBICACIÓN</th>
                        <th>TIPO DE EVENTO</th>
                        <th>Fecha Y HORA</th>

                        <th>SALA</th> 
                        <th>INVITADOS</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservas as $reserva)
                        <tr>
                            <td>{{ $reserva->id_reserva }}</td>
                            <td>{{ $reserva->titulo }}</td>
                            <td>{{ $reserva->ubicacion }}</td>
                            <td>{{ $reserva->tipo_evento }}</td>
                            <td> {{ $reserva->horario }} </td>
                            <td>{{ $reserva->sala->nombre }} </td>
                            <td>{{ $reserva->invitados[0]->usuario->name ?? '' }}</td>

                            <td><a class="btn btn-danger" href="{{ route('reserva.edit', $reserva->id_reserva) }}">Editar</a></td>
                            <td><a class="btn btn-danger delete-button" data-id="{{ $reserva->id_reserva }}"
                                    href="#">Eliminar</a></td>
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
                const url = '{{ route('reservas.eliminar' , '*') }}'.replace('*', id);
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
