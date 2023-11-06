<?php

class Pedido
{
    public $id;
    public $mesa;
    public $id_cliente;
    public $id_producto;
    public $estado; // en proceso - finalizado
    public $fechaCreacion;
    public $fechaCalculada;
    public $fechaFinalizada;
    public $precio_final;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedido (mesa, id_cliente,id_producto, estado, fechaCreacion, fechaCalculada, fechaFinalizada, precio) VALUES (:mesa, :id_cliente,:id_producto, :estado, :fechaCreacion, :fechaCalculada, :fechaFinalizada, :precio)");
        $consulta->bindValue(':mesa', $this->mesa);
        $consulta->bindValue(':id_cliente', $this->id_cliente);
        $consulta->bindValue(':id_producto', $this->id_producto);
        $consulta->bindValue(':estado', $this->estado);
        $consulta->bindValue(':fechaCreacion', $this->fechaCreacion);
        $consulta->bindValue(':fechaCalculada', $this->fechaCalculada);
        $consulta->bindValue(':fechaFinalizada', $this->fechaFinalizada);
        $consulta->bindValue(':precio', $this->precio_final);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodosPedidos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("
            SELECT pedido.id, pedido.mesa, pedido.id_cliente, pedido.id_producto, pedido.estado, pedido.fechaCreacion, pedido.fechaCalculada, pedido.fechaFinalizada, pedido.precio, cliente.nombre AS nombre_cliente, estadopedido.estado AS nombre_estado
            FROM pedido
            JOIN cliente ON pedido.id_cliente = cliente.id
            JOIN estadopedido ON pedido.estado = estadopedido.id
            JOIN productos ON pedido.id_producto = productos.id

      
        ");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

}

?>