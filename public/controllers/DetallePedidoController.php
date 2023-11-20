<?php
    require_once "./models/DetallePedido.php";
    require_once "./models/Producto.php";
    require_once "./models/Pedido.php";
    require_once './interfaces/IApiController.php';

    class DetallePedidoController implements IApiController
    {

        public function cargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            
            $codigoPedido = $parametros['codigopedido'];
            $nombreProducto = $parametros['producto'];

            $producto = Producto::obtenerUno($nombreProducto);
            $pedido = Pedido::obtenerUno($codigoPedido);

            if($pedido !=null){

                    //if($idProducto != -1)
                    if($producto!=null){
                        $detallePedido = new DetallePedido();
                        $detallePedido->codigoPedido = $codigoPedido;
                        $detallePedido->idProducto = $producto->id;
                        Pedido::SumaPrecio($pedido->id, Producto::ObtenerPrecioProductoPorId($producto->id));
            
                        $detallePedido->crearUno();
                        Pedido::SetearTiempoEstimado($codigoPedido);
            
                        $payload = json_encode(array("mensaje"=>"Producto cargado al pedido con exito."));
                        
                    }
                    else
                    {
                        $payload = json_encode(array("mensaje"=>"El producto seleccionado no existe"));
                    }


            }else{
                $payload = json_encode(array("mensaje"=>"Codigo de Pedido Inexistente"));
            }


            $response->getBody()->write($payload);

            return $response->withHeader('Content-Type', 'application/json');

        }

        public function TraerTodos($request, $response, $args)
        {
            $lista = DetallePedido::obtenerTodos();
            $payload = json_encode(array("listaDetallesPedidos"=> $lista));

            $response->getBody()->write($payload);
            
            return $response->withHeader('Content-Type', 'application/json');

        }

        public function TraerUno($request, $response, $args){
            $id = $args['id'];

            $detallePed = DetallePedido::obtenerUno($id);

            if (!$detallePed) {
                $payload = json_encode(array("mensaje" => "El detalle de pedido no existe"));
            } else {
                $payload = json_encode($detallePed);
            }

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args){
            $id = $args['id'];
        
            $mensaje = DetallePedido::borrarUno($id);

            $payload = json_encode(array("mensaje" => $mensaje));

            $response->getBody()->write($payload);
            return $response
            ->withHeader('Content-Type', 'application/json');
        }
        
        public function ModificarUno($request, $response, $args){
            
            $parametros = $request->getParsedBody();

            $id = $parametros['id'];
            $producto = $parametros['producto'];
            $codigo = $parametros['codigoPedido'];
        
            $mensaje = DetallePedido::modificarUno($id, $producto, $codigo);
        
            $payload = json_encode(array("mensaje" => $mensaje));
        
            $response->getBody()->write($payload);
            return $response
              ->withHeader('Content-Type', 'application/json');
        }


        public function ListarPendientes($request, $response, $args)
        {
            $sector = $request->getAttribute('sector');
            $mensaje = DetallePedido::ListarPendientes($sector);

            $payload = json_encode(array("mensaje" => $mensaje));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function CambiarEstadoDetallePedido($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $id = $parametros['id'];
            $estado = $parametros['estado'];

            $mensaje = DetallePedido::CambiarEstado($id, $estado);
            $payload = json_encode(array("mensaje" => $mensaje));

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }


        

    }
