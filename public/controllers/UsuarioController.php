<?php
require_once './models/Usuario.php';

class UsuarioController 
{
  
 
    public function CargarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();

      $tipo = $parametros['tipo'];
      $clave = $parametros['clave'];
      $nombre = $parametros['nombre'];
      $usuario = $parametros['usuario']; 

      $usr = new Usuario();
      $usr->tipo = $tipo;
      $usr->clave = $clave;
      $usr->nombre = $nombre;
      $usr->usuario = $usuario; 
      $usr->fechaCreacion = date('Y-m-d H:i:s');

      $usr->crearUsuario();

      $payload = json_encode(array("mensaje" => "Usuario creado con éxito"));

      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
      $usr = $args['usuario'];
      $usuario = Usuario::obtenerUsuario($usr);
      $payload = json_encode($usuario);

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }



    public function TraerTodosPedido($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
/* ESTO TENIA ANTES
    public function BorrarUno($request, $response, $args)
    {
      $usuario = $args['usuario']; 
      Usuario::borrarUsuario($usuario);

      $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }
    */

    public function BorrarUno($request, $response, $args)
    {
        $usuario = $args['usuario'];
        $mensaje = Usuario::borrarUsuario($usuario); 

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }



}