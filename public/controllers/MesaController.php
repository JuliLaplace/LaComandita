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

  public function ListadoMesasYEstados($request, $response, $args)
  {
      $listadoMesasConEstado = Mesa::obtenerListadoMesasConEstado();

      $payload = json_encode(array("LISTA DE MESAS Y ESTADOS:" => $listadoMesasConEstado));

      $response->getBody()->write($payload);
      return $response
          ->withHeader('Content-Type', 'application/json');
  }

  public function CerrarMesa($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $codigo = $parametros['codigo'];

    $mensaje = Mesa::modificarUno($codigo, 4);

    $payload = json_encode(array("mensaje" => $mensaje .  " - Se cerro la mesa"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ListarMesaMasUsada($request, $response, $args)
  { 
    $resultado = Mesa::obtenerMesaMasUsada();
      if ($resultado) {
        $codigoMesaMasUsada = $resultado['codigoMesa'];
        $cantidadUsos = $resultado['cantidad'];
        $mensaje = "La mesa mas usada es la mesa con cod: {$codigoMesaMasUsada} con {$cantidadUsos} usos.";
      } else {
        $mensaje = "No se utilizaron mesas por el momento.";
        
      }

    $payload = json_encode(array("MESA MAS USADA" => $mensaje ));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }





}
