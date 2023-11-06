<?php
require_once './models/Mesa.php';

class MesaController 
{
  
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $estado = $parametros['estado'];


        $mesa = new Mesa();
        $mesa->estado = $estado;

 
        $mesa->crearMesa();

        $payload = json_encode(array("mensaje" => "Mesa creada con éxito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }



    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodosMesa();
        $payload = json_encode(array("listaMesa" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


    
}