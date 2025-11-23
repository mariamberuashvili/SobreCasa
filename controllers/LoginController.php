<?php

declare(strict_types=1);

namespace Controllers;

use MVC\Router;
use Model\Admin;

final class LoginController
{
    public static function login(Router $router): void
    {
        session_start();
        $errores = [];

      
        if (!empty($_SESSION['login'])) {
         header('Location: ' . RUTA_PUBLIC . '/admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);

$errores = $auth->validar();

if (empty($errores)) {
    $usuario = $auth->existeUsuario();

    if ($usuario && $auth->verificarPassword($usuario)) {
        $auth->autenticar($usuario['email']);
    } else {
        $errores[] = 'Usuario o contraseña incorrectos';
    }
}

        }

        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }

    public static function logout(): void
    {
        session_start();
        $_SESSION = [];
        session_destroy();

      header('Location: ' . RUTA_PUBLIC . '/');
exit;

    }
    
}
