<div class="modal fade" id="facturaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'facturaForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Factura</h4>
            </div>
            <div class="modal-body">

              @if($ordenesSinFactura !=null)
                  <div class="row">
                  <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <div class="equipo">
                            <!-- Ordenes de Trabajo -->
                          <label for="ordenes">Ordenes de Trabajo sin facturar:</label>
                          <div class="bloque" style="height: 50px">
                            <select name="ordenes" class="form-control form-control-lg" id="ordenes">
                              @foreach($ordenesSinFactura as $o) 
                            <option value="{{$o->id}}">{{ $o->no_orden_trabajo}}-{{ $o->equipo}}</option>
                              @endforeach
                            </select>
                          </div>
                          {{--  --}}
                          <label for="isCustomer">Cliente/Consumidor Final:</label>
                          <div class="bloque" style="height: 50px">

                            <select name="isCustomer" class="form-control form-control-lg" id="isCustomer">
                              <option value="1">Cliente Registrado</option> 
                              <option value="0">Consumidor Final</option> 
                            </select>
                          </div>
                          {{--  --}}
                      </div>
                      <hr>
                      <div class="datosCliente">
                          <!-- Cliente -->
                        <label for="cliente">Cliente:</label>
                        <input type="text" name="cliente" id="cliente" placeholder="Ingrese el cliente" class="form-control">
                        <br>

                        <!-- Cliente -->
                        <label for="nit">Nit:</label>
                        <input type="text" name="nit" id="nit" placeholder="Ingrese el nit" class="form-control">
                        <br>

                        <!-- Direccion -->
                        <label for="direccion">Dirección:</label>
                        <input type="text" name="direccion" value="Ciudad" placeholder="Ingrese la dirección" class="form-control">
                        <br>
                        <hr>
                      </div>
                      <div class="encabezado">
                          <!-- No. Factura -->
                        <label for="no_factura">No. Factura:</label>
                        <input type="text" name="no_factura" placeholder="Ingrese el número de Factura" class="form-control">
                        <br>

                        <!-- Serie -->
                        <label for="serie">Serie:</label>
                        <input type="text" name="serie" placeholder="Ingrese la serie" class="form-control">
                        <br>
                      </div>
              
                  </div>
                </div>
              @else 
                <div class="row">
                  <h3 style="text-align: center">No hay ordenes que facturar actualmente</h3>
                </div>
              @endif
              <br>
              <input type="hidden" name="_token" id="facturaToken" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              @if($ordenesSinFactura !=null)
              <button type="submit" class="btn btn-primary" id="ButtonFacturaModal" >Agregar</button>
              @else 
              <button type="submit" disabled class="btn btn-primary" id="ButtonFacturaModal" >Agregar</button>
              @endif
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>