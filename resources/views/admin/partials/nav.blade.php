    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Navegacion</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{request()->is('admin')? 'active': ''}}" ><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> <span>Inicio</span></a></li>

        @role('Super-Administrador|Administrador|Asistente')
        <li class="treeview {{request()->is('empleados*', 'puestos*','destinos_pedidos*','tipos_localidad*','localidades*','unidades_medida*','categorias_insumos*','insumos*', 'productos*', 'categorias_menus*', 'recetas*', 'cajas*')? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Catalogos Generales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('productos')? 'active': ''}}"><a href="{{route('productos.index')}}"> 
              <i class="fab fa-product-hunt"></i> Productos</a>
            </li>  
          </ul>
          {{-- 
           <ul class="treeview-menu">
            <li class="{{request()->is('vendedores')? 'active': ''}}"><a href="{{route('vendedores.index')}}"> 
              <i class="fas fa-user-tag"></i> Vendedores</a>
            </li>  
          </ul>
          --}}
          <ul class="treeview-menu">
            <li class="{{request()->is('formaPago')? 'active': ''}}"><a href="{{route('formaPago.index')}}"> 
              <i class="fas fa-comments-dollar"></i> Formas de Pago</a>
            </li>  
          </ul>
          <ul class="treeview-menu">
            <li class="{{request()->is('tipoTrabajo')? 'active': ''}}"><a href="{{route('tipoTrabajo.index')}}"> 
              <i class="fas fa-code-branch"></i> Tipos de Trabajo</a>
            </li>  
          </ul>
          <ul class="treeview-menu">
            <li class="{{request()->is('estadosTaller')? 'active': ''}}"><a href="{{route('estadosTaller.index')}}"> 
              <i class="fas fa-wrench"></i> Estados de Taller</a>
            </li>  
          </ul>
          <ul class="treeview-menu">
            <li class="{{request()->is('equipos')? 'active': ''}}"><a href="{{route('equipos.index')}}"> 
              <i class="fas fa-desktop"></i> Equipos</a>
            </li>  
          </ul>
          <ul class="treeview-menu">
            <li class="{{request()->is('ubicacionEquipo')? 'active': ''}}"><a href="{{route('ubicacionEquipo.index')}}"> 
              <i class="fas fa-sign"></i> Ubicaciones de equipo</a>
            </li>  
          </ul>
           <ul class="treeview-menu">
            <li class="{{request()->is('servicios')? 'active': ''}}"><a href="{{route('servicios.index')}}"> 
              <i class="fas fa-taxi"></i> Servicios</a>
            </li>  
          </ul>
          
        </li>
        @endrole


        @role('Super-Administrador|Administrador|Asistente|Jefe de Taller|Asistente de Taller|Vendedor')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fas fa-cogs"></i> <span>Ordenes de Trabajo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
          @role('Super-Administrador|Administrador|Asistente|Vendedor')
            <li class="{{request()->is('clientes')? 'active': ''}}"><a href="{{route('clientes.index')}}"> 
              <i class="fas fa-shopping-basket"></i> Clientes</a>
            </li>  
            @endrole
          </ul>
          <ul class="treeview-menu">
          @role('Super-Administrador|Administrador|Asistente')
            <li class="{{request()->is('ordenequipo')? 'active': ''}}"><a href="{{route('ordenequipo.index')}}"> 
              <i class="fas fa-copy"></i> Registro Orden de Trabajo</a>
            </li>  
            @endrole
          </ul>
          <ul class="treeview-menu">
          @role('Super-Administrador|Administrador|Jefe de Taller|Asistente de Taller')
            <li class="{{request()->is('taller')? 'active': ''}}"><a href="{{route('taller.index')}}"> 
              <i class="fas fa-cog"></i> Gestión Orden en Taller</a>
            </li>  
            @endrole
          </ul>
          <ul class="treeview-menu">
          @role('Super-Administrador|Administrador|Asistente|Vendedor')
            <li class="{{request()->is('asesor')? 'active': ''}}"><a href="{{route('asesor.index')}}"> 
              <i class="fas fa-cog"></i> Gestión Orden con Asesor</a>
            </li>  
            @endrole
          </ul>
          <ul class="treeview-menu">
          @role('Super-Administrador|Administrador|Asistente')
            <li class="{{request()->is('taller')? 'active': ''}}"><a href="{{route('factura.index')}}"> 
              <i class="fas fa-file-invoice"> </i>  Facturación</a>
            </li>  
            @endrole
          </ul>      
                 
        </li>
        @endrole


        @role('Super-Administrador|Administrador|Tecnico|Vendedor')
            <li class="{{request()->is('visitas')? 'active': ''}}"><a href="{{route('visitas.index')}}"> 
              <i class="fas fa-check-double"></i>
              <span>&nbsp Registro de Visitas</span>
              </a>
            </li>
            @endrole


        @role('Super-Administrador|Administrador|Asistente|Tecnico|Vendedor')
          {{-- Cuentas por cobrar --}}
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fas fa-wallet"></i> <span>Cuentas por Cobrar</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('proveedores')? 'active': ''}}"><a href="{{route('cobrar.index')}}"> 
              <i class="fas fa-money-check"></i>  Cuentas por cobrar</a>
            </li>  
          </ul>
        </li>
        {{-- Fin cuentas por cobrar --}}
        @endrole

        @role('Super-Administrador|Administrador|Asistente')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fas fa-money-check-alt"></i> <span>Gestión de Bancos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('cuentasBancarias')? 'active': ''}}"><a href="{{route('cuentas.index')}}"> 
              <i class="fas fa-wallet"></i> Cuentas Bancarias</a>
            </li>  
          </ul>
            <ul class="treeview-menu">
              <li class="{{request()->is('cheques')? 'active': ''}}"><a href="{{route('cheques.index')}}"> 
                <i class="fas fa-money-check"></i> Admon de Cheques</a>
              </li>  
          </ul>
        </li>
        @endrole


        @role('Super-Administrador|Administrador|Asistente|Vendedor|Jefe de Taller')
        <li class="treeview {{request()->is('insumos*')? 'active': ''}}">
          <a href="#"><i class="fas fa-money-check-alt"></i> <span>Insumos y Computadoras</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            @role('Super-Administrador|Administrador|Asistente')
          <ul class="treeview-menu">
            <li class="{{request()->is('insumos')? 'active': ''}}"><a href="{{route('insumos.index')}}"> 
              <i class="fas fa-wallet"></i> Insumos</a>
            </li>  
          </ul>
          @endrole
          @role('Super-Administrador|Administrador|Asistente')
            <ul class="treeview-menu">
              <li class="{{request()->is('compra_insumos')? 'active': ''}}"><a href="{{route('compra_insumos.index')}}"> 
                <i class="fas fa-money-check"></i> Registro Compra Insumos</a>
              </li>  
          </ul>
          @endrole
          @role('Super-Administrador|Administrador|Asistente|Vendedor|Jefe de Taller')
          <ul class="treeview-menu">
              <li class="{{request()->is('requi_insumos')? 'active': ''}}"><a href="{{route('requi_insumos.index')}}"> 
                <i class="fas fa-money-check"></i> Requisición de Insumos</a>
              </li>  
          </ul>
          @endrole
          @role('Super-Administrador|Administrador|Asistente')
          <ul class="treeview-menu">
            <li class="{{request()->is('insumos')? 'active': ''}}"><a href="{{route('compus.index')}}"> 
              <i class="fas fa-wallet"></i> Bodega de Computadoras</a>
            </li>  
          </ul>
          @endrole
        </li>
        @endrole


        @role('Super-Administrador|Administrador|Asistente')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fas fa-motorcycle"></i> <span>Gestión de Envíos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
              <li class="{{request()->is('envios')? 'active': ''}}"><a href="{{route('envios.index')}}"> 
                <i class="fas fa-laptop-code"></i> Registro envíos de equipo</a>
              </li>  
          </ul>
          @role('Super-Administrador|Administrador|Vendedor|Tecnico')
           <ul class="treeview-menu">
              <li class="{{request()->is('envios')? 'active': ''}}"><a href="{{route('rutas.index')}}"> 
                <i class="fas fa-random"></i> Mis rutas</a>
              </li>  
          </ul>
          @endrole

        </li>
        @endrole


        @role('Super-Administrador|Administrador|Asistente')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fas fa-piggy-bank"></i> <span>Gestión de Caja Chica</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('movimientos')? 'active': ''}}"><a href="{{route('movimientos.index')}}"> 
              <i class="fas fa-coins"></i> Movimientos de Caja Chica</a>
            </li>  
          </ul>

        </li>
        @endrole


        @role('Super-Administrador|Administrador|Asistente')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fas fa-store"></i> <span>Gestión de Compras</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('proveedores')? 'active': ''}}"><a href="{{route('proveedores.index')}}"> 
              <i class="fas fa-people-carry"></i> Proveedores</a>
            </li>  
          </ul>
          <ul class="treeview-menu">
            <li class="{{request()->is('compras')? 'active': ''}}"><a href="{{route('compras.index')}}"> 
              <i class="fas fa-shopping-cart"></i> Registro de Compras</a>
            </li>  
          </ul> 

        </li>
        @endrole


        @role('Super-Administrador|Administrador|Asistente')
        {{-- Cuentas por pagar --}}
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fas fa-wallet"></i> <span>Cuentas por Pagar</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('proveedores')? 'active': ''}}"><a href="{{route('pagar.index')}}"> 
              <i class="fas fa-money-check"></i>  Cuentas por pagar</a>
            </li>  
          </ul>
        </li>
        {{-- Fin cuentas por pagar --}}
        @endrole


        @role('Super-Administrador|Administrador|Asistente')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fas fa-network-wired"></i> <span>Gestión de Planilla</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('empleados')? 'active': ''}}"><a href="{{route('empleados.index')}}"> 
              <i class="fas fa-users-cog"></i> Colaboradores</a>
            </li>  
          </ul>
          <ul class="treeview-menu">
            <li class="{{request()->is('puestos')? 'active': ''}}"><a href="{{route('puestos.index')}}"> 
              <i class="fas fa-address-card"></i> Puestos</a>
            </li>  
          </ul>
          <ul class="treeview-menu">
            <li class="{{request()->is('servicios')? 'active': ''}}"><a href="{{route('movs.index')}}"> 
              <i class="fas fa-list-alt"></i>  Ingresos y Egresos</a>
            </li>           
          </ul>
          {{--  --}}
          <ul class="treeview-menu">
            <li class="{{request()->is('planilla')? 'active': ''}}"><a href="{{route('planilla.index')}}"> 
              <i class="fas fa-users-cog"></i> Planillas</a>
            </li>  
          </ul>
        </li>
        @endrole

        @role('Super-Administrador|Administrador|Asistente|Vendedor')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fas fa-clipboard-list"></i> <span>Gestión de Cotizaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('servicios')? 'active': ''}}"><a href="{{route('cotizaciones.index')}}"> 
              <i class="fas fa-list-alt"></i> Cotizaciones</a>
            </li> 
          </ul>

        </li>
        @endrole

        @role('Super-Administrador|Administrador|Asistente|Jefe de Taller|Asistente de Taller|Tecnico|Vendedor')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-users"></i> <span>Gestion Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          @role('Super-Administrador|Administrador|Asistente')
            <li class="{{request()->is('users')? 'active': ''}}"><a href="{{route('users.index')}}"> 
              <i class="fas fa-user-friends"></i> Usuarios</a>
            </li>
            @endrole
            @role('Super-Administrador|Administrador|Asistente|Jefe de Taller|Asistente de Taller|Tecnico|Vendedor')
            <li>
                <a href="#" data-toggle="modal" data-target="#modalResetPassword"><i class="fa fa-lock-open"></i>Cambiar contraseña</a>             
            </li>
            @endrole

          </ul>          
        </li>
        @endrole

        @role('Super-Administrador')

        <li class="treeview {{request()->is('negocio*')? 'active': ''}}">
            <a href="#"><i class="fa fa-building"></i> <span>Mi Negocio</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
  
            <ul class="treeview-menu">
              <li class="{{request()->routeIs('negocio.edit')? 'active': ''}}"><a href="{{route('negocio.edit', 1)}}"> 
                <i class="fa fa-edit"></i>Editar Mi Negocio</a>
              </li>  
            </ul>
        </li>
        @endrole
        
        
    </ul>

    <!-- /.sidebar-menu -->