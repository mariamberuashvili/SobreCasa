<?php

namespace Model;

class Admin extends ActiveRecord {

    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "email", "password"];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
    }

    public function validar() {
        if (!$this->email) {
            self::$errores[] = "El Email del usuario es obligatorio";
        }
        if (!$this->password) {
            self::$errores[] = "El Password del usuario es obligatorio";
        }
        return self::$errores;
    }

    public function existeUsuario(): ?array {
        
        $query = "SELECT * FROM usuarios WHERE email = '" . self::$db->escape_string($this->email) . "' LIMIT 1";
        $resultado = self::$db->query($query);

       
        if ($resultado && $resultado->num_rows) {
            return $resultado->fetch_assoc();
        }

        
        self::$errores[] = "El Usuario no existe";
        return null;
    }

    public function verificarPassword(?array $usuario): bool {
        if (!$usuario) return false; 
        return password_verify($this->password, $usuario['password']);
    }

    public function autenticar(string $email): void {
        session_start();
        session_regenerate_id(true);

        $_SESSION['usuario'] = $email;
        $_SESSION['login'] = true;

        header('Location: ' . RUTA_PUBLIC . '/admin');
        exit;
    }
}


