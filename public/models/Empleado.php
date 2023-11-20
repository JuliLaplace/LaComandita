<?php
require_once './interfaces/IApiABM.php';
class Empleado implements IApiABM
{
    public $id;
    public $usuario;
    public $sector;
    public $clave;
    public $fechaCreacion;
    public $fechaBaja;
    public $fechaModificacion;
    public $estado;
    public $nombre;


    public function crearUno()
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


    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT empleados.id, empleados.usuario, sector.sector, estadousuario.estado, empleados.clave, empleados.fechaCreacion, empleados.fechaBaja, empleados.fechaModificacion, empleados.nombre FROM empleados JOIN sector ON empleados.sector = sector.id JOIN estadousuario ON empleados.estado = estadousuario.id WHERE empleados.estado NOT IN (2, 3) AND empleados.fechaBaja IS NULL");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Empleado');
    }

    public static function obtenerUno($usuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT empleados.id, empleados.usuario, sector.sector, estadousuario.estado, empleados.clave, empleados.fechaCreacion, empleados.fechaBaja, empleados.fechaModificacion, empleados.nombre FROM empleados JOIN sector ON empleados.sector = sector.id JOIN estadousuario ON empleados.estado = estadousuario.id WHERE usuario = :usuario AND empleados.fechaBaja IS NULL");
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();
        $empleado = $consulta->fetchObject('Empleado');
        return $empleado;
    }


    public static function borrarUno($usuario)
    {
        $mensaje = "";
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $empleadoExistente = self::obtenerUno($usuario);

        if (!$empleadoExistente) {
            $mensaje = "No se encontró el empleado.";
        } else {
            $consultaVerificacion = $objAccesoDato->prepararConsulta("SELECT fechaBaja FROM empleados WHERE usuario = :usuario");
            $consultaVerificacion->bindValue(':usuario', $usuario, PDO::PARAM_STR);
            $consultaVerificacion->execute();
            $fechaExiste = $consultaVerificacion->fetchColumn();

            if ($fechaExiste != NULL) {
                $mensaje = "El empleado ya fue dado de baja.";
            } else {
                $consulta = $objAccesoDato->prepararConsulta("UPDATE empleados SET fechaBaja = :fechaBaja, estado = :estado WHERE usuario = :usuario");
                $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
                $consulta->bindValue(':fechaBaja', date('Y-m-d H:i:s'));
                $consulta->bindValue(':estado', 3, PDO::PARAM_INT);
                $consulta->execute();
                $mensaje = "Empleado dado de baja.";
            }
        }


        return $mensaje;
    }



    public static function modificarEmpleado($usuario, $clave, $nombre)
    {
        $mensaje = "";
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $empleadoExistente = self::obtenerUno($usuario);

        if (!$empleadoExistente) {
            $mensaje = "No existe el empleado";
        } else {
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE empleados SET clave = :clave, nombre = :nombre, fechaModificacion = :fechaModificacion WHERE usuario = :usuario");

            $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));

            $consulta->execute();
            $mensaje = "Empleado modificado.";
        }

        return $mensaje;
    }

    //verifica que este logueado lo que me mandan por parametros
    public static function UsuarioContrasenaExiste($usuario, $clave)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados WHERE usuario = :usuario AND clave = :clave");
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Empleado');
    }

}
