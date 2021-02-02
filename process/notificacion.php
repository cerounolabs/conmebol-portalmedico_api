
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

        $sql00  =   "SELECT 
            a.NOTFICCOD     AS  notificacion_codigo,
            a.NOTFICORD     AS  notificacion_orden,  	
            a.NOTFICPAC     AS  notificacion_parametro,
            a.NOTFICTIT     AS  notificacion_titulo,	
            a.NOTFICDES     AS  notificacion_descripcion,	
            a.NOTFICFED     AS  notificacion_fecha_desde,	
            a.NOTFICFEH     AS  notificacion_fecha_hasta,
            a.NOTFICFCA     AS  notificacion_fecha_carga,
            a.NOTFICOBS     AS  notificacion_observacion,
                
            a.NOTFICAUS     AS  auditoria_usuario,
            a.NOTFICAFH     AS  auditoria_fecha_hora,	
            a.NOTFICAIP     AS  auditoria_ip,
            
            b.DOMFICCOD     AS  tipo_estado_codigo,
            b.DOMFICORD     AS  tipo_estado_orden,
            b.DOMFICNOI     AS  tipo_estado_ingles,
            b.DOMFICNOC     AS  tipo_estado_castellano,
            b.DOMFICNOP     AS  tipo_estado_portugues,
            b.DOMFICPAT     AS  tipo_estado_path,
            b.DOMFICVAL     AS  tipo_estado_dominio,
            b.DOMFICPAR     AS  tipo_estado_parametro,
            b.DOMFICOBS     AS  tipo_estado_observacion,
            
            c.DOMFICCOD     AS  tipo_notificacion_codigo,
            c.DOMFICORD     AS  tipo_notificacion_orden,
            c.DOMFICNOI     AS  tipo_notificacion_ingles,
            c.DOMFICNOC     AS  tipo_notificacion_castellano,
            c.DOMFICNOP     AS  tipo_notificacion_portugues,
            c.DOMFICPAT     AS  tipo_notificacion_path,
            c.DOMFICVAL     AS  tipo_notificacion_dominio,
            c.DOMFICPAR     AS  tipo_notificacion_parametro,
            c.DOMFICOBS     AS  tipo_notificacion_observacion,
            
            d.DOMFICCOD     AS  tipo_test_codigo,
            d.DOMFICORD     AS  tipo_test_orden,
            d.DOMFICNOI     AS  tipo_test_ingles,
            d.DOMFICNOC     AS  tipo_test_castellano,
            d.DOMFICNOP     AS  tipo_test_portugues,
            d.DOMFICPAT     AS  tipo_test_path,
            d.DOMFICVAL     AS  tipo_test_dominio,
            d.DOMFICPAR     AS  tipo_test_parametro,
            d.DOMFICOBS     AS  tipo_test_observacion
            
            FROM [adm].[NOTFIC] a

            INNER JOIN [adm].[DOMFIC] b ON a.NOTFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.NOTFICTNC = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON a.NOTFICTTC = d.DOMFICCOD
            
            WHERE b.DOMFICPAR = 1 AND c.DOMFICPAR = 2 AND a.NOTFICFED >= CONVERT(varchar(10), GETDATE(), 23) AND a.NOTFICFEH <= CONVERT(varchar(10), GETDATE(), 23)
     
            ORDER BY a.NOTFICCOD ASC";
        
        /*$sql01  =   "SELECT 
            a.NOTCOMCOD                     AS      notificacion_competicion_codigo,
            a.NOTCOMORD                     AS      notificacion_competicion_orden,
            a.NOTCOMOBS                     AS      notificacion_competicion_observacion,
            
            a.NOTCOMAUS                     AS      auditoria_usuario,
            a.NOTCOMAFH                     AS      auditoria_fecha_hora,
            a.NOTCOMAIP                     AS      auditoria_ip,
            
            b.DOMFICCOD                     AS      tipo_estado_codigo,
            b.DOMFICORD                     AS      tipo_estado_orden,
            b.DOMFICNOI                     AS      tipo_estado_ingles,
            b.DOMFICNOC                     AS      tipo_estado_castellano,
            b.DOMFICNOP                     AS      tipo_estado_portugues,
            b.DOMFICPAT                     AS      tipo_estado_path,
            b.DOMFICVAL                     AS      tipo_estado_dominio,
            b.DOMFICPAR                     AS      tipo_estado_parametro,
            b.DOMFICOBS                     AS      tipo_estado_observacion,
            
            c.NOTFICCOD                     AS      notificacion_codigo,
            c.NOTFICORD                     AS      notificacion_orden,  	
            c.NOTFICPAC                     AS      notificacion_parametro,
            c.NOTFICTIT                     AS      notificacion_titulo,	
            c.NOTFICDES                     AS      notificacion_descripcion,	
            c.NOTFICFED                     AS      notificacion_fecha_desde,		
            c.NOTFICFEH                     AS      notificacion_fecha_hasta,
            c.NOTFICFCA                     AS      notificacion_fecha_carga,	
            c.NOTFICOBS                     AS      notificacion_observacion,
            
            d.competitionFifaId             AS      competicion_codigo,
            d.superiorCompetitionFifaId     AS      competicion_codigo_padre,
            d.status                        AS      competicion_estado,
            d.internationalName             AS      competicion_nombre
            
            FROM [adm].[NOTCOM] a
            INNER JOIN [adm].[DOMFIC] b ON a.NOTCOMEST  = b.DOMFICCOD
            INNER JOIN [adm].[NOTFIC] c ON a.NOTCOMNOC  = c.NOTFICCOD
            INNER JOIN [comet].[competitions] d ON a.NOTCOMCOC = d.competitionFifaId 

            WHERE a.NOTCOMNOC = ?
            
            ORDER BY a.NOTCOMCOD DESC";

        $sql02  =   "SELECT 
            a.NOTEQUCOD             AS      notificacion_equipo_codigo,	
            a.NOTEQUORD             AS      notificacion_equipo_orden,	
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
            
            c.NOTCOMCOD             AS      notificacion_competicion_codigo,
            c.NOTCOMORD             AS      notificacion_competicion_orden,
            c.NOTCOMOBS             AS      notificacion_competicion_observacion,
            
            d.teamFifaId            AS      equipo_codigo,
            d.status                AS      equipo_estado,
            d.internationalName     AS      equipo_nombre
            
            FROM [adm].[NOTEQU] a
            INNER JOIN [adm].[DOMFIC]  b   ON a.NOTEQUEST  = b.DOMFICCOD
            INNER JOIN [adm].[NOTCOM]  c   ON a.NOTEQUNCM  = c.NOTCOMCOD
            INNER JOIN [comet].[teams] d   ON a.NOTEQUEQC  = d.teamFifaId 

            WHERE a.NOTEQUNCM = ?
            
            ORDER BY a.NOTEQUCOD DESC";

        $sql03  =   "SELECT 
            a.PERCOMOBS                         AS          competicion_persona_observacion,
            a.PERCOMRTS                         AS          competicion_persona_rts,
            a.PERCOMAUS                         AS          auditoria_usuario,
            a.PERCOMAFH                         AS          auditoria_fecha_hora,
            a.PERCOMAIP                         AS          auditoria_ip,

            b.PERFICCOD                         AS          persona_codigo,
            b.PERFICNOM                         AS          persona_nombre,
            b.PERFICUSE                         AS          persona_user,
            b.PERFICPAT                         AS          persona_path,
            b.PERFICMAI                         AS          persona_email,
            b.PERFICTEF                         AS          persona_telefono,

            c.DOMFICCOD                         AS          tipo_estado_codigo,
            c.DOMFICEST                         AS          tipo_estado_estado_codigo,
            c.DOMFICORD                         AS          tipo_estado_orden,
            c.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
            c.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
            c.DOMFICNOP                         AS          tipo_estado_nombre_portugues,
            c.DOMFICPAT                         AS          tipo_estado_path,
            c.DOMFICVAL                         AS          tipo_estado_dominio,
            c.DOMFICOBS                         AS          tipo_estado_observacion,
            c.DOMFICPAR                         AS          tipo_estado_parametro,

            d.DOMFICCOD                         AS          tipo_acceso_codigo,
            d.DOMFICEST                         AS          tipo_acceso_estado_codigo,
            d.DOMFICORD                         AS          tipo_acceso_orden,
            d.DOMFICNOI                         AS          tipo_acceso_nombre_ingles,
            d.DOMFICNOC                         AS          tipo_acceso_nombre_castellano,
            d.DOMFICNOP                         AS          tipo_acceso_nombre_portugues,
            d.DOMFICPAT                         AS          tipo_acceso_path,
            d.DOMFICVAL                         AS          tipo_acceso_dominio,
            d.DOMFICOBS                         AS          tipo_acceso_observacion,
            d.DOMFICPAR                         AS          tipo_acceso_parametro,

            e.DOMFICCOD                         AS          tipo_perfil_codigo,
            e.DOMFICEST                         AS          tipo_perfil_estado_codigo,
            e.DOMFICORD                         AS          tipo_perfil_orden,
            e.DOMFICNOI                         AS          tipo_perfil_nombre_ingles,
            e.DOMFICNOC                         AS          tipo_perfil_nombre_castellano,
            e.DOMFICNOP                         AS          tipo_perfil_nombre_portugues,
            e.DOMFICPAT                         AS          tipo_perfil_path,
            e.DOMFICVAL                         AS          tipo_perfil_dominio,
            e.DOMFICOBS                         AS          tipo_perfil_observacion,
            e.DOMFICPAR                         AS          tipo_perfil_parametro,


            f.teamFifaId                        AS          equipo_codigo,
            f.internationalShortName            AS          equipo_nombre,

            g.DOMFICCOD                         AS          tipo_categoria_codigo,
            g.DOMFICEST                         AS          tipo_categoria_estado_codigo,
            g.DOMFICORD                         AS          tipo_categoria_orden,
            g.DOMFICNOI                         AS          tipo_categoria_nombre_ingles,
            g.DOMFICNOC                         AS          tipo_categoria_nombre_castellano,
            g.DOMFICNOP                         AS          tipo_categoria_nombre_portugues,
            g.DOMFICPAT                         AS          tipo_categoria_path,
            g.DOMFICVAL                         AS          tipo_categoria_dominio,
            g.DOMFICOBS                         AS          tipo_categoria_observacion,
            g.DOMFICPAR                         AS          tipo_categoria_parametro,

            h.competitionFifaId                 AS          competicion_codigo,
            h.superiorCompetitionFifaId         AS          competicion_codigo_padre,
            h.status                            AS          competicion_estado,
            h.internationalName                 AS          competicion_nombre,
            h.internationalShortName            AS          competicion_nombre_corto,
            h.season                            AS          competicion_anho,
            h.ageCategory                       AS          competicion_categoria_codigo,
            h.ageCategoryName                   AS          competicion_categoria_nombre,
            h.dateFrom                          AS          competicion_desde,
            h.dateTo                            AS          competicion_hasta,
            h.discipline                        AS          competicion_disciplina,
            h.gender                            AS          competicion_genero,
            h.imageId                           AS          competicion_imagen_codigo,
            h.multiplier                        AS          competicion_multiplicador,
            h.nature                            AS          competicion_naturaleza,
            h.numberOfParticipants              AS          competicion_numero_participante,
            h.orderNumber                       AS          competicion_numero_orden,
            h.teamCharacter                     AS          competicion_equipo_tipo,
            h.flyingSubstitutions               AS          competicion_sustitucion,
            h.penaltyShootout                   AS          competicion_penal,
            h.matchType                         AS          competicion_tipo,
            h.pictureContentType                AS          competicion_imagen_tipo,
            h.pictureLink                       AS          competicion_image_link,
            h.pictureValue                      AS          competicion_imagen_valor,
            h.lastUpdate                        AS          competicion_ultima_actualizacion,

            i.DOMFICCOD                         AS          tipo_modulo_codigo,
            i.DOMFICEST                         AS          tipo_modulo_estado_codigo,
            i.DOMFICORD                         AS          tipo_modulo_orden,
            i.DOMFICNOI                         AS          tipo_modulo_nombre_ingles,
            i.DOMFICNOC                         AS          tipo_modulo_nombre_castellano,
            i.DOMFICNOP                         AS          tipo_modulo_nombre_portugues,
            i.DOMFICPAT                         AS          tipo_modulo_path,
            i.DOMFICVAL                         AS          tipo_modulo_dominio,
            i.DOMFICOBS                         AS          tipo_modulo_observacion,
            i.DOMFICPAR                         AS          tipo_modulo_parametro
            
            FROM [adm].[PERCOM] a
            INNER JOIN [adm].[PERFIC] b ON a.PERCOMPEC  = b.PERFICCOD
            INNER JOIN [adm].[DOMFIC] c ON b.PERFICEST  = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON b.PERFICTIP  = d.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] e ON b.PERFICROL  = e.DOMFICCOD
            INNER JOIN [comet].[teams] f ON b.PERFICEQU = f.teamFifaId
            INNER JOIN [adm].[DOMFIC] g ON b.PERFICCAT  = g.DOMFICCOD
            INNER JOIN [comet].[competitions] h ON a.PERCOMCOC = h.competitionFifaId
            INNER JOIN [adm].[DOMFIC] i ON a.PERCOMTMC = i.DOMFICCOD
            
            WHERE  b.PERFICEQU = ? AND a.PERCOMCOC = ? AND i.DOMFICPAR = 2 ";

        $sql04  =   "INSERT INTO [adm].[NOTMEN](                                                               NOTMENEST, NOTMENNOC, NOTMENNCC, NOTMENNEC, NOTMENMEC, NOTMENFEP, NOTMENOBS, NOTMENAUS, NOTMENAFH, NOTMENAIP) 
                     VALUES((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR  = ?),         ?,         ?,        ?,        ?,   GETDATE(),        ?,           ?, GETDATE(),       ?)";  */  

        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            /*$stmtMSSQL01= $connMSSQL->prepare($sql01);
            $stmtMSSQL02= $connMSSQL->prepare($sql02);
            $stmtMSSQL03= $connMSSQL->prepare($sql03);
            $stmtMSSQL04= $connMSSQL->prepare($sql04);*/

            $stmtMSSQL00->execute();
           
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {

                $NOTFICCOD  = $rowMSSQL00['notificacion_codigo'];
                $estado     = $rowMSSQL00['tipo_estado_parametro'];
               /* $stmtMSSQL01->execute([$NOTFICCOD]);

                while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {

                    $NOTCOMCOD  = $rowMSSQL01['notificacion_competicion_codigo'];
                    $stmtMSSQL02->execute([$NOTCOMCOD]);

                    while ($rowMSSQL02 = $stmtMSSQL02->fetch()) {
                        $NOTEQUCOD  = $rowMSSQL02['notificacion_equipo_codigo'];
                        $stmtMSSQL03->execute([$NOTEQUCOD, $NOTCOMCOD]);

                        while ($rowMSSQL03 = $stmtMSSQL03->fetch()) {
                            $NOTMENMEC = $rowMSSQL03['persona_codigo'];

                            $stmtMSSQL04->execute([$estado, $NOTFICCOD, $NOTCOMCOD, $NOTEQUCOD, $NOTMENMEC, $NOTMENOBS, $DOMFICAUS,$DOMFICAIP]);

                        }

                    }
                }*/

            }

        $stmtMSSQL00->closeCursor();
        /*$stmtMSSQL01->closeCursor();
        $stmtMSSQL02->closeCursor();
        $stmtMSSQL03->closeCursor();
        $stmtMSSQL04->closeCursor();*/

        $stmtMSSQL00    = null;
        /*$stmtMSSQL01    = null;
        $stmtMSSQL02    = null;
        $stmtMSSQL03    = null;
        $stmtMSSQL04    = null;*/

        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getMensaje(): '.$e;
        }

        $connMSSQL  = null;
    }

    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE NOTIFICACIÓN++++++++++++++++++++++++++";
   /* echo "\n";
    echo "++++++++++++++++ SISTEMA CORPORATIVO => SISTEMA SFHOLOX ++++++++++++++++";*/

    echo "INICIO getMensaje() => ".date('Y-m-d H:i:s');
    getMensaje();
    echo "\n";
    echo "FIN getMensaje() => ".date('Y-m-d H:i:s');
    echo "\n";
?>