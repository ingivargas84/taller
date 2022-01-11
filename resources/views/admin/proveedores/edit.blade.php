@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          PROVEEDORES
          <small>Editar Proveedor</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('proveedores.index')}}"><i class="fa fa-list"></i> Proveedores</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ProveedorUpdateForm"  action="{{route('proveedores.update', $proveedor)}}">
            {{csrf_field()}} {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4 {{$errors->has('nit')? 'has-error' : ''}}">
                                <label for="nit">Nit:</label>
                                <input type="text" class="form-control" placeholder="Nit:" name="nit" value="{{old('nit', $proveedor->nit)}}" >
                                {!!$errors->first('nit', '<label class="error">:message</label>')!!}
                            </div>
                            <div class="col-sm-4">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Teléfono:" name="telefono" value="{{old('telefono', $proveedor->telefono)}}" >
                            </div>
                            <div class="col-sm-4">
                                <label for="celular">Email:</label>
                                <input type="text" class="form-control" placeholder="Email:" name="email" value="{{old('email', $proveedor->email)}}">
                            </div> 
                        </div>
                        <br>                
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombre_legal">Nombre Legal:</label>
                                <input type="text" class="form-control" placeholder="Nombre Legal:" name="nombre_legal" value="{{old('nombre_legal', $proveedor->nombre_legal)}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="nombre_comercial">Nombre Comercial:</label>
                                <input type="text" class="form-control" placeholder="Nombre Comercial:" name="nombre_comercial" value="{{old('nombre_comercial', $proveedor->nombre_comercial)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="direccion">Direcciónn:</label>
                                <input type="text" class="form-control" placeholder="Direcciónn:" name="direccion" value="{{old('direccion', $proveedor->direccion)}}">
                            </div>                                
                        </div>
                        <br>
                <div class="row">
                    <h4>Contacto No 1</h4>
                    <div class="col-sm-4">
                        <label for="nombre_contacto1">Nombre:</label>
                        <input type="text" class="form-control" placeholder="Nombre Contacto 1:" name="nombre_contacto1" value="{{old('nombre_contacto1', $proveedor->nombre_contacto1)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="puesto_contacto1">Puesto:</label>
                        <input type="text" class="form-control" placeholder="Puesto Contacto 1:" name="puesto_contacto1" value="{{old('puesto_contacto1', $proveedor->puesto_contacto1)}}">
                    </div>
                    <div class="col-sm-2">
                        <label for="telefono_contacto1">Telefono:</label>
                        <input type="text" class="form-control" placeholder="Tel Contacto 1:" name="telefono_contacto1" value="{{old('telefono_contacto1', $proveedor->telefono_contacto1)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="correo_contacto1">Correo:</label>
                        <input type="text" class="form-control" placeholder="Correo Contacto 1:" name="correo_contacto1" value="{{old('correo_contacto1', $proveedor->correo_contacto1)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <h4>Contacto No 2</h4>
                    <div class="col-sm-4">
                        <label for="nombre_contacto2">Nombre:</label>
                        <input type="text" class="form-control" placeholder="Nombre Contacto 2:" name="nombre_contacto2" value="{{old('nombre_contacto2', $proveedor->nombre_contacto2)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="puesto_contacto2">Puesto:</label>
                        <input type="text" class="form-control" placeholder="Puesto Contacto 2:" name="puesto_contacto2" value="{{old('puesto_contacto2', $proveedor->puesto_contacto2)}}">
                    </div>
                    <div class="col-sm-2">
                        <label for="telefono_contacto2">Telefono:</label>
                        <input type="text" class="form-control" placeholder="Tel Contacto 2:" name="telefono_contacto2" value="{{old('telefono_contacto2', $proveedor->telefono_contacto2)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="correo_contacto2">Correo:</label>
                        <input type="text" class="form-control" placeholder="Correo Contacto 2:" name="correo_contacto2" value="{{old('correo_contacto2', $proveedor->correo_contacto2)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                            <div class="col-sm-12">
                                <label for="observaciones">Observaciones:</label>
                                <input type="text" class="form-control" placeholder="Observaciones:" name="observaciones" value="{{old('observaciones', $proveedor->observaciones)}}" >
                            </div>                                
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('proveedores.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonProveedorUpdate">Guardar</button>
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

<script src="{{asset('js/proveedores/edit.js')}}"></script>
@endpush