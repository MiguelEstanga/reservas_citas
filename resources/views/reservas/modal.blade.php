<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Seleccionar Invitados</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="row">
                  @foreach ($data['usuarios'] as $usuario)
                      <div class="col-md-4">
                          <div class="form-check">
                              <input class="form-check-input usuario-checkbox" type="checkbox"
                                  value="{{ $usuario->id }}"
                                  data-nombre="{{ $usuario->name }}"
                                  data-apellido="{{ $usuario->last_name }}"
                                  id="usuarioCheckbox{{ $usuario->id }}">
                              <label class="form-check-label" for="usuarioCheckbox{{ $usuario->id }}">
                                  {{ $usuario->name }} {{ $usuario->last_name }}
                              </label>
                          </div>
                      </div>
                  @endforeach
              </div>
              <button id="agregarUsuariosReunion" class="btn btn-success mt-3">Agregar Usuarios a Reunión</button>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cerrarModal">Cerrar</button>
          </div>
      </div>
  </div>
</div>