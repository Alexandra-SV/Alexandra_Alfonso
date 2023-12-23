<?php
//Carga de las clases necesarias
require 'Composer/vendor/autoload.php';
require 'Composer/vendor/phpmailer/src/Exception.php';
require 'Composer/vendor/phpmailer/src/PHPMailer.php';
require 'Composer/vendor/phpmailer/src/SMTP.php';

//Crear instancia
$mail = new PHPMailer(true);

try {
    //Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'asv.amd.php@gmail.com';
    $mail->Password = 'knom hijp ritw klyz';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = "465";
    //Configuración destinatarios
    $mail->setFrom('asv.amd.php@gmail.com', 'Alexandra y Alfonso');
    $mail->addAddress($usuario['email']);
    //Contenido
    $mail->isHTML(true);
    $mail->CharSet = "UTF8";
    //Asunto
    $mail->Subject = 'Activa tu cuenta para completar el registro';
    //Conteido HTML
    $mail->Body = 'Bienvenid@ a <i>Services</i>. Haz clic en el link para completar tu registro y poder acceder a tu cuenta.';
    //Contenido alternativo en texto simple
    $mail->AltBody = 'Bienvenid@ a Services. Haz clic en el link para completar tu registro y poder acceder a tu cuenta.';
    //Enviar correo
    $mail->send();
    header("location:activar_cuenta.php?token=$token");
} catch (Exception $e) {
    echo "El correo no se ha enviado: {$mail->ErrorInfo}";
}
?>