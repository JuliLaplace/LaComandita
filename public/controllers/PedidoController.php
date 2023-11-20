<?php
require_once("./models/Pedido.php");
require_once("./models/Mesa.php");
require_once './interfaces/IApiController.php';

class PedidoController implements IApiController
{

    public function cargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigoPedido = $parametros['codigoPedido'];
        $codigoMesa = $parametros['codigoMesa'];
        $idEmpleado = $parametros['idEmpleado'];
        $idCliente = $parametros['idCliente'];
        $fecha = date("Y-m-d H:i:s");





        $idMesa = Mesa::ObtenerIdPorCodigoDeMesa($codigoMesa);
        //var_dump(Mesa::VerificarEstadoMesa($idMesa));

        if ($idMesa != -1) {
            //var_dump(Mesa::VerificarEstadoMesa($idMesa));
            if (Mesa::VerificarEstadoMesa($idMesa) == "cerrada") //si la mesa esta cerrada sin clientes
            {
                if ($idEmpleado != -1) {
                    if ($idCliente != -1) {
                        $pedido = new Pedido();
                        $pedido->codigoPedido = $codigoPedido;
                        $pedido->codigoMesa = $codigoMesa;
                        $pedido->idEmpleado =  $idEmpleado;
                        $pedido->idCliente = $idCliente;
                        $pedido->fecha = $fecha;
                        $pedido->precio_final = 0;
                        $pedido->estado = 1; //estado en proceso


                        Mesa::CambiarEstadoMesa($idMesa, 1); //estado de mesa tiene que cambiar a "cliente esperando pedido"

                        $pedido->crearUno();

                        $payload = json_encode(array("mensaje" => "Pedido creado con exito"));
                    } else {
                        $payload = json_encode(array("mensaje" => "El id del cliente no existe."));
                    }
                } else {
                    $payload = json_encode(array("mensaje" => "El id de empleado no existe."));
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
            $payload = json_encode($ped);
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

        $codigo = $parametros['codigo'];
        $foto = $_FILES['foto'];

        $pedido = Pedido::obtenerUno($codigo);
        if ($pedido != null) {
            $nombreFoto = $pedido->id . "-" . $pedido->codigoPedido;
            if (Pedido::GuardarImagen($foto, $nombreFoto, $codigo)) {

                $mensaje = "Foto guardada";
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
}
