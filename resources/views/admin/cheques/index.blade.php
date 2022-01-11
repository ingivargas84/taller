@extends('admin.layoutadmin')
@section('header')
<section class="content-header">
    <h1>
      Listado de Cheques
      <small>Todos los cheques</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Cheques</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.cheques.getVoucherModal')
@include('admin.cheques.chequeModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <a class="btn btn-primary pull-right" href="{{route('cheques.new')}}">
        <i class="fa fa-plus"></i> Nuevo Cheque</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="cheques-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      
      //MESSAGE CHEQUE SUCCESS
    if (window.location.href.indexOf("ajaxSuccess") > -1) {
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('El cheque fue creado con exito!!');
    }

    if(window.location.href.indexOf("ajaxDSuccess") > -1) {
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('El Cheque fue anulado con exito!!');
    }
      chequesTable.ajax.url("{{route('cheques.getJson')}}").load();
    });
  </script>
  
    <script>
        //Desactivar un producto
    $(document).on('click', 'a.remove-cheque', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Anular cheque', 'Esta seguro de anular el cheque, ¡esta acción es irreversible!', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('cheques.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                  $('.loader').fadeOut(225);
                  chequesTable.ajax.reload();
                  alertify.set('notifier','position', 'top-center');
                  alertify.success('El cheque fue anulado correctamente!!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
  
  <script src="{{asset('js/cheques/index.js')}}"></script>
  <script src="{{asset('js/cheques/show.js')}}"></script>
  <script src="{{asset('js/cheques/getVoucher.js')}}"></script>
@endpush