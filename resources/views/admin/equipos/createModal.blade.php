<div class="modal fade" id="equipoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'equipoForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar equipo</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                    <label for="nombre">Equipo:</label>
                    <div class="bloque" style="height: 35px">
                      <input type="text" name="nombre"  id="nombre" placeholder="Ingrese el equipo" class="form-control">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>
                    <br>
                    <!-- Description -->
                    <label for="descripcion">Descripción:</label>
                    <input type="text" name="descripcion" placeholder="Ingrese la descripción" class="form-control">
                    <br>
                    <!-- Description -->
                    <label for="ubicacion">Ubicación:</label>
                    <select name="ubicaciones" class="form-control form-control-lg" id="ubicaciones">
                        
                    </select>
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="equipoToken" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonEquipoModal" >Agregar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>