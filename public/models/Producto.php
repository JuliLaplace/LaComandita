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

    public static function ObtenerIdPorNombre($nombreProducto)
    {
        $listaProducto = Producto::obtenerTodosProductos();
        $idProducto = -1;
        foreach ($listaProducto as $item) 
        {
            if(strtolower($item->nombre) == strtolower($nombreProducto))
            {
                $idProducto = $item->id;
                break;
            }

        }
        return $idProducto;
    }

    public static function ObtenerPrecioProductoPorId($id)
    {
        $listaProductos = Producto::obtenerTodosProductos();
        $precio = -1;


        foreach ($listaProductos as $item) 
        {
            if($item->id == $id)
            {
                $precio = $item->precio;
                break;
            }

        }

        return $precio;
    }




}
?>