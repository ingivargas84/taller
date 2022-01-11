<!-- Modal -->
<div class="modal fade" id="modalServicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'ServicioForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Servicio</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12">
                  <div style="height: 80px">
                      <label for="nombre">Nombre del Servicio:</label>
                      <input type="text" id="nombre" name="nombre" placeholder="Ingrese Nombre del servicio" class="form-control">
                  </div>
                  {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                  <div style="height: 80px">
                    <label for="nombre">Precio:</label>
                    <input type="number" id="precio" name="precio" placeholder="Ingrese el Precio del servicio" class="form-control" >
                  </div>
                  
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenServicio" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonServicioModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>