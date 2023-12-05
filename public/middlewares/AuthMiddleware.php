<?php


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as Response;


class AuthMiddleware
{
    public static function verificarToken(Request $request, RequestHandler $handler): Response
    {
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);
            $usuario = $data->usuario;
 
            //$request = $request->withAttribute('usuario', $usuario);
            $response = $handler->handle($request);

        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ValidarSocio($request, $handler): Response
    {   
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);

            if ($data->sector == '6') {
                $request = $request->withAttribute('sector', $data->sector); //le paso un atributo para obetenr el sector
                $response = $handler->handle($request);
               
            } else {
                $response = new Response();
                $payload = json_encode(array("mensaje" => "No sos Socio"));
                $response->getBody()->write($payload);
            }



        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ValidarCervecero($request, $handler): Response
    {
       
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);

            if ($data->sector == '4' || $data->sector == '6') {
                $request = $request->withAttribute('sector', $data->sector); //le paso un atributo para obetenr el sector
                $response = $handler->handle($request);
               
            } else {

                $response = new Response();
                $payload = json_encode(array("mensaje" => "No sos Cervecero"));
                $response->getBody()->write($payload);
            }



        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ValidarBartender($request, $handler): Response
    {
       
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);

            if ($data->sector == '3' || $data->sector == '6') {
                $request = $request->withAttribute('sector', $data->sector); //le paso un atributo para obetenr el sector
                $response = $handler->handle($request);
               
            } else {

                $response = new Response();
                $payload = json_encode(array("mensaje" => "No sos Bartender"));
                $response->getBody()->write($payload);
            }



        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ValidarCocinero($request, $handler): Response
    {
       
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);

            if ($data->sector == '2' || $data->sector == '6') {
                $request = $request->withAttribute('sector', $data->sector); //le paso un atributo para obetenr el sector
                $response = $handler->handle($request);
               
            } else {

                $response = new Response();
                $payload = json_encode(array("mensaje" => "No sos Cocinero"));
                $response->getBody()->write($payload);
            }



        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function ValidarCandybar($request, $handler): Response
    {
       
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);

            if ($data->sector == '1' || $data->sector == '6') {
                $request = $request->withAttribute('sector', $data->sector); //le paso un atributo para obetenr el sector
                $response = $handler->handle($request);
               
            } else {

                $response = new Response();
                $payload = json_encode(array("mensaje" => "No sos CandyMan"));
                $response->getBody()->write($payload);
            }



        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ValidarMozo($request, $handler): Response
    {
       
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);

            if ($data->sector == '5' || $data->sector == '6') {
                $request = $request->withAttribute('sector', $data->sector); //le paso un atributo para obetenr el sector
                $response = $handler->handle($request);
               
            } else {

                $response = new Response();
                $payload = json_encode(array("mensaje" => "No sos Mozo"));
                $response->getBody()->write($payload);
            }



        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function ValidarSoloMozo($request, $handler): Response
    {
       
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);

            if ($data->sector == '5') {
                $request = $request->withAttribute('sector', $data->sector); //le paso un atributo para obetenr el sector
                $response = $handler->handle($request);
               
            } else {

                $response = new Response();
                $payload = json_encode(array("mensaje" => "No sos Mozo"));
                $response->getBody()->write($payload);
            }



        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
/*
    public function ValidarMozoSocio($request, $handler): Response
    {
       
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);

            if ($data->sector == '5' || $data->sector == '6') {
                $request = $request->withAttribute('sector', $data->sector); //le paso un atributo para obetenr el sector
                $response = $handler->handle($request);
               
            } else {

                $response = new Response();
                $payload = json_encode(array("mensaje" => "No sos un usuario valido para esta accion"));
                $response->getBody()->write($payload);
            }



        } catch (Exception $e) {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'ERROR: Hubo un error con el TOKEN'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
*/

}

?>