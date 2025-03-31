@extends('layout.app')
@section('content')
    <div class="" style=" ">

        @if (session()->has('message'))
            <h2 class="alert alert-success" role="alert">
                {{ session('message') }}
            </h2>
        @endif
        @if (session()->has('danger'))
            <h2 class="alert alert-danger" role="alert">
                {{ session('danger') }}
            </h2>
        @endif
        <h2 class="text-center">
            Editar Usuario
        </h2>
        <div class="mt-4 w-50  " style="margin: auto;">
            <form action="{{ route('users.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Asegúrate de usar el método PUT para la actualización --}}
                <div class="border ">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $usuario->name }}" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="last_name">Apellido</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="{{ $usuario->last_name }}" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $usuario->email }}" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="unidad">Unidad</label>
                        <input type="text" class="form-control" id="unidad" name="unidad"
                            value="{{ $usuario->unidad }}" required>
                    </div>
                </div>
                <div class="mt-4 row mt-2">
                    <div class="col-md-6">
                        <a class="btn btn-danger" href="#" onclick="window.history.back(); return false;">Volver</a>
                    </div>
                    <div class="col-md-6 " style="display: flex; justify-content: flex-end;">
                        <button type="button" class="btn btn-primary" id="confirmEdit">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('confirmEdit').addEventListener('click', function() {
                Swal.fire({
                    title: '¿Estás seguro ejecutar estos cambios?',
                    text: '¿Deseas guardar los cambios?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Envía el formulario si el usuario confirma
                        document.querySelector('form').submit();
                    }
                });
            });
        });
    </script>
@endsection
