@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          COTIZACIÓN NO. 00{{ $cotizacion[0]->no_cotizacion }}-{{ $cotizacion[0]->anio }}
          <input type="hidden" id="id" name="id" value="{{ $cotizacion[0]->id }}">
          <small>Editar cotización</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('cotizaciones.index')}}"><i class="fa fa-list"></i> Cotizaciones</a></li>
          <li class="active">Editar</li>
        </ol>
    </section>
@stop

@section('content')
<form id="cotizacionUpdateForm">
    <div class="notif">
        </div>
        {{ csrf_field() }}  {{ method_field('PUT') }}
        <div class="col-md-12">
            <div class="box box-primary">
                <input type="hidden" name="_token" id="tokenCotizacionEdit" value="{{ csrf_token() }}">
                <div class="box-body" style="-webkit-box-shadow: -1px 4px 19px -13px rgba(3,29,43,1);
                                                -moz-box-shadow: -1px 4px 19px -13px rgba(3,29,43,1);
                                                box-shadow: -1px 4px 19px -13px rgba(3,29,43,1);">
                        <div class="row" style="height: 70px">
                        <div class="col-sm-6">
                                <label>Cliente:</label>
                                <select class="form-control" name="cliente" id="cliente">
                                    <option value="lala">--Seleccione el cliente--</option>
                                </select>
                        </div>
                        <div class="col-sm-6" style="height: 90px">
                                <label for="fecha">Fecha</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha" autocomplete="off" type="text" class="form-control pull-right" id="fecha">
                                </div>
                                {{--  --}}
                            </div>
                            <input type="hidden" value="{{ $cotizacion[0]->fecha }}" id="fechaReal">
                                
                        </div>
                            <br>  
                        <div class="row" style="height: 90px">
                            
                            <div class="col-sm-3">
                                <label for="nombre">Nombre del Cliente:</label>
                                <input type="text" value="{{$cotizacion[0]->cliente->nombre_comercial}}" readonly class="form-control" id="nombre" placeholder="Nombre del cliente:" name="nombre" >
                                <input type="hidden" id="clienteId" value="{{ $cotizacion[0]->cliente_id }}">
                            </div>
                            <div class="col-sm-3">
                                <label for="direccion">Dirección:</label>
                                <input type="text" readonly class="form-control" id="direccion" value="{{ $cotizacion[0]->cliente->direccion }}" placeholder="Dirección:" name="direccion" >
                            </div>
                             <div class="col-sm-3">
                                <label for="contacto">Contacto:</label>
                                <input type="text" readonly class="form-control" id="contacto" value="{{ $cotizacion[0]->cliente->nombre_contacto1 }}" placeholder="Contacto:" name="contacto" >
                            </div>
                            <div class="col-sm-3">
                                <label for="telefono">Telefono:</label>
                                <input type="text" readonly class="form-control" id="telefono" value="{{ $cotizacion[0]->cliente->telefono }}" placeholder="No.Telefono:" name="telefono" >
                            </div>
                        </div>
                        <div class="row" style="height: 70px">
                            <div class="col-sm-6">
                                <label>Buscar Servicio:</label>
                                <select class="form-control" name="servicio" id="servicio">
                                    <option value="lala" default>--Seleccione el servicio--</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="codigo">Buscar producto:</label>
                                <input type="text" placeholder="Escribe el código..." class="form-control" id="codigo" name="codigo">
                            </div>
                        </div>
                        <br>
                        <div class="row" style='height: 50px'>
                             <div class="col-sm-3" id='componenteP'>
                                <label for="cantidad">Producto / Servicio:</label>
                                <input type="text" class="form-control" readonly class="form-control" id="producto" placeholder="Producto / Servicio:" name="producto" >
                             </div>
                            <div class="col-sm-3">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="form-control" placeholder="Cantidad:" id="cantidad" name="cantidad" >
                            </div>
                            <div class="col-sm-3">
                                <label for="precio">Precio:</label>
                                <input type="text" class="form-control" placeholder="Precio:" id="precio" name="precio" >
                            </div>
                            <div class="col-sm-2">
                                <label for="subtotal">Subtotal:</label>
                                <input type="text" class="form-control" readonly placeholder="Subtotal:" id="subtotal" name="subtotal" >
                            </div>
                            
                            <input type="hidden" value="">
                            <input type="hidden" value=""  id="bienActualizar">
                            <div class="col-sm-1"  style="margin-top: 25px">
                                <span id="add" tabindex="0" class='btn btn-warning btn-sm'><i class='fas fa-plus'></i></span>
                            </div>
                        </div>
                        <br>
                        <hr>
                       
                        <table id="detalle-cotizacion-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
                        </table>
                        <hr>
                       
                        <div class="row">
                            <div class="col-sm-5">
                                <label for="total">Total en quetzales</label>
                                <input type="text" value="{{ $cotizacion[0]->total}}" readonly class="form-control" id="total" placeholder="Total:" name="total" >
                            </div>
                        </div>
                  
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('cotizaciones.index') }}">Regresar</a>
                            <button class="btn btn-success form-button"  id="actualizar">Actualizar</button>
                        </div>          
                    </div>
                    </div>
                </div>                
    </form>
<div class="loader loader-bar"></div> 

@endsection


@push('styles')

@endpush


@push('scripts')
<script>
    $(document).ready(function() {
           $('.loader').fadeOut(225);
           $('#bienActualizar').val('');
      if (window.location.href.indexOf("ajaxSuccess") > -1) {
            alertify.set('notifier','position', 'top-center');
            alertify.success('El detalle fue eliminado correctamente!!');
          //  window.history.replaceState({}, document.title, "/");
    }

    ///

    ///
    $('#codigo').val('');
    $('#producto').val('');
    $('#cantidad').val('');
    $('#precio').val('');
    $('#subtotal').val('');
    $('#bienActualizar').val('');

$.validator.addMethod("onlyInteger", function(value) {
     var regX = /^\d+$/;  
    if(regX.test(value.trim()) == false) 
    {
      $(this).val('');
      return false;
    } else {
        return true;
    }
});

var validator = $("#cotizacionUpdateForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    rules: {
        fecha: {
            required: true,
        },
        precio: {
            number: true,
        },

        cantidad: {
            number: true,
            onlyInteger: true,
        }
    },
    messages: {
        fecha: {
            required: "Por favor, ingrese la fecha de la cotización",
        },
        precio: {
            number: 'Ingrese solo formato número'
        },
        cantidad: {
            number: 'Ingrese formato número',
            onlyInteger:'Debes agregar solo números enteros'
        }
    }
});


//Obtener los detalles ya existentes de la cotización
$.getJSON('/cotizaciones/getWeakJson/' + $('#id').val(), function (data) { 
    $.each(data.data, function () {
        
        if(this.isProduct == 1) {
            detalleCotizacionTable.row.add({
                'id': this.id,
                'producto': this.producto.nombre,
                'cantidad': this.cantidad,
                'precio': this.precio,
                'subtotal': this.subtotal,
            }).draw(false);
        } else {
            detalleCotizacionTable.row.add({
                'id': this.id,
                'producto': this.servicio.nombre,
                'cantidad': this.cantidad,
                'precio': this.precio,
                'subtotal': this.subtotal,
            }).draw(false);
        }
        });

         
    });

//Agregar un producto
        $('#add').on('click', function() {
            //Validacion para producto
            $('#producto').rules('add', {
                required: true,
                messages: {
                    required: 'Ingrese el producto/Servicio'
                }
            });

            //Validacion para cantidad
            $('#cantidad').rules('add', {
                required: true,
                messages: {
                    required: 'ingrese la cantidad'
                }
            });

            //Validacion para precio
            $('#precio').rules('add', {
                required: true,
                messages: {
                    required: 'Por favor, ingrese el precio'
                }
            });
           if($('#producto').valid() && $('#cantidad').valid() && $('#precio').valid() && $('#subtotal').valid()) {
                $('.notif').html('');
                detalleCotizacionTable.row.add({
                'id': $('#bienActualizar').val(),
                'producto': $('#producto').val(),
                'cantidad': $('#cantidad').val(),
                'precio': $('#precio').val(),
                'subtotal': $('#subtotal').val(),
            }).draw(false);
            $('#codigo').val('');
            $('#producto').val('');
            $('#cantidad').val('');
            $('#precio').val('');
            $('#subtotal').val('');
            $('#bienActualizar').val('');
            $('#mensajeActualizar').remove();
            var subtotales = [];
            var total;
            $.each(detalleCotizacionTable.rows().data(), function() {
                  subtotales.push(parseFloat(this.subtotal));
                });
                total = subtotales.reduce(function(a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
            $('#total').val(total);
           }
        });
    });
</script>
<script>
     var bienes = [];
      //Editar bien
    $('#detalle-cotizacion-table').on('click', '.edit-bien', function(e) {
      e.preventDefault(); // does not go through with the link.
      var $this = $(this);
      var id = detalleCotizacionTable.row($this.parents('tr')).data().id; 
      var nombreBien = detalleCotizacionTable.row($this.parents('tr')).data().producto;
          //Condicion para saber si el dato ya esta ingresado o no, posteriormente
          //Decidir de que manera se eliminara
         if($('#producto').val() != '') {
            $('#componenteP').append("<label class='error' for='producto'>Antes debes actualizar el detalle</label>");
         } else {
              if(id == '') {
              //Pasar datos arriba, para editar
                $('#producto').val(detalleCotizacionTable.row($this.parents('tr')).data().producto);
                $('#cantidad').val(detalleCotizacionTable.row($this.parents('tr')).data().cantidad);
                $('#precio').val(detalleCotizacionTable.row($this.parents('tr')).data().precio);
                $('#subtotal').val(detalleCotizacionTable.row($this.parents('tr')).data().subtotal);
                $('#bienActualizar').val('no');
                //Eliminado en el frontend
                detalleCotizacionTable.row($this.parents('tr')).remove().draw();  
                var subtotales = [];
                var total;
                $.each(detalleCotizacionTable.rows().data(), function() {
                    subtotales.push(parseFloat(this.subtotal));
                    });
                    total = subtotales.reduce(function(a, b) {
                    return parseFloat(a) + parseFloat(b);
                    }, 0);
                    $('#total').val(total);
            
          } else {
              //Pasar datos arriba, para editar
                $('#producto').val(detalleCotizacionTable.row($this.parents('tr')).data().producto);
                $('#cantidad').val(detalleCotizacionTable.row($this.parents('tr')).data().cantidad);
                $('#precio').val(detalleCotizacionTable.row($this.parents('tr')).data().precio);
                $('#subtotal').val(detalleCotizacionTable.row($this.parents('tr')).data().subtotal);
                $('#bienActualizar').val(detalleCotizacionTable.row($this.parents('tr')).data().id);
               //Se toma el nombre y se busca en el controller para eliminar hasta al momento 
              //de actualizar
              //bienesEliminados.push(nombreBien);
               detalleCotizacionTable.row($this.parents('tr')).remove().draw();  
                var subtotales = [];
                var total;
                $.each(detalleCotizacionTable.rows().data(), function() {
                    subtotales.push(parseFloat(this.subtotal));
                    });
                    total = subtotales.reduce(function(a, b) {
                    return parseFloat(a) + parseFloat(b);
                    }, 0);
                    $('#total').val(total);
          }
         }
        
        });

    var bienesEliminados = [];
    //Eliminar bien
    $('#detalle-cotizacion-table').on('click', '.remove-bien', function(e) {
      e.preventDefault(); // does not go through with the link.
      var $this = $(this);
      var id = detalleCotizacionTable.row($this.parents('tr')).data().id;
      var nombreBien = detalleCotizacionTable.row($this.parents('tr')).data().producto;
      
      alertify.confirm('Eliminar producto/servicio', 'Esta seguro de eliminarlo', 
      function(){
          //Condicion para saber si el dato ya esta ingresado o no, posteriormente
          //Decidir de que manera se eliminara
          if(id == null) {
                detalleCotizacionTable.row($this.parents('tr')).remove().draw();  
                var subtotales = [];
                var total;
                $.each(detalleCotizacionTable.rows().data(), function() {
                    subtotales.push(parseFloat(this.subtotal));
                    });
                    total = subtotales.reduce(function(a, b) {
                    return parseFloat(a) + parseFloat(b);
                    }, 0);
                    $('#total').val(total);
            
          } else {
              //Se toma el nombre y se busca en el controller para eliminar hasta al momento 
              //de actualizar
              
              bienesEliminados.push(nombreBien);
               detalleCotizacionTable.row($this.parents('tr')).remove().draw();  
                var subtotales = [];
                var total;
                $.each(detalleCotizacionTable.rows().data(), function() {
                    subtotales.push(parseFloat(this.subtotal));
                    });
                    total = subtotales.reduce(function(a, b) {
                    return parseFloat(a) + parseFloat(b);
                    }, 0);
                    $('#total').val(total);
          }
        },
          function() {
               alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
          }
        );   
    });
  </script>
 <script src="{{asset('js/cotizaciones/edit.js')}}"></script>
@endpush