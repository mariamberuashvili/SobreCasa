<?php
$inicio = $inicio ?? false;
if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SobreCasa-mvcs</title>
    <link rel="stylesheet" href="<?php echo RUTA_PUBLIC; ?>/build/css/app.css">
</head>
<body>

<?php incluirTemplate('header', true); ?>


<main class="contenedor seccion">
    <?php echo $contenido; ?>
</main>

<?php incluirTemplate('footer'); ?>

<script src="<?php echo RUTA_PUBLIC; ?>/build/js/bundle.min.js" defer></script>
</body>
</html>
