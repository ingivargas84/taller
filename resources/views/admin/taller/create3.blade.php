@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ordenes de Trabajo en Taller
        <small>Editar Diagnóstico</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('taller.index')}}"><i class="fa fa-list"></i> Ordenes en Taller</a></li>
        <li class="active">Diagnóstico</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="TallerDiagnosticoForm" action="{{route('taller.save1', $taller)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <input type="hidden" name="id" value="{{ $ordenequipo->id }}">
                    <div class="form-group col-sm-3">
                        <h4><strong>No Orden de Trabajo:</strong> {{$ordenequipo->no_orden_trabajo}}</h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <h4><strong>No Comprobante:</strong> {{$ordenequipo->no_comprobante}}</h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <h4><strong>Equipo:</strong> {{$equipo->equipo}}</h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <h4><strong>Cliente:</strong> {{$cliente->nombre_comercial}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <h4><strong>Observaciones:</strong> {{$ordenequipo->observaciones}}</h4>
                    </div>
                </div>
                <div class="row text-center">
                    <h4><strong>Agregar Detalle de Cobro</strong></h4>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>Servicio:</label>
                        <select class="form-control" name="servicio" id="servicio">
                            <option value="default" id= "servicio">Seleccione Servicio</option>
                            @foreach($servicio as $srv)
                            <option value="{{ $srv->id }}">{{ $srv->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Cantidad:</label>
                        <input type="number" class="form-control" title="por favor, solo ingresar números enteros"  placeholder="Cantidad:" onchange="sub()" name="cantidad" id="cantidad" value="1">
                        <input type="hidden" class="form-control" placeholder="Precio Unitario:" name="servicio-id" id="servicio-id">
                        <input type="hidden" class="form-control" placeholder="Precio Unitario:" name="servicio-nom" id="servicio-nom">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Precio Unitario:</label>
                        <input type="text" class="form-control" placeholder="Precio Unitario:" name="precio-com" id="precio-com" readonly>
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Subtotal:</label>
                        <input type="text" class="form-control" placeholder="Subtotal" name="subtotal" id="subtotal" readonly>
                    </div>
                    <div class="form-group col-sm-1">
                        <div class="text-right m-t-15" style="margin-top: 25px; margin-bottom: 10px">
                        <button id="agregar-detalleS" class="btn btn-success form-button" tabindex="11">Agregar al detalle</button>
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm-3">
                          <label for="switch">¿Buscar por código?</label>
                          <div class="switch-field">
	                                	<input type="radio" id="radio-one" name="switch" value="false"/>
	                                	<label for="radio-one">No</label>
	                                	<input type="radio" id="radio-two" name="switch" value="true"  checked/>
	                                	<label for="radio-two">Si</label>
	                        </div>
                  </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-2">
                        <label>Código Producto:</label>
                        <input type="text" class="form-control" placeholder="codigo del producto:" name="producto" id="producto">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Producto:</label>
                        <input type="text" list="browsers" class="form-control customreadonly" placeholder="Producto:" name="producto-nom" id="producto-nom">

                        <datalist id="browsers">
                        @foreach ($producto as $p)
                            <option value="{{$p->nombre}}">
                        @endforeach
                        </datalist>

                    </div>
                    <div class="form-group col-sm-1">
                        <label>Cantidad:</label>
                        <input type="number" class="form-control"title="por favor, solo ingresar números enteros" placeholder="Cantidad:" name="cantidadP" id="cantidadP" onchange="subP()" value="1">
                        <input type="hidden" class="form-control" placeholder="Precio Unitario:" name="producto-id" id="producto-id">
                        <input type="hidden" class="form-control" placeholder="Precio Unitario:" name="producto-nom" id="producto-nom">
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Precio Unitario:</label>
                        <input type="text" class="form-control" placeholder="Precio Unitario:" name="precioP" id="precioP" readonly>
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Subtotal:</label>
                        <input type="text" class="form-control" placeholder="Subtotal" name="subtotalP" id="subtotalP" readonly>
                    </div>
                    <div class="form-group col-sm-1">
                      <div class="text-right m-t-15" style="margin-top: 25px; margin-bottom: 10px">
                        <button id="agregar-detalleP" class="btn btn-success form-button" tabindex="11">Agregar al detalle</button>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>Nombre Extras:</label>
                        <input type="text" class="form-control" placeholder="Extra:" name="extra" id="extra">
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Cantidad:</label>
                        <input type="number" class="form-control" title="por favor, solo ingresar números enteros" placeholder="CantidadE:" onchange="subE()"  name="cantidadE" id="cantidadE" value="1">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Precio Unitario:</label>
                        <input type="number"  step="0.01" class="form-control" title="por favor, solo ingresar números con dos decimales"placeholder="Precio Unitario:" onchange="subE()"  name="precioE" id="precioE" value="0.00">
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Subtotal:</label>
                        <input type="text" class="form-control" placeholder="Subtotal" name="subtotal" id="subtotalE" value = "0" readonly>
                    </div>
                    <div class="form-group col-sm-1">
                      <div class="text-right m-t-15" style="margin-top: 25px; margin-bottom: 10px">
                        <button id="agregar-detalleE" class="btn btn-success form-button" tabindex="11">Agregar al detalle</button>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="detalle_diagnostico">Detalle del Diagnóstico:</label>
                    </div>
                </div>
                <br>
                        <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
                        </table>
                        <br>
                        <div class="row">
                                    <div class="col-sm-4">
                                        <label for="total_ingreso">Total:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">Q.</span>
                                            <input type="text" class="form-control customreadonly" placeholder="Total de la compra" name="total_ingreso" id="total" value="{{ $ordenequipo->total_cobrar }}">
                                        </div>
                                    </div>
                                </div>
                <hr>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('taller.index') }}">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonTallerDiagnostico">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>
&nbsp;
<div class="loader loader-bar"></div>
@stop


@push('styles')

<style>
    .customreadonly{
        background-color: #eee;
        cursor: not-allowed;
        pointer-events: none;
        }
</style>
<style>
    .switch-field {
        display: flex;
        margin-bottom: 36px;
        overflow: hidden;
    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        /* box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1); */
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked + label {
        background-color: #55bd8c;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }
</style>
@endpush


@push('scripts')
<script type="text/javascript">
$(document).on('click', '#radio-one', function(){
  if(this.checked == true){
      $('#producto').addClass('customreadonly');
      $('#producto-nom').removeClass('customreadonly');
      $('#producto-nom').prop('maxlength', 256);
  }
});
$(document).on('click', '#radio-two', function(){
  if(this.checked == true){
      $('#producto').removeClass('customreadonly');
      $('#producto-nom').addClass('customreadonly');
  }
});
</script>
<script type="text/javascript">
var datos  = [];

function sub() {
  v = document.getElementById("cantidad").value;
  r = document.getElementById("precio-com").value;
  i = v * r;
  document.getElementById("subtotal").value = i;
  }

  function subP() {
    v = document.getElementById("cantidadP").value;
    r = document.getElementById("precioP").value;
    i = v * r;
    document.getElementById("subtotalP").value = i;
    }

    function subE() {
      v = document.getElementById("cantidadE").value;
      r = document.getElementById("precioE").value;
      i = v * r;
      document.getElementById("subtotalE").value = i;
      }





  //gets the selected prduct data and sets the readonly inputs
  $(document).on('focusout', '#servicio', function(){
    var codigo = $('#servicio').val();
    var url = "@php echo url('/') @endphp" + "/taller/getServicioData/" + codigo;
    $('#servicio-com-error').remove();
    $('#precio-error').remove();
    $('#servicio-com').val(null);
    $('#precio-com').val(null);
    $('#servicio-id').val(null);
    $('#subtotal').val(null);
    $.ajax({
        url: url,
        success: function(data){
            $('#precio-com').val(data[0].precio);
            $('#servicio-nom').val(data[0].nombre);
            $('#servicio-id').val(data[0].id);
            var subtotal = parseFloat($('#cantidad').val()) * parseFloat($('#precio-com').val());
            $('#subtotal').val(subtotal);
          },
          error: function(){
            alertify.set('notifier', 'position', 'top-center');
            alertify.error  (
                'No se encontró el servicio. Por favor, seleccionar');
                $('#servicio-nom').val(null);
                $('#precio-com').val(null);
                $('#servicio-id').val(null);
                $('#servicio').val('default');
                $('#subtotal').val(null);
              }
            });
          });

          function chkflds() {
                if ($('#servicio-nom').val() && $('#cantidad').val() && $('#precio-com').val()) {
                    return true
                }else{
                    return false
                }
            }

      $('#agregar-detalleS').click(function(e){
      e.preventDefault();
      if(chkflds()){
          //calculates the box
          var subtotal = parseFloat($('#cantidad').val()) * parseFloat($('#precio-com').val());
          subtotal = subtotal.toFixed(2);
          //calculates the importe

          detalle_table.row.add({
              'id': $('#servicio-id').val(),
              'nombre': $('#servicio-nom').val(),
              'cantidad': $('#cantidad').val(),
              'precio': $('#precio-com').val(),
              'subtotal': subtotal,
              'tipo': 'servicio',
          }).draw();
          datos.push({
              'id': $('#servicio-id').val(),
              'nombre': $('#servicio-nom').val(),
              'cantidad': $('#cantidad').val(),
              'precio': $('#precio-com').val(),
              'subtotal': subtotal,
              'tipo': 'servicio',
          });
          //adds all subtotal row data and sets the total input
          var total = 0;
          detalle_table.column(4).data().each(function(value, index){
              total = total + parseFloat(value);
              // parseFloat(total);
              $('#total').val(total);
              $('#total-error').remove();
          });
          //resets form data
          $('#servicio-nom').val(null);
          $('#cantidad').val(1);
          $('#precio-com').val(null);
          $('#servicio').val('default');
          $('#servicio-id').val(null);
            $('#subtotal').val(null);
      }else{
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  ('Debe seleccionar un servicio, cantidad, precios');
      }
  });



//producto por nombre

//gets the selected prduct data and sets the readonly inputs
$(document).on('focusout', '#producto-nom', function(){
  var codigo = $('#producto-nom').val();
  var url = "@php echo url('/') @endphp" + "/taller/getProductoData1/" + codigo;
  $('#producto-com-error').remove();
  $('#precioP-error').remove();
  $('#producto').val(null);
  $('#precioP').val(null);
  $('#producto-id').val(null);
  $('#cantidadP').val(1);
  $('#subtotalP').val(null);
  $.ajax({
      url: url,
      success: function(data){
          $('#precioP').val(data[0].precio_venta);
          $('#producto').val(data[0].codigo);
          $('#producto-id').val(data[0].id);
          var subtotal = parseFloat($('#cantidadP').val()) * parseFloat($('#precioP').val());
          $('#subtotalP').val(subtotal);
        },
        error: function(){
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  (
              'No se encontró el producto. Por favor, seleccionar');
              $('#producto-nom').val(null);
              $('#precioP').val(null);
              $('#producto-id').val(null);
              $('#subtotalP').val(null);
            }
          });
        });





//gets the selected prduct data and sets the readonly inputs
$(document).on('focusout', '#producto', function(){
  var codigo = $('#producto').val();
  var url = "@php echo url('/') @endphp" + "/taller/getProductoData/" + codigo;
  $('#producto-com-error').remove();
  $('#precioP-error').remove();
  $('#producto-nom').val(null);
  $('#precioP').val(null);
  $('#producto-id').val(null);
  $('#cantidadP').val(1);
  $.ajax({
      url: url,
      success: function(data){
          $('#precioP').val(data[0].precio_venta);
          $('#producto-nom').val(data[0].nombre);
          $('#producto-id').val(data[0].id);
          var subtotal = parseFloat($('#cantidadP').val()) * parseFloat($('#precioP').val());
          $('#subtotalP').val(subtotal);
        },
        error: function(){
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  (
              'No se encontró el producto. Por favor, seleccionar');
              $('#producto-nom').val(null);
              $('#precioP').val(null);
              $('#producto-id').val(null);
              $('#subtotalP').val(null);
            }
          });
        });

        function chkfldsP() {
              if ($('#producto-nom').val() && $('#cantidadP').val() && $('#precioP').val() && $('#producto').val() ) {
                  return true
              }else{
                  return false
              }
          }

    $('#agregar-detalleP').click(function(e){
    e.preventDefault();
    if(chkfldsP()){
        //calculates the box
        var subtotal = parseFloat($('#cantidadP').val()) * parseFloat($('#precioP').val());
        subtotal = subtotal.toFixed(2);
        //calculates the importe

        detalle_table.row.add({
            'id': $('#producto-id').val(),
            'nombre': $('#producto-nom').val(),
            'cantidad': $('#cantidadP').val(),
            'precio': $('#precioP').val(),
            'subtotal': subtotal,
            'tipo': 'producto',
        }).draw();
        datos.push({
          'id': $('#producto-id').val(),
          'nombre': $('#producto-nom').val(),
          'cantidad': $('#cantidadP').val(),
          'precio': $('#precioP').val(),
          'subtotal': subtotal,
          'tipo': 'producto',
        });

        //adds all subtotal row data and sets the total input
        var total = 0;
        detalle_table.column(4).data().each(function(value, index){
            total = total + parseFloat(value);
            // parseFloat(total);
            if ($('#t').val() > total)
            {
              var t =   $('#t').val();
              $('#total').val(t);
                $('#total-error').remove();
            }else {
              $('#total').val(total);
              $('#total-error').remove();
            }

        });
        //resets form data
        $('#producto-nom').val(null);
        $('#cantidadP').val(1);
        $('#precioP').val(null);
        $('#producto-id').val(null);
        $('#producto').val(null);
          $('#subtotalP').val(null);
    }else{
        alertify.set('notifier', 'position', 'top-center');
        alertify.error  ('Debe seleccionar un Producto, Cantidad, precios');
    }
});



        function chkfldsE() {
              if ($('#extra').val() && $('#cantidadE').val() && $('#precioE').val() ) {
                  return true
              }else{
                  return false
              }
          }

    $('#agregar-detalleE').click(function(e){
    e.preventDefault();
    if(chkfldsE()){
        //calculates the box
        var subtotal = parseFloat($('#cantidadE').val()) * parseFloat($('#precioE').val());
        subtotal = subtotal.toFixed(2);
        //calculates the importe

        detalle_table.row.add({
            'id': '0',
            'nombre': $('#extra').val(),
            'cantidad': $('#cantidadE').val(),
            'precio': $('#precioE').val(),
            'subtotal': subtotal,
            'tipo': "extra",
        }).draw();
        datos.push({
          'id': '0',
          'nombre': $('#extra').val(),
          'cantidad': $('#cantidadE').val(),
          'precio': $('#precioE').val(),
          'subtotal': subtotal,
          'tipo': "extra",
        });
        //adds all subtotal row data and sets the total input
        var total = 0;
        detalle_table.column(4).data().each(function(value, index){
            total = total + parseFloat(value);
            // parseFloat(total);
            $('#total').val(total);
            $('#total-error').remove();
        });
        //resets form data
        $('#cantidadE').val(1);
        $('#precioE').val('0.00');
        $('#extra').val(null);
        $('#subtotalE').val(null);
    }else{
        alertify.set('notifier', 'position', 'top-center');
        alertify.error  ('Debe escribir un extra, Cantidad, precios');
    }
});

$(document).on('click', '#ButtonTallerDiagnostico', function(e){
        e.preventDefault();
        $('.loader').removeClass("is-active");
        if ($('#TallerDiagnosticoForm').valid()) {
            $('.loader').addClass("is-active");
            var arr1 = $('#TallerDiagnosticoForm').serializeArray();
            var arr2 = datos;
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('taller.save1', $taller)}}",
                headers:{'X-CSRF-TOKEN': $('#tokenReset').val(),},
                data: JSON.stringify(arr3),
                dataType: 'json',
                success: function(){
                  $('#cantidadE').val(null);
                  $('#precioE').val(null);
                  $('#extra').val(null);
                  $('#producto-nom').val(null);
                  $('#cantidadP').val(null);
                  $('#precioP').val(null);
                  $('#producto-id').val(null);
                  $('#producto').val('default');
                  $('#servicio-nom').val(null);
                  $('#cantidad').val(null);
                  $('#precio-com').val(null);
                  $('#servicio').val('default');
                  $('#servicio-id').val(null);

                    detalle_table.rows().remove().draw();
                      window.location.assign("{{route('taller.index')}}")
                },
                error: function(){
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar el Diagnostico')
                }
            })
        }
    });

</script>


<script src="{{asset('js/taller/show.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/taller/create.js')}}"></script>
<script src="{{asset('js/taller/diagnostico.js')}}"></script>

@endpush
