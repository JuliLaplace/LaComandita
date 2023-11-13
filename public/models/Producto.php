<?php

class Producto
{
    public $id;
    public $nombre;
    public $precio;
    public $sector;
    public $tiempopreparacion;
    public $estado;


    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombre, precio, sector, tiempopreparacion, estado) VALUES (:nombre, :precio, :sector, :tiempopreparacion, :estado)");
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':tiempopreparacion', $this->tiempopreparacion, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodosProductos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT productos.id, productos.nombre, productos.precio, productos.tiempopreparacion, sector.sector, productos.estado FROM productos JOIN sector ON productos.sector = sector.id WHERE productos.estado = 'activo'");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function obtenerProducto($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT productos.id, productos.nombre, productos.precio, productos.tiempopreparacion, sector.sector, productos.estado FROM productos JOIN sector ON productos.sector = sector.id WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }


    public static function ObtenerIdPorNombre($nombreProducto)
    {
        $listaProducto = Producto::obtenerTodosProductos();
        $idProducto = -1;
        foreach ($listaProducto as $item) {
            if (strtolower($item->nombre) == strtolower($nombreProducto)) {
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


        foreach ($listaProductos as $item) {
            if ($item->id == $id) {
                $precio = $item->precio;
                break;
            }
        }

        return $precio;
    }

    public static function ObtenerTiempoPreparacion($id)
    {
        $listaProductos = Producto::obtenerTodosProductos();
        $tiempo = -1;


        foreach ($listaProductos as $item) {
            if ($item->id == $id) {
                $tiempo = $item->tiempoPreparacion;
                break;
            }
        }

        return $tiempo;
    }

    public static function borrarUno($producto)
    {
        $mensaje = "";
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consultaVerificacion = $objAccesoDato->prepararConsulta("SELECT estado FROM productos WHERE nombre = :nombre");
        $consultaVerificacion->bindValue(':nombre', $producto, PDO::PARAM_STR);
        $consultaVerificacion->execute();
        $estado = $consultaVerificacion->fetchColumn();

        if ($estado == "eliminado") {
            $mensaje = "El producto ya fue dado de baja.";
        } else {
            $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET estado = 'eliminado' WHERE nombre = :nombre");
            $consulta->bindValue(':nombre', $producto, PDO::PARAM_STR);
            $consulta->execute();
            $mensaje = "Producto dado de baja.";
        }

        return $mensaje;
    }

    public static function modificarUno($nombre, $precio, $id)
    {
        $mensaje = "";
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE productos SET precio = :precio, nombre = :nombre WHERE id = :id");

        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $precio, PDO::PARAM_STR);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        $filasAfectadas = $consulta->rowCount(); //me dice cuantas filas fueron modificadas

        if ($filasAfectadas > 0) {
            $mensaje = "El producto fue modificado.";
        } else {
            $mensaje = "No se pudo modificar el producto.";
        }

        return $mensaje;
    }
}
