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
            Editar Sala
        </h2>
        <div class="mt-4 w-50  " style="margin: auto;">
            <form id="salaForm" action="{{ route('salas.update', $sala->id_sala) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="border ">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="nombre" value="{{ $sala->nombre }}"
                            required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="last_name">Dirección</label>
                        <input type="text" class="form-control" id="last_name" name="ubicacion"
                            value="{{ $sala->ubicacion }}" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="email">Capacidad</label>
                        <input type="number" class="form-control" id="email" name="capacidad"
                            value="{{ $sala->capacidad }}" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="unidad">Estado</label>
                        <select name="status" class="form-control" id="unidad">
                            <option value="habilitada" {{ $sala->status == 'habilitada' ? 'selected' : '' }}>Habilitada
                            </option>
                            <option value="inhabilitada" {{ $sala->status == 'inhabilitada' ? 'selected' : '' }}>
                                Inhabilitada</option>
                        </select>
                       
                    </div>
                    <div class="form-group mt-2">
                        <label for="unidad">Dia de la reunion</label>
                        <input type="date" class="form-control" id="unidad" name="day" value="{{ $sala->day }}"
                            required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="unidad">Hora de inicio</label>
                        <input type="time" class="form-control" id="unidad" name="hora_inicio"
                            value="{{ $sala->hora_inicio }}" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="unidad">Hora de fin</label>
                        <input type="time" class="form-control" id="unidad" name="hora_fin"
                            value="{{ $sala->hora_fin }}" required>
                    </div>
                </div>
                <div class="mt-4 row mt-2">
                    <div class="col-md-6">
                        <a class="btn btn-danger" href="#" onclick="window.history.back(); return false;">Volver</a>
                    </div>
                    <div class="col-md-6 " style="display: flex; justify-content: flex-end;">
                        <button type="button" class="btn btn-danger" id="confirmEdit">Guardar</button>
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
                        const form = document.getElementById('salaForm');
                        const formData = new FormData(form);

                        fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(data => {
                                        throw new Error(JSON.stringify(data));
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire('Éxito', data.message, 'success')
                                    .then(() => {
                                        window.location.href =
                                        "{{ route('salas.index') }}";
                                    });
                            })
                            .catch(error => {
                                const errors = JSON.parse(error.message).errors;
                                let errorMessage = '';
                                for (const field in errors) {
                                    errorMessage += `${errors[field].join('<br>')}<br>`;
                                }
                                Swal.fire('Error', errorMessage, 'error').html();
                            });
                    }
                });
            });
        });
    </script>
@endsection
