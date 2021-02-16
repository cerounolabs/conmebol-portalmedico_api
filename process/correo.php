<?php
        require __DIR__.'/../src/connect.php';

        function getMensajeEnvioCorreo(){

            $sql00  =   "SELECT 
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

                WHERE a.PERFICCOD IN (8)

                ORDER BY a.NOTMENCOD DESC";

            try {
                $connMSSQL      = getConnectionMSSQLv2();
                $stmtMSSQL00  = $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([]); 


                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {

                    $to = trim($rowMSSQL00['persona_email']);
                    $subject = trim($rowMSSQL00['notificacion_titulo']);
                    $message = trim($rowMSSQL00['notificacion_mensaje_descripcion']); 
                     
                    mail($to, $subject, $message); 
                }

                $stmtMSSQL00->closeCursor();


                $stmtMSSQL00  = null;


            } catch (PDOException $e) {
                echo "\n";
                echo 'Error getMensajeEnvioCorreo(): '.$e;
            }
    
            $connMSSQL  = null;
        }

        echo "\n";
        echo "++++++++++++++++++++++++++PROCESO DE ENVIO CORREO++++++++++++++++++++++++++";
        echo "\n";
    
        echo "INICIO getMensajeEnvioCorreo() => ".date('Y-m-d H:i:s');
        getMensajeEnvioCorreo();
        echo "\n";
        echo "FIN getMensajeEnvioCorreo() => ".date('Y-m-d H:i:s');
        echo "\n";
?>