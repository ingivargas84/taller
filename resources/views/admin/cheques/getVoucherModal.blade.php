<div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'voucherForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Generar Voucher</h4>
            </div>
            <div class="modal-body">
                <h4><span id="no"></span></h4>
              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                       <!-- Description -->
                    <div class="bloque" style="height: 35px">
                    <label for="receptor_voucher">Receptor:</label>
                      <input type="text" name="receptor_voucher"  id="receptor_voucher" placeholder="Ingrese el Receptor" class="form-control">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>
                    <br>
                </div>
              </div>
              
              <input type="hidden" name="_token" id="voucherToken" value="{{ csrf_token() }}">
              <input type="hidden" name="cheque_id" id="cheque_id">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonVoucherModal" >Generar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>