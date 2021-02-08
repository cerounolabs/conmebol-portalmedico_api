<?php
    require __DIR__.'/../src/connect.php';

    /*$DOMFICEST  = 1;
    $DOMFICORD  = 999;*/
    $DOMFICAUS  = 'SFHOLOX';
    $DOMFICAIP  = '0.0.0.0';
    $NOTMENOBS  = '';

    function getMensaje(){
        global $DOMFICEST;
        global $DOMFICORD;
        global $DOMFICAUS;
        global $DOMFICAIP;
        global $NOTMENOBS;
        $MENSAJE    = '';
        $NOTMENENC  = 0;
        $DOMFICPAR  = 2;

        $sql00  =   "SELECT
            a.NOTFICCOD                     AS      notificacion_codigo,
            a.NOTFICORD                     AS      notificacion_orden,  	
            a.NOTFICPAC                     AS      notificacion_parametro,
            a.NOTFICTIT                     AS      notificacion_titulo,	
            a.NOTFICDES                     AS      notificacion_descripcion,	
            a.NOTFICFED                     AS      notificacion_fecha_desde,	
            a.NOTFICFEH                     AS      notificacion_fecha_hasta,	
            a.NOTFICFCA                     AS      notificacion_fecha_carga,
            a.NOTFICCOC                     AS      competicion_codigo,
            a.NOTFICOBS                     AS      notificacion_observacion,
                
            a.NOTFICAUS                     AS      auditoria_usuario,
            a.NOTFICAFH                     AS      auditoria_fecha_hora,	
            a.NOTFICAIP                     AS      auditoria_ip,
            
            b.DOMFICCOD                     AS      tipo_estado_codigo,
            b.DOMFICORD                     AS      tipo_estado_orden,
            b.DOMFICNOI                     AS      tipo_estado_ingles,
            b.DOMFICNOC                     AS      tipo_estado_castellano,
            b.DOMFICNOP                     AS      tipo_estado_portugues,
            b.DOMFICPAT                     AS      tipo_estado_path,
            b.DOMFICVAL                     AS      tipo_estado_dominio,
            b.DOMFICPAR                     AS      tipo_estado_parametro,
            b.DOMFICOBS                     AS      tipo_estado_observacion,
            
            c.DOMFICCOD                     AS      tipo_notificacion_codigo,
            c.DOMFICORD                     AS      tipo_notificacion_orden,
            c.DOMFICNOI                     AS      tipo_notificacion_ingles,
            c.DOMFICNOC                     AS      tipo_notificacion_castellano,
            c.DOMFICNOP                     AS      tipo_notificacion_portugues,
            c.DOMFICPAT                     AS      tipo_notificacion_path,
            c.DOMFICVAL                     AS      tipo_notificacion_dominio,
            c.DOMFICPAR                     AS      tipo_notificacion_parametro,
            c.DOMFICOBS                     AS      tipo_notificacion_observacion,
            
            d.DOMFICCOD                     AS      tipo_test_codigo,
            d.DOMFICORD                     AS      tipo_test_orden,
            d.DOMFICNOI                     AS      tipo_test_ingles,
            d.DOMFICNOC                     AS      tipo_test_castellano,
            d.DOMFICNOP                     AS      tipo_test_portugues,
            d.DOMFICPAT                     AS      tipo_test_path,
            d.DOMFICVAL                     AS      tipo_test_dominio,
            d.DOMFICPAR                     AS      tipo_test_parametro,
            d.DOMFICOBS                     AS      tipo_test_observacion

            FROM [adm].[NOTFIC] a

            INNER JOIN [adm].[DOMFIC] b ON a.NOTFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.NOTFICTNC = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON a.NOTFICTTC = d.DOMFICCOD

            WHERE b.DOMFICPAR = 1 AND c.DOMFICPAR = 2  AND a.NOTFICPAC = 1 AND a.NOTFICFED <= CONVERT(varchar(10), GETDATE(), 23) AND a.NOTFICFEH >= CONVERT(varchar(10), GETDATE(), 23)
    
            ORDER BY a.NOTFICCOD";

        $sql01  =   "SELECT 
            a.NOTEQUCOD             AS      notificacion_equipo_codigo,	
            a.NOTEQUORD             AS      notificacion_equipo_orden,
            a.NOTEQUFCA             AS      notificacion_equipo_fecha_carga,	
            a.NOTEQUOBS             AS      notificacion_equipo_observacion,
                
            a.NOTEQUAUS             AS      auditoria_usuario,
            a.NOTEQUAFH             AS      auditoria_fecha_hora,	
            a.NOTEQUAIP             AS      auditoria_ip,
            
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
            d.internationalName     AS      equipo_nombre
            
            FROM [adm].[NOTEQU] a
            INNER JOIN [adm].[DOMFIC]  b   ON a.NOTEQUEST  = b.DOMFICCOD
            INNER JOIN [adm].[NOTFIC]  c   ON a.NOTEQUNOC  = c.NOTFICCOD
            INNER JOIN [comet].[teams] d   ON a.NOTEQUEQC  = d.teamFifaId

            WHERE a.NOTEQUNOC = ? AND b.DOMFICPAR = 1 
            
            ORDER BY a.NOTEQUCOD";

        $sql02  =   "SELECT 
            a.PERFICCOD                         AS          persona_codigo,
            a.PERFICNOM                         AS          persona_nombre,
            a.PERFICMAI                         AS          persona_email,
            a.PERFICTEF                         AS          persona_telefono,
            a.PERFICEQU                         AS          persona_equipo,
            
            b.PERCOMCOC                         AS          competicion_persona_competicion                                                                                           
            
            FROM adm.PERFIC a
            INNER JOIN adm.PERCOM b ON a.PERFICCOD = b.PERCOMPEC
            INNER JOIN adm.DOMFIC c ON b.PERCOMTMC = c.DOMFICCOD
            
            WHERE a.PERFICEQU = ? AND b.PERCOMCOC = ? AND c.DOMFICPAR = 2";

        $sql03  =   "INSERT INTO [adm].[NOTMEN](                                                               NOTMENEST, NOTMENNOC, NOTMENEQC, NOTMENENC, NOTMENMEC, NOTMENMEN, NOTMENOBS, NOTMENAUS, NOTMENAFH, NOTMENAIP) 
                     VALUES((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR  = ?),         ?,          ?,        ?,         ?,        ?,        ?,           ?, GETDATE(),       ?)";  

        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL01= $connMSSQL->prepare($sql01);
            $stmtMSSQL02= $connMSSQL->prepare($sql02);
            $stmtMSSQL03= $connMSSQL->prepare($sql03);
        
            $stmtMSSQL00->execute();

           
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {//recorre NOTFIC

                $NOTFICCOD  = $rowMSSQL00['notificacion_codigo'];
                $NOTFICCOC  = $rowMSSQL00['competicion_codigo'];
                $MENSAJE    = $rowMSSQL00(trim(['notificacion_titulo'])).' '.$rowMSSQL00(trim(['notificacion_descripcion']));
                
                $stmtMSSQL01->execute([$NOTFICCOD]);

                while ($rowMSSQL01  = $stmtMSSQL01->fetch()) {//RECORRE NOTEQU
                    $NOTEQUEQC      = $rowMSSQL01['equipo_codigo'];
                    echo 'Competicion=> '.$NOTFICCOC.' Equipo=> '.$NOTEQUEQC;
                    $stmtMSSQL02->execute([$NOTEQUEQC, $NOTFICCOC]);

                    while ($rowMSSQL02  = $stmtMSSQL02->fetch()) {//RECORRE PERFIC
                        $NOTMENMEC      = $rowMSSQL02['persona_codigo'];
                        echo('codigo persona => '.$NOTMENMEC);
                        $stmtMSSQL03->execute([$DOMFICPAR, $NOTFICCOD, $NOTEQUEQC, $NOTMENENC, $NOTMENMEC, $MENSAJE, $NOTMENOBS, $DOMFICAUS,$DOMFICAIP]);
                    }  

                } 

            }

        $stmtMSSQL00->closeCursor();
        $stmtMSSQL01->closeCursor();
        $stmtMSSQL02->closeCursor();
        $stmtMSSQL03->closeCursor();

        $stmtMSSQL00    = null;
        $stmtMSSQL01    = null;
        $stmtMSSQL02    = null;
        $stmtMSSQL03    = null;

        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getMensaje(): '.$e;
        }

        $connMSSQL  = null;
    }

    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE NOTIFICACIÓN++++++++++++++++++++++++++";
    echo "\n";
    /*echo "++++++++++++++++ SISTEMA CORPORATIVO => SISTEMA SFHOLOX ++++++++++++++++";*/

    echo "INICIO getMensaje() => ".date('Y-m-d H:i:s');
    getMensaje();
    echo "\n";
    echo "FIN getMensaje() => ".date('Y-m-d H:i:s');
    echo "\n";
?>