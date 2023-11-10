<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/DetallePedidoController.php';
require_once './db/AccesoDatos.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();
//$app->setBasePath('/public');
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("TP La comandita :) !");
    return $response;
});

// peticiones
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');//funciona
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');//funciona
    $group->post('[/]', \UsuarioController::class . ':CargarUno'); //funciona
    $group->delete('/{usuario}[/]', \UsuarioController::class . ':BorrarUno'); //funciona
  });

  $app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->post('[/]', \ProductoController::class . ':CargarUno'); 
  });

  $app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \MesaController::class . ':TraerTodos');
    $group->post('[/]', \MesaController::class . ':CargarUno');
    $group->get('/{codigomesa}', \MesaController::class . ':TraerUno');
  });

  $app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \PedidoController::class . ':TraerTodos');
    $group->post('[/]', \PedidoController::class . ':CargarUno'); //primero cargo un pedido, despues el detalle - FUNCIONA
    $group->get('/detalles', \DetallePedidoController::class . ':TraerTodos');
    $group->post('/pedido', \DetallePedidoController::class . ':cargarUno');//FUNCIONA
});



// Run app
$app->run();


?>
