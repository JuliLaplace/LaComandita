<?php
require_once './interfaces/IApiABM.php';
class Producto implements IApiABM
{
    public $id;
    public $nombre;
    public $precio;
    public $sector;
    public $tiempopreparacion;
    public $fechaCreacion;
    public $fechaBaja;
    public $fechaModificacion;

    public function __construct() {
        
    }
    public function crearUno()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombre, precio, sector, tiempopreparacion, fechaCreacion) VALUES (:nombre, :precio, :sector, :tiempopreparacion, :fechaCreacion)");
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':tiempopreparacion', $this->tiempopreparacion, PDO::PARAM_STR);
        $consulta->bindValue(':fechaCreacion', date('Y-m-d H:i:s'));

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT productos.id, productos.nombre, productos.precio, productos.tiempopreparacion, sector.sector, productos.fechaCreacion, productos.fechaBaja, productos.fechaModificacion FROM productos JOIN sector ON productos.sector = sector.id WHERE productos.fechaBaja IS NULL");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function obtenerUno($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT productos.id, productos.nombre, productos.precio, productos.tiempopreparacion, sector.sector, productos.fechaCreacion, productos.fechaBaja, productos.fechaModificacion  FROM productos JOIN sector ON productos.sector = sector.id WHERE nombre = :nombre AND productos.fechaBaja IS NULL");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }


    public static function ObtenerIdPorNombre($nombreProducto)
    {
        $listaProducto = self::obtenerTodos();
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
        $listaProductos = self::obtenerTodos();
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
        $listaProductos = self::obtenerTodos();
        $tiempo = -1;


        foreach ($listaProductos as $item) {
            if ($item->id == $id) {
                $tiempo = $item->tiempopreparacion;
                break;
            }
        }

        return $tiempo;
    }

    public static function borrarUno($producto)
    {
        $mensaje = "";
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $productoExistente = self::obtenerUno($producto);
        if(!$productoExistente){
            $mensaje = "No existe el producto.";
        }else{
            $consultaVerificacion = $objAccesoDato->prepararConsulta("SELECT fechaBaja FROM productos WHERE nombre = :nombre");
            $consultaVerificacion->bindValue(':nombre', $producto, PDO::PARAM_STR);
            $consultaVerificacion->execute();
            $fechaExiste = $consultaVerificacion->fetchColumn();

            if ($fechaExiste != NULL) {
                $mensaje = "El producto ya fue dado de baja.";
            } else {
                $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET fechaBaja = :fechaBaja WHERE nombre = :nombre");
                $consulta->bindValue(':nombre', $producto, PDO::PARAM_STR);
                $consulta->bindValue(':fechaBaja', date('Y-m-d H:i:s'));
                $consulta->execute();
                $mensaje = "Producto dado de baja.";
            }
        }

        return $mensaje;
       
    }

    public static function modificarUno($nombre, $precio, $tiempo)
    {
        $mensaje = "";
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $productoExistente = self::obtenerUno($nombre);
        if (!$productoExistente) {
            $mensaje = "No existe el producto";
        } else {
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE productos SET precio = :precio, tiempopreparacion = :tiempo, fechaModificacion = :fechaModificacion WHERE nombre = :nombre");
            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $precio, PDO::PARAM_STR);
            $consulta->bindValue(':tiempo', $tiempo, PDO::PARAM_STR);
            $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));
            
            $consulta->execute();
            $mensaje = "Producto modificado.";
        }

        return $mensaje;
    }

    
}
