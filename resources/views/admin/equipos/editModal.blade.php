<!-- Modal -->
<div class="modal fade" id="equipoUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="equipoUpdateForm">
            {{ method_field('put') }}
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar equipo</h4>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="equipo">Nuevo equipo:</label>
                      <div class="bloque" style="height: 25px">  
                        <input type="text" name="equipo" placeholder="Ingrese el equipo" class="form-control" value="{{old('equipo')}}">
                        {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                      </div>
                        <!-- Description -->
                        <br>
                        <label for="descripcion" style='margin-top: 10px'>Descripción:</label>
                        <input type="text" name="descripcion" placeholder="Ingrese la descripción" value="{{old('descripcion')}}" class="form-control">
                        <br>
                       
                        <!-- Ubicaciones -->
                        <label for="locations">Ubicación:</label>
                        <select name="locations" class="form-control form-control-lg" id="locations"> 
                        </select>
                    </div>

                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="equipoUpdateToken" value="{{ csrf_token() }}">
                  <input type="hidden" id="id" name="id">
                
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonEquipoModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
</div>