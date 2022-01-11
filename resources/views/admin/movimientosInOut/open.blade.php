<div class="modal fade" id="modalOpen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'modalOpenForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Abrir caja chica</h4>
            </div>
               <input type="hidden" name="saldo" value="{{ $ultimoSaldo }}">
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="nombre">Movimiento de Entrada:</label>
                  <div class="bloque" style="height: 35px">
                    <input type="number" name="monto" placeholder="Determine el monto de entrada"  class="form-control" value="{{old('nombre')}}">
                    {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                  </div>
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenOpenCash" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonOpenCashModal" >Ingresar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>