<?php
require_once "./models/Encuesta.php";
require_once "./models/Pedido.php";

class EncuestaController
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $codigo = $parametros['codigo'];
        $notaCocina = $parametros['nota_cocina'];
        $notaMesa = $parametros['nota_mesa'];
        $notaMozo = $parametros['nota_mozo'];
        $notaRestaurante = $parametros['nota_restaurante'];
        $reseña = $parametros['resena'];


        $pedido = Pedido::obtenerUno($codigo);

        if($pedido== null){
            $payload = json_encode(array("mensaje" => "El codigo del pedido ingresado es invalido"));
        }else{
            if($pedido->estado == "2"){
                $encuesta = new Encuesta();
                $encuesta->notaMesa = $notaMesa;
                $encuesta->notaMozo = $notaMozo;
                $encuesta->notaCocina = $notaCocina;
                $encuesta->notaRestaurante = $notaRestaurante;
                $encuesta->resena = $reseña;
                $encuesta->codigoPedido = $codigo;
                $encuesta->cargarUno();

                $payload = json_encode(array("mensaje" => "Encuesta cargada"));
            }else{
                $payload = json_encode(array("mensaje" => "No se puede realizar la encuesta. El pedido no se encuentra finalizado"));
            }
            
        }
        

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $encuesta = Encuesta::obtenerEncuesta($id);
        $payload = json_encode($encuesta);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }



    public function TraerTodos($request, $response, $args)
    {
        $lista = Encuesta::obtenerTodos();
        $payload = json_encode(array("listaEncuesta" => $lista));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    
}
