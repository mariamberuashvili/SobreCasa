<?php
if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION["login"] ?? false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SobreCasa</title>
    <link rel="stylesheet" href="<?php echo RUTA_PUBLIC; ?>/build/css/app.css">
</head>
<body>

<header class="header inicio <?php echo $inicio ? 'inicio' : ''; ?>">
    

<div class="contenedor contenido-header">
        
        <div class="barra">
            <a href="<?php echo RUTA_PUBLIC; ?>/">
                <h1>SobreCasa</h1>
            </a>

            <div class="mobile-menu">
                <img src="<?php echo RUTA_PUBLIC; ?>/build/img/barras.svg" alt="icono menu responsive">
            </div>

            <div class="derecha">
                <img class="dark-mode-boton" src="<?php echo RUTA_PUBLIC; ?>/build/img/dark-mode.svg" alt="modo oscuro">
                <nav class="navegacion">
                    <a href="<?php echo RUTA_PUBLIC; ?>/nosotros">Nosotros</a>
                    <a href="<?php echo RUTA_PUBLIC; ?>/propiedades">Anuncios</a>
                    <a href="<?php echo RUTA_PUBLIC; ?>/blog">Blog</a>
                    <a href="<?php echo RUTA_PUBLIC; ?>/contacto">Contacto</a>
                    <?php if ($auth): ?>
                        <a href="<?php echo RUTA_PUBLIC; ?>/logout">Cerrar Sesión</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>

       <?php if ($inicio): ?>
            <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
        <?php endif; ?>
    </div>
</header>
