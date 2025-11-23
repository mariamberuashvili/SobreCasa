<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController {

    
    public static function index(Router $router) {
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;

        $router->render('vendedores/index', [
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }

   
    public static function crear(Router $router) {
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vendedor = new Vendedor($_POST['vendedor']);
            $errores = $vendedor->validar();

            if(empty($errores)) {
                $resultado = $vendedor->guardar();
                if($resultado) {
                    header('Location: ' . RUTA_PUBLIC . '/vendedores?resultado=1');
                    exit;
                }
            }
        }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

   
    public static function actualizar(Router $router) {
        $id = validarORedireccionar(RUTA_PUBLIC . '/vendedores');
        $vendedor = Vendedor::find($id);
        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['vendedors'];
            $vendedor->sincronizar($args);
            $errores = $vendedor->validar();

            if(empty($errores)) {
                $resultado = $vendedor->guardar();
                if($resultado) {
                    header('Location: ' . RUTA_PUBLIC . '/vendedores?resultado=2');
                    exit;
                }
            }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }
public static function eliminar(Router $router) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        if (!$id) {
            return;
        }

      
        $vendedor = Vendedor::find($id);
        if (!$vendedor) {
            return;
        }

      
        $resultado = $vendedor->eliminar();
        if ($resultado) {
            header('Location: ' . RUTA_PUBLIC . '/vendedores?resultado=3');
            exit;
        } else {
            echo "No se pudo eliminar el vendedor";
        }
    }
}
}
