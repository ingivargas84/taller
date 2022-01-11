@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Formas de pago
      <small>formas de pago</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Forma de Pago</li>
    </ol>
  </section>
@endsection

@section('content')
@include('admin.formaPago.createModal')
@include('admin.formaPago.editModal')
  <div class="loader loader-bar is-active"></div>
  <div class="box">
      <div class="box-header">
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalFormaPago">
          <i class="fa fa-plus"></i>Agregar Forma de pago</a>
        </button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="forma-pago-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
    formaPago.ajax.url("{{route('formaPago.getJson')}}").load();
  });

</script>
 <script>
    //Desactivar una forma de Pago
    $(document).on('click', 'a.remove-formaPago', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar forma de pago', 'Esta seguro de eliminar el pago', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('formaPago.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  formaPago.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('¡la forma de pago fue eliminada correctamente!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
<script src="{{asset('js/formaPago/index.js')}}"></script>
<script src="{{asset('js/formaPago/create.js')}}"></script>
<script src="{{asset('js/formaPago/edit.js')}}"></script>

@endpush