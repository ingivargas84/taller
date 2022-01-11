@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
  <h1>
    Listado de Clientes
    <small>Todos los clientes</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Clientes</li>
  </ol>
</section>
@endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
  <div class="box-header">
    <a class="btn btn-primary pull-right" href="{{route('clientes.new')}}">
      <i class="fa fa-plus"></i>Agregar Cliente</a>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
    <table id="clientes-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
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
    clientes_table.ajax.url("{{route('clientes.getJson')}}").load();
  });
</script>

<script>
  //Desactivar una forma de Pago
  $(document).on('click', 'a.remove-cliente', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);

    alertify.confirm('Inactivar cliente', 'Esta seguro de inactivar al cliente',
      function() {
        $('.loader').fadeIn();
        var id = $this.data('id');
        $.post({
          type: 'DELETE',
          url: "{{route('clientes.delete')}}",
          data: {
            'id': id
          },
        }).done(function(data) {
          $('.loader').fadeOut(225);
          clientes_table.ajax.reload();
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('¡el cliente fue inactivado correctamente!');
        });
      },
      function() {
        alertify.set('notifier', 'position', 'top-center');
        alertify.error('Cancel')
      });
  });
</script>

<script src="{{asset('js/clientes/index.js')}}"></script>
@endpush