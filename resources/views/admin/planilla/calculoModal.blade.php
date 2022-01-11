<div class="modal fade" id="operarCalculo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {{-- {!! Form::open( array( 'id' => 'InEgresoForm' ) ) !!} --}}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Operar <span></span></h4>
            </div>
            <div class="modal-body">
              <input type="hidden" id="isWhat" name="isWhat">
              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                    {{-- Calculado --}}
                    <div class="bloque" class="form-group">
                      <label for="multip">Cant. a Multiplicar</label>
                      <input type="number" class="form-control" name="multip" id="multip">
                    </div>
                  </div>
              </div>
              <input type="hidden" name="_token" id="tokenInEgreso" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button class="btn btn-primary" id="operar">Operar</button>
            </div>
          </div>
    </div>
    {{-- {!! Form::close() !!} --}}
</div>