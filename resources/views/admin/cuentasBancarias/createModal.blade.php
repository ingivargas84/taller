<div class="modal fade" id="cuentaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'cuentaForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Cuenta Bancaria</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                    <label for="nombre">Nombre de la cuenta:</label>
                    <div class="bloque" style="height: 35px">
                      <input type="text" name="nombre"  id="nombre" placeholder="Ingrese el nombre" class="form-control">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>
                    <br>
                    <label for="nombre">No. de cuenta:</label>
                    <div class="bloque" style="height: 40px">
                      <input type="text" name="no_cuenta"  id="no_cuenta" placeholder="Ingrese el no. de cuenta" class="form-control">
                      {!! $errors->first('no_cuenta', '<span class="help-block">:message</span>') !!}
                    </div>
                    <br>
                    <!-- Banco -->
                    <label for="banco_id">Institución financiera:</label>
                    <select name="banco_id" class="form-control form-control-lg" id="banco_id"></select>
                    <br>
                    <!-- Tipo de Cuenta -->
                    <label for="tipo_cuenta">Tipo de cuenta:</label>
                    <select name="tipo_cuenta" class="form-control form-control-lg" id="tipo_cuenta"></select>
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="cuentaToken" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonCuentaModal" >Agregar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>