@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          PRODUCTOS
          <small>Crear producto</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('productos.index')}}"><i class="fa fa-list"></i> Productos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="productoForm"  action="{{route('productos.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6" style="height: 90px">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código:" name="codigo" >
                            </div>
                            <div class="col-sm-6" style="height: 90px">
                                <label for="producto">Producto:</label>
                                <input type="text" class="form-control" placeholder="Producto:" name="producto" >
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-sm-12" style="height: 70px">
                                <label for="observaciones">Observaciones:</label>
                                <input type="text" class="form-control" placeholder="Observaciones:" name="observaciones" >
                            </div>
                        </div>
                        <br>                
                        <div class="row">
                            <div class="col-sm-4" style="height: 70px">
                                <label for="stock_minimo">Stock Mínimo:</label>
                                <input type="number" class="form-control" placeholder="Stock mínimo:" id="stock_minimo" name="stock_minimo" >
                            </div>
                            <div class="col-sm-4" style="height: 70px">
                                <label for="stock_maximo">Stock Máximo:</label>
                                <input type="number" class="form-control" placeholder="Stock máximo:" id="stock_maximo" name="stock_maximo">
                            </div>
                            <div class="col-sm-4" style="height: 70px">
                                <label for="precio_venta">Precio de venta:</label>
                                <input type="number" class="form-control" placeholder="Precio de venta:" name="precio_venta">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('productos.index') }}">Regresar</a>
                            <button type="submit" class="btn btn-success form-button" id="productoButton">Guardar</button>
                        </div>
                                    
                    </div>
                </div>                
            </div>
    </form>
    <div class="loader loader-bar"></div> 

@stop


@push('styles')

@endpush


@push('scripts')
<script src="{{asset('js/productos/create.js')}}"></script>
@endpush