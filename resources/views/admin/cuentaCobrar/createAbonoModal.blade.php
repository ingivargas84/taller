<div class="modal fade" id="abonoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  {!! Form::open( array( 'id' => 'abonoForm' ) ) !!}
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Abono</h4>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="form-group col-sm-12 {{ $errors->has('abono') ? 'has-error': '' }}">
            {{-- <label for="fecha">Fecha:</label>
            <div class="bloque" style="height:65px">
              <input class="form-control" type="date" name="fecha" id="fecha">
            </div> --}}
            <div  style="height: 90px">
                                <label for="fecha">Fecha</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha" type="text" class="form-control pull-right" id="fecha" autocomplete="off">
                                </div>
                                {{--  --}}
                            </div>
            <label for="abono">Cantidad:</label>
            <div class="bloque" style="height: 65px">
              <input type="text" name="abono"  id="abono" placeholder="Ingrese la cantidad" class="form-control">
              {!! $errors->first('abono', '<span class="help-block">:message</span>') !!}
            </div>
            <label for="tipo">Método de Pago</label>
            <div class="bloque" style="height:100">  
              <select class="form-control" name="tipo" id="tipo">
                @foreach($tipos as $t)
                <option value="{{ $t->id }}">{{ $t->documento}}</option>
                @endforeach
              </select>
            </div>
            <br>
            <br>

            <label for="observaciones">Observaciones:</label>
            <div class="bloque" style="height:65px">
              <input class="form-control" type="text" name="observaciones" id="observaciones">
            </div>
            <label for="num">No Documento:</label>
            <div class="bloque" style="height:65px">
              <input class="form-control" type="text" name="num" id="num">
            </div>
          </div>
        </div>
        <input type="hidden" name="_token" id="abonoToken" value="{{ csrf_token() }}">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="ButtonAbonoModal" >Agregar</button>
      </div>
    </div>
  </div>
  {!! Form::close() !!}
</div>