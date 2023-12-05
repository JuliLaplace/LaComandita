<?php
require_once "./models/DetallePedido.php";
require_once "./models/Producto.php";
require_once "./models/Pedido.php";
require_once './interfaces/IApiController.php';

class DetallePedidoController implements IApiController
{

    public function cargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigoPedido = $parametros['codigopedido'];
        $nombreProducto = $parametros['producto'];
        $cantidad = $parametros['cantidad'];

        $producto = Producto::obtenerUno($nombreProducto);
        $pedido = Pedido::obtenerUno($codigoPedido);

    
        if ($pedido != null) {

            $id = $pedido['id'];

            if ($producto != null) {
                $detallePedido = new DetallePedido();
                $detallePedido->codigoPedido = $codigoPedido;
                $detallePedido->idProducto = $producto->id;
                $detallePedido->cantidad = $cantidad;
                $precioProducto = Producto::ObtenerPrecioProductoPorId($producto->id) * $cantidad;
                Pedido::SumaPrecio($id, $precioProducto);

                $detallePedido->crearUno();

                $payload = json_encode(array("mensaje" => "Producto: $producto->nombre - Cantidad: $cantidad - Precio: $precioProducto - Producto cargado/s al pedido con codigo $codigoPedido."));
            } else {
                $payload = json_encode(array("mensaje" => "El producto seleccionado no existe"));
            }
        } else {
            $payload = json_encode(array("mensaje" => "Codigo de Pedido Inexistente"));
        }


        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = DetallePedido::obtenerTodos();
        $payload = json_encode(array("listaDetallesPedidos" => $lista));

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];

        $detallePed = DetallePedido::obtenerUno($id);

        if (!$detallePed) {
            $payload = json_encode(array("mensaje" => "El detalle de pedido no existe"));
        } else {
            $payload = json_encode($detallePed);
        }

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $id = $args['id'];

        $mensaje = DetallePedido::borrarUno($id);

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        $producto = $parametros['producto'];
        $codigo = $parametros['codigoPedido'];

        //$mensaje = DetallePedido::modificarUno($id, $producto, $codigo);

    $payload = json_encode(array("mensaje" => "hola"/*$mensaje*/));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }


    public function ListarPendientes($request, $response, $args)
    {
        $sector = $request->getAttribute('sector');
        $mensaje = DetallePedido::ListarPendientes($sector);
        if(empty($mensaje)){
            $payload = json_encode(array("PRODUCTOS PENDIENTES:" => "No se encontraron productos pendientes en este sector"));
        }else{
            $payload = json_encode(array("PRODUCTOS PENDIENTES:" => $mensaje));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function CambiarEstadoPreparacion($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $parametros['id'];
        $estado = $parametros['estado'];
        $tiempo = $parametros['tiempo'];
        
        $detallePedido = DetallePedido::obtenerUno($id);
        if($detallePedido){
            Pedido::SetearTiempoEstimado($detallePedido->codigoPedido, $tiempo);
            $mensaje = DetallePedido::CambiarEstado($id, $estado, $tiempo);
        }else{
            $mensaje = "No existe el pedido seleccionado";
        }
        
        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function CambiarEstadoListo($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $parametros['id'];        
   
        $mensaje = DetallePedido::CambiarEstadoListo($id);
        
        
        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    
    public function ChequearPedidoParaServir($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $codigoPedido = $parametros['codigoPedido']; 
        
        $mensaje = DetallePedido::TodosFinalizadosEnPedido($codigoPedido);
        $payload = json_encode(array("mensaje" => $mensaje));
        

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }



   
}
