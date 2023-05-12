<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\TareaController;
use MVC\Router;
$router = new Router();

// Login
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
// Logout
$router->get('/logout',[LoginController::class,'logout']);

// crear usuario
$router->get('/crear',[LoginController::class,'crear']);
$router->post('/crear',[LoginController::class,'crear']);

// Olvide
$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvide']);

// Colocar nuevo password
$router->get('/reestablecer',[LoginController::class,'reestablecer']);
$router->post('/reestablecer',[LoginController::class,'reestablecer']);

// Confirmacion de la cuenta
$router->get('/mensaje',[LoginController::class,'mensaje']);
$router->get('/confirmar',[LoginController::class,'confirmar']);

// Dashbord
$router->get('/dashboard',[DashboardController::class,'index']);
$router->get('/crear-proyecto',[DashboardController::class,'crear_proyecto']);
$router->post('/crear-proyecto',[DashboardController::class,'crear_proyecto']);
$router->get('/proyectos',[DashboardController::class,'proyectos']);
$router->get('/perfil',[DashboardController::class,'perfil']);
$router->post('/perfil',[DashboardController::class,'perfil']);
$router->get('/cambiar_password',[DashboardController::class,'cambiar_password']);
$router->post('/cambiar_password',[DashboardController::class,'cambiar_password']);

// Api
$router->get('/api/tareas',[TareaController::class, 'index']);
$router->post('/api/tareas',[TareaController::class, 'crear']);
$router->post('/api/tareas/actualizar',[TareaController::class, 'actualizar']);
$router->post('/api/tareas/eliminar',[TareaController::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();