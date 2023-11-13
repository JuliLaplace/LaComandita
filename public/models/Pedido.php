<?php 

class Pedido{

    public $id;
    public $codigoPedido;
    public $idCliente;
    public $codigoMesa;
    public $idEmpleado;
    public $fecha;
    public $precioFinal;
    public $estado;
    


    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (codigoPedido, idCliente, codigoMesa, idEmpleado, fecha, precioFinal, estado) VALUES (:codigoPedido, :idCliente, :codigoMesa, :idEmpleado, :fecha, :precioFinal, :estado)");
        
        $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_STR);
        $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_INT);
        $consulta->bindValue(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $this->fecha);
        $consulta->bindValue(':precioFinal', $this->precio_final, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
    
        $consulta->execute();
     
    }


    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoPedido, idCliente, codigoMesa, idEmpleado, fecha, precioFinal, estado FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function ExisteCodigoPedido($codigo)
    {
        $listaPedidos = Pedido::obtenerTodos();
        $idCodigoPedido = -1;

        foreach ($listaPedidos as $item) {
            if ($item->codigopedido === $codigo) {
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

        return $consulta->rowCount();

    }

    public static function obtenerPedido($codigo)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoPedido, idCliente, codigoMesa, idEmpleado, fecha, precioFinal, estado FROM pedidos WHERE codigoPedido = :codigo");
        $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }


}
