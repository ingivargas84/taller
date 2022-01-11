@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          VENDEDORES
          <small>Editar Vendedor</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('vendedores.index')}}"><i class="fa fa-list"></i> Vendedores</a></li>
          <li class="active">Editar</li>
        </ol>
    </section>
@stop

@section('content')
    <form action="{{ route('vendedores.update', $vendedor) }}" id="VendedorUpdateForm" method="post">
        {{ csrf_field() }}  {{ method_field('PUT') }}
        <div class="col-md-12">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6" style="height: 75px">
                                <label for="nombres">Nombres:</label>
                                <input type="text" class="form-control" placeholder="Nombres:" name="nombres" value="{{ $vendedor->nombres }}">
                            </div>
                            <div class="col-sm-6" style="height: 75px">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" placeholder="Apellidos:" name="apellidos" value="{{ $vendedor->apellidos }}">
                    </div>
                </div>
                <br>
                <div class="row">
                     <div class="col-sm-4 {{$errors->has('nit')? 'has-error' : ''}}" style="height: 80px">
                        <label for="nit">Nit:</label>
                        <input type="text" class="form-control" placeholder="Nit:" name="nit" value="{{old('nit', $vendedor->nit)}}" >
                        {!!$errors->first('nit', '<label class="error">:message</label>')!!}
                    </div>
                    <div class="col-sm-4" style="height: 65px">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" placeholder="Dirección:" name="direccion" value="{{ $vendedor->direccion }}">
                    </div>
                    <div class="col-sm-4" style="height: 65px">
                        <label for="celular">Celular:</label>
                        <input type="text" class="form-control" placeholder="Celular:" name="celular" value="{{ $vendedor->celular }}">
                    </div>
                </div>
                <br>
                    <div class="row">
                        <div class="col-sm-6" style="height: 65px">
                            <label for="correo">Correo:</label>
                            <input type="text" class="form-control" placeholder="Correo:" name="correo" value="{{ $vendedor->correo }}">
                        </div>
                        <div class="col-sm-6" style="height: 65px">
                            <label for="comision">Comisión:</label>
                            <input type="text" class="form-control" placeholder="Comisión:" name="comision" value="{{ $vendedor->comision }}">
                        </div>                                   
                    </div>
                <br>
                <div class="text-right m-t-15">
                    <a href="{{ route('vendedores.index')}}" class="btn btn-primary form-button">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonVendedorUpdate">Guardar</button>
                </div>
            </div>
        </div>
    </form>
    <div class="loader loader-bar"></div>
@stop

@push('styles')

@endpush

@push('scripts')

<script src="{{ asset('js/vendedores/edit.js') }}"></script>

@endpush