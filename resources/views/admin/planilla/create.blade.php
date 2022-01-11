@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          PLANILLAS
          <small>Crear Planilla</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('planilla.index')}}"><i class="fa fa-list"></i> Planillas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
@include('admin.planilla.calculoModal')
<div class="loader loader-bar is-active"></div>
<form id="planillaForm">
    <div class="notif">
    </div>
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <input type="hidden" id='cantM'>
            <input type="hidden" id='idtd'>
        
            <div class="box-body" style="-webkit-box-shadow: -1px 4px 19px -13px rgba(3,29,43,1);
-moz-box-shadow: -1px 4px 19px -13px rgba(3,29,43,1);
box-shadow: -1px 4px 19px -13px rgba(3,29,43,1);">
                        <div class="row" style="height: 70px">
                            <div class="col-sm-12">
                                <label>Título:</label>
                                <input name="titulo" id="titulo" type="text" class="form-control">
                            </div>
                        </div>
                        <br>
                        <br>
                        <label>Planilla:</label>
                        <div class="table-responsive">

                            <table id="planilla-create" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
                                <thead>
                                <tr id='header'>
                                    
                                </tr>
                            </thead>
                            <tbody id="datos">
                                
                            </tbody>
                        </table>
                    </div>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-5">
                                <label for="total">Total en quetzales</label>
                                <input type="text" readonly class="form-control" id="resultado" placeholder="Total:" name="resultado" >
                            </div>
                        </div>
                  
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('planilla.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="guardar">Guardar</button>
                        </div>          
                    </div>  
                    </div>
                </div>   
                <input type="hidden" name="_token" id="tokenPlanilla" value="{{ csrf_token() }}">
             
    </form>
<div class="loader loader-bar"></div> 

@endsection


@push('styles')
@endpush
@push('scripts')
<script>
    $(document).ready(function () {
        $('.loader').fadeOut(225);
        getHeader();
        getMovs();
        
    });
</script>
<script src="{{asset('js/planilla/create.js')}}"></script>
 @endpush