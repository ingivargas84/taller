@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Listado de Ordenes de Trabajo con Asesor
        <small>Ordenes con Asesor</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
        <li class="active">Ordenes con Asesor</li>
    </ol>
</section>
@endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
        
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="orden-asesor-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
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
        $('.loader').fadeOut(225);
    });
    $(document).ready(function() {
        ordenAsesor.ajax.url("{{route('asesor.getJson')}}").load();
    });
</script>

<script src="{{asset('js/asesor/index.js')}}"></script>

@endpush