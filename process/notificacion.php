<?php
    require __DIR__.'/../src/connect.php';

    $DOMFICAUS      = 'SFHOLOX';
    $DOMFICAIP      = '0.0.0.0';
    $NOTMENOBS      = '';
    
    function getProcesses($status, $errors){
        
        $sql00  =   "INSERT INTO [comet].[processes] (status, lastUpdate, errors) VALUES (?, GETDATE(), ?)";

        try {
            $connMSSQL      = getConnectionMSSQLv2();

            $stmtMSSQL00    = $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$status, $errors]); 
        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getProcesses(): '.$e;
        }

        $connMSSQL  = null;

    }

     function getMensajeManual(){

            global $DOMFICAUS;
            global $DOMFICAIP;
            global $NOTMENOBS;
            $notmenenc  = 0;
            $DOMFICPAR  = 1;

            $sql00  =   "SELECT
                a.NOTFICCOD                     AS      notificacion_codigo,
                a.NOTFICORD                     AS      notificacion_orden,  	
                a.NOTFICPAC                     AS      notificacion_parametro,
                a.NOTFICTIT                     AS      notificacion_titulo,	
                a.NOTFICDES                     AS      notificacion_descripcion,	
                a.NOTFICFED                     AS      notificacion_fecha_desde,	
                a.NOTFICFEH                     AS      notificacion_fecha_hasta,	
                a.NOTFICFCA                     AS      notificacion_fecha_carga,
                a.NOTFICDIN                     AS      notificacion_dia_inicio,
                a.NOTFICDFI                     AS      notificacion_dia_fin,
                a.NOTFICCOC                     AS      notificacion_competicion_codigo,
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

                WHERE b.DOMFICPAR = 1 AND c.DOMFICPAR = 2  AND a.NOTFICFED <= CONVERT(varchar(10), GETDATE(), 23) AND a.NOTFICFEH >= CONVERT(varchar(10), GETDATE(), 23)
        
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

                    $notficcod  = $rowMSSQL00['notificacion_codigo'];
                    $notficcoc  = $rowMSSQL00['notificacion_competicion_codigo'];
                    $mensaje    = trim($rowMSSQL00['notificacion_titulo']).' '.trim($rowMSSQL00['notificacion_descripcion']);

                    $stmtMSSQL01->execute([$notficcod]);

                    while ($rowMSSQL01  = $stmtMSSQL01->fetch()) {//RECORRE NOTEQU
                        $notequeqc      = $rowMSSQL01['equipo_codigo'];
                        
                        $stmtMSSQL02->execute([$notequeqc, $notficcoc]);

                        while ($rowMSSQL02  = $stmtMSSQL02->fetch()) {//RECORRE PERFIC
                            $notmenmec      = $rowMSSQL02['persona_codigo'];
                            
                            $stmtMSSQL03->execute([$DOMFICPAR, $notficcod, $notequeqc, $notmenenc, $notmenmec, $mensaje, $NOTMENOBS, $DOMFICAUS,$DOMFICAIP]);
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
                echo 'Error getMensajeManual(): '.$e;
                getProcesses('ERROR PROCESO DE NOTIFICACION MANUAL', $e);
                
            }

            $connMSSQL  = null;
    }

    function getMensajeAutomatico(){
       
        $sql00  =   "SELECT 
            a.NOTFICCOD                     AS      notificacion_codigo,
            a.NOTFICORD                     AS      notificacion_orden,  	
            a.NOTFICPAC                     AS      notificacion_parametro,
            a.NOTFICTIT                     AS      notificacion_titulo,	
            a.NOTFICDES                     AS      notificacion_descripcion,	
            a.NOTFICFED                     AS      notificacion_fecha_desde,	
            a.NOTFICFEH                     AS      notificacion_fecha_hasta,	
            a.NOTFICFCA                     AS      notificacion_fecha_carga,
            a.NOTFICDIN                     AS      notificacion_dia_inicio,
            a.NOTFICDFI                     AS      notificacion_dia_fin,
            a.NOTFICCOC                     AS      notificacion_competicion_codigo,
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

            WHERE b.DOMFICPAR = 1 AND c.DOMFICPAR = 1";

        $sql01  =   "SELECT
            a.COMPETICION_ID                        AS      competicion_codigo,
            a.COMPETICION_PADRE_ID                  AS      competicion_codigo_padre,
            a.COMPETICION_ESTADO                    AS      competicion_estado,
            a.COMPETICION_ANHO                      AS      competicion_anho,
            a.JUEGO_CODIGO                          AS      juego_codigo,
            a.JUEGO_NOMBRE                          AS      juego_fase,
            a.JUEGO_ESTADO                          AS      juego_estado,
            a.JUEGO_HORARIO                         AS      juego_horario,
            a.EQUIPO_LOCAL_CODIGO                   AS      equipo_local_codigo,
            a.EQUIPO_LOCAL_NOMBRE                   AS      equipo_local_nombre,
            a.EQUIPO_LOCAL_RESULTADO_PRIMER         AS      equipo_local_resultado_primer,
            a.EQUIPO_LOCAL_RESULTADO_SEGUNDO        AS      equipo_local_resultado_segundo,
            a.EQUIPO_VISITANTE_CODIGO               AS      equipo_visitante_codigo,
            a.EQUIPO_VISITANTE_NOMBRE               AS      equipo_visitante_nombre,
            a.EQUIPO_VISITANTE_RESULTADO_PRIMER     AS      equipo_visitante_resultado_primer,
            a.EQUIPO_VISITANTE_RESULTADO_SEGUNDO    AS      equipo_visitante_resultado_segundo,
            
            b.NOTFICCOD                             AS      notificacion_codigo,
            b.NOTFICORD                             AS      notificacion_orden,  	
            b.NOTFICPAC                             AS      notificacion_parametro,
            b.NOTFICTIT                             AS      notificacion_titulo,	
            b.NOTFICDES                             AS      notificacion_descripcion,	
            b.NOTFICFED                             AS      notificacion_fecha_desde,	
            b.NOTFICFEH                             AS      notificacion_fecha_hasta,	
            b.NOTFICFCA                             AS      notificacion_fecha_carga,
            b.NOTFICDIN                             AS      notificacion_dia_inicio,
            b.NOTFICDFI                             AS      notificacion_dia_fin,
            b.NOTFICOBS                             AS      notificacion_observacion

            FROM [view].[juego] a
            INNER JOIN [adm].[NOTFIC] b ON a.COMPETICION_PADRE_ID = b.NOTFICCOC

            WHERE a.COMPETICION_ESTADO = 'ACTIVE' AND a.JUEGO_ESTADO <> 'PLAYED' AND  a.COMPETICION_PADRE_ID = ? AND  a.JUEGO_HORARIO IS NOT NULL AND (CONVERT(varchar(10), DATEADD(DAY, - b.NOTFICDIN, a.JUEGO_HORARIO), 103) <=  CONVERT(varchar(10), GETDATE(), 103)) AND (CONVERT(varchar(10), DATEADD(DAY, - b.NOTFICDFI, a.JUEGO_HORARIO),103) >=  CONVERT(varchar(10), GETDATE(), 103))";

        
        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            $stmtMSSQL01= $connMSSQL->prepare($sql01);
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {//recorre NOTFIC
            
                $notficcod      = $rowMSSQL00['notificacion_codigo'];
                $notficcoc      = $rowMSSQL00['notificacion_competicion_codigo'];
                $descripcion    = trim($rowMSSQL00['notificacion_descripcion']);
                $stmtMSSQL01->execute([$notficcoc]);

                while ($rowMSSQL01  = $stmtMSSQL01->fetch()) {//recorre juego

                    $codequipol         = $rowMSSQL01['equipo_local_codigo'];
                    $nomequipol         = $rowMSSQL01['equipo_local_nombre'];
                    $codequipov         = $rowMSSQL01['equipo_visitante_codigo']; 
                    $nomequipov         = $rowMSSQL01['equipo_visitante_nombre'];
                    $codencuentro       = $rowMSSQL01['juego_codigo'];
                    $codcompeticion     = $rowMSSQL01['competicion_codigo_padre'];
                    $juegohorario       = $rowMSSQL01['juego_horario'];      

                    echo "INICIO getMensajeResultado() => ".date('Y-m-d H:i:s');
                    getMensajeResultado($codequipol, $codencuentro, $codcompeticion, $notficcod, $descripcion, $juegohorario, $nomequipol);
                    getMensajeResultado($codequipov, $codencuentro, $codcompeticion, $notficcod, $descripcion, $juegohorario, $nomequipov);
                    echo "\n";
                    echo "FIN getMensajeResultado() => ".date('Y-m-d H:i:s');
                    echo "\n";
                }
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL01->closeCursor();

            $stmtMSSQL00= null;
            $stmtMSSQL01= null;

        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getMensajeAutomatico(): '.$e;
            getProcesses('ERROR PROCESO DE NOTIFICACION AUTOMÁTICA', $e);
        }

        $connMSSQL  = null;

    }

    function getMensajeResultado($codequipo, $codencuentro, $codcompeticion, $notficcod, $descripcion, $juegohorario, $nomequipo){
        
        global $DOMFICAUS;
        global $DOMFICAIP;
        global $NOTMENOBS;
        $DOMFICPAR  = 1;

        $sql01_1    =   "SELECT 
            a.competitionFifaId        AS  competicion_codigo,
            a.teamFifaId               AS  equipo_codigo,
            
            b.personFifaId             AS  persona_codigo,
            b.internationalFirstName   AS  persona_nombre,
            b.internationalLastName    AS  persona_apellido,
            b.documentNumber           AS  persona_documento,
            RTRIM(CONVERT(CHAR, b.personFifaId))+' -    '+(b.internationalFirstName)+' '+(b.internationalLastName) AS persona_nombre_completo
        
            FROM comet.competitions_teams_players a 
            INNER JOIN comet.persons   b ON a.playerFifaId  = b.personFifaId
            
            WHERE a.competitionFifaId = ? and a.teamFifaId = ? AND b.personType <> 'Z' AND b.personType <> 'O' AND NOT EXISTS (SELECT * FROM exa.EXAFIC c 
                                                                                                                                        INNER JOIN adm.DOMFIC      d ON c.EXAFICEST  = d.DOMFICCOD
                                                                                                                                        INNER JOIN adm.DOMFIC      e ON c.EXAFICTEC  = e.DOMFICCOD 
                                                                                                                                            
                                                                                                                                        WHERE c.EXAFICCOC = ? AND c.EXAFICEQC = ? AND c.EXAFICENC  = ? AND d.DOMFICPAR NOT IN (3,5) AND e.DOMFICPAR = 1 AND c.EXAFICPEC = a.playerFifaId)";

        $sql02_2    =   "SELECT 
            RTRIM(CONVERT(CHAR, d.personFifaId))+' -    '+(d.internationalFirstName)+' '+(d.internationalLastName) AS persona_nombre_completo,
            b.DOMFICCOD     AS      tipo_estado_codigo,
            b.DOMFICNOC     AS      tipo_estado_nombre_castellano  

            FROM exa.EXAFIC a
            INNER JOIN adm.DOMFIC b ON a.EXAFICEST      = b.DOMFICCOD
            INNER JOIN adm.DOMFIC c ON a.EXAFICTEC      = c.DOMFICCOD
            INNER JOIN comet.persons d ON a.EXAFICPEC   = d.personFifaId
            
            WHERE a.EXAFICCOC = ? AND a.EXAFICEQC = ? AND a.EXAFICENC = ? AND b.DOMFICPAR = 2 AND c.DOMFICPAR = 1";

        $sql03_3    =   "SELECT 
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

        $sql04_4     =   "INSERT INTO [adm].[NOTMEN](                                                               NOTMENEST, NOTMENNOC, NOTMENEQC, NOTMENENC, NOTMENMEC, NOTMENMEN, NOTMENOBS, NOTMENAUS, NOTMENAFH, NOTMENAIP) 
        VALUES((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR  = ?),         ?,          ?,        ?,         ?,        ?,        ?,           ?, GETDATE(),       ?)";
            

        try {
            $connMSSQL      = getConnectionMSSQLv2();
            $stmtMSSQL01_1  = $connMSSQL->prepare($sql01_1);
            $stmtMSSQL01_1->execute([$codcompeticion, $codequipo, $codcompeticion, $codequipo, $codencuentro]); 

            $stmtMSSQL02_2  = $connMSSQL->prepare($sql02_2);
            $stmtMSSQL02_2->execute([$codcompeticion, $codequipo, $codencuentro]);
            
            $stmtMSSQL03_3  = $connMSSQL->prepare($sql03_3);
            $stmtMSSQL03_3->execute([$codequipo, $codcompeticion]);

            $stmtMSSQL04_4  = $connMSSQL->prepare($sql04_4);

            $persona_datos   = '';
            $persona_datos_2 = '';

            while ($rowMSSQL01_1 = $stmtMSSQL01_1->fetch()) {
                $persona_datos  = $persona_datos."<br>".'PERSONAS PENDIENTES: '.trim($rowMSSQL01_1['persona_nombre_completo']);
                
            }

            while ($rowMSSQL02_2 = $stmtMSSQL02_2->fetch()) {         
                $persona_datos_2    = $persona_datos_2."<br>".'PERSONAS PENDIENTE RESULTADO: '.trim($rowMSSQL02_2['persona_nombre_completo']);

            }

            while ($rowMSSQL03_3 = $stmtMSSQL03_3->fetch()) {
                $notmenmec  = $rowMSSQL03_3['persona_codigo'];
                $mensaje    = trim($descripcion)."<br>".'EQUIPO: '.trim($nomequipo).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.' FECHA DE JUEGO: '.$juegohorario."<br>".$persona_datos."<br>".$persona_datos_2;
                $stmtMSSQL04_4->execute([$DOMFICPAR, $notficcod, $codequipo, $codencuentro, $notmenmec, $mensaje, $NOTMENOBS, $DOMFICAUS, $DOMFICAIP]);

            }

            $stmtMSSQL01_1->closeCursor();
            $stmtMSSQL02_2->closeCursor();
            $stmtMSSQL03_3->closeCursor();
            $stmtMSSQL04_4->closeCursor();

            $stmtMSSQL01_1  = null;
            $stmtMSSQL02_2  = null;
            $stmtMSSQL03_3  = null;
            $stmtMSSQL04_4  = null;

        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getMensajeAutomatico(): '.$e;
        }

        $connMSSQL  = null;
    }


    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE NOTIFICACIÓN++++++++++++++++++++++++++";
    echo "\n";

    echo "INICIO getMensajeManual() => ".date('Y-m-d H:i:s');
    getProcesses('INICIO PROCESO DE NOTIFICACION MANUAL', '-');
    getMensajeManual();
    getProcesses('FIN PROCESO DE NOTIFICACION MANUAL', '-');
    echo "\n";
    echo "FIN getMensajeManual() => ".date('Y-m-d H:i:s');
    echo "\n";

    echo "INICIO getMensajeAutomatico() => ".date('Y-m-d H:i:s');
    getProcesses('INICIO PROCESO DE NOTIFICACION AUTOMÁTICA', '-');
    getMensajeAutomatico();
    getProcesses('FIN PROCESO DE NOTIFICACION AUTOMÁTICA', '-');

    echo "\n";
    echo "FIN getMensajeAutomatico() => ".date('Y-m-d H:i:s');
    echo "\n";

?>