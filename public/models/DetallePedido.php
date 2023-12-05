<?php 
class DetallePedido implements IApiABM
{

    public $id;
    public $codigoPedido;
    public $idProducto;
    public $cantidad;
    public $tiempoCalculado;
    public $estadoProducto;
    public $fechaCreacion;
    public $fechaBaja;
    public $fechaModificacion;

    public function __construct() {}

    public function crearUno()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO detallepedido (codigoPedido, idProducto, cantidad, tiempoCalculado, estadoProducto, fechaCreacion) VALUES (:codigoPedido, :idProducto, :cantidad,  :tiempoCalculado, :estadoProducto, :fechaCreacion)");
        
        $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
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
                Pedido::SumaPrecio($pedido->id, ($monto*-1), 1);//id de pedido
            }
            
        }
        

        return $mensaje;
    }
    public static function ListarPendientes($sector)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT detallepedido.id, detallepedido.codigoPedido, detallepedido.idProducto, productos.nombre, detallepedido.cantidad, detallepedido.tiempoCalculado, detallepedido.estadoProducto, detallepedido.fechaCreacion, detallepedido.fechaBaja, detallepedido.fechaModificacion
        FROM detallepedido JOIN productos ON detallepedido.idProducto = productos.id WHERE estadoProducto = 'pendiente' AND idProducto IN (SELECT id FROM productos WHERE sector = :sector)            
        ");

        $consulta->bindValue(':sector', $sector, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'DetallePedido');
    }


    public static function CambiarEstado($id, $estado, $tiempo)
    {
        $existePedido = self::obtenerUno($id);

        if ($existePedido != null) {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE detallepedido SET estadoProducto = :nuevoEstado, tiempoCalculado = :nuevoTiempo, fechaModificacion = :fechaModificacion WHERE id = :id");
            $consulta->bindValue(':nuevoEstado', $estado, PDO::PARAM_STR);
            $consulta->bindValue(':nuevoTiempo', $tiempo, PDO::PARAM_STR);
            $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();

            $dp = DetallePedido::obtenerUno($id);
            $idP = $dp->idProducto;
            $prod = Producto::obtenerUnoPorId($idP);
            $mensaje = "Estado del pedido: $existePedido->codigoPedido - Preparacion del producto: $prod->nombre modificado a $estado, tiempo de preparacion estimado: $tiempo";
        } else {
            $mensaje = "No existe el pedido seleccionado";
        }

        return $mensaje;
    }

    public static function CambiarEstadoListo($id)
    {
        $existeDetallePedido = self::obtenerUno($id);
        $producto = Producto::obtenerUnoPorId($existeDetallePedido->idProducto);
   


        if ($existeDetallePedido != null) {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $nuevoEstado = 'listo para servir';

            $consulta = $objAccesoDatos->prepararConsulta("UPDATE detallepedido SET estadoProducto = :nuevoEstado, fechaModificacion = :fechaModificacion WHERE id = :id");
            $consulta->bindValue(':nuevoEstado', $nuevoEstado, PDO::PARAM_STR);
            $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();

            $mensaje = "Estado del detalle pedido cod: $existeDetallePedido->codigoPedido - Producto $producto->nombre - $nuevoEstado";
        } else {
            $mensaje = "No existe el detalle pedido seleccionado";
        }

        return $mensaje;
    }


    public static function TodosFinalizadosEnPedido($codigoPedido)
    {
        $pedido = Pedido::obtenerUno($codigoPedido);
    
        if (!$pedido) {
            return "El pedido cod: $codigoPedido no existe.";
        }
    
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
    

        $consultaFinalizados = $objAccesoDatos->prepararConsulta("SELECT COUNT(*) FROM detallepedido WHERE codigoPedido = :codigoPedido AND estadoProducto = 'listo para servir'");
        $consultaFinalizados->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_STR);
        $consultaFinalizados->execute();
        $totalFinalizados = $consultaFinalizados->fetchColumn();

        $consultaTotalDetalles = $objAccesoDatos->prepararConsulta("SELECT COUNT(*) FROM detallepedido WHERE codigoPedido = :codigoPedido");
        $consultaTotalDetalles->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_STR);
        $consultaTotalDetalles->execute();
        $totalDetalles = $consultaTotalDetalles->fetchColumn();
    
        if ($totalFinalizados === $totalDetalles) {
            $idPedido = $pedido['id'];
            $codigoMesa = $pedido['codigoMesa'];
            $idMesa = Mesa::ObtenerIdPorCodigoDeMesa($codigoMesa);
            Mesa::CambiarEstadoMesa($idMesa, 2);
            Pedido::CambiarEstadoPedido($idPedido, 2);

            return "Pedido cod: $codigoPedido servido en mesa cod: $codigoMesa.";
        } else {
            return "Los productos pertenecientes al pedido numero $codigoPedido no se encuentran listos.";
        }
    }
    

    public static function finalizarDetallePedidos($codigoPedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE detallepedido SET estadoProducto = 'finalizado', fechaModificacion = :fechaModificacion WHERE codigoPedido = :codigoPedido AND estadoProducto = 'listo para servir'");
        
        $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));
        $consulta->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_STR);
        $consulta->execute();

        //return "Detalles del pedido cod: $codigoPedido finalizados correctamente.";
    }


}


?>