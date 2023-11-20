<?php
require_once './models/Empleado.php';
require_once './interfaces/IApiController.php';

class EmpleadoController implements IApiController
{

  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $sector = $parametros['sector'];
    $clave = $parametros['clave'];
    $nombre = $parametros['nombre'];
    $usuario = $parametros['usuario'];

    $empleado = new Empleado();
    $empleado->sector = $sector;
    $empleado->clave = $clave;
    $empleado->nombre = $nombre;
    $empleado->usuario = $usuario;
    $empleado->estado = 1; //si lo creo, lo dejo activo
    $empleado->fechaCreacion = date('Y-m-d H:i:s');

    $empleado->crearUno();

    $payload = json_encode(array("mensaje" => "Empleado creado con éxito"));

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    $usr = $args['usuario'];

    $empleado = Empleado::obtenerUno($usr);
    if (!$empleado) {
      $payload = json_encode(array("mensaje" => "El empleado no existe"));
    } else {
      $payload = json_encode($empleado);
    }

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }




  public function TraerTodos($request, $response, $args)
  {
    $lista = Empleado::obtenerTodos();
    $payload = json_encode(array("listaEmpleados" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }


  public function BorrarUno($request, $response, $args) 
  {
    $usr = $args['empleado'];

    $mensaje = Empleado::borrarUno($usr);

    $payload = json_encode(array("mensaje" => $mensaje));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }


  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $nombre = $parametros['nombre'];
    $clave = $parametros['clave'];
    $usuario = $parametros['usuario'];
    
    $mensaje = Empleado::modificarEmpleado($usuario, $clave, $nombre);

    $payload = json_encode(array("mensaje" => $mensaje));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }


}
