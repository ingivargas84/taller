@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ingresos y Egresos
      <small>Ingresos y Egresos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Ingresos y Egresos</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.movimientos.createModal')
@include('admin.movimientos.editModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
   <div class="box-header"> 
     <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalInEgreso">
       <i class="fa fa-plus"></i>Nuevo movimiento</a>
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="movs-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
        {{-- <input type="hidden" name="ultimoSaldo" id="ultimoSaldo" value="{{ $ultimoSaldo }}">  --}}
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection

@push('styles') 
@endpush
@push('scripts')
<script>
  $(document).ready(function(){
    $('.loader').fadeOut(225);
    //$('#salidaForm').html('');
    movsTable.ajax.url("{{route('movs.getJson')}}").load();
  });
</script>
 <script>
     //Desactivar un mov
    $(document).on('click', 'a.remove-mov', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar movimiento', 'Esta seguro de eliminarlo', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('movs.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  movsTable.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('El registro fue eliminado correctamente!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
<script src="{{asset('js/movimientos/index.js')}}"></script>
<script src="{{asset('js/movimientos/edit.js')}}"></script>
<script src="{{asset('js/movimientos/create.js')}}"></script>
@endpush