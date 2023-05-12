<?php

namespace Controllers;

use Model\Tarea;
use Model\Proyecto;

class TareaController {

  public static function index(){
    // leemos la url del usuario para mostrar sus tareas
    $url = $_GET['url'];

    if(!$url){
      header('Location:/dashboard');
    }
    
    // consulta
    $proyecto = Proyecto::where('url', $url);
    // // session_start();
    // if($proyecto->usuario_id !== $_SESSION['id'] || !$proyecto){
    //   header('Location:/404');
    // }

    $tareas = Tarea::belongsTo('proyecto_id',$proyecto->id);

 
    $respuesta = [
      'tareas' => $tareas
    ];
    header('Content-Type: application/json');
    echo json_encode($respuesta);
  }

  public static function crear(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      
      session_start();
      $proyectoId = $_POST['proyecto_id'];
     
      $proyecto = Proyecto::where('url', $proyectoId);

      if(!$proyecto || $proyecto->usuario_id !== $_SESSION['id']){
        $respuesta = [
          'tipo' => 'error',
          'mensaje' => 'Hubo un error al crear la tarea',
          
        ];  
        echo json_encode($respuesta);

        return;
      }

      // Instanciar la tarea
      $tarea = new Tarea($_POST);
      $tarea->proyecto_id = $proyecto->id; 
      $resultado = $tarea->guardar();
      $respuesta = [
        'tipo' => 'exito',
        'id' => $resultado['id'],
        'mensaje' => 'Tarea agregada correctamente',
        'proyecto_id' => $proyecto->id
      ];
      
      echo json_encode($respuesta);

    }
  }

  public static function actualizar(){
   if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $proyecto_id = $_POST['proyecto_id'];

    $proyecto = Proyecto::where('url',$proyecto_id);
    session_start();
    
    if(!$proyecto || $proyecto->usuario_id !== $_SESSION['id']){
      $respuesta = [
        'tipo' => 'error',
        'mensaje' => 'Hubo un error al actualizar la tarea',

      ];
      echo json_encode($respuesta);
      return;
    }

    $tarea = new Tarea($_POST);
    $tarea->proyecto_id = $proyecto->id;
    $resultado = $tarea->guardar();
    
    if($resultado){
      $respuesta = [
        'resultado' => $resultado,
        'tipo' => 'exito',
        'id' => $tarea->id,
        'mensaje' => 'Actualizado correctamente',
        'proyecto_id' => $proyecto->url
      ];
    }
   
    echo json_encode($respuesta);
   }
  }

  public static function eliminar(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $proyecto_id = $_POST['proyecto_id'];
      $proyecto = Proyecto::where('url',$proyecto_id);
      session_start();
      if(!$proyecto || $proyecto->usuario_id !== $_SESSION['id']){
        $respuesta = [
          'tipo' => 'error',
          'mensaje' => 'Hubo un error al actualizar la tarea',
        ];
        echo json_encode($respuesta);
        return;
      }
      $tarea = new Tarea($_POST);
      $resultado = $tarea->eliminar();
      
      if($resultado){
        $respuesta = [
          'resultado' => $resultado,
          'tipo' => 'exito',
          'id' => $tarea->id,
          'mensaje' => 'Eliminado correctamente',
          
        ];
      }
     
      echo json_encode($respuesta);
    }
  }
}

?>