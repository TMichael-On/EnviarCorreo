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

    public function formatoCorreo($nombres,$apellidos,$email,$dest_email,$asignado,$limite,$expediente,$proceso,$tarea,$id,$documento){

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
            $mail->Subject = 'Expediente: ' . $expediente;
            $htmlContent = "
            <html>
            <head>
                <title>Envío de expediente: " . htmlspecialchars($expediente, ENT_QUOTES, 'UTF-8') . "</title>
            </head>
            <body>
            <div>
                <div style=\"border: 1.0pt solid; padding: 15px;\">        
                    <strong>From</strong>: " . htmlspecialchars($apellidos, ENT_QUOTES, 'UTF-8') . ", " . htmlspecialchars($nombres, ENT_QUOTES, 'UTF-8') . " &lt;" . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "&gt;<br>
                    <strong>To</strong>: " . htmlspecialchars($dest_email, ENT_QUOTES, 'UTF-8') . "<br>
                    <strong>Subject</strong>: " . htmlspecialchars($proceso, ENT_QUOTES, 'UTF-8') . "<br>
                    <strong>Date</strong>: " . htmlspecialchars($limiteFormat, ENT_QUOTES, 'UTF-8') . "<br>
                </div>
                <div style=\"border: 1.0pt solid; padding: 15px; margin-top: 7.5pt;\">
                    <p class=\"MsoNormal\"><strong>DETALLE DE LA TAREA</strong><br>
                    <strong>Tarea a realizar </strong>: <strong><span style=\"background:yellow\">" . htmlspecialchars($tarea, ENT_QUOTES, 'UTF-8') . "</span></strong><br>
                    <strong>Comentario del remitente </strong>: <strong><span style=\"background:yellow\">Señores, por favor analizar la información remitida y determinar las acciones a realizar, elaborando los documentos que correspondan. De ser el caso, realizar una inspección, por ello, el plazo otorgado. Plazo: Hasta el día de hoy, " . htmlspecialchars($limite, ENT_QUOTES, 'UTF-8') . ".<br></br>Gracias</span></strong><br><br>
                    <strong>DATOS DEL EXPEDIENTE</strong><br>
                    <strong>Número </strong>: " . htmlspecialchars($expediente, ENT_QUOTES, 'UTF-8') . "<br>
                    <strong>Tarea </strong>: " . htmlspecialchars($tarea, ENT_QUOTES, 'UTF-8') . "<br>
                    <strong>Asunto </strong>: " . htmlspecialchars($proceso, ENT_QUOTES, 'UTF-8') . " - ATENCIÓN 587499109<br><br>
                    <strong>DATOS DEL DESTINATARIO</strong><br>
                    <strong>Nombres y apellidos</strong>: " . htmlspecialchars($dest_email, ENT_QUOTES, 'UTF-8') . "<br><br>
                    <strong>DATOS DEL REMITENTE</strong><br>
                    <strong>Remitente</strong>: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "<br><br>
                    <strong>Fecha asignada:</strong> " . htmlspecialchars($asignado, ENT_QUOTES, 'UTF-8') . "<br>
                    <strong>Fecha limite:</strong> " . htmlspecialchars($limite, ENT_QUOTES, 'UTF-8') . "<br>
                    Para acceder al expediente ingresar al siguiente enlace <a href=\"" . htmlspecialchars($documento, ENT_QUOTES, 'UTF-8') . "\" rel=\"noreferrer\" target=\"_blank\">Ver Documento</a>.
                    </p>
                </div>
            </div>
            </body>
            </html>";
            $mail->msgHTML($htmlContent);
            // Envío del correo
            $mail->send();
            return response()->json(['message' => 'Correo enviado correctamente']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al enviar el correo: ' . $mail->ErrorInfo], 500);
        }        
    }
}