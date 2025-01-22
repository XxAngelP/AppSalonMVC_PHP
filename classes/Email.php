<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

  public $email;
  public $nombre;
  public $token;

  public function __construct($email, $nombre, $token){
    $this->email = $email;
    $this->nombre = $nombre;
    $this->token = $token;
  }

  public function enviarConfirmacion(){
    //Crear objeto Email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = 'aa126dfcd1cf55';
    $mail->Password = '6c55f1d3b209e0';

    $mail->setFrom('cuentas@appsalon.com');
    $mail->addAddress('Cuentas@appsalon.com','AppSalon.com');
    $mail->Subject = 'Confirma tu cuenta';

    //Set HMTL
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $contenido = '<html>';
    $contenido.="<p><strong>Hola ".$this->nombre . " </strong> Has creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace</p>";
    $contenido.="<p>Presiona aqui: <a href='".$_ENV['APP_URL']."'/confirmar-cuenta?token=".$this->token."'>Confirmar Cuenta</a></p>";
    $contenido.= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
    $contenido.= "</html>";

    //Agregar cuerpo de email
    $mail->Body = $contenido;

    //Enviar email
    $mail->send();

  }

  public function enviarInstrucciones(){
    //Crear objeto Email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $_ENV['EMAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Port = $_ENV['EMAIL_PORT'];
    $mail->Username = $_ENV['EMAIL_USER'];
    $mail->Password = $_ENV['EMAIL_'];

    $mail->setFrom('cuentas@appsalon.com');
    $mail->addAddress('Cuentas@appsalon.com','AppSalon.com');
    $mail->Subject = 'Reestablece tu Contraseña';

    //Set HMTL
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $contenido = '<html>';
    $contenido.="<p><strong>Hola ".$this->nombre . " </strong> Has solicitador reestablecer tu contraseña, sigue el siguiente enlace para hacerlo</p>";
    $contenido.="<p>Presiona aqui: <a href='".$_ENV['APP_URL']."/recuperar?token=".$this->token."'>Reestablecer Contraseña</a></p>";
    $contenido.= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
    $contenido.= "</html>";

    //Agregar cuerpo de email
    $mail->Body = $contenido;

    //Enviar email
    $mail->send();
  }
}

?>