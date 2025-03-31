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
            Registro de Salas
        </h2>
        <div class="mt-4 w-50  " style="margin: auto;">
            <form id="salaForm" action="{{ route('salas.create') }}" method="POST">
                @csrf
                <div class="border ">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="name" name="nombre" value="{{ old('nombre') }}" required>
                       
                    </div>
                    <div class="form-group mt-2">
                        <label for="last_name">Dirección</label>
                        <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" id="last_name" name="ubicacion" value="{{ old('ubicacion') }}" required>
                      
                    </div>
                    <div class="form-group mt-2">
                        <label for="email">Capacidad</label>
                        <input type="number" class="form-control @error('capacidad') is-invalid @enderror" id="email" name="capacidad" value="{{ old('capacidad') }}" required>
                      
                    </div>
                    <div class="form-group mt-2">
                        <label for="unidad">Estado</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="unidad" name="status">
                            <option value="habilitada" {{ old('status') == 'habilitada' ? 'selected' : '' }}>Habilitada</option>
                            <option value="inhabilitada" {{ old('status') == 'inhabilitada' ? 'selected' : '' }}>Inhabilitada</option>
                        </select>
                      
                    </div>
                    <div class="form-group mt-2">
                        <label for="unidad">Dia de la reunion</label>
                        <input type="date" class="form-control @error('day') is-invalid @enderror" id="unidad" name="day" value="{{ old('day') }}" required>
                       
                    </div>
                    <div class="form-group mt-2">
                        <label for="unidad">Hora de inicio</label>
                        <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" id="unidad" name="hora_inicio" value="{{ old('hora_inicio') }}" required>
                     
                    </div>
                    <div class="form-group mt-2">
                        <label for="unidad">Hora de fin</label>
                        <input type="time" class="form-control @error('hora_fin') is-invalid @enderror" id="unidad" name="hora_fin" value="{{ old('hora_fin') }}" required>
                       
                    </div>
                </div>
                <div class="mt-4 row mt-2">
                    <div class="col-md-6">
                        <a class="btn btn-danger" href="#" onclick="window.history.back(); return false;">Volver</a>
                    </div>
                    <div class="col-md-6 " style="display: flex; justify-content: flex-end;">
                        <button type="button" id="confirmEdit" class="btn btn-primary" >Guardar</button>
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
                        // Envía el formulario a través de AJAX
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
                            Swal.fire('Éxito', 'Sala creada correctamente.', 'success')
                            .then(() => {
                                window.location.href = "{{ route('salas.index') }}";
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