@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ordenes de Trabajo en Recepción
        <small>Introducir Pago y Registro de Llamada Telefónica</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('ordenequipo.index')}}"><i class="fa fa-list"></i> Ordenes en Recepcion</a></li>
        <li class="active">Pago y Llamada</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="PagoTelForm" action="{{route('ordenequipo.finalizarorden', $ordenequipo)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-4">
                        <h4><strong>No Comprobante:</strong> {{$ordenequipo->no_comprobante}}</h4>
                    </div>
                    <div class="form-group col-sm-4">
                        <h4><strong>Equipo:</strong> {{$equipo->equipo}}</h4>
                    </div>
                    <div class="form-group col-sm-4">
                        <h4><strong>Cliente:</strong> {{$cliente->nombre_comercial}}</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-9">
                        <h4><strong>Observaciones:</strong> {{$ordenequipo->observaciones}}</h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <h4><strong>Teléfono Cliente:</strong> {{$cliente->telefono}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <h4><strong>Fecha de Diagnóstico Taller:</strong> {{$taller->fecha_diagnostico}}</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <h4><strong>Diagnóstico de Taller:</strong> {{$taller->trabajos_realizados}}</h4>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="codigo">Total a Cobrar:</label>
                        <input type="text"  class="form-control" placeholder="Total a Cobrar (Q.)" name="total_cobrar"  id="to" value="{{$ordenequipo->total_cobrar}}">
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="codigo">Tipo envío</label>
                      <div class="form-group">
                             <select id="entrega" class="form-control" name="entrega"  title="campo requerido" required>
                                 <option value="">Seleccionar envio</option>
                                 <option  value="1">Recoge el cliente</option>
                                 <option  value="Envio con Asesor">Envio con Asesor</option>
                                 <option  value="Envio Guatex">Envio Guatex</option>
                             </select>

                     </div>
                    </div>
                    <div class="form-group col-sm-4">
                       <div id="input"></div>
                       <input type="hidden"  class="form-control" id="entrega1">
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label>Tipo de Pago:</label>
                        <select class="form-control" name="pago" id="pago">
                            <option value="">Seleccionar</option>
                            @foreach($pago as $pa)
                            <option value="{{ $pa->id }}">{{ $pa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Cantidad:</label>
                        <input type="number" step="0.01" title="La cantidad no puede ser  menos de Q 0.00"  min = "1" class="form-control" placeholder="Cantidad:" name="cantidad" id="cantidad" pattern="^\\d+(?:\\.\\d{0,2})?$">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>No. Documento:</label>
                        <input type="text" class="form-control" placeholder="Ingrese el documento:" name="documento" id="documento" >
                    </div>

                      <div class="form-group col-sm-1">
                            <div class="text-right m-t-15" style="margin-top: 25px; margin-bottom: 10px">
                          <button id="agregar-detalle" class="btn btn-success form-button" tabindex="11">Agregar Pago</button>
                        </div>
                      </div>

                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="detalle_llamada">Detalle Pago:</label>
                    </div>
                </div>
                <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
                </table>
                <br>
                <div class="col-sm-4">
                    <label for="total_ingreso">Resta:</label>
                    <div class="input-group">
                        <span class="input-group-addon">Q.</span>
                        <input type="text" class="form-control customreadonly"  readonlyplaceholder="Total de la compra" name="total_ingreso" id="total" readonly>
                    </div>
                </div>
                <hr>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('ordenequipo.index') }}">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonPagoTel">Guardar</button>
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

@endpush


@push('scripts')
<script type="text/javascript">
'use strict'

window.addEventListener('load', function () {
    var select = document.querySelector("#entrega");
    var i = "";
    var input = document.querySelector("#input");

    select.addEventListener('change', function (e) {
        e.preventDefault();
        input.innerHTML = '';
        for (i = 0; i < select.value; i++) {
            createInputs();
        }
    });

    function createInputs() {
        var element = document.createElement('div');
        element.innerHTML = `
    <div class="form-group">
        <label>Nombre del Cliente</label>
              <input type="text"  class="form-control"  name="nombrecliente"  id="nombrecliente" value="" required title="Por favor, ingresar el nombre del cliente">
    </div>
    `;
        input.appendChild(element);
    }
});
</script>
<script type="text/javascript">

$(document).on('focusout', '#entrega', function(){
  var codigo = $('#entrega').val();
  $('#entrega1').val(codigo);
  $.ajax({
      success: function(data){
          $('#entrega1').val(codigo);
        },
        error: function(){
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  (
              'Error. Por favor, seleccionar');
              $('#pago').val('default');
              $('#cantidad').val(null);
              $('#documento').val(null);
            }
          });
        });






  function chkfldsE() {
      if ($('#pago').val() == 2 || $('#pago').val() == 3 || $('#pago').val() == 4){

            if ($('#pago').val() && $('#cantidad').val() && $('#documento').val())  {
                    return true
            }else{
                return false
            }
      }else{
          if ($('#pago').val() && $('#cantidad').val()) {
              return true
            }else{
              return false
            }
        }
        }

        function pago() {
            if ( parseFloat($('#to').val())>=  parseFloat($('#cantidad').val())){
                          return true
            }else{
                    return false

              }
        }




        $('#agregar-detalle').click(function(e){
          e.preventDefault();
          if (pago()) {
          if(chkfldsE()){
            //calculates the box
            var documento;
            if ($('#documento').val() === "") {
                documento = "sin documento";
            }else {
              documento =$('#documento').val();
            }
            var entrega;
            if ($('#entrega1').val() == 1) {
              entrega = "Recoge cliente";
            }else {
              entrega = $('#entrega1').val();
            }
            var persona =  $('#nombrecliente').val();

            if (persona !== null) {
              persona = $('#nombrecliente').val();
            }else {
              persona = "envio";
            }


          detalle_table.row.add({
            'pago': $('#pago').val(),
            'documento': documento,
            'cantidad': $('#cantidad').val(),
            'entrega': entrega,
            'persona': persona,
          }).draw();
          //adds all subtotal row data and sets the total input
          var total = parseFloat($('#to').val());
          total = total.toFixed(2)
          detalle_table.column(2).data().each(function(value, index){
            total = total - parseFloat(value);
            // parseFloat(total);
            $('#total').val(total);
            $('#total-error').remove();
          });
          //resets form data
          $('#cantidad').val(null);
          $('#documento').val(null);
          $('#pago').val(null);
        }else{
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  ('Debe escribir un seleccionar tipo de envio, tipo de pago, Cantidad, documento si es requerido');
          alertify.error  ('El Documento es requerido cuando el tipo de pago es Cheque, deposito y tarjeta');
        }
      }else {
        alertify.set('notifier', 'position', 'top-center');
        alertify.error  ('El pago no puede ser mayor al total a pagar.');
      }
      });


</script>
<script type="text/javascript">

function chkflds() {
      if (parseFloat($('#total').val()) == 0.00)  {
          return true
        }else{
          return false
        }
      }

$(document).on('click', '#ButtonPagoTel', function(e){
        e.preventDefault();
          if(chkflds()){
        if ($('#PagoTelForm').valid()) {
            var arr1 = $('#PagoTelForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('ordenequipo.finalizarorden', $ordenequipo)}}",
                headers:{'X-CSRF-TOKEN': $('#tokenReset').val(),},
                data: JSON.stringify(arr3),
                dataType: 'json',
                success: function(){


                    detalle_table.rows().remove().draw();
                      window.location.assign("{{route('ordenequipo.index')}}")
                },
                error: function(){
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar el cobro')
                }
            })
        }
      }else{
        alertify.set('notifier', 'position', 'top-center');
        alertify.error('El total a cobra no es igual a lo pagado')
      }
    });

</script>

<script src="{{asset('js/ordenequipo/new.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/ordenequipo/create2.js')}}"></script>
@endpush
