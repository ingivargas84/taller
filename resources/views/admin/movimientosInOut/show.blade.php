@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        MOVIMIENTOS NO. {{ $caja->id }}
      <small>Entradas y salidas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Movimientos de hoy</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
  <div class="box-header">
    <a href="{{route('movimientos.previous')}}" class="btn btn-primary pull-left">Movimientos Anteriores</a>
  </a>
  <span style="margin-left: 27%; font-size: 20px"><b>Cerrada con:</b> {{ $caja->saldo }}</span>
  <div class="pull-right">
    <span style="font-size: 20px">{{date('d', strtotime($caja->fecha ))}} de {{ $monthName }} del {{ date('Y', strtotime($caja->fecha ))}}</span>
  </div>

    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="show-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
        <input type="hidden" name="idCaja" id="idCaja" value="{{ $caja->id }}"> 
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
   
 });
</script>
<script src="{{asset('js/movimientosInOut/show.js')}}"></script>

@endpush