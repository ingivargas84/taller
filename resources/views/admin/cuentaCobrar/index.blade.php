@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Cuentas por Cobrar
      <small>Todos las cuentas por cobrar</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Cuentas por Cobrar</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="cuentas-cobrar-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection


@push('styles')
 
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
      cuentasCobrarTable.ajax.url("{{route('cobrar.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/cuentaCobrar/index.js')}}"></script>
@endpush