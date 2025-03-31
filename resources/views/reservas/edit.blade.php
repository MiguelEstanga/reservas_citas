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
            Registro de reservas
        </h2>
        <div class="mt-4 w-50" style="margin: auto;">
            <form id="reservaForm" action="{{ route('reservas.update', $reserva->id_reserva) }}" method="POST">
                @csrf
                @method('PUT') 
                <div class="border">
                    <div class="form-group">
                        <label for="tipo_evento">Tipo de evento</label>
                        <input value="{{ $reserva->tipo_evento ?? '' }}" type="text"
                            class="form-control @error('tipo_evento') is-invalid @enderror" id="tipo_evento"
                            name="tipo_evento" value="{{ old('tipo_evento') }}" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="descripcion">Descripción</label>
                        <input value="{{ $reserva->descripcion ?? '' }}" type="text"
                            class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                            name="descripcion" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="ubicacion">Ubicación</label>
                        <input value="{{ $reserva->ubicacion ?? '' }}" type="text"
                            class="form-control @error('ubicacion') is-invalid @enderror" id="ubicacion" name="ubicacion"
                            required>
                    </div>
                    <div class="form-group mt-2">
                        <div>
                            <label for="sala">Sala</label>
                        </div>
                        <select class="form-control select2-salas @error('id_sala') is-invalid @enderror" id="sala"
                            name="id_sala" required>
                            <option value="">--- Seleccionar ---</option>
                            @foreach ($data['salas'] as $sala)
                                <option value="{{ $sala->id_sala }}"
                                    {{ $reserva->id_sala == $sala->id_sala ? 'selected' : '' }}>
                                    {{ old('id_sala') == $sala->id_sala ? 'selected' : '' }}>
                                    {{ $sala->nombre }} ({{ $sala->hora_inicio }} - {{ $sala->hora_fin }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group mt-2 col-md-6">
                            <label for="day">Fecha</label>
                            <input type="date" class="form-control @error('day') is-invalid @enderror" id="day"
                                name="day" value="{{ explode(' ', $reserva->horario)[0] ?? '' }}" required>
                        </div>
                        <div class="form-group mt-2 col-md-6">
                            <label for="hora_inicio">Hora</label>
                            <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror"
                                id="hora_inicio" name="hora_inicio" value="{{ explode(' ', $reserva->horario)[1] ?? '' }}"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mt-2">
                            <div>
                                <label for="id_usuario">Invitados</label>
                            </div>
                            <select name="id_usuario" id="id_usuario"
                                class="form-control select2-usuarios @error('id_usuario') is-invalid @enderror" required>
                                <option value="">--- Seleccionar ---</option>
                                @foreach ($data['usuarios'] as $usuario)
                                    <option value="{{ $usuario->id }}"
                                        {{ $reserva->id_usuario == $usuario->id ? 'selected' : '' }}>
                                        {{ old('id') == $usuario->id_usuario ? 'Seleccionado->' : '' }}
                                        {{ $usuario->name }} {{ $usuario->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-4 row mt-2">
                    <div class="col-md-6">
                        <a class="btn btn-danger" href="#" onclick="window.history.back(); return false;">Volver</a>
                    </div>
                    <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                        <button type="button" id="confirmEdit" class="btn btn-danger">Actualizar</button>
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
                        const form = document.getElementById('reservaForm');
                        const formData = new FormData(form);

                        fetch(form.action, {
                                method: 'put',
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
