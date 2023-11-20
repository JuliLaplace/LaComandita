<?php 
class DetallePedido implements IApiABM
{

    public $id;
    public $codigoPedido;
    public $idProducto;
    public $tiempoCalculado;
    public $estadoProducto;
    public $fechaCreacion;
    public $fechaBaja;
    public $fechaModificacion;

    public function __construct() {}

    public function crearUno()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO detallepedido (codigoPedido, idProducto, tiempoCalculado, estadoProducto, fechaCreacion) VALUES (:codigoPedido, :idProducto, :tiempoCalculado, :estadoProducto, :fechaCreacion)");
        
        $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoCalculado', $this->tiempoCalculado, PDO::PARAM_INT);
        $consulta->bindValue(':estadoProducto', "pendiente", PDO::PARAM_STR);
        $consulta->bindValue(':fechaCreacion', date('Y-m-d H:i:s'));
        $consulta->bindValue(':idProducto', $this->idProducto, PDO::PARAM_INT);
    
        $consulta->execute();
     
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM detallepedido");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'DetallePedido');

    }
    public static function obtenerUno($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM detallepedido WHERE id = :id AND fechaBaja IS NULL");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

        $detallePedido = $consulta->fetchObject('DetallePedido');
        return $detallePedido;
    }


    public static function modificarUno($id, $producto, $codigoPedido)
    {
        $mensaje = "";
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $detallePedidoExistente = self::obtenerUno($id);
        $pedido = Pedido::obtenerUno($codigoPedido);
        $producto = Producto::obtenerUno($producto);
        

        if (!$detallePedidoExistente) {
            $mensaje = "No existe el pedido";
        }else if($producto ==null){
            $mensaje = "No existe el producto que desea agregar al pedido";
        }else if($pedido == null){
            $mensaje = "No existe el pedido ingresado";
        }
        else {
            
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE detallepedido SET idProducto = :idProducto, fechaModificacion = :fechaModificacion WHERE id = :id");
            $consulta->bindValue(':idProducto', $producto->id, PDO::PARAM_INT);
            $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            
            $montoARestar = Producto::ObtenerPrecioProductoPorId($detallePedidoExistente->idProducto);
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET fechaModificacion = :fechaModificacion WHERE codigoPedido = :codigoPedido");
            $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));
            $consulta->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_STR);
            $consulta->execute();
            
            $montoASumar = Producto::ObtenerPrecioProductoPorId($producto->id);//sumo el nuevo producto
            $mensaje = "Detalle de Pedido modificado.";
            Pedido::SumaPrecio($detallePedidoExistente->id, ($montoARestar*-1));
            Pedido::SumaPrecio($detallePedidoExistente->id, $montoASumar);

        }

        return $mensaje;
    }
    

    public static function borrarUno($id)
    {
        $mensaje = "";
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $detallePedidoExistente = self::obtenerUno($id);
        

        if(!$detallePedidoExistente){
            $mensaje = "No se encontró el pedido.";
        }else{
            if($detallePedidoExistente->estadoProducto == "entregado"){
                $mensaje = "No se puede cancelar el pedido seleccionado porque fue entregado";
            }
            else
            {
                $monto = Producto::ObtenerPrecioProductoPorId($detallePedidoExistente->idProducto);
                $pedido = Pedido::obtenerUno($detallePedidoExistente->codigoPedido);

                $consulta = $objAccesoDato->prepararConsulta("UPDATE detallepedido SET fechaBaja = :fechaBaja, estadoProducto = :estadoProducto WHERE id = :id");
                $consulta->bindValue(':id', $id, PDO::PARAM_STR);
                $consulta->bindValue(':estadoProducto', "cancelado", PDO::PARAM_STR);
                $consulta->bindValue(':fechaBaja', date('Y-m-d H:i:s'));
                $consulta->execute();

                $objAccesoDatos = AccesoDatos::obtenerInstancia();
                $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET fechaModificacion = :fechaModificacion WHERE codigoPedido = :codigoPedido");
                $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));
                $consulta->bindValue(':codigoPedido', $pedido->codigoPedido, PDO::PARAM_STR);
                $consulta->execute();
                $mensaje = "Pedido cancelado.";
                Pedido::SumaPrecio($pedido->id, ($monto*-1));//id de pedido
            }
            
        }
        

        return $mensaje;
    }
    public static function ListarPendientes($sector)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoPedido, idProducto, tiempoCalculado, estadoProducto, fechaCreacion, fechaBaja, fechaModificacion
        FROM detallepedido WHERE estadoProducto = 'pendiente' AND idProducto IN (SELECT id FROM productos WHERE sector = :sector)            
        ");

        $consulta->bindValue(':sector', $sector, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'DetallePedido');
    }

    
    public static function CambiarEstado($id, $estado)
    {
        $existePedido = DetallePedido::obtenerUno($id);

        if ($existePedido != null) {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE detallepedido SET estadoProducto = :nuevoEstado, fechaModificacion = :fechaModificacion WHERE id = :id");
            $consulta->bindValue(':nuevoEstado', $estado, PDO::PARAM_STR);
            $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();

            $mensaje = "Modificado";
        } else {
            $mensaje = "No existe el pedido seleccionado";
        }

        return $mensaje;
    }

    


}


?>