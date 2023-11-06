<?php

class Producto{
    public $id;
    public $nombre;
    public $precio;
    public $sector;
    public $tiempopreparacion;


    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombre, precio, sector, tiempopreparacion) VALUES (:nombre, :precio, :sector, :tiempopreparacion)");
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':tiempopreparacion', $this->tiempopreparacion, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }


public static function obtenerTodosProductos()
{
    $objAccesoDatos = AccesoDatos::obtenerInstancia();
    $consulta = $objAccesoDatos->prepararConsulta("SELECT productos.id, productos.nombre, productos.precio, productos.tiempopreparacion, sector.sector FROM productos JOIN sector ON productos.sector = sector.id");
    $consulta->execute();

    return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
}


}
?>