<?php
    require_once "./models/DetallePedido.php";
    require_once "./models/Producto.php";
    require_once "./models/Pedido.php";

    class DetallePedidoController
    {

        public function cargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            
            $codigoPedido = $parametros['codigopedido'];
            $nombreProducto = $parametros['producto'];
            $idProducto = Producto::ObtenerIdPorNombre($nombreProducto);
            $tiempoProducto = Producto::ObtenerTiempoPreparacion($idProducto);
            
            $idPedido = Pedido::ExisteCodigoPedido($codigoPedido);
            //var_dump($idProducto, $idPedido);
           if( $idPedido!= -1) //si pedido existe
            {

                    if($idProducto != -1)
                    {
                        $detallePedido = new DetallePedido();
                        $detallePedido->codigoPedido = $codigoPedido;
                        $detallePedido->idProducto = $idProducto;
                        $detallePedido->tiempoCalculado = $tiempoProducto; //tengo que mejorar esto
                        //$detallePedido->estado = 1;

                        Pedido::SumaPrecio($idPedido, Producto::ObtenerPrecioProductoPorId($idProducto));

            
                        $detallePedido->crearDetalleProducto();
            
                        $payload = json_encode(array("mensaje"=>"Producto cargado al pedido con exito."));
                        
                    }
                    else
                    {
                        $payload = json_encode(array("mensaje"=>"El producto seleccionado no existe"));
                    }


                }
                else
                {
                $payload = json_encode(array("mensaje"=>"Codigo de Pedido Inexistente"));
                }


            $response->getBody()->write($payload);

            return $response->withHeader('Content-Type', 'application/json');

        }

        public function TraerTodos($request, $response, $args)
        {
            $lista = DetallePedido::obtenerTodos();
            $payload = json_encode(array("listaPedido"=> $lista));

            $response->getBody()->write($payload);
            
            return $response->withHeader('Content-Type', 'application/json');

        }



    }
