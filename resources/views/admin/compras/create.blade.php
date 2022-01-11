@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          COMPRAS
          <small>Crear compra</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('compras.index')}}"><i class="fa fa-list"></i> Compras</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')

    <form id="compraForm">
<div class="notif">
</div>
    {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
             
                    <div class="box-body" style="border: #87ace8 solid 1px;">
                        <div class="row" style="height: 70px">
                        <div class="col-sm-4">
                                <label>Proveedor:</label>
                                <select class="form-control" name="proveedor" id="proveedor">
                                    <option value="lala" default>--Seleccione el proveedor--</option>
                                </select>
                                <!--<input type="text" class="form-control" placeholder="Proveedor:" name="proveedor" >-->
                            </div>
                            <div class="col-sm-4" style="height: 90px">
                                <label for="fecha_compra">Fecha Compra</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha_compra" type="text" class="form-control pull-right" autocomplete="off" id="fecha_compra">
                                </div>
                                {{--  --}}
                            </div>
                            <div class="col-sm-4" style="height: 90px">
                                <label for="fecha_factura">Fecha Factura</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha_factura" type="text" class="form-control pull-right" autocomplete="off" id="fecha_factura">
                                </div>
                                {{--  --}}
                            </div>
                        </div>
                            <br>  
                        <div class="row" style="height: 90px">
                            
                            <div class="col-sm-4">
                                <label for="serie">Serie factura:</label>
                                <input type="text" class="form-control" placeholder="Serie:" name="serie" >
                            </div>
                            <div class="col-sm-4">
                                <label for="no_factura">No. Factura:</label>
                                <input type="text" class="form-control" placeholder="No.Factura:" name="no_factura" >
                            </div>
                        </div>
                        <hr>
                        <div class="row" style='height: 50px'>
                        <div class="col-sm-3">
                                <label for="codigo">Código del producto:</label>
                                <input type="text" class="form-control" id="codigo" name="codigo">
                            </div>
                             <div class="col-sm-3">
                                <label for="cantidad">Producto:</label>
                                <input type="text" class="form-control" readonly class="form-control" id="producto" placeholder="Producto:" name="producto" >
                             </div>
                            <div class="col-sm-2">
                                <label for="cantidad">Cantidad:</label>
                                <input type="text" class="form-control" placeholder="Cantidad:" id="cantidad" name="cantidad" >
                            </div>
                             <div class="col-sm-3">
                                <label for="precio_compra">Precio de compra:</label>
                                <input type="text" class="form-control" placeholder="Precio compra:" id="precio_compra" name="precio_compra" >
                            </div>
                            <div style="margin-top: 25px">
                                <button id="add" class='btn btn-warning btn-sm'><i class='fas fa-plus'></i></button>
                            </div>
                        </div>
                        <hr>
                        <table id="productos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
                        </table>
                        <hr>
                       
                        <div class="row">
                         <div class="col-sm-5">
                                <label for="total">Total en quetzales</label>
                                <input type="text" readonly class="form-control" id="total" placeholder="Total:" name="total" >
                            </div>
                        </div>
                  
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('compras.index') }}">Regresar</a>
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
          "Seleccione un proveedor"
        );


var validator = $("#compraForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    rules: {
        fecha_compra: {
            required: true,
        },
        proveedor: {
            required: true,
            notEqualTo: 'lala',
        },
        fecha_factura: {
            required: true,
        },
        serie: {
            required: true,
        }, 
        no_factura: {
            required: true, 
        }
    },
    messages: {
        fecha_compra: {
            required: "Por favor, ingrese la fecha de compra",
        },
        fecha_factura: {
            required: "Por favor, ingrese la fecha de factura",
        },
        serie: {
            required: "Por favor, ingrese la serie de factura",
        }, 
        no_factura: {
            required: "Por favor, ingrese el no. de factura",
        },
    }
});
//validar proveedor
            $('#proveedor').change(function() {
                validator.element('#proveedor');
            });

//Agregar un producto
        $('#add').on('click', function() {
            //Validacion para producto
            $('#producto').rules('add', {
                required: true,
                messages: {
                    required: 'Por favor, ingrese el producto'
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
            $('#precio_compra').rules('add', {
                required: true,
                messages: {
                    required: 'Por favor, ingrese el precio de compra'
                }
            });
           if($('#producto').valid() && $('#cantidad').valid() && $('#precio_compra').valid()) {
                $('.notif').html('');
            productosTable.row.add({
                'producto': $('#producto').val(),
                'cantidad': $('#cantidad').val(),
                'precio_compra': $('#precio_compra').val(),
                'subtotal': parseFloat($('#cantidad').val()) * parseFloat( $('#precio_compra').val()),
            }).draw(false);
            $('#codigo').val('');
            $('#producto').val('');
            $('#cantidad').val('');
            $('#precio_compra').val('');
            var subtotales = [];
            var total;
            $.each(productosTable.rows().data(), function() {
                  subtotales.push(this.subtotal);
                });
                total = subtotales.reduce(function(a, b) {
                    return a + b;
                }, 0);
            $('#total').val(total);
           }
        });
    });
</script>
<script>
    //Eliminar producto
    $('#productos-table').on('click', '.remove-producto', function(e) {
      e.preventDefault(); // does not go through with the link.
      var $this = $(this);
      console.log(productosTable.row($this));
      alertify.confirm('Eliminar producto', 'Esta seguro de eliminar el producto', 
      function(){
          //obtener el
          //restar total
          //var resultado = parseFloat($('#total').val()) - parseFloat(productosTable.rows({ selected: true }).data().subtotal);
          //$('#total').val(resultado);  
         
          productosTable.row($this.parents('tr')).remove().draw();  

           var subtotales = [];
            var total;
            $.each(productosTable.rows().data(), function() {
                  subtotales.push(this.subtotal);
                });
                total = subtotales.reduce(function(a, b) {
                    return a + b;
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
<script src="{{asset('js/compras/create.js')}}"></script>
@endpush