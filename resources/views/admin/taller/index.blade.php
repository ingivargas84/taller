@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Listado de Ordenes de Trabajo en Taller
        <small>Ordenes en Taller</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
        <li class="active">Ordenes en Taller</li>
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
        <table id="orden-taller-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
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
        ordenTaller.ajax.url("{{route('taller.getJson')}}").load();
    });
</script>

<script src="{{asset('js/taller/index.js')}}"></script>

@endpush