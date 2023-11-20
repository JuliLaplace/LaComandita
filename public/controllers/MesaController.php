<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiController.php';

class MesaController implements IApiController
{

  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $codigomesa = $parametros['codigoMesa'];


    $mesa = new Mesa();
    $mesa->codigoMesa = $codigomesa;

    $mesa->crearUno();

    $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    $codigomesa = $args['codigomesa'];
    $mesa = Mesa::obtenerUno($codigomesa);
    if (!$mesa) {
      $payload = json_encode(array("mensaje" => "No existe la mesa"));
    } else {
      $payload = json_encode($mesa);
    }


    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }



  public function TraerTodos($request, $response, $args)
  {
    $lista = Mesa::obtenerTodos();
    $payload = json_encode(array("listaMesa" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {
    $codigo = $args['codigo'];

    $mensaje = Mesa::borrarUno($codigo);

    $payload = json_encode(array("mensaje" => $mensaje));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $codigo = $parametros['codigo'];
    $estado = $parametros['estado'];

    $mensaje = Mesa::modificarUno($codigo, $estado);

    $payload = json_encode(array("mensaje" => $mensaje));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}
