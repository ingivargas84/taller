<!-- Modal -->
<div class="modal fade" id="modalUpdateRuta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="RutaUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Observaciones</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                         <div class="col-sm-12">
                                <textarea style='resize: none' type="input" class="form-control" placeholder="Motivo de visita..." id="observaciones_edit" name="observaciones_edit"></textarea>
                            </div>
                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="tokenRutaEdit" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonRutaModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
</div>