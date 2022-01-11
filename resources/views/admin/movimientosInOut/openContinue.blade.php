<div class="modal fade" id="modalContinue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'modalOpenContinueForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"><b>Registro de movimiento de caja chica</b></h4>
              <h5 class="modal-title">Saldo actual: {{ $ultimoSaldo }}</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="saldo" value="{{ $ultimoSaldo }}">
                <input type="hidden" name="idCaja" value="{{ $id }}">
              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <div class="bloque" style="height: 75px">
                    <label for="tipo_mov">Tipo movimiento:</label>
                      <select name="tipo_mov" class='form-control' id="tipo_mov">
                          <option value="1">Entrada</option>
                          <option value="2">Salida</option>
                      </select> 
                  </div>
                  <div class="bloque" style="height: 25px">
                  <label for="monto">Monto del movimiento:</label>
                    <input type="number" name="monto" id="monto" placeholder="Determine el monto" class="form-control">
                  </div>
                  <div id="salidaForm"></div>
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenOpenContinue" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonOpenContinueModal" >Ingresar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>
