<div class="modal fade" id="modalInEgreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'InEgresoForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Ingreso / Egreso</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" id="isWhat" name="isWhat">
              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                    <div class="bloque" class="form-group" style="height: 85px">
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre:">
                    </div>
                  <div class="bloque" class="form-group" style="height: 85px">
                    <label for="tipoM">Tipo de Movimiento</label>
                    <select name="tipoM" id="tipoM" class="form-control">
                      @foreach($tipos as $t)
                      <option value="{{ $t->id }}">{{ $t->tipo }}</option>
                      @endforeach
                    </select>
                  </div>
                   <div class="bloque" class="form-group" style="height: 85px">
                    <label for="tipoC">Tipo de Cálculo</label>
                    <select name="tipoC" id="tipoC" class="form-control">
                      @foreach($tiposC as $t)
                      <option value="{{ $t->id }}">{{ $t->tipo }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="content" id="seccionPorcentaje">
                    <div class="bloque" class="form-group" style="height: 85px">
                      <label for="valor_afecto_p">Campo afecto</label>
                      <select name="valor_afecto_p" id="valor_afecto_p" class="form-control">
                        <option value="1">Sueldo Base</option>
                      </select>
                    </div>
                    <div class="bloque" class="form-group">
                      <label for="porcentaje">Porcentaje</label>
                      <input type="number" class="form-control" name="porcentaje" id="porcentaje" placeholder="%">
                    </div>
                  </div>
                  {{-- Calculado --}}
                  <div class="content" id="seccionCalculado">
                    <div class="bloque" class="form-group" style="height: 85px">
                      <label for="valor_afecto_c">Campo afecto</label>
                      <select name="valor_afecto_c" id="valor_afecto_c" class="form-control">
                        <option value="1">Sueldo Base</option>
                        <option value="3">Valor Hora</option>
                      </select>
                    </div>
                    <div class="bloque" class="form-group">
                      <label for="multip">Cant. a Multiplicar</label>
                      <input type="number" class="form-control" name="multip" id="multip">
                    </div>
                  </div>
                  {{-- Fijo --}}
                  <div class="content" id="seccionFijo">
                    <div class="bloque" class="form-group" style="height: 85px">
                      <label for="valor_afecto_f">Campo afecto</label>
                      <select name="valor_afecto_f" id="valor_afecto_f" class="form-control">
                        <option value="1">Manual</option>
                        <option value="2">Automático</option>
                      </select>
                    </div>
                    <div id="seccionAuto" style="height: 30px">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad" id="cantidad">
                    </div>
                  </div>
                </div>
              </div>
              <input type="hidden" name="_token" id="tokenInEgreso" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonInEgresoModal" >Agregar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>