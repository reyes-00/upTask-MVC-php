<?php
namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

  protected $nombre;
  protected $email;
  protected $token;

  public function __construct($nombre, $email, $token){
    $this->nombre = $nombre;
    $this->email = $email; 
    $this->token = $token; 
  }

  public function enviarConfirmacion() {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = 'e6954ad4db04b8';
    $mail->Password = 'c6746fe979f696';

    // contenido
    $mail->isHTML(true);
    $mail->CharSet = 'utf-8';

    $mail->setFrom('cuentas@uptask.com','Mailer');
    $mail->addAddress('cuentas@uptask.com','Arturo Reyes');
    $mail->Subject = 'Confirmación de la cuenta';

    $contenido = "<html>";
    $contenido .= "<p><strong>Confirmación de la cuenta</strong></p>";
    $contenido .= "<p>Para confirmar tu cuenta da ";
    $contenido .= "<a href='http://localhost:3000/confirmar?token=".$this->token."'>click aqui</a> </p> ";
    $contenido .= "</html>";

    $mail->Body = $contenido;
    $mail->send();
  }

  public function olvide() {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = 'e6954ad4db04b8';
    $mail->Password = 'c6746fe979f696';

    // contenido
    $mail->isHTML(true);
    $mail->CharSet = 'utf-8';

    $mail->setFrom('cuentas@uptask.com','Mailer');
    $mail->addAddress('cuentas@uptask.com','Arturo Reyes');
    $mail->Subject = 'Olvido su password';

    $contenido = "<html>";
    $contenido .= "<p><strong>Hola: ".$this->nombre." </strong></p>";
    $contenido .= "<p>Ingresa al siguiente enlace para restablecer tu password: ";
    $contenido .= "<a href='http://localhost:3000/reestablecer?token=".$this->token."'>click aqui</a> </p> ";
    $contenido .= "</html>";

    $mail->Body = $contenido;
    $mail->send();
  }

}