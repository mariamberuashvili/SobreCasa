<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {

    public static function index(Router $router): void {
        $propiedades = Propiedad::all();
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => true
        ]);
    }

    public static function nosotros(Router $router): void {
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router): void {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', ['propiedades' => $propiedades]);
    }

    public static function propiedad(Router $router): void {
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad', ['propiedad' => $propiedad]);
    }

    public static function blog(Router $router): void {
        $router->render('paginas/blog');
    }

    public static function entrada(Router $router): void {
        $router->render('paginas/entrada');
    }

    public static function contacto(Router $router): void {
        session_start();
        $mensaje = null;

       
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrf_token = $_SESSION['csrf_token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'] ?? [];
            $token = $_POST['csrf_token'] ?? '';

            if (!hash_equals($csrf_token, $token)) {
                $mensaje = "aviso, algo va mal!";
            } else {
                $nombre = trim(htmlspecialchars($respuestas['nombre'] ?? ''));
                $email = filter_var($respuestas['email'] ?? '', FILTER_VALIDATE_EMAIL);
                $telefono = trim(htmlspecialchars($respuestas['telefono'] ?? ''));
                $mensajeFormulario = trim(htmlspecialchars($respuestas['mensaje'] ?? ''));
                $opciones = trim(htmlspecialchars($respuestas['opciones'] ?? ''));
                $presupuesto = trim(htmlspecialchars($respuestas['presupuesto'] ?? ''));
                $contacto = $respuestas['contacto'] ?? '';
                $fecha = trim(htmlspecialchars($respuestas['fecha'] ?? ''));
                $hora = trim(htmlspecialchars($respuestas['hora'] ?? ''));

                if ($contacto === 'email' && !$email) {
                    $mensaje = "Por favor ponlo gmail corecto.";
                } else {
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'sandbox.smtp.mailtrap.io';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'bdb6748a079ae1';
                    $mail->Password = '4f39113fde9842';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 2525;

                    $mail->setFrom('admin@SobreCasa.com', $nombre);
                    $mail->addAddress('admin@SobreCasa.com', 'SobreCasa-mvcs');
                    $mail->Subject = 'Nueva mensaje';
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';

                    $contenido = <<<HTML
<html>
    <p><strong>Nombre:</strong> {$nombre}</p>
    <p><strong>Mensaje:</strong> {$mensajeFormulario}</p>
    <p><strong>Compra/Venta:</strong> {$opciones}</p>
    <p><strong>Precio:</strong> {$presupuesto}</p>
HTML;

                    if ($contacto === 'telefono') {
                        $contenido .= <<<HTML
    <p>Como quiere contancar gmail/telefono</p>
    <p>Telefono: {$telefono}</p>
    <p>Fecha y hora: {$fecha} - {$hora}</p>
HTML;
                    } else {
                        $contenido .= <<<HTML
    <p>Si quieres con gmail</p>
    <p>Gmail: {$email}</p>
HTML;
                    }

                    $contenido .= "</html>";

                    $mail->Body = $contenido;
                    $mail->AltBody = "nombre: {$nombre}\nmensaje: {$mensajeFormulario}";

                    $mensaje = $mail->send() ? "gmailya esta enviado corectamente" : "algo va mal, intentalo de nuevo";
                }
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje,
            'csrf_token' => $csrf_token
        ]);
    }
}

