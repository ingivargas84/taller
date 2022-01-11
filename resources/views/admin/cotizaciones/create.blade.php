@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          COTIZACIONES
          <small>Crear cotización</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('cotizaciones.index')}}"><i class="fa fa-list"></i> Cotizaciones</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')

<form id="cotizacionForm">
    <div class="notif">
    </div>
    {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
             
                    <div class="box-body" style="-webkit-box-shadow: -1px 4px 19px -13px rgba(3,29,43,1);
-moz-box-shadow: -1px 4px 19px -13px rgba(3,29,43,1);
box-shadow: -1px 4px 19px -13px rgba(3,29,43,1);">
                        <div class="row" style="height: 70px">
                        <div class="col-sm-6">
                                <label>Cliente:</label>
                                <select class="form-control" name="cliente" id="cliente">
                                    <option value="lala" default>--Seleccione el cliente--</option>
                                </select>
                        </div>
                        <div class="col-sm-6" style="height: 90px">
                                <label for="fecha">Fecha</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha" type="text" class="form-control pull-right" id="fecha" autocomplete="off">
                                </div>
                                {{--  --}}
                            </div>
                        </div>
                            <br>  
                        <div class="row" style="height: 90px">
                            
                            <div class="col-sm-3">
                                <label for="nombre">Nombre del Cliente:</label>
                                <input tabindex='-1' type="text" readonly class="form-control" id="nombre" placeholder="Nombre del cliente:" name="nombre" >
                            </div>
                            <div class="col-sm-3">
                                <label for="direccion">Dirección:</label>
                                <input tabindex='-1' type="text" readonly class="form-control" id="direccion" placeholder="Dirección:" name="direccion" >
                            </div>
                             <div class="col-sm-3">
                                <label for="contacto">Contacto:</label>
                                <input tabindex='-1' type="text" readonly class="form-control" id="contacto" placeholder="Contacto:" name="contacto" >
                            </div>
                            <div class="col-sm-3">
                                <label for="telefono">Telefono:</label>
                                <input tabindex='-1' type="text" readonly class="form-control" id="telefono" placeholder="No.Telefono:" name="telefono" >
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
                             <div class="col-sm-3">
                                <label for="producto">Producto / Servicio:</label>
                                <input type="text" class="form-control" readonly class="form-control" id="producto" placeholder="Producto / Servicio:" name="producto" >
                             </div>
                            <div class="col-sm-3">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="form-control" min="1" placeholder="Cantidad:" id="cantidad" name="cantidad" >
                            </div>
                            <div class="col-sm-3">
                                <label for="precio">Precio:</label>
                                <input type="text" class="form-control" placeholder="Precio:" id="precio" name="precio" >
                            </div>
                            <div class="col-sm-2">
                                <label for="subtotal">Subtotal:</label>
                                <input type="text" class="form-control" readonly placeholder="Subtotal:" id="subtotal" name="subtotal" >
                            </div>
                            <div class="col-sm-1"  style="margin-top: 25px">
                                <span id="add" tabindex="0" class='btn btn-warning btn-sm'><i class='fas fa-plus'></i></span>
                            </div>
                        </div>
                        <br>
                        <hr>
                       
                        <table id="bienCotizado-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
                        </table>
                        <hr>
                       
                        <div class="row">
                            <div class="col-sm-5">
                                <label for="total">Total en quetzales</label>
                                <input type="text" readonly class="form-control" id="total" placeholder="Total:" name="total" >
                            </div>
                        </div>
                  
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('cotizaciones.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="guardar">Guardar</button>
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
        //validation

jQuery.validator.addMethod(
          "notEqualTo",
          function(elementValue,element,param) {
            return elementValue != param;
          },
          "Seleccione un cliente"
        );

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

var validator = $("#cotizacionForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    rules: {
        fecha: {
            required: true,
        },
        cliente: {
            required: true,
            notEqualTo: 'lala',
        },
        precio: {
            number: true,
        },

        cantidad: {
            number: true,
            onlyInteger: true,
        }, 
    },
    messages: {
        fecha: {
            required: "Por favor, ingrese la fecha de la cotización",
        },
        cliente: {
            required: "Por favor, seleccione un cliente"
        },
        precio: {
            number: 'Ingrese solo formato número'
        },
        cantidad: {
            number: 'Ingrese formato número',
            onlyInteger: 'Ingrese solo numeros enteros'
        }
    }
});
//validar cliente
            $('#cliente').change(function() {
                validator.element('#cliente');
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
                bienCotizadoTable.row.add({
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
            var subtotales = [];
            var total;
            $.each(bienCotizadoTable.rows().data(), function() {
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
    //Eliminar bien
    $('#bienCotizado-table').on('click', '.remove-bien', function(e) {
      e.preventDefault(); // does not go through with the link.
      var $this = $(this);
      alertify.confirm('Eliminar producto/servicio', 'Esta seguro de eliminarlo', 
      function(){
          bienCotizadoTable.row($this.parents('tr')).remove().draw();  
           var subtotales = [];
            var total;
            $.each(bienCotizadoTable.rows().data(), function() {
                  subtotales.push(parseFloat(this.subtotal));
                });
                total = subtotales.reduce(function(a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
                $('#total').val(total);
        },
          function() {
               alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
          }
        );   
    });
  </script>
 <script src="{{asset('js/cotizaciones/create.js')}}"></script>
@endpush