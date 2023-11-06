<?php

class Usuario
{
    public $id;
    public $usuario;
    public $tipo;
    public $clave;
    public $fecha_creacion;
    public $nombre;
    public $dni;

    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuario (usuario, tipo, clave, fecha_creacion, nombre, dni) VALUES (:usuario, :tipo, :clave, :fecha_creacion, :nombre, :dni)");
        //$claveHash = password_hash($this->clave, PASSWORD_DEFAULT);
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR); 
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_creacion', date('Y-m-d H:i:s'));
        $consulta->bindValue(':dni', $this->dni, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT usuario.id, usuario.usuario, tipousuario.tipo, usuario.clave, usuario.fecha_creacion, usuario.nombre, usuario.dni FROM usuario JOIN tipousuario ON usuario.tipo = tipousuario.id");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

}