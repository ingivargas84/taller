@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
  <h1>
    Listado de Insumos
    <small>Todos los insumos</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Insumos</li>
  </ol>
</section>
@endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
  <div class="box-header">
    <a class="btn btn-primary pull-right" href="{{route('insumos.new')}}">
      <i class="fa fa-plus"></i>Agregar Insumo</a>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
    <table id="insumos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
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
    insumos_table.ajax.url("{{route('insumos.getJson')}}").load();
  });
</script>

<script>
  //Desactivar una forma de Pago
  $(document).on('click', 'a.remove-insumo', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);

    alertify.confirm('Inactivar insumo', 'Esta seguro de inactivar el insumo',
      function() {
        $('.loader').fadeIn();
        var id = $this.data('id');
        $.post({
          type: 'DELETE',
          url: "{{route('insumos.delete')}}",
          data: {
            'id': id
          },
        }).done(function(data) {
          $('.loader').fadeOut(225);
          insumos_table.ajax.reload();
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('¡el insumo fue inactivado correctamente!');
        });
      },
      function() {
        alertify.set('notifier', 'position', 'top-center');
        alertify.error('Cancel')
      });
  });
</script>

<script src="{{asset('js/insumos/index.js')}}"></script>
@endpush