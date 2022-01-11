<!-- Modal -->
<div class="modal fade" id="servicioModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="servicioUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Servicio</h4>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div style='height: 70px' class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre">Nombre Servicio:</label>
                      <input type="text" name="nombre" placeholder="Ingrese Nombre" class="form-control" value="{{old('nombre')}}">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div style='height: 70px' class="form-group col-sm-12 {{ $errors->has('precio') ? 'has-error': '' }}">
                      <label for="precio">Precio Servicio:</label>
                      <input type="number" name="precio" placeholder="Ingrese Servicio" class="form-control" value="{{old('precio')}}">
                      {!! $errors->first('precio', '<span class="help-block">:message</span>') !!}
                    </div>

                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="servicioEditToken" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="buttonServicioModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
          </div>