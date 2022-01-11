@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
  <h1>
    Cuenta por Cobrar, Cliente {{ $cuenta[0]->cliente->nombre_comercial }}
    <small>Todos los detalles</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('cobrar.index')}}">Cuentas por Cobrar</a></li>
    <li class="active">Detalle</li>
  </ol>
</section>

@endsection
@section('content')
@include('admin.cuentaCobrar.createAbonoModal')

<div class="loader loader-bar is-active">

</div>
<div class="box">
  <!-- /.box-header -->
  <div class="box-header">
    <a class="btn btn-primary pull-right"  data-toggle="modal" data-target="#abonoModal">
      <i class="fa fa-plus"></i>Abonar</a>
  </div>
    <div class="box-body">
      <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
      <input type="hidden" name="clienteID" value='{{ $cuenta[0]->cliente->id }}'>
      <table id="cuenta-detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
      </table>
      <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
      <input type="hidden" id="id" name="id" value="{{ $cuenta[0]->id}}">
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
      cuentaDetalleTable.ajax.reload();
    });
  </script>
  <script src="{{asset('js/cuentaCobrar/show.js')}}"></script>
  <script src="{{asset('js/cuentaCobrar/createAbono.js')}}"></script>
  @endpush