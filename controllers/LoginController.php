<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
  public static function login(Router $router){
    session_destroy();
    
    $alertas = [];

    if($_SERVER['REQUEST_METHOD']==='POST'){
      $auth = new Usuario($_POST);

      $alertas = $auth->validarLogin($auth->email);
      if(empty($alertas)){
        $usuario = Usuario::where('email',$auth->email);
        
        if($usuario){
          if($usuario->comprobarPasswordAndVerificado($auth->password)){
            //Autenticar Usuario
            session_start();
            
            $_SESSION['id'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre. " ". $usuario->apellido;
            $_SESSION['email'] = $usuario->email;
            $_SESSION['login'] = true;

            //Redireccionamiento
            if($usuario->admin === '1'){
              $_SESSION['admin'] = $usuario->admin ?? null;
              header('Location: /admin');
            }else{
              header('Location: /cita');
            }
          };
        }else{
          Usuario::setAlerta('error','Usuario no encontrado');
        }
      }
    }
    

    $alertas = Usuario::getAlertas();

    $router->render('/auth/login',[
      'alertas'=>$alertas
    ]);
  }

  public static function logout(){
    session_destroy();
    header('Location:/');
  }

  public static function olvide(Router $router){
    $alertas = [];

    if($_SERVER['REQUEST_METHOD']==='POST'){
      $auth = new Usuario($_POST);
      $alertas = $auth->validarEmail();

      if(empty($alertas)){
        $usuario = Usuario::where('email',$auth->email);

        if($usuario && $usuario->confirmado === '1'){
          //Generar Token
          $usuario->crearToken();
          $usuario->guardar();

          //Enviar el email
          $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
          $email->enviarInstrucciones();
          //Alerta de Exito
          Usuario::setAlerta('exito','Revisa tu email');
        }else{
          Usuario::setAlerta('error','El usuario no existe o no esta confirmado');
        }
      }
      $alertas = Usuario::getAlertas();

    }
    $router->render('/auth/olvide_password',[
      'alertas'=>$alertas
    ]);
  }

  public static function recuperar(Router $router){
    $alertas = [];
    $error = false;

    $token = s($_GET['token']);

    //Buscar usuario por token
    $usuario = Usuario::where('token',$token);

    if(empty($usuario)){
      Usuario::setAlerta('error','Token no valido');
      $error = true;
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
      //Leer la nueva contraseña y guardarla
      $password = new Usuario($_POST);
      $alertas = $password->validarPassword();

      if(empty($alertas)){
        $usuario->password = null;

        $usuario->password = $password->password;
        $usuario->hashPassword();
        $usuario->token = null;

        $resultado = $usuario->guardar();
        if($resultado){
          header('Location:/');
        }
      }
    }

    $alertas = Usuario::getAlertas();
    $router->render('auth/recuperar-password',[
      'alertas'=>$alertas,
      'error'=>$error
    ]);
  }

  public static function crear(Router $router){
    $usuario = new Usuario();

    //Alertas vacias
    $alertas = [];

    if($_SERVER['REQUEST_METHOD']==='POST'){
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validarCuentaNueva();

      //Revisar que alertas este vacio
      if(empty($alertas)){
        //Verificar que el usuario no este registrado
        $resultado = $usuario->extisteUsuario();

        if($resultado->num_rows){
          $alertas = Usuario::getAlertas();
        }else{
          //Hashear Contraseña
          $usuario->hashPassword();

          //Generar un token unico
          $usuario->crearToken();

          //Enviar Email
          $email = new Email($usuario->email,$usuario->nombre,$usuario->token);

          $email->enviarConfirmacion();

          //Crear el usuario
          $resultado = $usuario->guardar();
          if($resultado){
            header('Location: /mensaje');
          }
        }
      }
    }

    $router->render('/auth/crear-cuenta',[
      'usuario' => $usuario,
      'alertas' => $alertas
    ]);
  }

  public static function mensaje(Router $router){
    
    $router->render('/auth/mensaje');
  }

  public static function confirmar(Router $router){
    $alertas = [];
    $token = s($_GET['token']);
    $usuario = Usuario::where('token',$token);

    if(empty($usuario)){
      //Mostrar mensaje de error
      Usuario::setAlerta('error','Token NO Valido');
    }else{
      //Modificar usuario confirmado
      $usuario->confirmado = '1';
      $usuario->token = null;
      $usuario->guardar();
      Usuario::setAlerta('exito','Cuenta comprobada Correctamente');
    }

    //Renderizar la vista
    $alertas = Usuario::getAlertas();
    $router->render('/auth/confirmar-cuenta',[
      'alertas'=>$alertas
    ]);
  }
  

}