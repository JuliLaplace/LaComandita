<?php
require_once './models/Producto.php';
require_once './interfaces/IApiController.php';

class ProductoController implements IApiController
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $sector = $parametros['sector'];
        $tiempopreparacion = $parametros['tiempopreparacion'];

        $prod = new Producto();
        $prod->nombre = $nombre;
        $prod->precio = $precio;
        $prod->sector = $sector;
        $prod->tiempopreparacion = $tiempopreparacion;

        $prod->crearUno();

        $payload = json_encode(array("mensaje" => "Producto creado con exito"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $prod = $args['producto'];
        $producto = Producto::obtenerUno($prod);
        if (!$producto) {
            $payload = json_encode(array("mensaje" => "El producto no existe"));
          } else {
            $payload = json_encode($producto);
          }

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = Producto::obtenerTodos();
        $payload = json_encode(array("listaProductos" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $producto = $args['producto'];
        $mensaje = Producto::borrarUno($producto);

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $tiempo = $parametros['tiempo'];
        $mensaje = Producto::modificarUno($nombre, $precio, $tiempo);

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
