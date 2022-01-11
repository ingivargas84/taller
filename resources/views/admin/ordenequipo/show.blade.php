@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Comprobante No. {{ $orden[0]->no_comprobante }}
      <small>Todos los registros</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li><a href="{{route('ordenequipo.index')}}">Ordenes</a></li>
      <li class="active">Detalle</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <input type="hidden" name="id" value='d'>
    <div class="box-header">

      <br>

    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <div id="accordion">
  <div class="card">
    <div class="card-header list-group list-group-flush" id="headingOne">
      <h5 class="mb-0">
        <a role="button" class="list-group-item " data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne">
          Creación de Orden de Trabajo
        </a>
      </h5>
    </div>
    @if($orden[0]->estado_orden_trabajo_id ==1)
    <div id="collapseOne" class="collapse panel-collapse collapse in" aria-labelledby="headingOne" data-parent="#accordion">
    @else
    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
    @endif
      <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><b>No. Comprobante:</b>  {{ $orden[0]->no_comprobante }}</li>
            <li class="list-group-item"><b>Equipo:</b>  {{ $orden[0]->equipo->equipo }}</li>
            <li class="list-group-item"><b>Cliente:</b>  {{ $orden[0]->clientes->nombre_comercial }}</li>
            <li class="list-group-item"><b>Tipo Trabajo:</b>  {{ $orden[0]->tipo_trabajo->nombre }}</li>
            <li class="list-group-item"><b>Observaciones Cliente:</b>  {{ $orden[0]->observaciones }}</li>
            <li class="list-group-item"><b>Usuario creador:</b>  {{ $orden[0]->users->name }}</li>
            <li class="list-group-item"><b>Fecha creación:</b>  {{ $orden[0]->created_at }}</li>
        </ul>
      </div>
    </div>
  </div>

  <br>

  <div class="card">
    <div class="card-header list-group list-group-flush" id="headingTwo">
      <h5 class="mb-0">
        <a role="button" class="list-group-item" data-toggle="collapse" data-target="#collapseTwo" aria-controls="collapseTwo">
          Envío y Recepción de Orden en Taller
        </a>
      </h5>
    </div>
    @if($orden[0]->estado_orden_trabajo_id == 2 || $orden[0]->estado_orden_trabajo_id == 3)
    <div id="collapseTwo" class="collapse panel-collapse collapse in" aria-labelledby="headingTwo" data-parent="#accordion">
    @else
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
    @endif
    <div class="card-body">
        @if($orden[0]->estado_orden_trabajo_id == 2)
        <ul class="list-group">
            <li class="list-group-item"><b>Usuario Envia a Taller:</b>  {{ $enviado[0]->name }}</li>
            <li class="list-group-item"><b>Fecha y Hora Envio a Taller:</b>  {{ $orden[0]->fecha_envia_ataller_p12 }}</li>
        </ul>
        @elseif($orden[0]->estado_orden_trabajo_id >= 3)
        <ul class="list-group">
            <li class="list-group-item"><b>Usuario Envia a Taller:</b>  {{ $enviado[0]->name }}</li>
            <li class="list-group-item"><b>Fecha y Hora Envio a Taller:</b>  {{ $orden[0]->fecha_envia_ataller_p12 }}</li>
            <li class="list-group-item"><b>Usuario Receptor en Taller:</b> {{ $recibido[0]->name }}</li>
            <li class="list-group-item"><b>Fecha y Hora Recibido en Taller:</b>  {{ $orden[0]->fecha_recibe_taller_p23 }}</li>
            <li class="list-group-item"><b>Diagnóstico:</b>  {{ $taller[0]->trabajos_realizados }}</li>
            <li class="list-group-item"><b>Observaciones:</b>  {{ $taller[0]->observaciones }}</li>
            <li class="list-group-item"><b>Usuario que registró diagnóstico preliminar:</b>  {{ $usuarioDiagnostico[0]->name }}</li>
            <li class="list-group-item"><b>Fecha y Hora:</b>  {{ $taller[0]->fecha_reparacion }}</li>
        </ul>
        @else
        <span>Aun falta para este paso</span>
        @endif
      </div>
    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header list-group list-group-flush" id="headingThree">
      <h5 class="mb-0">
        <a role="button" class="list-group-item" data-toggle="collapse" data-target="#collapseThree" aria-controls="collapseThree">
          Registro del Diagnóstico
        </a>
      </h5>
    </div>
    @if($orden[0]->estado_orden_trabajo_id == 4)
        <div id="collapseThree" class="collapse panel-collapse collapse in" aria-labelledby="headingThree" data-parent="#accordion">
    @else
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
    @endif
        <div class="card-body">
        @if($orden[0]->estado_orden_trabajo_id >= 4 )
        <ul class="list-group">
            <li class="list-group-item"><b>Usuario que envia orden a asesor:</b>  {{ $usuarioEnviaAsesor[0]->name }}</li>
            <li class="list-group-item"><b>Fecha y Hora de envio de orden a asesor:</b>  {{ $orden[0]->fecha_envia_asesor_p34 }}</li>
        </ul>
        @else
            <span>Aun falta para este paso</span>
        @endif
      </div>
    </div>
  </div>
  <br>
    <div class="card">
    <div class="card-header list-group list-group-flush" id="headingFour">
      <h5 class="mb-0">
        <a role="button" class="list-group-item" data-toggle="collapse" data-target="#collapseFour" aria-controls="collapseFour">
            Recepción de Orden de Taller por Asesor
        </a>
      </h5>
    </div>
    
    @if($orden[0]->estado_orden_trabajo_id == 5 || $orden[0]->estado_orden_trabajo_id == 6)
        <div id="collapseFour" class="collapse panel-collapse collapse in" aria-labelledby="headingFour" data-parent="#accordion">
    @else
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
    @endif
    <div class="card-body">
        @if($orden[0]->estado_orden_trabajo_id == 5)
            <ul class="list-group">
                <li class="list-group-item"><b>Asesor que recibe la Orden:</b>  {{ $usuarioReceptorAsesor[0]->name }}</li>
                <li class="list-group-item"><b>Fecha y Hora:</b>  {{ $orden[0]->fecha_recibe_asesor_p45 }}</li>
            </ul>
        @elseif($orden[0]->estado_orden_trabajo_id >=6)
        <ul class="list-group">
            <li class="list-group-item"><b><u>Recepción de Orden por Asesor</u></b></li>
            <li class="list-group-item"><b>Asesor que recibe la Orden:</b>  {{ $usuarioReceptorAsesor[0]->name }}</li>
            <li class="list-group-item"><b>Fecha y Hora:</b>  {{ $orden[0]->fecha_recibe_asesor_p45 }}</li>
            <li class="list-group-item"><b><u>Envio de Orden a Recepción</u></b></li>
            <li class="list-group-item"><b>Asesor que envia la Orden:</b>  {{ $usuarioEnviaLlamadas[0]->name }}</li>
            <li class="list-group-item"><b>Fecha y Hora de envío:</b>  {{ $orden[0]->fecha_envia_llamada_p56 }}</li>
            <li class="list-group-item"><b><u>Registro Detalle</u></b></li>
            <li class="list-group-item"><b>Total a Cobrar:</b>  Q.{{ $orden[0]->total_cobrar }}</li>
            
        </ul>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Cantidad</th>
                <th scope="col" style="text-align: right;">Precio</th>
                <th scope="col" style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalles as $key => $d)
                <tr>
                    <th scope="row">{{$key + 1}}</th>
                    <td>{{$d->nombre}}</td>
                    <td>{{$d->cantidad}}</td>
                    <td style="text-align: right;">Q.  <?php
                        $numero = $d->precio;
                        echo number_format($numero, 2, ".", ",");

                        ?></td>
                    <td style="text-align: right;">Q.  <?php
                        $numero = $d->subtotal;
                        echo number_format($numero, 2, ".", ",");

                        ?></td>
                </tr>
                @endforeach
            </tbody>
            </table>
        @else
            <span>Aun falta para este paso</span>
        @endif
    </div>
    </div>
  </div>

  <br>

  <div class="card">
    <div class="card-header list-group list-group-flush" id="headingFive">
      <h5 class="mb-0">
        <a role="button" class="list-group-item" data-toggle="collapse" data-target="#collapseFive" aria-controls="collapseFive">
            Registro de Contacto con Cliente
        </a>
      </h5>
    </div>
    @if($orden[0]->estado_orden_trabajo_id == 7 || $orden[0]->estado_orden_trabajo_id == 8)
        <div id="collapseFive" class="collapse panel-collapse collapse in" aria-labelledby="headingFive" data-parent="#accordion">
    @else
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
    @endif
    <div class="card-body">
        @if($orden[0]->estado_orden_trabajo_id >= 8)
            <ul class="list-group">
                @if( $taller[0]->autoriza_rechaza == 1)
                <li class="list-group-item"><b>Estado de la Orden:</b>  Aprobado</li>
                @elseif($taller[0]->autoriza_rechaza == 2)
                <li class="list-group-item"><b>Estado de la Orden:</b>  No Aprobado</li>
                @endif
                <li class="list-group-item"><b>Usuario que hizo la llamada:</b>  {{ $usuarioLlamadas[0]->name }}</li>
                <li class="list-group-item"><b>Detalle de la llamada:</b>  {{ $taller[0]->detalle_llamada }}</li>
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($llamadas as $l)
                        <tr>
                            <td scope="row">{{$l->fecha}}</td>
                            <td scope="row">{{$l->hora}}</td>
                            <td scope="row">{{$l->descripcion}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                
            </ul>
        @else
            <span>Aun falta para este paso</span>
        @endif
    </div>
    </div>
  </div>
  
  <br>
  <div class="card">
    <div class="card-header list-group list-group-flush" id="headingSix">
      <h5 class="mb-0">
        <a role="button" class="list-group-item" data-toggle="collapse" data-target="#collapseSix" aria-controls="collapseSix">
            Recepción de orden de taller 2
        </a>
      </h5>
    </div>
     @if($orden[0]->estado_orden_trabajo_id == 9)
        <div id="collapseSix" class="collapse panel-collapse collapse in" aria-labelledby="headingSix" data-parent="#accordion">
    @else
        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
    @endif
    <div class="card-body">
        @if($orden[0]->estado_orden_trabajo_id >=9)
            <ul class="list-group">
                <li class="list-group-item"><b>Usuario que recibe la orden:</b>  {{ $usuarioRecibeTaller2[0]->name }}</li>
                <li class="list-group-item"><b>Fecha y Hora:</b>  {{ $orden[0]->fecha_recibe_taller2_p89 }}</li>
            </ul>
        @else
            <span>Aun falta para este paso</span>
        @endif
      </div>
    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header list-group list-group-flush" id="headingSeven">
      <h5 class="mb-0">
        <a role="button" class="list-group-item" data-toggle="collapse" data-target="#collapseSeven" aria-controls="collapseSeven">
            Registro de Reparación
        </a>
      </h5>
    </div>
        @if($orden[0]->estado_orden_trabajo_id == 10)
            <div id="collapseSeven" class="collapse panel-collapse collapse in" aria-labelledby="headingSeven" data-parent="#accordion">
        @else
            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
        @endif
    <div class="card-body">
        @if($orden[0]->estado_orden_trabajo_id >= 10)
            <ul class="list-group">
                <li class="list-group-item"><b>Trabajos realizados:</b>  {{ $taller[0]->detalle_diagnostico }}</li>
                <li class="list-group-item"><b>Usuario generador:</b>  {{ $usuarioDiagnostico[0]->name }}</li>
                <li class="list-group-item"><b>Fecha y Hora:</b>  {{ $taller[0]->updated_at }}</li>
            </ul>
        @else
            <span>Aun falta para este paso</span>
        @endif
    </div>
    </div>
  </div>
  <br>
    <div class="card">
    <div class="card-header list-group list-group-flush" id="headingEight">
      <h5 class="mb-0">
        <a role="button" class="list-group-item" data-toggle="collapse" data-target="#collapseEight" aria-controls="collapseEight">
            Recepción de orden finalizada desde taller
        </a>
      </h5>
    </div>
    @if($orden[0]->estado_orden_trabajo_id == 12)
        <div id="collapseEight" class="collapse panel-collapse collapse in" aria-labelledby="headingEight" data-parent="#accordion">
    @else
        <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
    @endif
    <div class="card-body">
        @if($orden[0]->estado_orden_trabajo_id >= 12)
            <ul class="list-group">
                <li class="list-group-item"><b>Usuario receptor:</b>  {{ $ordenFinalUsuario[0]->name }}</li>
                <li class="list-group-item"><b>Fecha y Hora:</b>  {{ $orden[0]->fecha_recibe_recepcion3_p1011 }}</li>
            </ul>
        @else
            <span>Aun falta para este paso</span>
        @endif
    </div>
    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header list-group list-group-flush" id="headingNine">
      <h5 class="mb-0">
        <a role="button" class="list-group-item" data-toggle="collapse" data-target="#collapseNine" aria-controls="collapseNine">
            Recepción de Pago
        </a>
      </h5>
    </div>
        @if($orden[0]->estado_orden_trabajo_id == 13)
            <div id="collapseNine" class="collapse panel-collapse collapse in" aria-labelledby="headingNine" data-parent="#accordion">
        @else
            <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
        @endif
    <div class="card-body">
         @if($orden[0]->estado_orden_trabajo_id >= 13)
            <ul class="list-group">
                <li class="list-group-item"><b>Tipo de Envío:</b>  {{ $tipo[0]->tipo_envio }}</li>
                @if( $tipo[0]->persona_recibe != null)
                <li class="list-group-item"><b>Cliente que recibe:</b>  {{ $tipo[0]->persona_recibe }}</li>
                @endif
                <li class="list-group-item"><b>Fecha y Hora registro pago:</b>  {{ $pago[0]->created_at }}</li>
            </ul>
            {{--  --}}
            <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Tipo de Pago</th>
                <th scope="col">Cantidad</th>
                <th scope="col">No. Documento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pago as $key => $d)
                <tr>
                    <th scope="row">{{$key + 1}}</th>
                    <td>{{$d->tipo->nombre}}</td>
                    <td>{{$d->cantidad}}</td>
                    <td>{{$d->documento}}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        @else
            <span>Aun falta para este paso</span>
        @endif
    </div>

    </div>
  </div>
  <br>
      <div class="text-right m-t-15">
        <a class='btn btn-primary form-button' href="{{ route('ordenequipo.index') }}">Regresar</a>
      </div>
</div>
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
      if (window.location.href.indexOf("ajaxSuccess") > -1) {
            alertify.set('notifier','position', 'top-center');
            alertify.success('El detalle fue eliminado correctamente!!');
    }
        //detalleCompraTable.ajax.reload();
    });
  </script>

  {{-- <script src="{{asset('js/compras/show.js')}}"></script> --}}
@endpush
