<?php

require_once './models/Cliente.php';

class ClienteController 
{
    
    public function TraerUno($request, $response, $args)
    {

        $codigoPedido = $args['codigo'];      

        $tiempoDeEspera = Cliente::TraerTiempoPedido($codigoPedido);
        if($tiempoDeEspera===null){
            $mensaje = "No se encontraron datos para el código de pedido $codigoPedido";
        }else{
            $mensaje = "El tiempo de espera es de $tiempoDeEspera minutos";
        }
        
        $payload = json_encode(array("mensaje" => $mensaje));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
} 
?>