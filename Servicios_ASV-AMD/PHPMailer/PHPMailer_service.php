<?php
    //Carga de las clases necesarias
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'Composer/vendor/autoload.php';
    require 'Composer/vendor/phpmailer/phpmailer/src/Exception.php';
    require 'Composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'Composer/vendor/phpmailer/phpmailer/src/SMTP.php';
    //Crear instancia
    $mail = new PHPMailer(true);
    try {
        //Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'asv.amd.php@gmail.com';
        $mail->Password = 'xwpe elgz mylv gdai';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = "465";
        //Configuración destinatarios
        $mail->setFrom('asv.amd.php@gmail.com', 'Alexandra y Alfonso');
        $mail->addAddress($serviceUser['email']);
        //Contenido
        $mail->isHTML(true);
        $mail->CharSet = "UTF8";
        //Asunto
        $mail->Subject = 'Solicitud de Servicio';
        $mail->Body = 'Bienvenid@ a <i>Services</i>.<p>Remitente: '.$user.'</p>
                       <p><b>Servicio: </b>'.$servicio['titulo'].'</p>
                       <p>'.$descripcion.'</p>
                       <p>Gracias,'.$serviceUser['nombre'].' por su atencion.</p>
                       <p><i>No conteste a este mensaje.<br>Si desea ponerse en contacto con el solicitante del servicio presione en el mail del remitente.</i></p>';
        //Contenido alternativo en texto simple
        $mail->AltBody = 'Bienvenid@ a Services. Su servicio está siendo solicitado';
        //Enviar correo
        $mail->send();
    } catch (Exception $e) {
        echo "El correo no se ha enviado: {$mail->ErrorInfo}";
    }
?>