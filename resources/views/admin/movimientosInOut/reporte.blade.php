<div class="modal fade" id="modalReporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form action="cerrados/reportePDF/" id="modalReporteForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Reporte de movimientos Caja Chica</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <p id="tituloModal" type="text"></p>
                  {{--  --}}
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
                  {{--  --}}
                  {{-- <div class="bloque" style="height: 80px">
                    <label for="fechaInicial">Fecha Inicial:</label>
                    <input id="fechaInicial" name="fechaInicial" type="date" class="form-control">
                    
                  </div> --}}
                 {{-- <div class="bloque" style="height: 45px">
                    <label for="fechaFinal">Fecha Final:</label>
                    <input type="date" name="fechaFinal" id="fechaFinal" class="form-control">
                  </div> --}}
                </div>
              </div>
              <input type="hidden" name="_token" id="tokenReporte" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonReporteModal" >Obtener reporte</button>
            </div>
          </div>
    </div>
    </form>
</div>
