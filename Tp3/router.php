<?php
require_once 'Libs/router.php';
require_once 'Controller/auto.controller.php';
require_once 'Controller/user.controller.php';
require_once 'Middlewares/jwt.auth.middleware.php';

$router = new Router();
$router->addMiddleware(new JWTAuthMiddleware());

// Rutas para la API de Autos
$router->addRoute('autos', 'GET', 'AutoApiController', 'listarTodosLosAutos'); // Obtener todos los autos
$router->addRoute('autos/:id', 'GET', 'AutoApiController', 'mostrar_detalle_modelo'); // Obtener un auto por ID
$router->addRoute('autos', 'POST', 'AutoApiController', 'AgregarAuto'); // Añadir un nuevo auto
$router->addRoute('autos/:id', 'PUT', 'AutoApiController', 'editarAuto'); // Editar un auto

// Rutas para la API de Marcas
$router->addRoute('marcas', 'GET', 'AutoApiController', 'listarMarcas'); // Obtener todas las marcas
$router->addRoute('marcas/:id', 'GET', 'AutoApiController', 'listarModelos'); // Obtener modelos por ID de marca
$router->addRoute('marcas', 'POST', 'AutoApiController', 'AgregarMarca'); // Añadir una nueva marca

// Rutas para la API de Usuarios
$router->addRoute('usuarios/token', 'GET', 'UserController', 'getToken'); // Obtener token

// Ejecutar la ruta correspondiente
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
