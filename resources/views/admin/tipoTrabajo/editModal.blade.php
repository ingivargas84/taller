<!-- Modal -->
<div class="modal fade" id="tipoTrabajoUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="tipoTrabajoUpdateForm">
            {{ method_field('put') }}
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar tipo de Trabajo</h4>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre">Nuevo tipo de Trabajo:</label>
                      <div class="bloque" style="height: 35px">
                        <input type="text" name="nombre" placeholder="Ingrese tipo de Trabajo" class="form-control" value="{{old('nombre')}}">
                        {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                      </div>
                    </div>

                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="tipoTrabajoEditToken" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonTipoTrabajoModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
</div>