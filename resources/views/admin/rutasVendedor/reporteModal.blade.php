<div class="modal fade" id="modalVisitas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form action=" {{ route('rutas.pdf') }}" id="modalVisitasForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Reporte de visitas</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <p id="tituloModal" type="text"></p>
                  <div class="col-sm-12" style="height: 90px">
                                <label for="fechaInicial">Fecha Inicial:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fechaInicial" autocomplete="off" type="text" class="form-control pull-right" id="fechaInicial">
                                </div>
                                {{--  --}}
                  </div>
                  <div class="col-sm-12" style="height: 90px">
                                <label for="fechaFinal">Fecha Final:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fechaFinal" autocomplete="off" type="text" class="form-control pull-right" id="fechaFinal">
                                </div>
                                {{--  --}}
                  </div>
                </div>
              </div>
              <input type="hidden" name="_token" id="tokenReporteVisita" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonReporteVisitaModal" >Obtener reporte</button>
            </div>
          </div>
    </div>
    </form>
</div>
