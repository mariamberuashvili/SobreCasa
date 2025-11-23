<?php
require_once __DIR__ . "/funciones.php";
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/../models/ActiveRecord.php";
require_once __DIR__ . "/../models/Propiedad.php";
require_once __DIR__ . "/../models/Vendedor.php";

use Model\ActiveRecord;


define('RUTA_PUBLIC', '/SobreCasa-mvc/public');
define('CARPETA_IMAGENES', __DIR__ . '/../public/imagenes/');


$db = conectarDB();
ActiveRecord::setDB($db);
