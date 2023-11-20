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

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();
//$app->setBasePath('/public'); saque para no usar el public en la URL
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->group('/auth', function (RouteCollectorProxy $group) {

  $group->post('/login', \LoginController::class . ':LoginEmpleado');

});

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("TP La comandita :) !");
    return $response;
});

// peticiones 
$app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadoController::class . ':TraerTodos')
    ->add(\AuthMiddleware::class. ':verificarToken')
    ->add(\AuthMiddleware::class. ':ValidarSocio');
    $group->get('/{usuario}[/]', \EmpleadoController::class . ':TraerUno');
    $group->post('/modificar[/]', \EmpleadoController::class . ':ModificarUno');
    $group->post('[/]', \EmpleadoController::class . ':CargarUno');
    $group->delete('/{empleado}[/]', \EmpleadoController::class . ':BorrarUno');
  })->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio');

  $app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->get('/{producto}[/]', \ProductoController::class . ':TraerUno');
    $group->post('/modificar[/]', \ProductoController::class . ':ModificarUno');
    $group->post('[/]', \ProductoController::class . ':CargarUno'); 
    $group->delete('/{producto}[/]', \ProductoController::class . ':BorrarUno');
  })->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarSocio');

  $app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \MesaController::class . ':TraerTodos');
    $group->get('/{codigomesa}[/]', \MesaController::class . ':TraerUno');
    $group->post('/modificar[/]', \MesaController::class . ':ModificarUno');
    $group->post('[/]', \MesaController::class . ':CargarUno');
  })->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarMozo');
  


  $app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->get('/detalles[/]', \DetallePedidoController::class . ':TraerTodos');
    $group->get('[/]', \PedidoController::class . ':TraerTodos');
    $group->post('[/]', \PedidoController::class . ':CargarUno');
    $group->get('/{codigo}[/]', \PedidoController::class . ':TraerUno');
    $group->get('/detalles/{id}[/]', \DetallePedidoController::class . ':TraerUno');
    $group->post('/modificar[/]', \PedidoController::class . ':ModificarUno');
    $group->post('/detalles/modificar[/]', \DetallePedidoController::class . ':ModificarUno');
    $group->post('/pedido[/]', \DetallePedidoController::class . ':cargarUno');
    $group->post('/foto[/]', \PedidoController::class . ':CargarFoto'); 
  })->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarMozo');
  
  $app->get('/pedidos/detalles/listar/bar[/]',  \DetallePedidoController::class . ':ListarPendientes')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarBartender');
  $app->get('/pedidos/detalles/listar/cocina[/]',  \DetallePedidoController::class . ':ListarPendientes')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarCocinero');
  $app->get('/pedidos/detalles/listar/candy[/]',  \DetallePedidoController::class . ':ListarPendientes')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarCandybar');
  $app->get('/pedidos/detalles/listar/cerveza[/]',  \DetallePedidoController::class . ':ListarPendientes')
  ->add(\AuthMiddleware::class. ':verificarToken')
  ->add(\AuthMiddleware::class. ':ValidarCervecero');
 
  //CAMBIAR ESTADO
  $app->post('/pedidos/detalles/estado[/]', \DetallePedidoController::class . ':CambiarEstadoDetallePedido');

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

  //CLIENTE
  $app->get('/cliente/{codigo}',  \ClienteController::class . ':TraerUno');
  $app->post('/cliente/encuesta[/]',  \EncuestaController::class . ':CargarUno');

 

  




// Run app
$app->run();
