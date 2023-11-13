<?php

class Mesa{
    public $id;
    public $codigomesa;
    public $estado;


    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (codigomesa, estado) VALUES (:codigomesa, :estado)");
        $consulta->bindValue(':codigomesa', $this->codigomesa, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);


        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }


    public static function obtenerTodosMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT mesas.id, mesas.codigomesa, estadomesa.estado FROM mesas JOIN estadomesa ON mesas.estado = estadomesa.id;");
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }
    
    public static function obtenerMesa($codigomesa)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT mesas.id, mesas.codigomesa, estadomesa.estado FROM mesas JOIN estadomesa ON mesas.estado = estadomesa.id WHERE mesas.codigomesa = :codigomesa");
        $consulta->bindValue(':codigomesa', $codigomesa, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Mesa');
    }

    public static function ObtenerIdPorCodigoDeMesa($codigoMesa)
    {
            $listaMesas = Mesa::obtenerTodosMesa();
            $idMesa = -1;

            foreach ($listaMesas as $item) 
            {
                if($item->codigomesa == $codigoMesa)
                {
                    $idMesa = $item->id;
                    break;
                }
            }

            return $idMesa;
    }

    public static function VerificarEstadoMesa($idMesa)
    {
        $listaMesa = Mesa::obtenerTodosMesa();
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



}
