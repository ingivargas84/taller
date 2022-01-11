<div class="modal fade" id="envioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'envioModalForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Entregar envío</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                       <!-- Description -->
                    <div class="bloque" style="height: 35px">
                    <label for="receptor_modal">Confirma al receptor:</label>
                      <input type="text" name="receptor_modal"  id="receptor_modal" class="form-control">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>
                    <br>
                </div>
              </div>
              
              <input type="hidden" name="_token" id="envioModalToken" value="{{ csrf_token() }}">
              <input type="hidden" name="envioModalId" id="envioModalId">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonEnvioModal" >Actualizar estado</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>