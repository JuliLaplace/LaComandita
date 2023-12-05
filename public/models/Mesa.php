<?php
require_once './interfaces/IApiABM.php';
class Mesa implements IApiABM{
    public $id;
    public $codigoMesa;
    public $estado;
    public $fechaCreacion;
    public $fechaBaja;
    public $fechaModificacion;


    public function crearUno()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (codigoMesa, estado, fechaCreacion) VALUES (:codigoMesa, :estado, :fechaCreacion)");
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_STR);
        $consulta->bindValue(':estado', 4, PDO::PARAM_STR);
        $consulta->bindValue(':fechaCreacion', date('Y-m-d H:i:s'));

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }


    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT mesas.id, mesas.codigoMesa, estadomesa.estado, mesas.fechaCreacion, mesas.fechaBaja, mesas.fechaModificacion  FROM mesas JOIN estadomesa ON mesas.estado = estadomesa.id WHERE mesas.fechaBaja IS NULL;");
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }

    
    public static function obtenerUno($codigomesa)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT mesas.id, mesas.codigoMesa, estadomesa.estado, mesas.fechaCreacion, mesas.fechaBaja, mesas.fechaModificacion FROM mesas JOIN estadomesa ON mesas.estado = estadomesa.id WHERE mesas.codigoMesa = :codigoMesa AND mesas.fechaBaja IS NULL");
        $consulta->bindValue(':codigoMesa', $codigomesa, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Mesa');
    }

    public static function borrarUno($codigoMesa)
    {
        $mensaje = "";
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $mesaExistente = self::obtenerUno($codigoMesa);

        if(!$mesaExistente){
            $mensaje = "No se encontró la mesa.";
        }else{
            if($mesaExistente->estado !=4){
                $mensaje = "No se puede eliminar la mesa porque tiene pedidos.";
            }else{
                $consultaVerificacion = $objAccesoDato->prepararConsulta("SELECT fechaBaja FROM mesas WHERE codigoMesa = :codigoMesa");
                $consultaVerificacion->bindValue(':codigoMesa', $codigoMesa, PDO::PARAM_STR);
                $consultaVerificacion->execute();
                $fechaExiste = $consultaVerificacion->fetchColumn();

                if ($fechaExiste != NULL) {
                    $mensaje = "La mesa ya fue dada de baja.";
                } else {
                    $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET fechaBaja = :fechaBaja WHERE codigoMesa = :codigoMesa");
                    $consulta->bindValue(':codigoMesa', $codigoMesa, PDO::PARAM_STR);
                    $consulta->bindValue(':fechaBaja', date('Y-m-d H:i:s'));
                    $consulta->execute();
                    $mensaje = "Mesa dada de baja.";
                }
            }
            
        }
        

        return $mensaje;
    }

    public static function modificarUno($codigo, $estado)
    {
        $mensaje = "";
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $mesaExistente = self::obtenerUno($codigo);

        if (!$mesaExistente) {
            $mensaje = "No existe la mesa";
        } else {
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE mesas SET estado = :estado, fechaModificacion = :fechaModificacion WHERE codigoMesa = :codigoMesa");

            $consulta->bindValue(':codigoMesa', $codigo, PDO::PARAM_STR);
            $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
            $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));

            $consulta->execute();
            $mensaje = "Mesa con codigo: $codigo modificada.";
        }

        return $mensaje;
    }


    public static function ObtenerIdPorCodigoDeMesa($codigoMesa)
    {
            $listaMesas = self::obtenerTodos();
            $idMesa = -1;

            foreach ($listaMesas as $item) 
            {
                if($item->codigoMesa == $codigoMesa)
                {
                    $idMesa = $item->id;
                    break;
                }
            }

            return $idMesa;
    }

    public static function VerificarEstadoMesa($idMesa)
    {
        $listaMesa = self::obtenerTodos();
        $estadoMesa = -1;

        foreach ($listaMesa as $item) 
        {
            if($item->id == $idMesa)
            {
                $estadoMesa = $item->estado;
                break;
            }
        }

        return $estadoMesa;
    }

    public static function CambiarEstadoMesa($idMesa, $estadoMesa)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("UPDATE mesas SET estado = :estado WHERE id = :id");

        $consulta->bindValue(':id', $idMesa, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estadoMesa, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->rowCount();
    }
////
    public static function obtenerListadoMesasConEstado()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT mesas.id, mesas.codigoMesa, estadomesa.estado as estadoMesa FROM mesas JOIN estadomesa ON mesas.estado = estadomesa.id WHERE mesas.fechaBaja IS NULL");

        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function obtenerMesaMasUsada()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT codigoMesa, COUNT(codigoMesa) as cantidad FROM pedidos GROUP BY codigoMesa ORDER BY cantidad DESC LIMIT 1");
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return $resultado;
    }





}
