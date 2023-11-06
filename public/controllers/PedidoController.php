<?php

require_once './models/Pedido.php';

class PedidoController 
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $mesa = $parametros['mesa'];
        $id_cliente = $parametros['id_cliente'];
        $estado = $parametros['estado'];
        $fechaCreacion = $parametros['fechaCreacion'];
        $fechaCalculada = $parametros['fechaCalculada'];
        $fechaFinalizada = $parametros['fechaFinalizada'];
        $precio_final = $parametros['precio'];
        $id_producto = $parametros['id_producto'];

        $pedido = new Pedido();
        $pedido->mesa = $mesa;
        $pedido->id_cliente = $id_cliente;
        $pedido->estado = $estado;
        $pedido->fechaCreacion = $fechaCreacion;
        $pedido->fechaCalculada = $fechaCalculada;
        $pedido->fechaFinalizada = $fechaFinalizada;
        $pedido->precio_final = $precio_final;
        $pedido->id_producto = $id_producto;

        $pedido->crearPedido();

        $payload = json_encode(array("mensaje" => "Pedido creado con éxito"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::obtenerTodosPedidos();
        $payload = json_encode(array("listaPedidos" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


}

?>