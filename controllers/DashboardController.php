<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController{

  public static function index(Router $router){
    session_start();
    isAuth();
    $id = $_SESSION['id'];

    $proyectos = Proyecto::belongsTo('usuario_id', $id);
    
    $router->render('dashboard/index',[
      'titulo' => 'Proyectos',
      'proyectos' => $proyectos
    ]);
  }
  public static function crear_proyecto(Router $router){
    session_start();
    isAuth();
    $alertas = [];
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $proyecto = new Proyecto($_POST);

      $alertas = $proyecto->validarProyecto();

      if(empty($alertas)){
        $proyecto->url = md5(uniqid());
        $proyecto->usuario_id = $_SESSION['id'];

        $proyecto->guardar();
        header('Location: /proyectos?url=' . $proyecto->url);
      }
    }
    
    $router->render('dashboard/crear',[
      'alertas' => $alertas,
      'titulo' => 'Crear Proyecto',
    ]);
  }
  public static function proyectos(Router $router){
    session_start();
    isAuth();
    $alertas = [];

    $url = $_GET['url'];
    if(!$url){
      header('Location:/dashboard');
    }

    $proyecto = Proyecto::where('url', $url);
    if($proyecto->usuario_id !== $_SESSION['id']){
      // debuguear($proyecto);
      header('Location: /dashboard');
    }
    
    $router->render('dashboard/proyectos',[
      'alertas' => $alertas,
      'titulo' => $proyecto->proyecto,
    ]);
  }
  public static function perfil(Router $router){
    session_start();
    $alertas =[];
    isAuth();
    $usuario = Usuario::find($_SESSION['id']);

    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validarPerfil();
      
      if(empty($alertas)){
        $consultaEmail = Usuario::where('email', $usuario->email);
        
        if($consultaEmail && $consultaEmail->id !== $usuario->id){    
          // Mensaje Error
          Usuario::setAlerta('error','El correo ya existe');
          $alertas = $usuario->getAlertas();
        }else{
          $usuario->guardar();
          Usuario::setAlerta('exito','Creado correctamente');
          $alertas = $usuario->getAlertas();
          // Asignar el nombre nuevo actualizado a la session 
          $_SESSION['nombre'] = $usuario->nombre;
        }
       
      }
    }
    
    $router->render('dashboard/perfil',[
      'titulo' => 'Perfil',
      'usuario' => $usuario,
      
      'alertas' =>$alertas
    ]);
  }

  public static function cambiar_password(Router $router){
    session_start();
    isAuth();
    $alertas=[];
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $usuario = Usuario::find($_SESSION['id']);
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validanuevaPassword();
     
      if(empty($alertas)){
        $resultado = $usuario->comprobarPassword();
        if(!$resultado){
          Usuario::setAlerta('error','El password no coicide');
          $alertas = $usuario->getAlertas();
        }else{
          $usuario->password = $usuario->password_nuevo;
          $usuario->hashPassword();
          
          // Borrar datos inicesarios
          unset($usuario->password_actual);
          unset($usuario->password_nuevo);

          $usuario->guardar();

          Usuario::setAlerta('exito','Password Actualizado');
          $alertas = $usuario->getAlertas();
        }
       
      }
    }
    
    $router->render('dashboard/cambiar_password',[
      'titulo' => 'Cambiar Password',
      'alertas' =>$alertas
    ]);
  }
}

?>