<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Slim\Psr7\Response as Response;

class AuthMiddleware
{

    public function ValidarSocio($request, $handler): ResponseInterface
    {   
        $parametros = $request->getQueryParams();

        $sector = $parametros['sector'];

        if ($sector === 'admin') {
            $response = $handler->handle($request);
           
        } else {
            $response = new Response();
            $payload = json_encode(array("mensaje" => "No sos Admin"));
            $response->getBody()->write($payload);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ValidarMozo($request, $handler): ResponseInterface
    {
        $parametros = $request->getQueryParams();

        $sector = $parametros['sector'];

        if ($sector === 'salon') {
            $response = $handler->handle($request);
           
        } else {
            $response = new Response();
            $payload = json_encode(array("mensaje" => "No sos Mozo"));
            $response->getBody()->write($payload);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}

?>