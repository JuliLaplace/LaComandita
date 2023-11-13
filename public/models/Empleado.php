<?php

class Empleado
{
    public $id;
    public $usuario;
    public $sector;
    public $clave;
    public $fechaCreacion;
    public $estado;
    public $nombre;


    public function crearEmpleado()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO empleados (usuario, sector, estado, clave, fechaCreacion, nombre) VALUES (:usuario, :sector, :estado, :clave, :fechaCreacion, :nombre)");
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':fechaCreacion', date('Y-m-d H:i:s'));


        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }
    /*
    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT usuarios.id, usuarios.usuario, tipousuario.tipo,  estadousuario.estado, usuarios.clave, usuarios.fechaCreacion, usuarios.nombre FROM usuarios JOIN tipousuario ON usuarios.tipo = tipousuario.id JOIN estadousuario ON usuarios.estado = estadousuario.id");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }
    */
    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT empleados.id, empleados.usuario, sector.sector, estadousuario.estado, empleados.clave, empleados.fechaCreacion, empleados.nombre FROM empleados JOIN sector ON empleados.sector = sector.id JOIN estadousuario ON empleados.estado = estadousuario.id WHERE empleados.estado NOT IN (2, 3)");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Empleado');
    }
    public static function obtenerEmpleado($usuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT empleados.id, empleados.usuario, sector.sector, estadousuario.estado, empleados.clave, empleados.fechaCreacion, empleados.nombre FROM empleados JOIN sector ON empleados.sector = sector.id JOIN estadousuario ON empleados.estado = estadousuario.id WHERE usuario = :usuario");
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Empleado');
    }


    public static function borrarEmpleado($usuario)
    {
        $mensaje = "";
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consultaVerificacion = $objAccesoDato->prepararConsulta("SELECT estado FROM empleados WHERE usuario = :usuario");
        $consultaVerificacion->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consultaVerificacion->execute();
        $estadoUsuario = $consultaVerificacion->fetchColumn();

        if ($estadoUsuario == 3) {
            $mensaje = "El empleado ya fue dado de baja.";
        } else {
            $consulta = $objAccesoDato->prepararConsulta("UPDATE empleados SET estado = :estado WHERE usuario = :usuario");
            $consulta->bindValue(':usuario', $usuario, PDO::PARAM_INT);
            $consulta->bindValue(':estado', 3, PDO::PARAM_INT); // Cambio fechaBaja por estado y seteo a 3
            $consulta->execute();
            $mensaje = "Empleado dado de baja.";
        }

        return $mensaje;
    }

    public static function modificarEmpleado($usuario, $clave, $nombre)
    {
        $mensaje = "";
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE empleados SET clave = :clave, nombre = :nombre WHERE usuario = :usuario");

        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);

        $consulta->execute();

        $filasAfectadas = $consulta->rowCount(); //me dice cuantas filas fueron modificadas

        if ($filasAfectadas > 0) {
            $mensaje = "El empleado fue modificado.";
        } else {
            $mensaje = "No se pudo modificar el empleado.";
        }

        return $mensaje;
    }

    public static function empleadoExiste($usuario, $clave)
    {

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados WHERE usuario = :usuario AND clave = :clave");
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Empleado');
    }
}
