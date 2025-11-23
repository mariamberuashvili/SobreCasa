<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;

class PropiedadController
{
   
    public static function index(Router $router)
    {
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/index', [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }

   
    public static function crear(Router $router)
    {
        $propiedad = new Propiedad();
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $propiedad->sincronizar($_POST['propiedad']);


if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
    $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
    move_uploaded_file($_FILES['imagen']['tmp_name'], CARPETA_IMAGENES . $nombreImagen);
    $propiedad->setImagen($nombreImagen);
}

            
            $errores = $propiedad->validar();

            if (empty($errores)) {
                $propiedad->guardar();
                header('Location: ' . RUTA_PUBLIC . '/propiedades?resultado=1');
                exit;
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

   
    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $propiedad->sincronizar($_POST['propiedad']);


if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
    $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
    move_uploaded_file($_FILES['imagen']['tmp_name'], CARPETA_IMAGENES . $nombreImagen);
    $propiedad->setImagen($nombreImagen);
}

         
            $errores = $propiedad->validar();

            if (empty($errores)) {
                $propiedad->guardar();
                header('Location: ' . RUTA_PUBLIC . '/propiedades?resultado=2');
                exit;
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

  
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            if ($id) {
                $propiedad = Propiedad::find($id);
                if ($propiedad) {
                    $propiedad->eliminar();
                    header('Location: ' . RUTA_PUBLIC . '/propiedades?resultado=3');
                    exit;
                }
            }
        }
    }
  


}
