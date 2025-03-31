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
        <div class="row">
            <div class="mt-4 w-50" style="margin: auto;">
                <form id="salaForm" action="{{ route('reservas.store') }}" method="POST">
                    @csrf
                  
                    <div class="border">
                        
                        <div class="form-group">
                            <label for="tipo_evento">Tipo de evento</label>
                            <input type="text" class="form-control @error('tipo_evento') is-invalid @enderror"
                                id="tipo_evento" name="tipo_evento" value="{{ old('tipo_evento') }}" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                                id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" class="form-control @error('ubicacion') is-invalid @enderror"
                                id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" required>
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
                                    name="day" value="{{ old('day') }}" required>
                            </div>
                            
                            <div class="form-group mt-2 col-md-6">
                                <label for="hora_inicio">Hora</label>
                                <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror"
                                    id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio') }}" required>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Abrir Modal de Reserva
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="usuariosReunion" id="usuariosReunionInput"> 
                    <div class="mt-4 row mt-2">
                        <div class="col-md-6">
                            <a class="btn btn-danger" href="#"
                                onclick="window.history.back(); return false;">Volver</a>
                        </div>
                        <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                            <button type="submit" id="confirmEdit" class="btn btn-primary" >Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Usuarios agregados</h2>
                <div id="usuariosAgregadosLista">


                </div>
            </div>
        </div>
    </div>
    @include('reservas.modal')
    <script>
        $(document).ready(function() {
            $('.select2-salas').select2({
                placeholder: '--- Seleccionar ---',
                allowClear: true
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const agregarUsuariosBtn = document.getElementById('agregarUsuariosReunion');
            const usuariosAgregadosLista = document.getElementById('usuariosAgregadosLista');
            let usuariosReunion = JSON.parse(localStorage.getItem('usuariosReunion')) || [];

            function usuarioCard(data, index) {
                return `<div class=" row  mt-3 ">
                        <div class="col-md-2">
                            <img src="" alt="" class="border rounded-circle" width="70px" height="70px">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title">${data.nombre} ${data.apellido}</h5>
                                <button class="btn btn-danger btn-sm eliminar-usuario mt-2" data-index="${index}">Eliminar</button>
                            </div>
                        </div>
                    </div>`;
            }

            function actualizarListaUsuarios() {
                usuariosAgregadosLista.innerHTML = '';
                usuariosReunion.forEach((usuario, index) => {
                    const usuarioDiv = document.createElement('div');
                    usuarioDiv.innerHTML = usuarioCard(usuario, index);
                    usuariosAgregadosLista.appendChild(usuarioDiv);
                });

                // Agregar evento de eliminación a los botones
                document.querySelectorAll('.eliminar-usuario').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        usuariosReunion.splice(index, 1);
                        localStorage.setItem('usuariosReunion', JSON.stringify(usuariosReunion));
                        actualizarListaUsuarios();
                    });
                });
            }

            actualizarListaUsuarios();
           
            // Marcar checkboxes si los usuarios ya están en localStorage
            function marcarCheckboxes() {
                document.querySelectorAll('.usuario-checkbox').forEach(checkbox => {
                    const usuarioId = checkbox.value;
                    if (usuariosReunion.some(usuario => usuario.id === usuarioId)) {
                        checkbox.checked = true;
                    }
                });
            }

            // Mostrar usuarios en el modal al abrirlo
            $('#exampleModal').on('shown.bs.modal', function() {
                marcarCheckboxes();
            });

            agregarUsuariosBtn.addEventListener('click', function() {
                const checkboxesSeleccionados = document.querySelectorAll('.usuario-checkbox:checked');
                usuariosReunion = []; // Reiniciar el array usuariosReunion

                checkboxesSeleccionados.forEach(checkbox => {
                    const usuarioId = checkbox.value;
                    const nombre = checkbox.dataset.nombre;
                    const apellido = checkbox.dataset.apellido;

                    usuariosReunion.push({
                        id: usuarioId,
                        nombre: nombre,
                        apellido: apellido
                    });
                });

                localStorage.setItem('usuariosReunion', JSON.stringify(usuariosReunion));
                actualizarListaUsuarios();

                document.getElementById('salaForm').addEventListener('submit', function() {
                    document.getElementById('usuariosReunionInput').value = localStorage.getItem(
                        'usuariosReunion');
                });
                cerrarModal.click(); // Cerrar el modal
            });
        });
    </script>
@endsection
