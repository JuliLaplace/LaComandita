<?php
require_once './models/Producto.php';

class ProductoController 
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

        $prod->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto creado con éxito"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = Producto::obtenerTodosProductos();
        $payload = json_encode(array("listaProductos" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }



    
}