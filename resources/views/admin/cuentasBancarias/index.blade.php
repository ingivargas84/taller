@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Cuentas Bancarias
      <small>cuentas bancarias</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Cuentas</li>
    </ol>
  </section>
@endsection

@section('content')
@include('admin.cuentasBancarias.createModal')
@include('admin.cuentasBancarias.editModal')
  <div class="loader loader-bar is-active"></div>
  <div class="box">
      <div class="box-header">
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#cuentaModal">
          <i class="fa fa-plus"></i>Agregar cuenta</a>
        </button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="cuenta-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
            $('.loader').fadeOut(255);
        });
        $(document).ready(function() {
          cuentaTable.ajax.reload();
      });
  </script>
  <script>
     //Desactivar una cuenta bancaria
    $(document).on('click', 'a.remove-cuenta', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Desactivar cuenta bancaria', 'Esta seguro de desactivar la cuenta', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('cuentas.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  cuentaTable.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('La cuenta fue desactivada correctamente!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
<script src="{{asset('js/cuentasBancarias/index.js')}}"></script>
<script src="{{asset('js/cuentasBancarias/create.js')}}"></script>
<script src="{{asset('js/cuentasBancarias/edit.js')}}"></script>

@endpush