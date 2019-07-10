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

    <?php foreach ($links as $link) : ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/<?= $link ?>">
    <?php endforeach; ?>

</head>

<body>