@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          CHEQUES
          <small>Editar Cheque</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('cheques.index')}}"><i class="fa fa-list"></i> Cheques</a></li>
          <li class="active">Editar</li>
        </ol>
    </section>
@stop

@section('content')
    <form action="{{ route('cheques.update', $cheque) }}" id="ChequeUpdateForm" method="post">
        {{ csrf_field() }}  {{ method_field('PUT') }}
        <div class="col-md-12">
            <div class="box-body">
               <div class="row">
                            <div class="col-sm-4" style="height: 90px">
                                <label for="fecha">Fecha</label>
                                <input type="date" class="form-control" placeholder="Fecha..." id="fecha" name="fecha" value="{{ $cheque->fecha }}">
                            </div>
                           
                              <div class="col-sm-4" style="height: 90px">
                                <label for="cuenta_bancaria_id">Cuenta Bancaria</label>
                                <select  class="form-control" name="cuenta_bancaria_id" id="cuenta_bancaria_id">
                                    <option value="{{ $cheque->cuentaBancaria->id }}">{{ $cheque->cuentaBancaria->nombre_cuenta }}, {{ $cheque->cuentaBancaria->no_cuenta }}-{{ $cheque->cuentaBancaria->banco->banco }}</option>
                                     @foreach($cuentas as $c)
                                        <option value="{{ $c->id }}">{{ $c->nombre_cuenta }}, {{ $c->no_cuenta }} - {{ $c->banco->banco }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4" style="height: 90px">
                                <label for="no_cheque">No. Cheque:</label>
                                <input type="text" class="form-control" placeholder="No. Cheque:" id="no_cheque" name="no_cheque" value="{{ $cheque->no_cheque }}">
                            </div>
                </div>
                <div class="row">
                     <div class="col-sm-4" style="height: 90px">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="form-control" placeholder="Cantidad:" id="cantidad" name="cantidad" value="{{ $cheque->cantidad }}">
                            </div>
                            <div class="col-sm-4" style="height: 90px">
                                <label for="desc">Descripción</label>
                                <input type="text" class="form-control" placeholder="Descripción..." id="desc" name="desc" value="{{ $cheque->descripcion }}">
                            </div>
                            <div class="col-sm-4" style="height: 90px"> 
                                <label for="receptor">Receptor:</label>
                                <input type="text" class="form-control" placeholder="Receptor:" id="receptor" name="receptor" value="{{ $cheque->receptor }}">
                            </div>
                            <div class="col-sm-4" style="height: 90px">
                                <label for="ref">Referencia:</label>
                                <input type="text" class="form-control" maxlength="12"  placeholder="Referencia:" id="ref" name="ref" value="{{ $cheque->referencia }}">
                            </div>
                            <input type="hidden" name="cuentaId" id="cuentaId">
                            <input type="hidden"  value="{{ $cheque->id }}" name="chequeId" id="chequeId">

                            <div class="col-sm-4" style="height: 90px">
                                <label for="persona_acepta">Persona que acepta:</label>
                                <input type="text" class="form-control" placeholder="Persona..." id="persona_acepta" name="persona_acepta" value="{{ $cheque->persona_acepta }}">
                            </div>
                           
                </div>
                <br>
                <div class="text-right m-t-15">
                    <a href="{{ route('cheques.index')}}" class="btn btn-primary form-button">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonChequeUpdate">Guardar</button>
                </div>
            </div>
        </div>
    </form>
    <div class="loader loader-bar"></div>
@stop

@push('styles')

@endpush

@push('scripts')

<script src="{{ asset('js/cheques/edit.js') }}"></script>

@endpush