<!-- Modal -->
<div class="modal fade" id="ubicacionEquipoDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         {!! Form::open( array( 'id' => 'ubicacionEquipoDeleteForm' ) ) !!}
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Desactivar ubicación de equipo</h4>
                </div>
                <div class="modal-body modal-h">
                  <div class="row row-h">
                    <div class="form-group col-sm-8">
                      <span id="mensaje"></span> 
                      <select hidden name="" id="selectEquipos"></select>
                      <span class="help-block"  id="numeroEquipos"></span>
                    </div>
                    <input type="text" name="idUbicacion" hidden id='idUbicacion'>
                    <input type="text" name="nuevaU" hidden id="nuevaU">
                    <div class="form-group col-sm-8">
                        <select hidden name="" id="selectUbicaciones"></select>
                        <span style="color:#b89509" class="help-block" id="mensajeCambio"></span>
                      </div>
                  </div>
                  <br>
                  <input type="hidden" name="_token" id="ubicacionEquipoDeleteToken" value="{{ csrf_token() }}">
                  <input type="hidden"  name="id" id="locat">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" id="closeModal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" disabled id="ButtonUbicacionEquipoModalDelete" >Desactivar</button>
                </div>
              </div>
            </div>
          {!! Form::close() !!}
</div>