<!-- Modal -->
<div class="modal fade" id="cuentaUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="cuentaUpdateForm">
            {{ method_field('put') }}
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar cuenta</h4>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre_edit">Nuevo nombre de cuenta:</label>
                      <div class="bloque" style="height: 35px">  
                        <input type="text" name="nombre_edit"  id="nombre_edit" placeholder="Ingrese el nombre" value="{{ old('nombre') }}" class="form-control">                        
                        {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                      </div>
                        <br>
                        <label for="no_cuenta_edit">No. de cuenta:</label>
                        <div class="bloque" style="height: 40px">
                          <input type="text" name="no_cuenta_edit"  id="no_cuenta_edit" placeholder="Ingrese el no. de cuenta" value="{{ old('no_cuenta') }}" class="form-control">
                          {!! $errors->first('no_cuenta', '<span class="help-block">:message</span>') !!}
                        </div>
                        <br>
                        <!-- Banco -->
                         <label for="banco_id_edit">Banco:</label>
                          <select name="banco_id_edit" class="form-control form-control-lg" id="banco_id_edit"></select>
                        <br>
                        <!-- Ubicaciones -->
                    <!-- Tipo de Cuenta -->
                    <label for="tipo_cuenta_edit">Tipo de cuenta:</label>
                    <select name="tipo_cuenta_edit" class="form-control form-control-lg" id="tipo_cuenta_edit"></select>
                    </div>

                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="cuentaUpdateToken" value="{{ csrf_token() }}">
                  <input type="hidden" id="id" name="id">
                
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonCuentaModalUpdate">Actualizar</button>
                </div>
              </div>
            </div>
        </form>
</div>