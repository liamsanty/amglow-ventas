<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="{{ route('panel') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fst-italic"></i></div>
                    Sistema Post Ventas Amglow
                </a>

                <div class="sb-sidenav-menu-heading">Maestros</div>

                @hasanyrole('Administrador')
                <a class="nav-link" href="{{ route('categorias.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-folder-open"></i></div>
                    Categorías
                </a>
                @endhasanyrole

                @hasanyrole('Administrador')
                <a class="nav-link" href="{{ route('marcas.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-tag"></i></div>
                    Marcas
                </a>
                @endhasanyrole

                @hasanyrole('Administrador')
                <a class="nav-link" href="{{ route('productos.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    Productos
                </a>
                @endhasanyrole
                @hasanyrole('Administrador')
                <a class="nav-link" href="{{ route('clientes.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users-line"></i>
                    </div>
                    Clientes
                </a>
                @endhasanyrole

                @hasanyrole('Administrador')
                <a class="nav-link" href="{{ route('proveedores.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid  fa-handshake"></i>
                    </div>
                    Proveedores
                </a>
                @endhasanyrole

                <div class="sb-sidenav-menu-heading">Procesos</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVentas"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    Ventas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseVentas" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('ventas.index') }}">Ver</a>

                            <a class="nav-link" href="{{ route('ventas.create') }}">Crear</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                    Compras
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse show" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('compras.index') }}">Ver</a>
                        <a class="nav-link" href="{{ route('compras.create') }}">Crear</a>
                    </nav>
                </div>

            @if(auth()->user()->hasRole('Administrador'))
                <div class="sb-sidenav-menu-heading">ROLES Y PERMISOS</div>
                    <a class="nav-link" href="{{ route('roles.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid  fa-user"></i>
                        </div>
                        Roles
                    </a>
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid  fa-person-circle-plus"></i>
                        </div>
                        Usuarios
                    </a>
                </div>
            @endif
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>
