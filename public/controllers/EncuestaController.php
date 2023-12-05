<?php
require_once "./models/Encuesta.php";
require_once "./models/Pedido.php";

class EncuestaController
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $codigo = $parametros['codigoPedido'];
        $nota = $parametros['nota'];
        $reseña = $parametros['resena'];


        $pedido = Pedido::obtenerUno($codigo);

        if($pedido== null){
            $payload = json_encode(array("mensaje" => "El codigo del pedido ingresado ($codigo) es invalido"));
        }else{
            if($pedido['estado'] == "finalizado"){
                $encuesta = new Encuesta();
                $encuesta->nota = $nota;
                $encuesta->resena = $reseña;
                $encuesta->codigoPedido = $codigo;
                $encuesta->cargarUno();

                $payload = json_encode(array("mensaje" => "Encuesta cargada exitosamente! Nota: $nota - Reseña: $reseña - Pedido numero $codigo"));
            }else{
                $payload = json_encode(array("mensaje" => "No se puede realizar la encuesta ya que el pedido numero $codigo no se encuentra finalizado"));
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

    public function TraerMejoresComentarios($request, $response, $args)
    {
        $lista = Encuesta::obtenerTresMejoresEncuestras();
        $payload = json_encode(array("Lista de tres mejores notas en Encuestas" => $lista));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    
}
