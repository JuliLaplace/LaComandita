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
          $dni = $parametros['dni'];
          $usuario = $parametros['usuario']; 

          $usr = new Usuario();
          $usr->tipo = $tipo;
          $usr->clave = $clave;
          $usr->nombre = $nombre;
          $usr->dni = $dni;
          $usr->usuario = $usuario; 
          $usr->fecha_creacion = date('Y-m-d H:i:s');

          $usr->crearUsuario();

          $payload = json_encode(array("mensaje" => "Usuario creado con éxito"));

          $response->getBody()->write($payload);
          return $response->withHeader('Content-Type', 'application/json');
      }



    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


}