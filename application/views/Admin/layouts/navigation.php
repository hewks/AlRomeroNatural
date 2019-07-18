<!-- Header -->
<header>

    <div class="bs-navigation">

        <a href="#" class="bs-nav-brand">
            BackSurface
        </a>

        <div class="bs-nav-left-content">
            <button class="bs-nav-toggler" id="bs-sidebar-toggler-btn">
                <i class="fas fa-bars"></i>
            </button>

            <div class="bs-nav-user">
                <a href="#">Username</a>
            </div>
        </div>

    </div>

    <div id="bs-main-sidebar" class="bs-sidebar">
        <div class="bs-sidebar-separator">
            <span class="bs-sidebar-separator-title">Estadisticas</span>
        </div>
        <a href="<?= base_url() ?>BackOffice/Ventas" class="bs-sidebar-block-a">Local</a>
        <div class="bs-sidebar-separator">
            <span class="bs-sidebar-separator-title">Negocio</span>
        </div>        
        <a href="<?= base_url() ?>BackOffice/Ventas" class="bs-sidebar-block-a">Ventas</a>
        <a href="<?= base_url() ?>BackOffice/Compras" class="bs-sidebar-block-a">Compras</a>
        <a href="<?= base_url() ?>BackOffice/Nomina" class="bs-sidebar-block-a">Nomina</a>
        <a href="<?= base_url() ?>BackOffice/Servicios" class="bs-sidebar-block-a">Servicios</a>
        <div class="bs-sidebar-separator">
            <span class="bs-sidebar-separator-title">Productos</span>
        </div>
        <a href="<?= base_url() ?>BackOffice/Productos" class="bs-sidebar-block-a">Productos</a>
        <a href="<?= base_url() ?>BackOffice/Categorias" class="bs-sidebar-block-a">Categorias</a>
        <div class="bs-sidebar-separator">
            <span class="bs-sidebar-separator-title">Usuarios</span>
        </div>
        <a href="<?= base_url() ?>BackOffice/Clientes" class="bs-sidebar-block-a">Clientes</a>
        <div class="bs-sidebar-separator">
            <span class="bs-sidebar-separator-title">Configuracion</span>
        </div>
        <a href="<?= base_url() ?>BackOffice/Administradores" class="bs-sidebar-block-a">Administradores</a>
    </div>

</header>
<!-- Header -->