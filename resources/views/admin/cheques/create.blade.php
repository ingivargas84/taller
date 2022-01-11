@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          CHEQUES
          <small>Crear Cheque</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('cheques.index')}}"><i class="fa fa-list"></i> Cheques</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ChequeForm"  action="{{route('cheques.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4" style="height: 90px">
                                <label for="fecha">Fecha</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha" type="text" class="form-control pull-right" id="fecha" autocomplete="off">
                                </div>
                                {{--  --}}
                            </div>
                             <div class="col-sm-4" style="height: 90px">
                                <label for="cuenta_bancaria_id">Cuenta Bancaria</label>
                                <select  class="form-control" name="cuenta_bancaria_id" id="cuenta_bancaria_id">
                                    <option value="0">--Seleccione la cuenta bancaria--</option>
                                     @foreach($cuentas as $c)
                                        <option value="{{ $c->id }}">{{ $c->nombre_cuenta }}, {{ $c->no_cuenta }} - {{ $c->banco->banco }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="cuentaId" id="cuentaId">
                            </div>
                            <div class="col-sm-4" style="height: 90px">
                                <label for="no_cheque">No. Cheque:</label>
                                <input type="text" class="form-control" placeholder="No. Cheque:" id="no_cheque" name="no_cheque" >
                            </div>
                        </div>
                        
                         <div class="row">
                          <div class="col-sm-4" style="height: 90px">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="form-control" placeholder="Cantidad:" id="cantidad" name="cantidad" >
                            </div>
                            <div class="col-sm-4" style="height: 90px">
                                <label for="desc">Descripción</label>
                                <input type="text" class="form-control" placeholder="Descripción..." id="desc" name="desc">
                            </div>
                            <div class="col-sm-4" style="height: 90px"> 
                                <label for="receptor">Receptor:</label>
                                <input type="text" class="form-control" placeholder="Receptor:" id="receptor" name="receptor" >
                            </div>
                        </div>
                         <div class="row">
                          <div class="col-sm-4" style="height: 90px">
                                <label for="ref">Referencia:</label>
                                <input type="text" class="form-control" maxlength="12" placeholder="Referencia:" id="ref" name="ref" >
                            </div>
                            <div class="col-sm-4" style="height: 90px">
                                <label for="persona_acepta">Persona que acepta:</label>
                                <input type="text" class="form-control" placeholder="Persona..." id="persona_acepta" name="persona_acepta" >
                            </div>
                            
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('cheques.index') }}">Regresar</a>
                            <button type="submit" class="btn btn-success form-button" id="ButtonCheque">Guardar</button>
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
<script src="{{asset('js/cheques/create.js')}}"></script>
@endpush