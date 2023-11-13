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
require_once './db/AccesoDatos.php';
require_once './middlewares/AuthMiddleware.php';
require_once './middlewares/LoginMDW.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();
//$app->setBasePath('/public'); saque para no usar el public en la URL
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

//$app->add(new LoginMDW());//aca me fijo que este logueado para hacer cualquier otra cosa- NO FUNCIONA


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("TP La comandita :) !");
    return $response;
});

// peticiones
$app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadoController::class . ':TraerTodos');
    $group->get('/{usuario}[/]', \EmpleadoController::class . ':TraerUno');
    $group->post('/modificar[/]', \EmpleadoController::class . ':ModificarUno');
    $group->post('[/]', \EmpleadoController::class . ':CargarUno');
    $group->delete('/{empleado}[/]', \EmpleadoController::class . ':BorrarUno');
  })->add(AuthMiddleware::class. ':ValidarSocio'); //FUNCIONA

  $app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->get('/{producto}', \ProductoController::class . ':TraerUno');
    $group->post('/modificar[/]', \ProductoController::class . ':ModificarUno');
    $group->post('[/]', \ProductoController::class . ':CargarUno'); 
    $group->delete('/{producto}[/]', \ProductoController::class . ':BorrarUno');
  })->add(AuthMiddleware::class. ':ValidarSocio');

  $app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \MesaController::class . ':TraerTodos');
    $group->get('/{codigomesa}', \MesaController::class . ':TraerUno');
    $group->post('[/]', \MesaController::class . ':CargarUno');
  })->add(AuthMiddleware::class. ':ValidarSocio');

  //podria sacar dek grupo el "cerrar mesa" para pasaselo a admin que es el unico que puede hacerlo

  $app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->get('/detalles', \DetallePedidoController::class . ':TraerTodos');
    $group->get('[/]', \PedidoController::class . ':TraerTodos');
    $group->post('[/]', \PedidoController::class . ':CargarUno'); //primero cargo un pedido, después el detalle
    $group->get('/{codigo}', \PedidoController::class . ':TraerUno');
    $group->post('/pedido', \DetallePedidoController::class . ':cargarUno'); 
  })->add(\AuthMiddleware::class. ':ValidarMozo');



  




// Run app
$app->run();
