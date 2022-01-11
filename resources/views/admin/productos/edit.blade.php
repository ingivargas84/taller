@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          PRODUCTOS
          <small>Editar Producto</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('productos.index')}}"><i class="fa fa-list"></i> Productos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form action="{{ route('productos.update', $producto) }}" id="productoUpdateForm" method="post">
        {{ csrf_field() }}  {{ method_field('PUT') }}
        <div class="col-md-12">
            <div class="box-body">
                <div class="row">
                            <div class="col-sm-6" style="height: 90px">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código:" name="codigo" value=' {{ $producto->codigo}}'>
                                <input type="hidden" name='id' value=" {{ $producto->id }}">
                            </div>
                            <div class="col-sm-6" style="height: 90px">
                                <label for="producto">Producto:</label>
                                <input type="text" class="form-control" placeholder="Producto:" name="producto" value=' {{ $producto->nombre }}'>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-sm-12" style="height: 70px">
                                <label for="observaciones">Observaciones:</label>
                                <input type="text" class="form-control" placeholder="Observaciones:" name="observaciones" value=' {{ $producto->observaciones }}'>
                            </div>
                        </div>
                        <br>                
                        <div class="row">
                            <div class="col-sm-4" style="height: 70px">
                                <label for="stock_minimo">Stock Mínimo:</label>
                                <input type="text" class="form-control" placeholder="Stock mínimo:" name="stock_minimo" value=' {{ $producto->estado_id }}'>
                            </div>
                            <div class="col-sm-4" style="height: 70px">
                                <label for="stock_maximo">Stock Máximo:</label>
                                <input type="text" class="form-control" placeholder="Stock máximo:" name="stock_maximo" value=' {{ $producto->stock_maximo }}'>
                            </div>
                            <div class="col-sm-4" style="height: 70px">
                                <label for="precio_venta">Precio de venta:</label>
                                <input type="text" class="form-control" placeholder="Precio de venta:" name="precio_venta" value=' {{ $producto->precio_venta }}'>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('productos.index') }}">Regresar</a>
                            <button type="submit" class="btn btn-success form-button" id="productoUpdateButton">Guardar</button>
                        </div>
            </div>
        </div>
    </form>
    <div class="loader loader-bar"></div>
@stop

@push('styles')

@endpush

@push('scripts')

<script src="{{ asset('js/productos/edit.js') }}"></script>

@endpush