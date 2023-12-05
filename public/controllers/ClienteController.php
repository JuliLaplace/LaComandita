<?php

require_once './models/Cliente.php';

class ClienteController 
{

    public function TraerUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $codigoMesa = $parametros['codigoMesa'];
        $codigoPedido = $parametros['codigoPedido'];  

        $pedido = Pedido::obtenerUno($codigoPedido);
        if($pedido){
            
                $tiempoDeEspera = Cliente::TraerTiempoPedido($codigoPedido, $codigoMesa);
                if($tiempoDeEspera === null){
                    $mensaje = "El pedido todavia no fue tomado - No se puede dar datos sobre el tiempo de demora del pedido N° $codigoPedido - Reintente en unos instantes";
                }else{
                    $mensaje = "El tiempo de demora del pedido cod: $codigoPedido en la mesa cod:$codigoMesa es de $tiempoDeEspera minutos";
                }
        }else{
            $mensaje = "El pedido N° $codigoPedido no existe";
        }

        
        $payload = json_encode(array("mensaje" => $mensaje));
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }
} 
?>