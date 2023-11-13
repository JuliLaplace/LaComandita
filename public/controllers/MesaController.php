<?php
require_once './models/Mesa.php';
require_once './interfaces/IApi.php';

class MesaController implements IApi
{

  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $codigomesa = $parametros['codigomesa'];
    $estado = $parametros['estado'];


    $mesa = new Mesa();
    $mesa->codigomesa = $codigomesa;
    $mesa->estado = $estado;


    $mesa->crearMesa();

    $payload = json_encode(array("mensaje" => "Mesa creada con éxito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    $codigomesa = $args['codigomesa'];
    $mesa = Mesa::obtenerMesa($codigomesa);
    $payload = json_encode($mesa);

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
