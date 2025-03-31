@extends('layout.app')
@section('content')
    <div>
        <h2 class="text-center">
            Listado de Usuarios
        </h2>
        <div class="mt-4 border">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>CORREO ELECTRONICO</th>
                        <th>UNIDAD</th>
                        <th>EDITAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->last_name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->unidad }}</td>
                            <td><a class="btn btn-danger" href="{{ route('users.edit', $usuario->id) }}">Editar</a></td>
                            <td><a class="btn btn-danger delete-button" data-id="{{ $usuario->id }}" href="#">Eliminar</a></td>
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
                const url = '{{ route('users.eliminar' , '*') }}'.replace('*', id);
                console.log(url);
                Swal.fire({
                    title: '¿Estás seguro de eliminar este usuario?',
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
                                    'El usuario ha sido eliminado.',
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
