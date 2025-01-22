<?php

namespace Model;

class Usuario extends ActiveRecord{
  //Base de Datos
  protected static $tabla = 'usuarios';
  protected static $columnasDB = ['id','nombre','apellido','email','password','telefono','admin','confirmado','token'];

  public $id;
  public $nombre;
  public $apellido;
  public $email;
  public $password;
  public $telefono;
  public $admin;
  public $confirmado;
  public $token;

  public function __construct($args = []){
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->telefono = $args['telefono'] ?? '';
    $this->admin = $args['admin'] ?? 0;
    $this->confirmado = $args['confirmado'] ?? 0;
    $this->token = $args['token'] ?? '';
  }

  //Mensajes de validacion de cuenta
  public function validarCuentaNueva(){
    if(!$this->nombre){
      self::$alertas['error'][]='El Nombre es Oblgatorio';
    }
    if(!$this->apellido){
      self::$alertas['error'][]='El Apellido es Oblgatorio';
    }
    if(!$this->telefono){
      self::$alertas['error'][]='El Télefono es Oblgatorio';
    }
    if(!$this->email){
      self::$alertas['error'][]='El Email es Oblgatorio';
    }
    if(!$this->password){
      self::$alertas['error'][]='La Contraseña es Oblgatorio';
    }
    if(strlen($this->password) < 6){
      self::$alertas['error'][]='La Contraseña debe contener al menos 6 Caracteres';
    }

    return self::$alertas;
  }

  //Validar Usuario
  public function validarLogin(){
    if(!$this->email){
      self::$alertas['error'][] = 'El email es obligatorio';
    }
    if(!$this->password){
      self::$alertas['error'][] = 'La contraseña es obligatoria';
    }

    return self::$alertas;
  }

  public function validarEmail(){
    if(!$this->email){
      self::$alertas['error'][] = 'El email es obligatorio';
    }
    
    return self::$alertas;
  }

  //Revisa si el usuario ya existe
  public function extisteUsuario(){
    $query = "SELECT * FROM ". self::$tabla." WHERE email = '".$this->email."' LIMIT 1";

    $resultado = self::$db->query($query);

    if($resultado->num_rows){
      self::$alertas['error'][] = 'El Usuario ya esta registrado';
    }

    return $resultado;
  }

  public function hashPassword(){
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function crearToken(){
    $this->token = uniqid();
  }

  public function comprobarPasswordAndVerificado($password){
    $resultado = password_verify($password,$this->password);
    if(!$resultado || !$this->confirmado){
      self::$alertas['error'][] = 'Contraseña Incorrecta o Cuenta no Cofirmada';
    }else{
      return true;
    }
  }

  public function validarPassword(){
    if(!$this->password){
      self::$alertas['error'][] = 'La contraseña es obligatoria';
    }
    if(strlen($this->password) < 6){
      self::$alertas['error'][]='La Contraseña debe contener al menos 6 Caracteres';
    }

    return self::$alertas;
  }
}