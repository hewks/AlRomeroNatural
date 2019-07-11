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

    <?php if ($options['google_analitics']) : ?>
        <script>
            alert('Google');
        </script>
    <?php endif; ?>

    <style>
        @font-face {
            font-family: "Chalk Hand";
            src: url("assets/fonts/chalk-hand-lettering-shaded.otf") format("opentype");
        }

        @font-face {
            font-family: "Angelina Vintage";
            src: url("assets/fonts/angeline-vintage.otf") format("opentype");
        }
    </style>

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/layout.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/fontawesome/css/all.min.css">

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
                <a href="#" class="hw-header-link">Jabones</a>
                <a href="#" class="hw-header-link">Ingreso</a>
                <a href="#" class="hw-header-link">Registro</a>
                <div id="hw-navigation-toggler" class="hw-header-brand">
                    <h1>Al Romero Natural</h1>
                </div>
                <a href="#" class="hw-header-link">Nosotros</a>
                <a href="#" class="hw-header-link">Contacto</a>
                <a href="#" class="hw-header-link">Mapa</a>
            </header>

            <div class="hw-sidebar" id="hw-primary-sidebar">
                <div class="hw-sidebar-title">
                    <span>Productos</span>
                </div>
                <div class="hw-sidebar-links-container">
                    <a href="#" class="hw-sidebar-link">Jabones</a>
                </div>
                <div class="hw-sidebar-title">
                    <span>Usuarios</span>
                </div>
                <div class="hw-sidebar-links-container">
                    <a href="#" class="hw-sidebar-link">Ingreso</a>
                    <a href="#" class="hw-sidebar-link">Registro</a>
                </div>
                <div class="hw-sidebar-title">
                    <span>Nuestra Tienda</span>
                </div>
                <div class="hw-sidebar-links-container">
                    <a href="#" class="hw-sidebar-link">Informaci&oacute;n</a>
                    <a href="#" class="hw-sidebar-link">Contacto</a>
                    <a href="#" class="hw-sidebar-link">Mapa</a>
                </div>
            </div>

        </div>
        <!-- //Navigation -->

        <!-- Section Container -->
        <div class="hw-section-container">