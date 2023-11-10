<?php

class Usuario
{
    public $id;
    public $usuario;
    public $tipo;
    public $clave;
    public $fechaCreacion;
    public $estado;
    public $nombre;


    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (usuario, tipo, estado, clave, fechaCreacion, nombre) VALUES (:usuario, :tipo, :estado, :clave, :fechaCreacion, :nombre)");
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':stado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR); 
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':fechaCreacion', date('Y-m-d H:i:s'));


        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT usuarios.id, usuarios.usuario, tipousuario.tipo,  estadousuario.estado, usuarios.clave, usuarios.fechaCreacion, usuarios.nombre FROM usuarios JOIN tipousuario ON usuarios.tipo = tipousuario.id JOIN estadousuario ON usuarios.estado = estadousuario.id");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($usuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT usuarios.id, usuarios.usuario, tipousuario.tipo, estadousuario.estado, usuarios.clave, usuarios.fechaCreacion, usuarios.nombre FROM usuarios JOIN tipousuario ON usuarios.tipo = tipousuario.id JOIN estadousuario ON usuarios.estado = estadousuario.id WHERE usuario = :usuario");
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }


    public static function borrarUsuario($usuario)
    {
        $mensaje = "";
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consultaVerificacion = $objAccesoDato->prepararConsulta("SELECT estado FROM usuarios WHERE usuario = :usuario");
        $consultaVerificacion->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consultaVerificacion->execute();
        $estadoUsuario = $consultaVerificacion->fetchColumn();

        if ($estadoUsuario == 3) {
            $mensaje = "El usuario ya fue dado de baja.";
        } else {
            $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET estado = :estado WHERE usuario = :usuario");
            $consulta->bindValue(':usuario', $usuario, PDO::PARAM_INT);
            $consulta->bindValue(':estado', 3, PDO::PARAM_INT); // Cambio fechaBaja por estado y seteo a 3
            $consulta->execute();
            $mensaje = "Usuario dado de baja.";
        }

        return $mensaje;
    }

}