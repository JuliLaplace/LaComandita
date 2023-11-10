<?php
    require_once("./models/Pedido.php");
    require_once("./models/Mesa.php");

    class PedidoController{

        public function cargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            
            $codigoPedido = $parametros['codigopedido'];
            $codigoMesa = $parametros['codigomesa'];
            $idEmpleado = $parametros['idempleado'];
            $idCliente = $parametros['idcliente'];
            $fecha = date("Y-m-d H:i:s");


            $idMesa = Mesa::ObtenerIdPorCodigoDeMesa($codigoMesa);
            //var_dump(Mesa::VerificarEstadoMesa($idMesa));

            if($idMesa != -1)
            {
                var_dump(Mesa::VerificarEstadoMesa($idMesa));
                if(Mesa::VerificarEstadoMesa($idMesa) == "abierta") //si la mesa esta abierta sin clientes
                {
                    if($idEmpleado != -1)
                    {
                        if($idCliente != -1)
                        {                            
                            $pedido = new Pedido();
                            $pedido->codigoPedido = $codigoPedido;
                            $pedido->codigoMesa = $codigoMesa;
                            $pedido->idEmpleado =  $idEmpleado;
                            $pedido->idCliente = $idCliente;
                            $pedido->fecha = $fecha;
                            $pedido->precio_final = 0;
                            
                            Mesa::CambiarEstadoMesa($idMesa, 1); //estado de mesa tiene que cambiar a "cliente esperando pedido"
                            
                            $pedido->crearPedido();
                
                            $payload = json_encode(array("mensaje"=>"Pedido creado con exito"));
                        }
                        else
                        {
                            $payload = json_encode(array("mensaje"=>"El id del cliente no existe."));
                        }
                    }
                    else
                    {
                        $payload = json_encode(array("mensaje"=>"El id de empleado no existe."));
                    }
                }
                else
                {
                    $payload = json_encode(array("mensaje"=>"La mesa seleccionada se encuentra ocupada."));
                }
            }
            else
            {
                $payload = json_encode(array("mensaje"=>"La mesa ingresada no existe."));
            }


            $response->getBody()->write($payload);

            return $response->withHeader('Content-Type', 'application/json');

        }

        public function TraerTodos($request, $response, $args)
        {
            $lista = Pedido::obtenerTodos();
            $payload = json_encode(array("listaPedido"=> $lista));

            $response->getBody()->write($payload);
            
            return $response->withHeader('Content-Type', 'application/json');

        }


    }


?>