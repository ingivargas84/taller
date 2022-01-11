<div class="modal fade" id="modalInEgresoEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'InEgresoEditForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Editar Ingreso / Egreso</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" id="isWhatEdit" name="isWhatEdit">
              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombreEdit') ? 'has-error': '' }}">
                    <div class="bloque" class="form-group" style="height: 85px">
                      <label for="nombreEdit">Nombre</label>
                      <input type="text" class="form-control" name="nombreEdit" id="nombreEdit" placeholder="Nombre:">
                    </div>
                  <div class="bloque" class="form-group" style="height: 85px">
                    <label for="tipoMe">Tipo de Movimiento</label>
                    <select name="tipoMe" id="tipoMe" class="form-control">
                      @foreach($tipos as $t)
                      <option value="{{ $t->id }}">{{ $t->tipo }}</option>
                      @endforeach
                    </select>
                  </div>
                   <div class="bloque" class="form-group" style="height: 85px">
                    <label for="tipoCe">Tipo de Cálculo</label>
                    <select name="tipoCe" id="tipoCe" class="form-control">
                      @foreach($tiposC as $t)
                      <option value="{{ $t->id }}">{{ $t->tipo }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="content" id="seccionPorcentajeEdit">
                    <div class="bloque" class="form-group" style="height: 85px">
                      <label for="valor_afecto_p_edit">Campo afecto</label>
                      <select name="valor_afecto_p_edit" id="valor_afecto_p_edit" class="form-control">
                        <option value="1">Sueldo Base</option>
                        <option value="2">Sueldo Total</option>
                      </select>
                    </div>
                    <div class="bloque" class="form-group">
                      <label for="porcentajeEdit">Porcentaje</label>
                      <input type="number" class="form-control" name="porcentajeEdit" id="porcentajeEdit" placeholder="%">
                    </div>
                  </div>
                  {{-- Calculado --}}
                  <div class="content" id="seccionCalculadoEdit">
                    <div class="bloque" class="form-group" style="height: 85px">
                      <label for="valor_afecto_c_edit">Campo afecto</label>
                      <select name="valor_afecto_c_edit" id="valor_afecto_c_edit" class="form-control">
                        <option value="1">Sueldo Base</option>
                        <option value="2">Sueldo Total</option>
                        <option value="3">Valor Hora</option>
                      </select>
                    </div>
                    <div class="bloque" class="form-group">
                      <label for="multipEdit">Cant. a Multiplicar</label>
                      <input type="number" class="form-control" name="multipEdit" id="multipEdit">
                    </div>
                  </div>
                  <input type="hidden" id="id" name="id">
                  {{-- Fijo --}}
                  <div class="content" id="seccionFijoEdit">
                    <div class="bloque" class="form-group" style="height: 85px">
                      <label for="valor_afecto_f_edit">Campo afecto</label>
                      <select name="valor_afecto_f_edit" id="valor_afecto_f_edit" class="form-control">
                        <option value="1">Manual</option>
                        <option value="2">Automático</option>
                      </select>
                    </div>
                    <div id="seccionAutoEdit" style="height: 30px">
                        <label for="cantidadEdit">Cantidad</label>
                        <input type="number" class="form-control" name="cantidadEdit" id="cantidadEdit">
                    </div>
                  </div>
                </div>
              </div>
              <input type="hidden" name="_token" id="tokenInEgresoEdit" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonInEgresoUpdateModal" >Agregar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>