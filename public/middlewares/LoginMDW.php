<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class LoginMDW
{

    public function __invoke(Request $request, RequestHandler $handler)
    {
        $params = $request->getParsedBody();

        $usuario = $params['usuario'];
        $clave = $params['clave'];

        if (Empleado::empleadoExiste($usuario, $clave)) {
            $response = $handler->handle($request);
        } else {
            $response = new Response();
            $payload = json_encode(array("mensaje" => "El usuario y la clave no existen. Reintente"));
            $response->getBody()->write($payload);
        }

        return $response;
    }
    
}

?>