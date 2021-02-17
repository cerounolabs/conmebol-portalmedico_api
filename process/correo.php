<?php
        require __DIR__.'/../src/connect.php';
        //require_once('../PHPMailer_v5.0.2/class.phpmailer.php');
        

        // El mensaje
        $mensaje = "Nota:
        La implementación en Windows de mail() difiere bastante de la implementación en Unix. Primero, no usa un binario local para componer mensajes ya que sólo opera en sockets directos, lo que significa que es necesario un MTA escuchando en un socket de red (que puede estar tanto en localhost como en una máquina remota)";

        // Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
        $mensaje = wordwrap($mensaje, 70, "\r\n");

        // Enviarlo
        mail('vcardozo@cerouno.com.py', 'PRUEBA', $mensaje);

        /*function getMensajeEnvioCorreo(){
            $mail             = new PHPMailer();

            $body             = "Prueba de envio"; // Cuerpo del mensaje
            $mail->IsSMTP(); // Usar SMTP para enviar
            $mail->SMTPDebug  = 0; // habilita información de depuración SMTP (para pruebas)
                                   // 1 = errores y mensajes
                                   // 2 = sólo mensajes
            $mail->SMTPAuth   = true; // habilitar autenticación SMTP
            $mail->Host       = "smtp.ugr.es"; // establece el servidor SMTP
            $mail->Port       = 587; // configura el puerto SMTP utilizado
            $mail->SMTPSecure = "tls";
            $mail->Username   = "usuario"; // nombre de usuario UGR
            $mail->Password   = "contraseña"; // contraseña del usuario UGR
         
            $mail->SetFrom('usuario', 'Nombre y Apellidos, etc.');
            $mail->Subject    = "Asunto del mensaje";
            $mail->MsgHTML($body); // Fija el cuerpo del mensaje
        
            $address = "destinatario@dominio"; // Dirección del destinatario
            $mail->AddAddress($address, "Nombre del destinatario");
        
            if(!$mail->Send()) {
                echo "Error: " . $mail->ErrorInfo;
            }
            else {
                echo "¡Mensaje enviado!";
            }

           /* $sql00  =   "SELECT 
                a.NOTMENCOD             AS      notificacion_mensaje_codigo,	
                a.NOTMENORD             AS      notificacion_mensaje_orden,
                a.NOTMENFEP             AS      notificacion_mensaje_fecha_proceso,
                a.NOTMENENC             AS      notificacion_mensaje_encuentro,
                a.NOTMENMEN             AS      notificacion_mensaje_descripcion,
                a.NOTMENOBS             AS      notificacion_mensaje_observacion,
                    
                a.NOTMENAUS             AS      auditoria_usuario,
                a.NOTMENAFH             AS      auditoria_fecha_hora,	
                a.NOTMENAIP             AS      auditoria_ip,
                
                b.DOMFICCOD             AS      tipo_estado_codigo,
                b.DOMFICORD             AS      tipo_estado_orden,  
                b.DOMFICNOI             AS      tipo_estado_ingles,
                b.DOMFICNOC             AS      tipo_estado_castellano,
                b.DOMFICNOP             AS      tipo_estado_portugues,
                b.DOMFICPAT             AS      tipo_estado_path,
                b.DOMFICVAL             AS      tipo_estado_dominio,
                b.DOMFICPAR             AS      tipo_estado_parametro,
                b.DOMFICOBS             AS      tipo_estado_observacion,

                c.NOTFICCOD             AS      notificacion_codigo,
                c.NOTFICORD             AS      notificacion_orden,  	
                c.NOTFICPAC             AS      notificacion_parametro,
                c.NOTFICTIT             AS      notificacion_titulo,	
                c.NOTFICDES             AS      notificacion_descripcion,	
                c.NOTFICFED             AS      notificacion_fecha_desde,	
                c.NOTFICFEH             AS      notificacion_fecha_hasta,
                c.NOTFICFCA             AS      notificacion_fecha_carga,	
                c.NOTFICOBS             AS      notificacion_observacion,

                d.teamFifaId            AS      equipo_codigo,
                d.status                AS      equipo_estado,
                d.internationalName     AS      equipo_nombre,

                
                e.PERFICCOD             AS      persona_codigo,
                e.PERFICNOM             AS      persona_nombre,
                e.PERFICUSE             AS      persona_user,
                e.PERFICPAT             AS      persona_path,
                e.PERFICMAI             AS      persona_email,
                e.PERFICTEF             AS      persona_telefono

                FROM [adm].[NOTMEN] a
                INNER JOIN [adm].[DOMFIC] b ON a.NOTMENEST  = b.DOMFICCOD
                INNER JOIN [adm].[NOTFIC] c ON a.NOTMENNOC  = c.NOTFICCOD
                INNER JOIN [comet].[teams]d ON a.NOTMENEQC  = d.teamFifaId
                INNER JOIN [adm].[PERFIC] e ON a.NOTMENMEC  = e.PERFICCOD

                WHERE a.NOTMENMEC IN (8)

                ORDER BY a.NOTMENCOD DESC";

            try {
                $connMSSQL      = getConnectionMSSQLv2();
                $stmtMSSQL00  = $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([]); 


                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {

                    /*$to = trim($rowMSSQL00['persona_email']);
                    $subject = trim($rowMSSQL00['notificacion_titulo']);
                    $message = trim($rowMSSQL00['notificacion_mensaje_descripcion']); 
                     
                    mail($to, $subject, $message); 
                    echo 'email=> '.$to.' titulo => '.$subject.' cuerpo => '.$message;
                }

                $stmtMSSQL00->closeCursor();


                $stmtMSSQL00  = null;


            } catch (PDOException $e) {
                echo "\n";
                echo 'Error getMensajeEnvioCorreo(): '.$e;
            }
    
            $connMSSQL  = null;
        }*/

        echo "\n";
        echo "++++++++++++++++++++++++++PROCESO DE ENVIO CORREO++++++++++++++++++++++++++";
        echo "\n";
    
        echo "INICIO getMensajeEnvioCorreo() => ".date('Y-m-d H:i:s');
        //getMensajeEnvioCorreo();
        echo "\n";
        echo "FIN getMensajeEnvioCorreo() => ".date('Y-m-d H:i:s');
        echo "\n";
?>