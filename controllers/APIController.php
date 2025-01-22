<?php

namespace Controllers;

use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController{
  public static function index(){
    if(!isset($_SESSION)){
      session_start();
    }

    isAdmin();

    $servicio = Servicio::all();
    echo json_encode($servicio);
  }

  public static function guardar(){
    //Almacena la Cita y Devuelve el Id
     $cita = new Cita($_POST);
     $resultado = $cita->guardar();

     $id = $resultado['id'];

    //Almacena las Citas y Los Servicios con el id de la cita
    $idServicios = explode(",", $_POST['servicios']);

    foreach($idServicios as $idServicio){
      $args = [
        'citaId' => $id,
        'servicioId' => $idServicio
      ];

      $citaServicio = new CitaServicio($args);
      $citaServicio->guardar();
    }

    //Retornamos una respuesta
    $respuesta = [
      'resultado' => $resultado
    ];

    echo json_encode($respuesta);
  }

  public static function eliminar(){
    if($_SERVER['REQUEST_METHOD']==='POST'){
      $id = $_POST['id'];

      $cita = Cita::find($id);
      $cita->eliminar();

      header('Location:'.$_SERVER['HTTP_REFERER']);
    }
  }
}
