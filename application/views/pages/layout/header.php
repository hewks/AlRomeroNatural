<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="author" content="<?= $author ?>">
    <meta name="description" content="<?= $description ?>">
    <meta name="keywords" content="<?= $keywords ?>">

    <title><?= $title ?></title>

    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/icons/logo3.png">

    <?php if ($options['google_analitics']) : ?>
        <script>
            alert('Google');
        </script>
    <?php endif; ?>

    <?=
        '<style>
        @font-face {
            font-family: "Chalk Hand";
            src: url("' . base_url() . 'assets/fonts/chalk-hand-lettering-shaded.otf") format("opentype");
        }
        @font-face {
            font-family: "Angelina Vintage";
            src: url("' . base_url() . 'assets/fonts/angeline-vintage.otf") format("opentype");
        }
    </style>'
    ?>

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/pnotify/css/pnotify.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/pnotify/css/pnotify.mobile.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/pnotify/css/pnotify.history.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/pnotify/css/pnotify.buttons.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/pnotify/css/pnotifybrighttheme.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/layout.css">

    <?php foreach ($links as $link) : ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/<?= $link ?>">
    <?php endforeach; ?>

</head>

<body>

    <!-- Page Container -->
    <div class="hw-page-container hw-cover-bg hw-bg-theme-color">

        <!-- Navigation -->
        <div class="hw-navigation">

            <header class="hw-header-navigation">
                <a href="<?= base_url() ?>" class="hw-header-link">Jabones</a>
                <?php if ($this->session->userdata('login')) : ?>
                    <a href="<?= base_url() ?>Users/Profile" class="hw-header-link">Mi Perfil</a>
                    <a href="#" class="hw-header-link hw-exit-link hw-exit-button">Salir</a>
                <?php else : ?>
                    <a href="<?= base_url() ?>Users" class="hw-header-link">Ingreso</a>
                    <a href="<?= base_url() ?>Users/Index/Register" class="hw-header-link">Registro</a>
                <?php endif; ?>
                <div id="hw-navigation-toggler" class="hw-header-brand">
                    <h1>Al Romero Natural</h1>
                </div>
                <a href="<?= base_url() ?>Admin" class="hw-header-link">Admin</a>
                <a href="#" class="hw-header-link">Contacto</a>
                <a href="#" class="hw-header-link">Mapa</a>
            </header>

            <div class="hw-sidebar" id="hw-primary-sidebar">
                <div class="hw-sidebar-title">
                    <span>Productos</span>
                </div>
                <div class="hw-sidebar-links-container">
                    <a href="<?= base_url() ?>" class="hw-sidebar-link">Jabones</a>
                </div>
                <div class="hw-sidebar-title">
                    <span>Usuarios</span>
                </div>
                <div class="hw-sidebar-links-container">
                    <?php if ($this->session->userdata('login')) : ?>
                        <a href="<?= base_url() ?>Users/Profile" class="hw-sidebar-link">Mi Perfil</a>
                        <a href="#" class="hw-sidebar-link hw-exit hw-exit-button">Salir</a>
                    <?php else : ?>
                        <a href="<?= base_url() ?>Users" class="hw-sidebar-link">Ingreso</a>
                        <a href="<?= base_url() ?>Users/Index/Register" class="hw-sidebar-link">Registro</a>
                    <?php endif; ?>
                </div>
                <div class="hw-sidebar-title">
                    <span>Nuestra Tienda</span>
                </div>
                <div class="hw-sidebar-links-container">
                    <a href="<?= base_url() ?>Admin" class="hw-sidebar-link">Admin</a>
                    <a href="#" class="hw-sidebar-link">Contacto</a>
                    <a href="#" class="hw-sidebar-link">Mapa</a>
                </div>
            </div>

        </div>
        <!-- //Navigation -->

        <!-- Section Container -->
        <div class="hw-section-container">