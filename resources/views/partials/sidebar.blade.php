<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo de la Marca -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('images/intelconn.jpg') }}" alt="Logo Intelcon" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">INTELCOM</span>
    </a>

    <!-- Contenido de la Barra Lateral -->
    <div class="sidebar">
        <!-- Panel de Usuario -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->first_name }}</a>
            </div>
        </div>

        <!-- Menú de Navegación -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- === ENLACES COMUNES PARA TODOS LOS ROLES === -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>Mi Perfil</p>
                    </a>
                </li>

                <!-- =================================================== -->
                <!--               MENÚ DEL ADMINISTRADOR                -->
                <!-- =================================================== -->
                @if(Auth::user()->role_id == 1) {{-- Asumiendo que 1 es el ID del rol de Admin --}}
                    
                    <li class="nav-header">GESTIÓN DE CLIENTES</li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Clientes <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Ver Todos</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Registrar Cliente</p></a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">GESTIÓN FINANCIERA</li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Pagos <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('payments.index') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Historial General</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('payments.create') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Registrar Pago</p></a>
                            </li>
                            <!-- INICIO: NUEVO ENLACE -->
                            <li class="nav-item">
                                <a href="{{ route('payments.paid') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon text-success"></i>
                                    <p>Pagos Pagados</p>
                                </a>
                            </li>
                            <!-- FIN: NUEVO ENLACE -->
                            <li class="nav-item">
                                <a href="{{ route('payments.pending') }}" class="nav-link"><i class="far fa-circle nav-icon text-warning"></i><p>Pagos Pendientes</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('payments.overdue') }}" class="nav-link"><i class="far fa-circle nav-icon text-danger"></i><p>Clientes Con Pagos Morosos</p></a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">GESTIÓN DE SERVICIOS</li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-wifi"></i>
                            <p>Servicios <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{-- route('services.index') --}}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Historial de Servicios</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{-- route('services.create') --}}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Registrar Servicio</p></a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">CONFIGURACIÓN</li>
                    <li class="nav-item">
                        <a href="{{-- route('zones.index') --}}" class="nav-link">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>Zonas Geográficas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{-- route('roles.index') --}}" class="nav-link">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Roles y Permisos</p>
                        </a>
                    </li>

                @else
                <!-- =================================================== -->
                <!--                  MENÚ DEL CLIENTE                   -->
                <!-- =================================================== -->
                    <li class="nav-header">MI CUENTA</li>

                    <li class="nav-item">
                        <a href="{{-- route('my-service.show') --}}" class="nav-link">
                            <i class="nav-icon fas fa-wifi text-success"></i>
                            <p>Mi Servicio</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>Mis Pagos <i class="right fas fa-angle-left"></i></p>
                        </a>
                         <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{-- route('my-payments.index') --}}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Ver mi Historial</p></a>
                            </li>
                             <li class="nav-item">
                                <a href="{{ route('my-payments.create') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Reportar un Pago</p></a>
                            </li>
                        </ul>
                    </li>
                     <li class="nav-item">
                        <a href="{{-- route('documents.index') --}}" class="nav-link">
                            <i class="nav-icon fas fa-file-upload"></i>
                            <p>Mis Documentos</p>
                        </a>
                    </li>
                @endif

                <!-- === ENLACE DE CERRAR SESIÓN (COMÚN PARA TODOS) === -->
                <li class="nav-header"></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p class="text">Cerrar Sesión</p>
                    </a>
                    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>