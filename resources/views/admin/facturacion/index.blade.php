@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Facturas
      <small>Facturas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Facturas</li>
    </ol>
  </section>
@endsection

@section('content')
@include('admin.facturacion.createFactura')
@include('admin.facturacion.razonModal')
  <div class="loader loader-bar is-active"></div>
  <div class="box">
      <div class="box-header">
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#facturaModal">
          <i class="fa fa-plus"></i>Agregar Factura</a>
        </button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="factura-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
          </table>
          <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
      </div>
      <!-- /.box-body -->
  </div>
@endsection

@push('styles')
@endpush

@push('scripts')
 <script>
        $(document).ready(function() {
            $('.loader').fadeOut(255);
        });
        $(document).ready(function() {
          facturaTable.ajax.reload();
      });
  </script>

<script src="{{asset('js/facturacion/index.js')}}"></script>
<script src="{{asset('js/facturacion/create.js')}}"></script>
<script src="{{asset('js/facturacion/razon.js')}}"></script>

@endpush