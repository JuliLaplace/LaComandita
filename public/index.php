<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/EmpleadoController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/DetallePedidoController.php';
require_once './controllers/ClienteController.php';
require_once './controllers/LoginController.php';
require_once './controllers/EncuestaController.php';
require_once './db/AccesoDatos.php';
require_once './middlewares/AuthMiddleware.php';
require_once './middlewares/AutentificadorJWT.php';
require_once './middlewares/logMiddleware.php';


date_default_timezone_set('America/Buenos_Aires');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();
//$app->setBasePath('/public'); saque para no usar el public en la URL
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();





$app->group('/auth', function (RouteCollectorProxy $group) {

  $group->post('/login', \LoginController::class . ':LoginEmpleado');

});

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("TP La comandita :) !");
    return $response;
});

//EMPLEADOS 
$app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadoController::class . ':TraerTodos');
    $group->get('/{usuario}[/]', \EmpleadoController::class . ':TraerUno');
    $group->put('/modificar[/]', \EmpleadoController::class . ':ModificarUno');
    $group->post('[/]', \EmpleadoController::class . ':CargarUno');
    $group->delete('/{empleado}[/]', \EmpleadoController::class . ':BorrarUno');
  })
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio');

  //PRODUCTOS
  $app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->get('/{producto}[/]', \ProductoController::class . ':TraerUno');
    $group->put('/modificar[/]', \ProductoController::class . ':ModificarUno');
    $group->post('[/]', \ProductoController::class . ':CargarUno'); 
    $group->delete('/{producto}[/]', \ProductoController::class . ':BorrarUno');
  })
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio');

  //MESAS
  $app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \MesaController::class . ':TraerTodos');
    $group->get('/{codigomesa}[/]', \MesaController::class . ':TraerUno');
    $group->post('[/]', \MesaController::class . ':CargarUno');
  })
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarMozo');
  

  //PEDIDOS
  $app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->get('/detalles[/]', \DetallePedidoController::class . ':TraerTodos');
     
    $group->get('[/]', \PedidoController::class . ':TraerTodos');
    $group->post('[/]', \PedidoController::class . ':CargarUno');
    $group->get('/{codigo}[/]', \PedidoController::class . ':TraerUno');
    $group->get('/detalles/{id}[/]', \DetallePedidoController::class . ':TraerUno');
    $group->put('/modificar[/]', \PedidoController::class . ':ModificarUno');
    $group->put('/detalles/modificar[/]', \DetallePedidoController::class . ':ModificarUno');
    //$group->post('/demora[/]', \PedidoController::class . ':TraerTiempoDemora');
    $group->post('/servir[/]', \DetallePedidoController::class . ':ChequearPedidoParaServir');
  })
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarMozo');

  //SOCIO
  $app->post('/pedidos/demora[/]', \PedidoController::class . ':TraerTiempoDemora')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio');

  //PEDIDOS MOZO
  $app->post('/pedidos/pedir[/]', \PedidoController::class . ':CargarUno')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSoloMozo');
  $app->post('/pedidos/pedido[/]', \DetallePedidoController::class . ':cargarUno')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSoloMozo');
  $app->post('/pedidos/foto[/]', \PedidoController::class . ':CargarFoto')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSoloMozo');
  $app->post('/pedidos/pagando[/]', \PedidoController::class . ':PagarPedido')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSoloMozo');

  //LISTAR PENDIENTES POR SECTOR
  $app->get('/pedidos/detalles/listar/bar[/]',  \DetallePedidoController::class . ':ListarPendientes')
  ->add(\AuthMiddleware::class. ':ValidarBartender')
  ->add(\AuthMiddleware::class. ':verificarToken');

  $app->get('/pedidos/detalles/listar/cocina[/]',  \DetallePedidoController::class . ':ListarPendientes')
  ->add(\AuthMiddleware::class. ':ValidarCocinero')
  ->add(\AuthMiddleware::class. ':verificarToken');

  $app->get('/pedidos/detalles/listar/candy[/]',  \DetallePedidoController::class . ':ListarPendientes')
  ->add(\AuthMiddleware::class. ':ValidarCandybar')
  ->add(\AuthMiddleware::class. ':verificarToken');

  $app->get('/pedidos/detalles/listar/cerveza[/]',  \DetallePedidoController::class . ':ListarPendientes')
  ->add(\AuthMiddleware::class. ':ValidarCervecero')
  ->add(\AuthMiddleware::class. ':verificarToken');
 
  //CAMBIAR ESTADO DETALLE PEDIDO
  $app->post('/pedidos/detalles/estado_preparacion[/]', \DetallePedidoController::class . ':CambiarEstadoPreparacion');
  $app->post('/pedidos/detalles/estado_listo[/]', \DetallePedidoController::class . ':CambiarEstadoListo');
  
  //LISTAR MESAS Y ESTADOS
  $app->get('/listar_mesas[/]', \MesaController::class . ':ListadoMesasYEstados')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio');

  //MESA MAS USADA  
  $app->get('/mesa_mas_usada[/]', \MesaController::class . ':ListarMesaMasUsada')
  
  ->add(\AuthMiddleware::class. ':ValidarSocio')
  ->add(\AuthMiddleware::class. ':verificarToken');

  //ELIMINAR - SOCIO
  $app->delete('mesas/{codigo}[/]', \MesaController::class . ':BorrarUno')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio');
  $app->delete('/pedidos/{codigo}[/]', \PedidoController::class . ':BorrarUno')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio'); 
  $app->delete('/pedidos/detalles/{id}[/]', \DetallePedidoController::class . ':BorrarUno')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio');
  
  //CERRAR MESA SOCIO
  $app->put('/mesas/modificar[/]', \MesaController::class . ':CerrarMesa')
  ->add(\AuthMiddleware::class. ':ValidarSocio')
  ->add(\AuthMiddleware::class. ':verificarToken');

  //MEJORES COMENTARIOS SOCIO
  $app->get('/encuesta/tres_mejores[/]', \EncuestaController::class . ':TraerMejoresComentarios')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio');

  //CLIENTE
  $app->post('/cliente/espera',  \ClienteController::class . ':TraerUno');
  $app->post('/cliente/encuesta[/]',  \EncuestaController::class . ':CargarUno');



  //ARCHIVOS CSV
  $app->post('/csv/importar[/]', \ProductoController::class . ':ImportarTabla');
  $app->get('/csv/guardar[/]', \ProductoController::class . ':ExportarTabla');

  //PDF
   $app->get('/download', function($request, $response, $args) {
    $filename = 'Logo/logo.pdf';
    
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="'. basename($filename) .'.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: max-age=0');
    readfile($filename);
    return $response;
});




$app->add(\LogMiddleware::class);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);


// Run app
$app->run();
