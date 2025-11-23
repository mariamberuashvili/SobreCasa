<?php

namespace Model;

class ActiveRecord {

    protected static $db;
    protected static $tabla = "";
    protected static $columnasDB = [];

    public $id;
    public $imagen;
    public $precio;
    public $titulo;

    public $nombre;
    public $apellido;
    public $telefono;

    protected static $errores = [];

    
    public static function setDB($database) {
        self::$db = $database;
    }

 
    public static function getErrores() {
        return static::$errores;
    }

    
    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    
    public function guardar() {
        if (!is_null($this->id)) {
            return $this->actualizar();
        } else {
            return $this->crear();
        }
    }

   
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        return self::consultarSQL($query);
    }
 
    public static function find($id) {
        $id = intval($id);
        if (!$id) return null;

        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id} LIMIT 1";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

  
    public function crear() {
        $atributos = $this->sanitizarAtributos();

        $query = "INSERT INTO " . static::$tabla . " (" . join(', ', array_keys($atributos)) . ") ";
        $query .= "VALUES ('" . join("', '", array_values($atributos)) . "')";
        return self::$db->query($query);
    }

   
    public function actualizar() {
        $atributos = $this->sanitizarAtributos();
        $valores = [];

        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET " . join(', ', $valores);
        $query .= " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        return self::$db->query($query);
    }


    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
        }

        return $resultado;
    }

    
    public static function consultarSQL($query) {
        $resultado = self::$db->query($query);
        $array = [];

        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        $resultado->free();
        return $array;
    }

    
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

  
    public function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

  
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    
    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }


    public function setImagen($imagen) {
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }

        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    
    public function borrarImagen() {
        if (isset($this->imagen) && !empty($this->imagen)) {
            $ruta = CARPETA_IMAGENES . $this->imagen;
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
    }
}
