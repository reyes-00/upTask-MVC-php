<?php

namespace Controllers;

use MVC\Router;
use Clases\Email;
use Model\Usuario;

class LoginController{

  public static function login(Router $router){
    
    $usuario = new Usuario;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $usuario = new Usuario($_POST);
      $alertas = $usuario->validaLogin();

      if(empty($alertas)){
        // comprobar que exita en la base de datos 
        $auth = Usuario::where('email',$usuario->email);

        if(!$auth || !$auth->confirmado){
          $alertas = Usuario::setAlerta('error','El correo no existe o el usuario no esta confirmado.');
           
        }else{

          if(password_verify($_POST['password'], $auth->password)) {

              session_start();
              $_SESSION['id'] = $auth->id;
              $_SESSION['nombre'] = $auth->nombre;
              $_SESSION['email'] = $auth->email;
              $_SESSION['login'] = true;
              header('Location:/dashboard');
          }else{
            $alertas = Usuario::setAlerta('error','El password es incorrecto.'); 
            
            
          }
        }
      }
    }

    $alertas = Usuario::getAlertas();
    $router->render('auth/login',[
      'titulo'=> 'Inicia sesion',
      'usuario'=> $usuario,
      'alertas' => $alertas
    ]);
  }
  
  public static function logout(){
    
    session_start();
    $_SESSION = [];

    header('Location:/');
    
  }
  public static function crear(Router $router){
    
    $usuario = new Usuario();
    $alertas = $usuario->getAlertas();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $usuario = new Usuario($_POST);

      $alertas = $usuario->validarDatos();

      if(empty($alertas)){
        $existeUsuario = Usuario::where('email',$usuario->email);
        if($existeUsuario){
          $usuario->setAlerta('error','El usuario ya ha sido registrado');
          $alertas = $usuario->getAlertas();
        }else{
          // hashear password
          $usuario->hashPassword();
          unset($usuario->password_dos);

          // Generar token
          $usuario->token();
          $usuario->guardar();

          // Generar correo 
          $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
          $email->enviarConfirmacion();
          header('Location: /mensaje');
        }
      }
    }
    $router->render('auth/crear',[
      'titulo'=> 'Crea una cuenta',
      'usuario'=> $usuario,
      'alertas'=>$alertas,
    ]);
  }
  public static function olvide(Router $router){
    // 
    $alertas =[];
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $usuario = new Usuario($_POST);
      $alertas = $usuario->validarEmail();

      // comprobar que el correo exista
      if(empty($alertas)){

        // consultar DB
          $email = Usuario::where('email', $usuario->email);

        if($email && $email->confirmado){
          // generar token
          $email->token();
          unset($email->password_dos);
        
          // actualizar el usuario
          $email->guardar();
          // Enviar el email
          $mail = new Email($email->nombre,$email->email,$email->token);
          $mail->olvide();

          // Imprimir alerta
          $alertas['exito'][] = "Enviado Correctamente";

         
        }else{
          $alertas['error'][]= 'No se registro con ese correo';
        }
    }

    }
    
    $router->render('auth/olvide',[
      'titulo'=>"Olvide",
      'alertas' =>$alertas,
    ]);
  }
  public static function reestablecer(Router $router){
    $token = s($_GET['token']);
    $mostrar = true;

    if(!$token){
      header("Location:/");
    }
    $usuario = Usuario::where('token', $token);

    if(empty($usuario)){
      $alertas = Usuario::setAlerta('error','Token no valido');
      $mostrar = false;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      
      $usuario->sincronizar($_POST);
      
      $alertas = $usuario->validarPassword();

      if(empty($alertas)){
        unset($usuario->password_dos);
        $usuario->hashPassword();
        $usuario->token = null;
        $resultado = $usuario->guardar();

        if($resultado){
          header('Location: /');
        }else{
          $alertas = Usuario::setAlerta('error','Ocurrio un error');
        }
      }

    }

    $alertas = Usuario::getAlertas();
    $router->render('auth/restablecer',[
      'alertas' => $alertas,
      'mostrar' => $mostrar
    ]);

  }
  public static function confirmar(Router $router){
    $token = $_GET ['token'];
    $consulta = Usuario::where('token', $token);
    if(!$consulta){
      Usuario::setAlerta('error', 'Token no valido');
    }else{
      $consulta->confirmado = 1;
      $consulta->token = null;
      unset($consulta->password_dos);
      $consulta->guardar();
      if($consulta){

        Usuario::setAlerta('exito', 'Token valido puedes iniciar sesion');
      }


    }
    $alertas = Usuario::getAlertas();
    $router->render('auth/confirma',[
      'titulo' => 'Corfirma cuenta upTask',
      'alertas' => $alertas
    ]);
   
  }
  public static function mensaje(Router $router){
    
    $router->render('auth/mensaje',[
      'titulo' => 'Cuenta creada correctamente'
    ]);
  
  }
}
