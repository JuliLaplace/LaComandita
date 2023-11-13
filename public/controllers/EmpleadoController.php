<?php
require_once './models/Empleado.php';
require_once './interfaces/IApi.php';

class EmpleadoController implements IApi
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

    $empleado->crearEmpleado();

    $payload = json_encode(array("mensaje" => "Empleado creado con éxito"));

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    $usr = $args['usuario'];
    $usuario = Empleado::obtenerEmpleado($usr);
    $payload = json_encode($usuario);

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
    $usuario = $args['usuario'];
    $mensaje = Empleado::borrarEmpleado($usuario);

    $payload = json_encode(array("mensaje" => $mensaje));

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
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
