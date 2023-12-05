<?php
require_once './interfaces/IApiABM.php';
class Pedido implements IApiABM
{

    public $id;
    public $codigoPedido;
    public $idCliente;
    public $codigoMesa;
    public $idEmpleado;
    public $fechaCreacion;
    public $fechaBaja;
    public $fechaModificacion;
    public $precioFinal;
    public $estado;
    public $foto;
    public $tiempoEstimado;



    public function crearUno()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (codigoPedido, idCliente, codigoMesa, idEmpleado, fechaCreacion, precioFinal, estado) VALUES (:codigoPedido, :idCliente, :codigoMesa, :idEmpleado, :fechaCreacion, :precioFinal, :estado)");

        $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_STR);
        $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_INT);
        $consulta->bindValue(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $consulta->bindValue(':fechaCreacion', date('Y-m-d H:i:s'));
        $consulta->bindValue(':precioFinal', 0, PDO::PARAM_STR);
        $consulta->bindValue(':estado', 4, PDO::PARAM_INT);

        $consulta->execute();
    }


    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT pedidos.id, pedidos.codigoPedido, clientes.nombre as nombreCliente, pedidos.codigoMesa, empleados.nombre as nombreEmpleado, pedidos.fechaCreacion, pedidos.fechaBaja, pedidos.fechaModificacion, pedidos.precioFinal, estadopedido.estado as estado, pedidos.tiempoEstimado 
            FROM pedidos 
            LEFT JOIN empleados ON pedidos.idEmpleado = empleados.id 
            LEFT JOIN clientes ON pedidos.idCliente = clientes.id 
            LEFT JOIN estadopedido ON pedidos.estado = estadopedido.id
            WHERE pedidos.fechaBaja IS NULL");

        $consulta->execute();
        $pedidos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pedidos as &$pedido) {
            $detalles = self::obtenerDetalles($pedido['codigoPedido']);
            $pedido['detalles'] = $detalles;
        }

        return $pedidos;
    }
    public static function obtenerDetalles($codigoPedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM detallepedido WHERE codigoPedido = :codigo");
        $consulta->bindValue(':codigo', $codigoPedido, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'DetallePedido');
    }

    public static function obtenerUno($codigo)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT pedidos.id, pedidos.codigoPedido, clientes.nombre as nombreCliente, pedidos.codigoMesa, empleados.nombre as nombreEmpleado, pedidos.fechaCreacion, pedidos.fechaBaja, pedidos.fechaModificacion, pedidos.precioFinal, estadopedido.estado as estado, pedidos.tiempoEstimado 
            FROM pedidos 
            LEFT JOIN empleados ON pedidos.idEmpleado = empleados.id 
            LEFT JOIN clientes ON pedidos.idCliente = clientes.id 
            LEFT JOIN estadopedido ON pedidos.estado = estadopedido.id
            WHERE pedidos.codigoPedido = :codigo AND pedidos.fechaBaja IS NULL");
    
        $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        $consulta->execute();
    
        $pedido = $consulta->fetch(PDO::FETCH_ASSOC);
    
        if ($pedido) {
            $detalles = self::obtenerDetalles($codigo);
            $pedido['detalles'] = $detalles;
        }
    
        return $pedido;
    }
 

    public static function ExisteCodigoPedido($codigo)
    {
        $listaPedidos = Pedido::obtenerTodos();
        $idCodigoPedido = -1;

        foreach ($listaPedidos as $item) {
            if ($item->codigoPedido === $codigo) {
                $idCodigoPedido = $item->id;
                break;
            }
        }

        return $idCodigoPedido;
    }

    public static function SumaPrecio($id, $monto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();


        $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET precioFinal = precioFinal + :monto WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':monto', $monto, PDO::PARAM_STR);

        $consulta->execute();

        return $consulta->rowCount();//devuelve la cantidad de filas afectadas sie s 0 no se modifico
    }

   
    public static function SetearTiempoEstimado($codigoPedido, $tiempo)
{
    $objAccesoDatos = AccesoDatos::obtenerInstancia();

    $consultaPedidoActual = $objAccesoDatos->prepararConsulta("SELECT tiempoEstimado FROM pedidos WHERE codigoPedido = :codigoPedido AND fechaBaja IS NULL");
    $consultaPedidoActual->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_INT);
    $consultaPedidoActual->execute();  
    $tiempoEstimadoActual = $consultaPedidoActual->fetch(PDO::FETCH_ASSOC)['tiempoEstimado'];

    if ($tiempoEstimadoActual === null || $tiempo > $tiempoEstimadoActual) {
        $consultaPedido = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET tiempoEstimado = :tiempoEstimado WHERE codigoPedido = :codigoPedido AND fechaBaja IS NULL");
        $consultaPedido->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_INT);
        $consultaPedido->bindValue(':tiempoEstimado', $tiempo, PDO::PARAM_STR);
        $consultaPedido->execute();
    }
}
    
    public static function modificarUno($codigoPedido, $codigoMesa)
    {
        $mensaje = "";
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $pedidoExistente = self::obtenerUno($codigoPedido);

        if (!$pedidoExistente) {
            $mensaje = "No existe el pedido";
        } else {
            
            $mesa = Mesa::ObtenerIdPorCodigoDeMesa($codigoMesa);
            $estadoMesa = Mesa::VerificarEstadoMesa($mesa);
            if($estadoMesa == -1){
                $mensaje = "La mesa a la que se quieren cambiar no existe";
            }else if($estadoMesa == 1){
                $mensaje = "La mesa a ya tiene pedidos/clientes. No es posible realizar la modificacion";
            }else{
                $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET codigoMesa = :nuevoCodigoMesa, fechaModificacion = :fechaModificacion WHERE codigoPedido = :codigoPedido");
                $consulta->bindValue(':nuevoCodigoMesa', $codigoMesa, PDO::PARAM_STR);
                $consulta->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_STR);
                $consulta->bindValue(':fechaModificacion', date('Y-m-d H:i:s'));

                Mesa::CambiarEstadoMesa($mesa, 1);
                $consulta->execute();
                $mensaje = "Pedido modificado.";

            }
            
        }

        return $mensaje;
    }
    

    public static function borrarUno($codigoPedido)
    {
        $mensaje = "";
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $pedidoExistente = self::obtenerUno($codigoPedido);

        if(!$pedidoExistente){
            $mensaje = "No se encontró el pedido.";
        }else{
            if($pedidoExistente->estado ==2){
                $mensaje = "No se puede cancelar el pedido seleccionado porque fue entregado";
            }
            else
            {
                $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET estado = 3, fechaBaja = :fechaBaja WHERE codigoPedido = :codigoPedido");
                $consulta->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_STR);
                $consulta->bindValue(':fechaBaja', date('Y-m-d H:i:s'));
                $consulta->execute();
                $mensaje = "Pedido cancelado.";
            }
            
        }
        

        return $mensaje;
    }
    static function GuardarImagen($foto, $nombre, $codigo) 
    {
        $retorno = false;
        $directorio = './ImagenesPedidos/';
        $nombreImagen = $directorio . $nombre . ".jpg";
        
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }
    
        if (move_uploaded_file($foto['tmp_name'], $nombreImagen)) {
            $retorno = true;
    
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET foto = :foto WHERE codigoPedido = :codigoPedido");
            $consulta->bindValue(':foto', $nombre . ".jpg", PDO::PARAM_STR);
            $consulta->bindValue(':codigoPedido', $codigo, PDO::PARAM_STR);
            $consulta->execute();
        } 
    
        return $retorno;
    }

    public static function CambiarEstadoPedido($id, $estado)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET estado = :estado WHERE id = :id");

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->rowCount();
    }

    public static function TraerTiempoDemora($codigoPedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();


        $consultaDemora = $objAccesoDatos->prepararConsulta("SELECT ADDTIME(TIME(fechaCreacion), tiempoEstimado) AS sumaFechaYTiempo FROM pedidos WHERE codigoPedido = :codigoPedido AND fechaBaja IS NULL");
        
        $consultaDemora->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_STR);
        $consultaDemora->execute();


        $sumaFechaYTiempo = $consultaDemora->fetch(PDO::FETCH_ASSOC);


        return $sumaFechaYTiempo !== false ? $sumaFechaYTiempo['sumaFechaYTiempo'] : null; //devuelve null si no existe
    }

    public static function CobrarCuenta($codigoPedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT precioFinal FROM pedidos WHERE codigoPedido = :codigoPedido AND fechaBaja IS NULL");

        $consulta->bindValue(':codigoPedido', $codigoPedido, PDO::PARAM_STR);
        $consulta->execute();

        $precioFinal = $consulta->fetchColumn();


        return $precioFinal !== false ? $precioFinal : null; //o dan el precio o dan null
    }



}
