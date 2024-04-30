<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    public function enviarCorreo($correo, $contra){
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'inucendgasis@gmail.com'; // Tu dirección de Gmail
            $mail->Password = 'yasd easn zypr mmmm'; // Tu contraseña de Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Destinatario del correo
            $mail->setFrom('inucendgasis@gmail.com', 'Cambio de contraseña');
            $mail->addAddress($correo);

            // Asunto y cuerpo del correo
            $mail->Subject = 'Cambio de contraseña';
            $htmlContent = '
                <h2>Cambio de contraseña</h2>            
                <h1>La contraseña se ha cambiado correctamente</h1>
                <p>Nueva contraseña: '.$contra.'</p>';
            $mail->msgHTML($htmlContent);
            // Envío del correo
            $mail->send();            
            return response()->json(['message' => 'Correo enviado correctamente']);
        } catch (Exception $e) {            
            return response()->json(['error' => 'Error al enviar el correo: ' . $mail->ErrorInfo], 500);
        }
    }

    public function formatoCorreo($Data){

        // return $Data;
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'inucendgasis@gmail.com'; // Tu dirección de Gmail
            $mail->Password = 'yasd easn zypr mmmm'; // Tu contraseña de Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Destinatario del correo
            $mail->setFrom('inucendgasis@gmail.com', $Data['proceso']);
            $mail->addAddress($Data['dest_email']);

            // Asunto y cuerpo del correo
            $mail->Subject = 'Expediente: ' . $Data['expediente'];
            $htmlContent = "
            <html>
            <head>
                <title>Envío de expediente: " . $Data['expediente'] . "</title>
            </head>
            <body>
            <div>
                <div style=\"border: 1.0pt solid; padding: 15px;\">        
                    <strong>From</strong>: " . $Data['apellidos'] . ", " . $Data['nombres'] . " &lt;" . $Data['email'] . "&gt;<br>
                    <strong>To</strong>: " . $Data['dest_email'] . "<br>
                    <strong>Subject</strong>: " . $Data['proceso'] . "<br>
                    <strong>Date</strong>: " . $Data['limite'] . "<br>
                </div>
                <div style=\"border: 1.0pt solid; padding: 15px; margin-top: 7.5pt;\">
                    <p class=\"MsoNormal\"><strong>DETALLE DE LA TAREA</strong><br>                    
                    <strong>Comentario del remitente </strong>: <strong><span style=\"background:yellow\">Señores, por favor analizar la información remitida y determinar las acciones a realizar, elaborando los documentos que correspondan. De ser el caso, realizar una inspección, por ello, el plazo otorgado. Plazo: Hasta el día de hoy, " . $Data['limite'] . ".<br></br>Gracias</span></strong><br><br>
                    <strong>DATOS DEL EXPEDIENTE</strong><br>
                    <strong>Número </strong>: " . $Data['expediente'] . "<br>                    
                    <strong>Asunto </strong>: " . $Data['proceso'] . " - ATENCIÓN 587499109<br><br>
                    <strong>DATOS DEL DESTINATARIO</strong><br>
                    <strong>Nombres y apellidos</strong>: " . $Data['dest_email'] . "<br><br>
                    <strong>DATOS DEL REMITENTE</strong><br>
                    <strong>Remitente</strong>: " . $Data['email'] . "<br><br>
                    <strong>Fecha asignada:</strong> " . $Data['asignado'] . "<br>
                    <strong>Fecha limite:</strong> " . $Data['limite'] . "<br>
                    Para acceder al expediente ingresar al siguiente enlace <a href=\"" . $Data['documento'] . "\" rel=\"noreferrer\" target=\"_blank\">Ver Documento</a>.
                    </p>
                </div>
            </div>
            </body>
            </html>";
            $mail->msgHTML($htmlContent);
            // Envío del correo
            $mail->send();
            // return response()->json(['message' => 'Correo enviado correctamente']);
            return true;
        } catch (Exception $e) {
            return 'Error al enviar el correo: ' . $mail->ErrorInfo;
        }        
    }
}