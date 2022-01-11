<div class="modal fade" id="garantiaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form method="post" id='garantiaForm'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ingrese la fecha: </h4>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="form-group col-sm-12 {{ $errors->has('abono') ? 'has-error': '' }}">
              <div  style="height: 90px">
                  <label for="fecha">Fecha</label>
                      <div class="input-group date">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                          <input name="fecha" type="text" class="form-control pull-right" id="fecha" autocomplete="off">
                      </div>         
              </div>
              <input type="hidden" id='ordenID'>
            </div>
        </div>
        <input type="hidden" name="_token" id="modalToken" value="{{ csrf_token() }}">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="ButtonGarantiaModal" >Generar Garantía</button>
      </div>
    </div>
  </div>
</form>
 
</div>