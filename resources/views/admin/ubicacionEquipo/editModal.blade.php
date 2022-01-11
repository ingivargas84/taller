<!-- Modal -->
<div class="modal fade"  id="ubicacionEquipoUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="ubicacionEquipoUpdateForm">
            {{ method_field('put') }}
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar ubicación de equipo</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre">Nueva ubicación de equipo:</label>
                      <div class="bloque" style="height: 35px">
                        <input type="text" name="nombre" placeholder="Ingrese la ubicación" class="form-control" value="{{old('nombre')}}">
                        {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                      </div>
                    </div>

                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="ubicacionEquipoEditToken" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonUbicacionEquipoModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
</div>