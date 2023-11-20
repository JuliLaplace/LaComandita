<?php

require_once './models/Empleado.php';

class LoginController 
{
    public function LoginEmpleado($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $usuario = $parametros['usuario'];
    $clave = $parametros['clave'];

    $empleado = new Empleado();
    $respuesta = Empleado::UsuarioContrasenaExiste($usuario, $clave);

    if ($respuesta == null) {
      $payload = json_encode(array("Error" => "Usuario-contrasena incorrecta. Reintente"));
    } else {
      $datos = ["usuario" => $respuesta->usuario, "sector" => $respuesta->sector];
      $token = AutentificadorJWT::CrearToken($datos);
      $payload = json_encode(array('jwt' => $token));
    }

    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
  }
}