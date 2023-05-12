<?php

namespace Model;

class Usuario extends ActiveRecord {

  protected static $tabla = 'usuarios';
  protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

  public $id;
  public $nombre;
  public $email;
  public $password;
  public $password_dos;
  public $password_actual;
  public $password_nuevo;
  public $token;
  public $confirmado;
  

  public function __construct($args = []){
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? "";
    $this->email = $args['email'] ?? "";
    $this->password = $args['password'] ?? "";
    $this->password_dos = $args['password_dos'] ?? "";
    $this->password_actual = $args['password_actual'] ?? "";
    $this->password_nuevo = $args['password_nuevo'] ?? "";
    $this->token = $args['token'] ?? "";
    $this->confirmado = $args['confirmado'] ?? 0;
  }

  public function validaLogin(){
    if(!$this->email){
      self::$alertas['error'] [] = 'El email del usuario es obligatorio';
    }
    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      self::$alertas['error'][]= 'No es correcto el email';
    }
    if(!$this->password){
      self::$alertas['error'] [] = 'El password del usuario es obligatorio';
    }
    if(strlen($this->password) < 6 ){
      self::$alertas['error'] [] = 'El password del usuario debe ser mayor a seis caracteres';
    }
    return self::$alertas;
  }
  
  public function validarDatos(){
    if(!$this->nombre){
      self::$alertas['error'] [] = 'El nombre del usuario es obligatorio';
    }
    if(!$this->email){
      self::$alertas['error'] [] = 'El email del usuario es obligatorio';
    }
    if(!$this->password){
      self::$alertas['error'] [] = 'El password del usuario es obligatorio';
    }
    if(strlen($this->password) < 6 ){
      self::$alertas['error'] [] = 'El password del usuario debe ser mayor a seis caracteres';
    }
    if($this->password !== $this->password_dos){
      self::$alertas['error'] [] = 'Los passwords no coinciden';
    } 

    return self::$alertas;
  }

  // Generar password hasheado
  public function hashPassword(){
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  // Generar token
  public function token(){
    $this->token = uniqid();
  }

  public function validarEmail(){
    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      self::$alertas['error'][]= 'No es correcto el email';
    }

    if(empty($this->email)){
      self::$alertas['error'][]= 'Email requerido';
    }

    return self::$alertas;
  }

  public function validarPassword()
  {
    if(!$this->password){
      self::$alertas['error'] [] = 'El password del usuario es obligatorio';
    }
    if(strlen($this->password) < 6 ){
      self::$alertas['error'] [] = 'El password del usuario debe ser mayor a seis caracteres';
    }

    return self::$alertas;
  }

  public function validarPerfil(){
    if(!$this->nombre){
      self::$alertas['error'][]="El nombre es requerido";
    }
    if(!$this->email){
      self::$alertas['error'][]="El email es requerido";
    }

    return self::$alertas;
  }

  public function validanuevaPassword(){
    if(!$this->password_actual){
      self::$alertas['error'][]="El password es requerido";
    }
    if(!$this->password_nuevo){
      self::$alertas['error'][]="El password nuevo es requerido";
    }
    if(strlen($this->password_nuevo) < 6 ){
      self::$alertas['error'][]="El password debe ser mayor a seis caracteres";
    }

    return self::$alertas;
  }
  
  public function comprobarPassword  () :bool
  {
    $resultado = password_verify($this->password_actual, $this->password);
    return $resultado;
  }
}
?>