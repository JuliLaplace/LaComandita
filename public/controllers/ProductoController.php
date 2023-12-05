<?php
require_once './models/Producto.php';
require_once './models/ArchivosCSV.php';
require_once './interfaces/IApiController.php';

class ProductoController implements IApiController
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $sector = $parametros['sector'];

        $prod = new Producto();
        $prod->nombre = $nombre;
        $prod->precio = $precio;
        $prod->sector = $sector;

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
            $payload = json_encode(array("Producto seleccionado" => $producto));
           
          }

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = Producto::obtenerTodos();
        $payload = json_encode(array("Lista de Productos" => $lista));

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
        $mensaje = Producto::modificarUno($nombre, $precio);

        $payload = json_encode(array("mensaje" => $mensaje));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
/////////////////////////////////////////////////////////////////////////////////
    public function exportarTabla($request, $response, $args)
    {
        try {
            ArchivosCSV::exportarTabla('productos', 'Producto', 'producto.csv');
            //$payload = json_encode("Tabla exportada con éxito");
            $payload = json_encode(array("mensaje" => "Tabla productos exportada"));
            $response->getBody()->write($payload);
            $newResponse = $response->withHeader('Content-Type', 'application/json');
            return $newResponse;
        } catch (\Throwable $mensaje) {
            // Aquí maneja los errores si ocurrieron durante la exportación
            $response->getBody()->write("Error al exportar: " . $mensaje->getMessage());
            return $response->withStatus(500); // Devuelve un estado de error 500
        }
    }


    public function ImportarTabla($request, $response, $args)
    {
        try
        {
            $archivo = ($_FILES["archivo"]);          
            Producto::CargarCSV($archivo["tmp_name"]);
            $payload = json_encode("Carga exitosa.");
            $payload = json_encode(array("mensaje" => "Tabla productos exportada"));
            $response->getBody()->write($payload);
            $newResponse = $response->withHeader('Content-Type', 'application/json');
        }
        catch(Throwable $mensaje)
        {
            printf("Error al listar: <br> $mensaje .<br>");
        }
        finally
        {
            return $newResponse;
        }    
    }
}
