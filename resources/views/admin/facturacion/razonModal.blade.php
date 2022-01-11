<div class="modal fade" id="razonModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'razonForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Anular Factura</h4>
            </div>
            <div class="modal-body">

            <div class="row">
            <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                    <!-- Razon -->
                    <label for="razon">Razón de la Anulación:</label>
                    <input type="text" name="razon" placeholder="Ingrese el por qué se anula la factura" class="form-control">
                    <br>
                  </div>
                </div>
              <input type="hidden" name="_token" id="razonToken" value="{{ csrf_token() }}">
              <input type="hidden" name="idFactura" id="idFactura">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonRazonModal" >Agregar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>