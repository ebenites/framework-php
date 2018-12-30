<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../vendor/autoload.php';

session_start();    // After autoload

/**
 * Container Setup
 **/
$containerBuilder = new \DI\ContainerBuilder();
//$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(true);
$containerBuilder->addDefinitions([
    'config.database' => function() {
        return parse_ini_file(base_path('app/Config/database.ini'));  
    },
]);
$container = $containerBuilder->build();

/**
 * Router Setup
 **/
$dispatcher = require base_path('app/Config/routes.php');

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$route = $dispatcher->dispatch($httpMethod, $uri);

// Kint::dump($route);

switch ($route[0]) {
	case \FastRoute\Dispatcher::NOT_FOUND: {
		echo "Ruta no encontrada";
		break;
	}
	case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED: {
		echo "Método HTTP no permitido";
		break;
	}
	case \FastRoute\Dispatcher::FOUND: {
	    
	    // Authentication validate (artificio)
	    if (isset($route[1][2]) && $route[1][2] === 'auth') {
	        unset($route[1][2]);
			$session = $container->get(\Application\Providers\Session::class);
			if (!$session->islogged()) {
				$session->setFlash('danger', 'Acceso denegado');
				$view = $container->get(\Application\Providers\View::class);
				$view->redirect('login');
			}
 		}
	    
		$controller = $route[1];
		$params = $route[2];

		$container->call($controller, $params);
		break;
	}
}
