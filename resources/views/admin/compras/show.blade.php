@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Compra no {{ $compra->num_factura }}
      <small>Todos los registros</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li><a href="{{route('compras.index')}}">Compras</a></li>
      <li class="active">Detalle</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <input type="hidden" name="id" value='{{ $compra->id }}'>
    <div class="box-header">
      <div style='display: flex; justify-content: space-around; font-size: 17px;'>
        <span><b>Fecha factura. </b> {{ $compra->fecha_factura }}</span>
        <input type="hidden" name="idCompra" value="{{ $compra->id }} ">
        <span><b>No. Factura</b> {{ $compra->num_factura }}</span>
        <span><b>Serie. </b> {{ $compra->serie_factura }}</span>
        <span><b>Usuario. </b> {{ $compra->user->username }}</span>
        <span><b>Proveedor. </b> {{ $compra->proveedor->nombre_comercial }}</span>
        <span><b>Total. </b> {{ $compra->total }}</span>
        <input type="hidden" id="idCompra" value="{{ $compra->id }}">
      </div>
      <br>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="detalle-compra-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      if (window.location.href.indexOf("ajaxSuccess") > -1) {
            alertify.set('notifier','position', 'top-center');
            alertify.success('El detalle fue eliminado correctamente!!');
    }
        detalleCompraTable.ajax.reload();
    });
  </script>
  <script>
        //Desactivar un producto
    $(document).on('click', 'a.remove-producto', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar Producto', 'Esta seguro de eliminar el detalle del producto', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('compraDetail.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                 $.getJSON('/compras/getCompra/' + $('#idCompra').val(), function(data) {
                   if(data[0].total == 0) {
                     window.location.assign('/compras' + "?ajaxDSuccess");
                  } else {
                     window.location.assign('/compras/show/' + $("input[name='idCompra']").val() + "?ajaxSuccess")
                    
                  }
                 });
                 
                 
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
  <script src="{{asset('js/compras/show.js')}}"></script>
@endpush