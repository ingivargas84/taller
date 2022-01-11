<div class="modal fade" id="tipoTrabajoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'TipoTrabajoForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Tipo de Trabajo</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="nombre">Tipo de Trabajo:</label>
                  <div class="bloque" style="height: 35px">
                    <input type="text" name="nombre" placeholder="Ingrese el tipo de trabajo" class="form-control" value="{{old('nombre')}}">
                    {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                  </div>
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tipoTrabajoToken" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonTipoTrabajoModal" >Agregar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>