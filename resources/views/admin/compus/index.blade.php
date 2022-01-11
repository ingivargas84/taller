@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
  <h1>
    Listado de Computadoras
    <small>Todas las computadoras</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Computadoras</li>
  </ol>
</section>
@endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
  <div class="box-header">
    <a class="btn btn-primary pull-right" href="{{route('compus.newingreso')}}">
      <i class="fa fa-plus"></i>Registrar Ingreso</a>
    <a class="btn btn-success pull-right" href="{{route('compus.newsalida')}}">
      <i class="fa fa-minus"></i>Registrar Salida</a>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
    <table id="compus-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
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
    compus_table.ajax.url("{{route('compus.getJson')}}").load();
  });
</script>

<script src="{{asset('js/compus/index.js')}}"></script>
@endpush