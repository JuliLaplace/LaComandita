<?php
require_once("./models/Pedido.php");
require_once("./models/Mesa.php");
require_once("./models/DetallePedido.php");
require_once './interfaces/IApiController.php';

class PedidoController implements IApiController
{

    public function cargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigoPedido = $parametros['codigoPedido'];
        $codigoMesa = $parametros['codigoMesa'];
        $idCliente = $parametros['idCliente'];
        $fecha = date("Y-m-d H:i:s");
        //aca
        /*
        $usuario = $request->getAttribute('usuario');
        $empleado = Empleado::obtenerUno($usuario);*/
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $data = AutentificadorJWT::ObtenerData($token);
        $usuario = $data->usuario;
        $empleado = Empleado::obtenerUno($usuario);



        $idMesa = Mesa::ObtenerIdPorCodigoDeMesa($codigoMesa);

        if ($idMesa != -1) {
            if (Mesa::VerificarEstadoMesa($idMesa) == "cerrada") //si la mesa esta cerrada sin clientes
            {

                    if ($idCliente != -1) {
                        $pedido = new Pedido();
                        $pedido->codigoPedido = $codigoPedido;
                        $pedido->codigoMesa = $codigoMesa;                        
                        $pedido->idEmpleado =  $empleado->id;
                        $pedido->idCliente = $idCliente;
                        $pedido->precioFinal = 0;
                        $pedido->estado = 4; //estado iniciado


                        Mesa::CambiarEstadoMesa($idMesa, 1); //estado de mesa tiene que cambiar a "cliente esperando pedido"

                        $respuesta = $pedido->crearUno();


                        $payload = json_encode(array("mensaje" => "Pedido creado con exito - Codigo: $codigoPedido - Mozo: $usuario -  Ahora ingrese los productos que desee"));
                    } else {
                        $payload = json_encode(array("mensaje" => "El id del cliente no existe."));
                    }
 
            } else {
                $payload = json_encode(array("mensaje" => "La mesa seleccionada se encuentra ocupada."));
            }
        } else {
            $payload = json_encode(array("mensaje" => "La mesa ingresada no existe."));
        }


        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::obtenerTodos();


        $payload = json_encode(array("listaPedido" => $lista));

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $codigo = $args['codigo'];

        $ped = Pedido::obtenerUno($codigo);

        if (!$ped) {
            $payload = json_encode(array("mensaje" => "El pedido no existe"));
        } else {
            $payload = json_encode(array("Pedido seleccionado" => $ped));
        }

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $codigo = $args['codigo'];

        $mensaje = Pedido::borrarUno($codigo);

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigo = $parametros['codigoPedido'];
        $mesa = $parametros['codigoMesa'];

        $mensaje = Pedido::modificarUno($codigo, $mesa);

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function CargarFoto($request, $response, $args)
    {
            $parametros = $request->getParsedBody();

            $codigo = $parametros['codigoPedido'];
            $foto = $_FILES['foto'];

            $pedido = Pedido::obtenerUno($codigo);
            if ($pedido != null) {
                $id = $pedido['id'];
                $codigoPedido = $pedido['codigoPedido'];
                //$nombreFoto = $pedido->id . "-" . $pedido->codigoPedido;
                $nombreFoto = $id . "-" . $codigoPedido;
                if (Pedido::GuardarImagen($foto, $nombreFoto, $codigo)) {

                    $mensaje = "Foto de pedido N° $codigoPedido guardada";
                } else {
                    $mensaje = "Error en cargar la foto";
                }
            } else {
                $mensaje = "El pedido seleccionado no existe";
            }

            $payload = json_encode(array("mensaje" => $mensaje));

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json');
    }
    

    public function TraerTiempoDemora($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $codigo = $parametros['codigoPedido'];

        $pedido = Pedido::obtenerUno($codigo);

        if ($pedido) {
            $tiempoDemora = Pedido::TraerTiempoDemora($codigo);
            

            if ($tiempoDemora !== null) {  
                $horaActual = new DateTime();
                $tiempoDemora = DateTime::createFromFormat('H:i:s', $tiempoDemora);

                // Calcular la diferencia en minutos
                $interval = $horaActual->diff($tiempoDemora);

                // Obtener la diferencia en minutos
                $diferenciaEnMinutos = $interval->format('%r%i');

                if ($interval->invert) {
                    $dif = abs($diferenciaEnMinutos);
                    $mensaje = "El pedido ha pasado el tiempo de espera por $dif minutos";
                } else {
                    $mensaje = "El tiempo de demora del pedido Numero $codigo es de $diferenciaEnMinutos minutos";
                }
            } else {
                $mensaje = "Todavia no se adjudico un tiempo de demora al pedido cod: $codigo";
            }

            $payload = json_encode(array("mensaje" => $mensaje));
        } else {
            $payload = json_encode(array("mensaje" => "El pedido con código N° $codigo no existe"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function ServirPedido($request, $response, $args)
    {
        $codigo = $args['codigo'];

        $pedido = Pedido::obtenerUno($codigo);
        if ($pedido != null) {
            $retorno = DetallePedido::TodosFinalizadosEnPedido($codigo);
            if($retorno){
                $idMesa = Mesa::ObtenerIdPorCodigoDeMesa($pedido->codigoMesa);
                Mesa::CambiarEstadoMesa($idMesa, 2); //cambio estado a mesa con cliente comiendo
                Pedido::CambiarEstadoPedido($pedido->id, 2);
                $mensaje = "Pedido servido";
            }
            else{
                $mensaje = "No se puede entregar el pedido - Todavia hay pedidos sin terminar";
            }
        } else {
            $mensaje = "El pedido seleccionado no existe";
        }

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function PagarPedido($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $codigo = $parametros['codigoPedido'];

        $pedido = Pedido::obtenerUno($codigo);

        if ($pedido != null && $pedido['estado'] == "finalizado") {
            $idMesa = Mesa::ObtenerIdPorCodigoDeMesa($pedido['codigoMesa']);
            Mesa::CambiarEstadoMesa($idMesa, 3); //cambio estado a mesa con cliente pagando
            DetallePedido::finalizarDetallePedidos($codigo);
            $precio = Pedido::CobrarCuenta($codigo); //busco el precio
            $mensaje = "Pedido cod: $codigo - precio total a pagar: $precio - Cliente pagando";
            
        } else if($pedido != null && $pedido['estado'] != "finalizado"){
            $mensaje = "El pedido seleccionado no pidio la cuenta - Pedido todavia en proceso/comiendo";
        }else{
            $mensaje = "El pedido seleccionado no existe";
        }

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    
}
