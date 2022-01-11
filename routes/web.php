<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware'=>['auth','estado'] ],
function(){
    Route::get('/admin','HomeController@index')->name('dashboard');

    Route::get('user/getJson' , 'UsersController@getJson' )->name('users.getJson');
    Route::get('users' , 'UsersController@index' )->name('users.index');
    Route::post('users' , 'UsersController@store' )->name('users.store');
    Route::delete('users/{user}' , 'UsersController@destroy' );
    Route::post('users/update/{user}' , 'UsersController@update' );
    Route::get('users/{user}/edit', 'UsersController@edit' );
    Route::post('users/reset/tercero' , 'UsersController@resetPasswordTercero')->name('users.reset.tercero');
    Route::post('users/reset' , 'UsersController@resetPassword')->name('users.reset');
    Route::get( '/users/cargar' , 'UsersController@cargarSelect')->name('users.cargar');
    Route::get( '/users/cargarA' , 'UsersController@cargarSelectApertura')->name('users.cargarA');

    Route::get( '/empleados' , 'EmpleadosController@index')->name('empleados.index');
    Route::get( '/empleados/getJson/' , 'EmpleadosController@getJson')->name('empleados.getJson');
    Route::get( '/empleados/new' , 'EmpleadosController@create')->name('empleados.new');
    Route::get( '/empleados/edit/{empleado}' , 'EmpleadosController@edit')->name('empleados.edit');
    Route::put( '/empleados/{empleado}/update' , 'EmpleadosController@update')->name('empleados.update');
    Route::post( '/empleados/save/' , 'EmpleadosController@store')->name('empleados.save');
    Route::delete('empleados/delete' , 'EmpleadosController@destroy')->name('empleados.delete');
    //Route::post( '/empleado/active/{empleado}' , 'EmpleadosController@active');
    Route::get('/empleados/nitDisponible/', 'EmpleadosController@nitDisponible')->name('empleados.nitDisponible');
    Route::get('cui-disponible/', 'EmpleadosController@dpiDisponible')->name('cui-disponible');
    Route::post( 'empleados/{empleado}/asignaruser' , 'EmpleadosController@asignarUser')->name('empleados.asignaruser');

    Route::get( '/negocio/{negocio}/edit' , 'NegocioController@edit')->name('negocio.edit');
    Route::put( '/negocio/{negocio}/update' , 'NegocioController@update')->name('negocio.update');

    Route::get( '/puestos' , 'PuestosController@index')->name('puestos.index');
    Route::get( '/puestos/getJson/' , 'PuestosController@getJson')->name('puestos.getJson');
    Route::put( '/puestos/{puesto}/update' , 'PuestosController@update')->name('puestos.update');
    Route::post( '/puestos/save' , 'PuestosController@store')->name('puestos.save');
    Route::post('/puestos/{puesto}/delete' , 'PuestosController@destroy');
    Route::get('/puestos/nombreDisponible/', 'PuestosController@nombreDisponible');
    Route::get('/puestos/nombreDisponibleEdit/', 'PuestosController@nombreDisponibleEdit');

    Route::get( '/proveedores' , 'ProveedoresController@index')->name('proveedores.index');
    Route::get( '/proveedores/getJson/' , 'ProveedoresController@getJson')->name('proveedores.getJson');
    Route::get( '/proveedores/new' , 'ProveedoresController@create')->name('proveedores.new');
    Route::get( '/proveedores/edit/{proveedor}' , 'ProveedoresController@edit')->name('proveedores.edit');
    Route::put( '/proveedores/{proveedor}/update' , 'ProveedoresController@update')->name('proveedores.update');
    Route::post( '/proveedores/save/' , 'ProveedoresController@store')->name('proveedores.save');
    Route::post('/proveedores/{proveedor}/delete' , 'ProveedoresController@destroy');
    Route::post('/proveedores/{proveedor}/activar' , 'ProveedoresController@activar');
    Route::get('/proveedores/nitDisponible/', 'ProveedoresController@nitDisponible')->name('proveedores.nitDisponible');

    // Vendedores
    Route::get('/vendedores', 'VendedoresController@index')->name('vendedores.index');
    Route::get('/vendedores/getJson/', 'VendedoresController@getSellerJson')->name('vendedores.getJson');
    Route::get('/vendedores/new', 'VendedoresController@create')->name('vendedores.new');
    Route::post('/vendedores/save/', 'VendedoresController@store')->name('vendedores.save');
    Route::get('/vendedores/nitDisponible/', 'VendedoresController@nitDisponible')->name('vendedores.nitDisponible');
    Route::get('/vendedores/edit/{vendedor}', 'VendedoresController@edit')->name('vendedores.edit');
    Route::put('/vendedores/{vendedor}/update', 'VendedoresController@update')->name('vendedores.update');
    Route::delete('/vendedores/delete', 'VendedoresController@destroy')->name('vendedores.delete');
    Route::post('/vendedores/{vendedor}/activar', 'VendedoresController@activar');

    // Clientes
    Route::get( '/clientes' , 'ClientesController@index')->name('clientes.index');
    Route::get( '/clientes/getJson/' , 'ClientesController@getJson')->name('clientes.getJson');
    Route::get( '/clientes/new' , 'ClientesController@create')->name('clientes.new');
    Route::post( '/clientes/save/' , 'ClientesController@store')->name('clientes.save');
    Route::get( '/clientes/edit/{cliente}' , 'ClientesController@edit')->name('clientes.edit');
    Route::put( '/clientes/{cliente}/update' , 'ClientesController@update')->name('clientes.update');
    Route::delete('/clientes/delete' , 'ClientesController@destroy')->name('clientes.delete');
    Route::post('/clientes/{cliente}/activar' , 'ClientesController@activar');
    Route::get('/clientes/nitDisponible/', 'ClientesController@nitDisponible')->name('clientes.nitDisponible');

    // Insumos
    Route::get( '/insumos' , 'InsumosController@index')->name('insumos.index');
    Route::get( '/insumos/getJson/' , 'InsumosController@getJson')->name('insumos.getJson');
    Route::get( '/insumos/new' , 'InsumosController@create')->name('insumos.new');
    Route::post( '/insumos/save/' , 'InsumosController@store')->name('insumos.save');
    Route::get( '/insumos/edit/{insumo}' , 'InsumosController@edit')->name('insumos.edit');
    Route::put( '/insumos/{insumo}/update' , 'InsumosController@update')->name('insumos.update');
    Route::delete('/insumos/delete' , 'InsumosController@destroy')->name('insumos.delete');
    Route::post('/insumos/{insumo}/activar' , 'InsumosController@activar');


    Route::get( '/compus' , 'CompusController@index')->name('compus.index');
    Route::get( '/compus/getJson/' , 'CompusController@getJson')->name('compus.getJson');
    Route::get( '/compus/newingreso' , 'CompusController@createingreso')->name('compus.newingreso');
    Route::post( '/compus/saveingreso/' , 'CompusController@storeingreso')->name('compus.saveingreso');
    Route::get( '/compus/newsalida' , 'CompusController@createsalida')->name('compus.newsalida');
    Route::post( '/compus/savesalida/' , 'CompusController@storesalida')->name('compus.savesalida');
    Route::get('/compus/getTatuajes/{equipo}' , 'CompusController@getTatuajes')->name('compus.getTatuajes');


    Route::get( '/compra_insumos' , 'ComprasInsumosController@index')->name('compra_insumos.index');
    Route::get( '/compra_insumos/getJson/' , 'ComprasInsumosController@getJson')->name('compra_insumos.getJson');
    Route::get( '/compra_insumos/new' , 'ComprasInsumosController@create')->name('compra_insumos.new');
    Route::post( '/compra_insumos/save/' , 'ComprasInsumosController@store')->name('compra_insumos.save');
    Route::post('/compra_insumos/{insumos_maestros}/anular' , 'ComprasInsumosController@anular');
    Route::get('/compra_insumos/show/{insumos_maestros}' , 'ComprasInsumosController@show')->name('compra_insumos.show');

    Route::get( '/requi_insumos' , 'RequisInsumosController@index')->name('requi_insumos.index');
    Route::get( '/requi_insumos/getJson/' , 'RequisInsumosController@getJson')->name('requi_insumos.getJson');
    Route::get( '/requi_insumos/new' , 'RequisInsumosController@create')->name('requi_insumos.new');
    Route::post( '/requi_insumos/save/' , 'RequisInsumosController@store')->name('requi_insumos.save');
    Route::post('/requi_insumos/{requisicion_maestro}/autorizar' , 'RequisInsumosController@autorizar');
    Route::post('/requi_insumos/{requisicion_maestro}/entregar' , 'RequisInsumosController@entregar');
    Route::get('/requi_insumos/show/{requisicion_maestros}' , 'RequisInsumosController@show')->name('requi_insumos.show');
    Route::get( '/requi_insumos/{requisicion_maestro}/rechazarequi' , 'RequisInsumosController@rechazarequi');
    Route::post('/requi_insumos/rechazar' , 'RequisInsumosController@rechazar')->name('requi_insumos.rechazar');
    Route::get('/requi_insumos/getInsumo/{insumo}' , 'RequisInsumosController@getInsumo')->name('requi_insumos.getInsumo');


    // Orden Equipo
    Route::get('/ordenequipo/show/{id}', 'OrdenEquipoController@show');
    Route::get( '/ordenequipo' , 'OrdenEquipoController@index')->name('ordenequipo.index');
    Route::get( '/ordenequipo/getJson/' , 'OrdenEquipoController@getJson')->name('ordenequipo.getJson');
    Route::get( '/ordenequipo/OTDisponible' , 'OrdenEquipoController@OTDisponible');
    Route::get( '/ordenequipo/ComprobanteDisponible' , 'OrdenEquipoController@ComprobanteDisponible');
    Route::get( '/ordenequipo/new' , 'OrdenEquipoController@create')->name('ordenequipo.new');
    Route::post( '/ordenequipo/save/' , 'OrdenEquipoController@store')->name('ordenequipo.save');
    Route::get( '/ordenequipo/ttaller/{ordenequipo}' , 'OrdenEquipoController@ttaller')->name('ordenequipo.ttaller');
    Route::get( '/ordenequipo/edit/{ordenequipo}' , 'OrdenEquipoController@edit')->name('ordenequipo.edit');
    Route::put( '/ordenequipo/{ordenequipo}/update' , 'OrdenEquipoController@update')->name('ordenequipo.update');
    Route::delete('/ordenequipo/delete' , 'OrdenEquipoController@destroy')->name('ordenequipo.delete');
    Route::get( '/ordenequipo/recibirorden2/{ordenequipo}' , 'OrdenEquipoController@recibirorden2')->name('ordenequipo.recibeorden');
    Route::get( '/ordenequipo/new2/{ordenequipo}' , 'OrdenEquipoController@create2')->name('ordenequipo.new2');
    Route::post( '/ordenequipo/{ordenequipo}/save2/' , 'OrdenEquipoController@store2')->name('ordenequipo.save2');
    Route::get( '/ordenequipo/recibirorden3/{ordenequipo}' , 'OrdenEquipoController@recibirorden3')->name('ordenequipo.recibeorden3');
    Route::get( '/ordenequipo/recibirorden4/{ordenequipo}' , 'OrdenEquipoController@create3')->name('ordenequipo.recibeorden4');
    Route::post( '/ordenequipo/finalizarorden/{ordenequipo}' , 'OrdenEquipoController@recibirorden4')->name('ordenequipo.finalizarorden');
    Route::get( '/ordeneequipo/pdf/{ordenequipo}', 'OrdenEquipoController@pdf');
    Route::get( '/ordenequipo/garantia/pdf/{ordenid}', 'OrdenEquipoController@getpdfguarantee');
    Route::get('/ordeneequipo/getLlamadasJson/{id}/', 'OrdenEquipoController@getLlamadasJson');
    Route::post('/ordenequipo/{ordenID}/garantia/save', 'OrdenEquipoController@garantia');
    Route::get( '/ordenequipo/enviataller2/{ordenequipo}' , 'OrdenEquipoController@enviataller2');

    // Gestión Taller
    Route::get( '/taller' , 'TallerController@index')->name('taller.index');
    Route::get( '/taller/getJson/' , 'TallerController@getJson')->name('taller.getJson');
    Route::get( '/taller/tcliente/{taller}' , 'TallerController@ttaller')->name('taller.tcliente');
    Route::get( '/taller/recibirorden/{ordenequipo}' , 'TallerController@recibirorden');
    Route::get( '/taller/new/{ordenequipo}' , 'TallerController@create')->name('taller.new');
    Route::get( '/taller/new1/{ordenequipo}' , 'TallerController@create1')->name('taller.new1');
    Route::post( '/taller/{taller}/save/' , 'TallerController@store')->name('taller.save');
    Route::get( '/taller/edit/{ordenequipo}' , 'TallerController@edit')->name('taller.edit');
    Route::put( '/taller/{ordenequipo}/update' , 'TallerController@update')->name('taller.update');
    Route::get( '/taller/recibirorden3/{ordenequipo}' , 'TallerController@recibirorden3')->name('taller.recibeorden3');
    Route::get( '/taller/new3/{ordenequipo}' , 'TallerController@create3')->name('taller.new3');
    Route::post( '/taller/save3/' , 'TallerController@store3')->name('taller.save3');
    Route::get( '/taller/getServicioData/{servicio}' , 'TallerController@getServicioData')->name('taller.getServicioData');
    Route::get( '/taller/getProductoData/{producto}' , 'TallerController@getProductoData')->name('taller.getProductoData');
    Route::get( '/taller/getProductoData1/{producto}' , 'TallerController@getProductoData1')->name('taller.getProductoData1');
    Route::get('/taller/getEditarJson/{id}/', 'TallerController@getEditarJson');
    Route::post( '/taller/{taller}/save1/' , 'TallerController@store1')->name('taller.save1');
    Route::get('/taller/envio/{ordenequipo}', 'TallerController@Envio1');
    Route::get( '/taller/new5/{ordenequipo}' , 'TallerController@create5')->name('taller.new5');
    Route::post( '/taller/{ordenequipo}/save5/' , 'TallerController@store5')->name('taller.save5');
    Route::get( '/taller/enviorecepcion3/{ordenequipo}' , 'TallerController@enviorecepcion3');
    Route::get( '/taller/irreparable/{ordenequipo}' , 'TallerController@irreparable');

    Route::get( '/taller/getdiagnostico/{ordenequipo}' , 'TallerController@getdiagnostico')->name('taller.getdiagnostico');

    // Gestión Asesor
    Route::get( '/asesor' , 'AsesorController@index')->name('asesor.index');
    Route::get( '/asesor/getJson/' , 'AsesorController@getJson')->name('asesor.getJson');
    Route::get( '/asesor/recibirordenasesor/{ordenequipo}' , 'AsesorController@recibirordenasesor');
    Route::get('/asesor/envio/{id}', 'AsesorController@Envio');
    Route::get( '/asesor/new/{ordenequipo}' , 'AsesorController@create')->name('asesor.new');
    Route::get( '/asesor/getdiagnostico/{ordenequipo}' , 'AsesorController@getdiagnostico')->name('asesor.getdiagnostico');
    Route::get( '/asesor/recibirorden2/{ordenequipo}' , 'AsesorController@recibirorden2')->name('asesor.recibeorden');
    Route::get( '/asesor/enviataller2/{ordenequipo}' , 'AsesorController@enviataller2');

    Route::get( '/asesor/editdetalle/{diagnostico}' , 'AsesorController@editdetalle')->name('asesor.editdetalle');
    Route::post( '/asesor/{diagnostico}/updatedetalle' , 'AsesorController@updatedetalle')->name('asesor.updatedetalle');
    Route::get('/asesor/deletedetalle/{diagnostico}' , 'AsesorController@destroydetalle');


    Route::get( '/visitas' , 'VisitaController@index')->name('visitas.index');
    Route::get( '/visitas/getJson/' , 'VisitaController@getJson')->name('visitas.getJson');
    Route::get( '/visitas/new' , 'VisitaController@create')->name('visitas.new');
    Route::post( '/visitas/save/' , 'VisitaController@store')->name('visitas.save');
    Route::get( '/visitas/edit/{visita}' , 'VisitaController@edit')->name('visitas.edit');
    Route::put( '/visitas/{visita}/update' , 'VisitaController@update')->name('visitas.update');
    Route::post('/visitas/{visita}/delete' , 'VisitaController@destroy');

    //FormaPago
    Route::get('/formaPago', 'FormaPagoController@index')->name('formaPago.index');
    Route::get('/formaPago/getJson/', 'FormaPagoController@getJson')->name('formaPago.getJson');
    Route::post('/formaPago/save', 'FormaPagoController@store')->name('formaPago.save');
    Route::delete('/formaPago/delete/', 'FormaPagoController@destroy')->name('formaPago.delete');
    Route::put('/formaPago/{formaPago}/update/', 'FormaPagoController@update')->name('formaPago.update');
    Route::get('/formaPago/nombreDisponible/', 'FormaPagoController@nombreDisponible');
    Route::get('/formaPago/nombreDisponibleEdit/', 'FormaPagoController@nombreDisponibleEdit');
    Route::post('/formaPago/{formaPago}/activar', 'FormaPagoController@activar');

    //TipoTrabajo
    Route::get('/tipoTrabajo', 'TipoTrabajoController@index')->name('tipoTrabajo.index');
    Route::get('/tipoTrabajo/getJson', 'TipoTrabajoController@GetJson')->name('tipoTrabajo.getJson');
    Route::post('/tipoTrabajo/save', 'TipoTrabajoController@store')->name('tipoTrabajo.save');
    Route::delete('/tipoTrabajo/delete/', 'TipoTrabajoController@destroy')->name('tipoTrabajo.delete');
    Route::put('/tipoTrabajo/{tipoTrabajo}/update', 'TipoTrabajoController@update')->name('tipoTrabajo.update');
    Route::get('/tipoTrabajo/nombreDisponible/', 'TipoTrabajoController@nombreDisponible');
    Route::get('/tipoTrabajo/nombreDisponibleEdit/', 'TipoTrabajoController@nombreDisponibleEdit');
    Route::post('/tipoTrabajo/{tipoT}/activar', 'TipoTrabajoController@activar');

    //EstadosTaller
    Route::get('/estadosTaller', 'EstadosTallerController@index')->name('estadosTaller.index');
    Route::get('/estadosTaller/getJson', 'EstadosTallerController@getJson')->name('estadosTaller.getJson');
    Route::post('/estadosTaller/save', 'EstadosTallerController@store')->name('estadosTaller.save');
    Route::delete('/estadosTaller/delete/', 'EstadosTallerController@destroy')->name('estadosTaller.delete');
    Route::put('/estadosTaller/{estadosTaller}/update', 'EstadosTallerController@update')->name('estadosTaller.update');
    Route::get('/estadosTaller/nombreDisponible/', 'EstadosTallerController@nombreDisponible');
    Route::get('/estadosTaller/nombreDisponibleEdit/', 'EstadosTallerController@nombreDisponibleEdit');
    Route::post('/estadosTaller/{estadosTaller}/activar', 'EstadosTallerController@activar');

    //UbicacionEquipo
    Route::get('/ubicacionEquipo', 'UbicacionEquipoController@index')->name('ubicacionEquipo.index');
    Route::get('/ubicacionEquipo/getJson', 'UbicacionEquipoController@getJson')->name('ubicacionEquipo.getJson');
    Route::post('/ubicacionEquipo/save', 'UbicacionEquipoController@store')->name('ubicacionEquipo.save');
    Route::delete('/ubicacionEquipo/delete/', 'UbicacionEquipoController@destroy')->name('ubicacionEquipo.delete');
    Route::put('/ubicacionEquipo/{ubicacionEquipo}/update', 'UbicacionEquipoController@update')->name('ubicacionEquipo.update');
    Route::get('/ubicacionEquipo/nombreDisponible/', 'UbicacionEquipoController@nombreDisponible');
    Route::get('/ubicacionEquipo/nombreDisponibleEdit/', 'UbicacionEquipoController@nombreDisponibleEdit');
    Route::post('/ubicacionEquipo/{ubicacionEquipo}/activar', 'UbicacionEquipoController@activar');
    Route::get('/equipos/{id}', 'UbicacionEquipoController@getEquipo');
    Route::get('/ubicaciones/{id}', 'UbicacionEquipoController@getUbicaciones');

    //Equipo
    Route::get('/equipos', 'EquipoController@index')->name('equipos.index');
    Route::post('/equipos/getJson', 'EquipoController@getJson')->name('equipos.getJson');
    Route::post('/equipos/nombreDisponible/', 'EquipoController@nombreDisponible');
    Route::get('/ubicaciones', 'EquipoController@getUbicaciones');
    Route::post('/equipos/nombreDisponibleEdit/', 'EquipoController@nombreDisponibleEdit');
    Route::put('/equipos/{equipo}/update', 'EquipoController@update')->name('equipos.update');
    Route::post('/equipos/{equipo}/activar', 'EquipoController@activar');
    Route::post('/equipos/save', 'EquipoController@store')->name('equipos.save');
    Route::delete('/equipos/delete/', 'EquipoController@destroy')->name('equipos.delete');

    //Producto
    Route::get('/productos', 'ProductosController@index')->name('productos.index');
    Route::get('/productos/getJson/', 'ProductosController@getJson')->name('productos.getJson');
    Route::get('/productos/new', 'ProductosController@create')->name('productos.new');
    Route::post('/productos/save/', 'ProductosController@store')->name('productos.save');
    Route::get('/productos/nombreDisponible/', 'ProductosController@nombreDisponible');
    Route::get('/productos/nombreDisponibleEdit/', 'ProductosController@nombreDisponibleEdit');
    Route::get('/productos/codigoDisponible/', 'ProductosController@codigoDisponible');
    Route::get('/productos/codigoDisponibleEdit/', 'ProductosController@codigoDisponibleEdit');
    Route::get('/productos/edit/{producto}', 'ProductosController@edit')->name('productos.edit');
    Route::put('/productos/{producto}/update', 'ProductosController@update')->name('productos.update');
    Route::delete('/productos/delete', 'ProductosController@destroy')->name('productos.delete');
    Route::post('/productos/{producto}/activar', 'ProductosController@activar');

    //Compras
    Route::get('/compras', 'ComprasController@index')->name('compras.index');
    Route::get('/compras/new', 'ComprasController@create')->name('compras.new');
    Route::post('/compras/save', 'ComprasController@store')->name('compras.save');
    Route::delete('/compras/deleteDetail', 'ComprasController@destroyDetail')->name('compraDetail.delete');
    Route::delete('/compras/delete', 'ComprasController@destroy')->name('compras.delete');
    Route::get('/compras/getJson/', 'ComprasController@getStrongJson')->name('compras.getJson');
    Route::get('/compras/getWeakJson/{id}/', 'ComprasController@getWeakJson');
    Route::get('/compras/show/{id}', 'ComprasController@show');
    Route::get('/compras/proveedores', 'ComprasController@getProveedores');
    Route::get('/compras/productos/{codigo}', 'ComprasController@getProducto');
    Route::get('/compras/getCompra/{id}', 'ComprasController@getCompra');

    //Servicios
    Route::get('/servicios', 'ServicioController@index')->name('servicios.index');
    Route::get('/servicios/getJson', 'ServicioController@getJson')->name('servicios.getJson');
    Route::post('/servicios/save', 'ServicioController@store')->name('servicios.save');
    Route::get('/servicios/nombreDisponible/', 'ServicioController@nombreDisponible');
    Route::get('/servicios/nombreDisponibleEdit/', 'ServicioController@nombreDisponibleEdit');
    Route::put('/servicios/{servicio}/update', 'ServicioController@update')->name('servicios.update');
    Route::delete('/servicios/delete', 'ServicioController@destroy')->name('servicios.delete');
    Route::post('/servicios/{servicio}/activar', 'ServicioController@activar');

    //Cotizaciones
    Route::get('/cotizaciones', 'CotizacionesController@index')->name('cotizaciones.index');
    Route::get('/cotizaciones/new', 'CotizacionesController@create')->name('cotizaciones.new');
    Route::post('/cotizaciones/save', 'CotizacionesController@store')->name('cotizaciones.save');
    Route::delete('/cotizaciones/deleteDetail', 'CotizacionesController@destroyDetail')->name('cotDetail.delete');
    Route::delete('/cotizaciones/deleteDetailUpdate', 'CotizacionesController@destroyDetailUpdate')->name('cotDetail.deleteUpdate');
    Route::delete('/cotizaciones/delete', 'CotizacionesController@destroy')->name('cotizaciones.delete');
    Route::get('/cotizaciones/getJson/', 'CotizacionesController@getStrongJson')->name('cotizaciones.getJson');
    Route::get('/cotizaciones/getWeakJson/{id}/', 'CotizacionesController@getWeakJson');
    Route::get('/cotizaciones/show/{id}', 'CotizacionesController@show');
    Route::get('/cotizaciones/clientes/', 'CotizacionesController@getClientes');
    Route::get('/cotizaciones/servicios/', 'CotizacionesController@getServicios');
    Route::get('/cotizaciones/servicios/{id}', 'CotizacionesController@getServicio');
    Route::get('/cotizaciones/clientes/{id}', 'CotizacionesController@getCliente');
    Route::get('/cotizaciones/productos/{codigo}', 'CotizacionesController@getProducto');
    Route::get('/cotizaciones/getCot/{id}', 'CotizacionesController@getCotizacion');
    Route::get('/cotizaciones/edit/{cot}', 'CotizacionesController@edit')->name('cotizaciones.edit');
    Route::put('/cotizaciones/{cotizacion}/update', 'CotizacionesController@update')->name('cotizaciones.update');
    Route::get('/cotizaciones/codigoDisponible/', 'CotizacionesController@codigoDisponible');
    Route::get('/cotizaciones/codigoDisponibleEdit/', 'CotizacionesController@codigoDisponibleEdit');
    Route::get('/cotizaciones/pdf/{id}', 'CotizacionesController@getPDF');

    //Movimientos de entrada y salida Caja Chica
    Route::get('/movimientos', 'MovimientosInOutController@index')->name('movimientos.index');
    Route::get('/movimientos/getJson/', 'MovimientosInOutController@getJson')->name('movimientos.getJson');
    Route::get('/movimientos/cerrados', 'MovimientosInOutController@previous')->name('movimientos.previous');
    Route::get('/movimientos/getPrevious/', 'MovimientosInOutController@getPreviousJson')->name('movimientos.getPrevious');
    Route::get('/movimientos/getPreviousDetail/{id}', 'MovimientosInOutController@getPreviousDetail')->name('movimientos.getPreviousDetail');
    Route::post('/movimientos/open', 'MovimientosInOutController@open')->name('movimientos.open');
    Route::post('/movimientos/save', 'MovimientosInOutController@store')->name('movimientos.save');
    Route::delete('/movimientos/close', 'MovimientosInOutController@destroy')->name('movimientos.close');
    Route::get('/movimientos/cerrados/show/{id}', 'MovimientosInOutController@show')->name('movimientos.show');
    Route::get('/movimientos/isGreater/', 'MovimientosInOutController@isGreater');
    Route::delete('/movimientos/delete/', 'MovimientosInOutController@deleteDetail')->name('movimientos.delete');
    Route::get('/movimientos/pdf/{id}', 'MovimientosInOutController@getPDF');
    Route::get('/movimientos/registros/', 'MovimientosInOutController@getData');
    Route::get('/movimientos/cerrados/reportePDF/', 'MovimientosInOutController@reportePDF');
    Route::get('/movimientos/cerrados/singleReport/{id}', 'MovimientosInOutController@singleReport');

    //CuentaBancaria
    Route::get('/cuentasBancarias', 'CuentaBancariaController@index')->name('cuentas.index');
    Route::get('/cuentasBancarias/getJson', 'CuentaBancariaController@getJson')->name('cuentas.getJson');
    Route::get('/tiposCuenta', 'CuentaBancariaController@getTiposCuenta');
    Route::get('/tipos/{id}', 'CuentaBancariaController@getTipos');
    //Route::post('/cuentasBancarias/nombreDisponible/', 'CuentaBancariaController@nombreDisponible');
    //Route::post('/cuentasBancarias/nombreDisponibleEdit/', 'EquipoController@nombreDisponibleEdit');
    Route::put('/cuentasBancarias/{cuentaBancaria}/update', 'CuentaBancariaController@update')->name('cuentas.update');
    Route::post('/cuentasBancarias/{cuentaBancaria}/activar', 'CuentaBancariaController@activate');
    Route::post('/cuentasBancarias/save', 'CuentaBancariaController@store')->name('cuentas.save');
    Route::delete('/cuentasBancarias/delete/', 'CuentaBancariaController@destroy')->name('cuentas.delete');

    //Cheques
    Route::get('/cheques/chequeEmitido', 'ChequeController@chequeEmitido')->name('cheques.chequeEmitido');
    Route::get('/cheques/chequeEmitidoEdit/', 'ChequeController@chequeEmitidoEdit')->name('cheques.chequeEmitidoEdit');
    Route::get('/cheques', 'ChequeController@index')->name('cheques.index');
    Route::get('/cheques/getJson', 'ChequeController@getJson')->name('cheques.getJson');
    Route::get('/bancos', 'BancoController@getJson')->name('bancos.getJson');
    Route::get('/bancos/{id}', 'BancoController@getBancos');
    Route::get('/cheques/new', 'ChequeController@create')->name('cheques.new');
    Route::get('/cheque/{id}', 'ChequeController@getCheque');
    Route::delete('/cheques/delete/', 'ChequeController@destroy')->name('cheques.delete');
    Route::post('/cheques/save', 'ChequeController@store')->name('cheques.save');
    Route::get('/cheques/edit/{cheque}', 'ChequeController@edit')->name('cheques.edit');
    Route::put('/cheques/{cheque}/update', 'ChequeController@update')->name('cheques.update');
    Route::post('/cheques/vouchers/save', 'VoucherController@store')->name('vouchers.save');
    Route::get('/cheques/pdf/{id}', 'ChequeController@chequePDF');
    Route::get('/cheques/vouchers/pdf/{id}', 'ChequeController@voucherPDF');
    Route::put('/cheques/entregar/{id}', 'ChequeController@delivered');
    Route::put('/cheques/cobrar/{id}', 'ChequeController@charged');
    Route::get('/cheques/prueba', 'ChequeController@prueba');

    //Registro de Envíos de equipo
    Route::get('/enviosEquipo', 'RegistroEnvioEquipoController@index')->name('envios.index');
    Route::get('/enviosEquipo/getJson', 'RegistroEnvioEquipoController@getJson')->name('envios.getJson');
    Route::get('/enviosEquipo/getOrdenEquipo/{id}', 'RegistroEnvioEquipoController@getOrden');
    Route::get('/enviosEquipo/new', 'RegistroEnvioEquipoController@create')->name('envios.new');
    Route::post('/enviosEquipo/save', 'RegistroEnvioEquipoController@store')->name('envios.save');
    Route::get('/enviosEquipo/edit/{envio}', 'RegistroEnvioEquipoController@edit')->name('envios.edit');
    Route::put('/enviosEquipo/{envio}/update', 'RegistroEnvioEquipoController@update')->name('envios.update');
    //anular
    Route::delete('/enviosEquipo/delete/', 'RegistroEnvioEquipoController@destroy')->name('envios.delete');
    //en ruta
    Route::put('/enviosEquipo/enCamino/{id}', 'RegistroEnvioEquipoController@enCamino')->name('envios.enCamino');
    //entregar
    Route::put('/enviosEquipo/entregar/{id}', 'RegistroEnvioEquipoController@entregar')->name('envios.entregar');
    //Rechazar
    Route::put('/enviosEquipo/rechazar/{id}', 'RegistroEnvioEquipoController@rechazar')->name('envios.rechazar');
    //Recibir
    Route::put('/enviosEquipo/recibir/{id}', 'RegistroEnvioEquipoController@recibir')->name('envios.recibir');
    //pdf
    Route::get('/enviosEquipo/pdf/{id}', 'RegistroEnvioEquipoController@envioPDF');


    //Rutas de vendedor
    Route::get('/misRutas', 'RutasVendedorController@index')->name('rutas.index');
    Route::get('/misRutas/getJson', 'RutasVendedorController@getJson')->name('rutas.getJson');
    Route::get('/misRutas/fechas', 'RutasVendedorController@getFechas');
    Route::get('/misRutas/pdf', 'RutasVendedorController@visitaPDF')->name('rutas.pdf');
    Route::get('/misRutas/new', 'RutasVendedorController@create')->name('rutas.new');
    Route::post('/misRutas/save', 'RutasVendedorController@store')->name('rutas.save');
    Route::get('/misRutas/edit/{ruta}', 'RutasVendedorController@edit')->name('rutas.edit');
    Route::put('/misRutas/{ruta}/update', 'RutasVendedorController@update')->name('rutas.update');
    Route::delete('/misRutas/delete/{id}', 'RutasVendedorController@destroy')->name('rutas.delete');
    Route::get('/misRutas/clientes/{id}', 'RutasVendedorController@getCliente');
    Route::get('/misRutas/{id}', 'RutasVendedorController@getRuta');

    //Cuenta Por Pagar
    Route::get('/cuentasPorPagar/show/{id}/', 'CuentaPorPagarController@show')->name('pagar.show');
    Route::get('/cuentasPorPagar', 'CuentaPorPagarController@index')->name('pagar.index');
    Route::get('/cuentasPorPagar/getJson', 'CuentaPorPagarController@getJson')->name('pagar.getJson');
    Route::get('/cuentasPorPagar/getDetalleJson/{id}/', 'CuentaPorPagarController@getDetalleJson');
    Route::post('/cuentasPorPagar/Abono/save', 'CuentaPorPagarController@abonar')->name('pagar.createAbono');
    Route::get('/cuentasPorPagar/show/{id}/check', 'CuentaPorPagarController@check')->name('pagar.check');
    Route::post('/cuentasPorPagar/{id}/Abono/save', 'CuentaPorPagarController@abonar');
    Route::post('/cuentasPorPagar/abono/{idA}/cuenta/{idC}/revertir', 'CuentaPorPagarController@revertirAbono');
    Route::get('/cuentaPorPagar/pdf/{id}', 'CuentaPorPagarController@print');

    //Ingresos y Egresos
    Route::get('/inEgresos', 'IngresoEgresoController@index')->name('movs.index');
    Route::get('/inEgresos/getJson', 'IngresoEgresoController@getJson')->name('movs.getJson');
    Route::post('/inEgresos/save', 'IngresoEgresoController@store')->name('movs.save');
    Route::delete('/inEgresos/delete', 'IngresoEgresoController@destroy')->name('movs.delete');
    Route::put('/inEgresos/update', 'IngresoEgresoController@update')->name('movs.update');

    //Planilla
    Route::get('/planilla', 'PlanillaController@index')->name('planilla.index');
    Route::get('/planilla/getHeader', 'PlanillaController@getHeader')->name('planilla.getHeader');
    Route::get('/planilla/getMovs', 'PlanillaController@getMovs')->name('planilla.getMovs');
    Route::get('/planilla/getJson', 'PlanillaController@getJson')->name('planilla.getJson');
    Route::get('/planilla/new', 'PlanillaController@create')->name('planilla.new');
    Route::get( '/planilla/nombreUnico' , 'PlanillaController@nombreUnico');
    Route::post('/planilla/save', 'PlanillaController@store')->name('planilla.save');

    //CuentasPorCobrar
    Route::get('/cuentasPorCobrar/show/{id}/', 'CuentaPorCobrarController@show')->name('cobrar.show');
    Route::get('/cuentasPorCobrar', 'CuentaPorCobrarController@index')->name('cobrar.index');
    Route::get('/cuentasPorCobrar/getJson', 'CuentaPorCobrarController@getJson')->name('cobrar.getJson');
    Route::get('/cuentasPorCobrar/getDetalleJson/{id}/', 'CuentaPorCobrarController@getDetalleJson');
    Route::post('/cuentasPorCobrar/Abono/save', 'CuentaPorCobrarController@abonar')->name('cobrar.createAbono');
    Route::get('/cuentasPorCobrarD/pdf/{id}', 'CuentaPorCobrarController@printRecibo');
    Route::get('/cuentasPorCobrar/show/{id}/check', 'CuentaPorCobrarController@check')->name('cobrar.check');
    Route::post('/cuentasPorCobrar/{id}/Abono/save', 'CuentaPorCobrarController@abonar');
    Route::post('/cuentasPorCobrar/abono/{idA}/cuenta/{idC}/revertir', 'CuentaPorCobrarController@revertirAbono');
    Route::get('/cuentasPorCobrar/pdf/{id}', 'CuentaPorCobrarController@print');

    //Facturación
    Route::get('/facturacion', 'FacturacionController@index')->name('factura.index');
    Route::post('/facturacion/save', 'FacturacionController@store')->name('factura.save');
    Route::delete('/facturacion/anular/{id}', 'FacturacionController@destroy');
    Route::get('/facturacion/getJson', 'FacturacionController@getJson')->name('factura.getJson');
    Route::delete('/facturacion/delete/{id}' , 'FacturacionController@destroy' )->name('factura.delete');
    Route::get('/clienteOrden/{id}', 'FacturacionController@clienteOrden');
    Route::get('/facturacion/numDisponible', 'FacturacionController@numDisponible');
    Route::get('/facturacion/facturaDisponible', 'FacturacionController@facturaDisponible');
    Route::get('/facturacion/printBill/{id}', 'FacturacionController@printBill');


});


Route::get('/', function () {
    $negocio = App\Negocio::all();
    return view('welcome', compact('negocio'));
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home')->middleware(['estado']);

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/user/get/' , 'Auth\LoginController@getInfo')->name('user.get');
Route::post('/user/contador' , 'Auth\LoginController@Contador')->name('user.contador');
Route::post('/password/reset2' , 'Auth\ForgotPasswordController@ResetPassword')->name('password.reset2');
Route::get('/user-existe/', 'Auth\LoginController@userExiste')->name('user.existe');

//Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
/*Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/
