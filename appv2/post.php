<?php
    $app->post('/v2/login', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['usuario_var01'];
        $val02      = $request->getParsedBody()['usuario_var02'];
        $val03      = $request->getParsedBody()['usuario_var03'];
        $val04      = $request->getParsedBody()['usuario_var04'];
        $val05      = $request->getParsedBody()['usuario_var05'];
        $val06      = $request->getParsedBody()['usuario_var06'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {
            $sql00  = "SELECT
            a.PERFICCOD                         AS          persona_codigo,
            a.PERFICNOM                         AS          persona_nombre,
            a.PERFICUSE                         AS          persona_user,
            a.PERFICCON                         AS          persona_contrasenha,
            a.PERFICPAT                         AS          persona_path,
            a.PERFICMAI                         AS          persona_email,
            a.PERFICTEF                         AS          persona_telefono,
            a.PERFICOBS                         AS          persona_observacion,
            a.PERFICAUS                         AS          persona_usuario,
            a.PERFICAFH                         AS          persona_fecha_hora,
            a.PERFICAIP                         AS          persona_ip,

            b.DOMFICCOD                         AS          tipo_estado_codigo,
            b.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
            b.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
            b.DOMFICNOP                         AS          tipo_estado_nombre_portugues,

            c.DOMFICCOD                         AS          tipo_acceso_codigo,
            c.DOMFICNOI                         AS          tipo_acceso_nombre_ingles,
            c.DOMFICNOC                         AS          tipo_acceso_nombre_castellano,
            c.DOMFICNOP                         AS          tipo_acceso_nombre_portugues,

            d.DOMFICCOD                         AS          tipo_perfil_codigo,
            d.DOMFICNOI                         AS          tipo_perfil_nombre_ingles,
            d.DOMFICNOC                         AS          tipo_perfil_nombre_castellano,
            d.DOMFICNOP                         AS          tipo_perfil_nombre_portugues,

            e.teamFifaId                        AS          equipo_codigo,
            e.internationalName                 AS          equipo_nombre,

            f.DOMFICCOD                         AS          tipo_categoria_codigo,
            f.DOMFICNOI                         AS          tipo_categoria_nombre_ingles,
            f.DOMFICNOC                         AS          tipo_categoria_nombre_castellano,
            f.DOMFICNOP                         AS          tipo_categoria_nombre_portugues
            
            FROM [adm].[PERFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.PERFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.PERFICTIP = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON a.PERFICROL = d.DOMFICCOD
            INNER JOIN [comet].[teams] e ON a.PERFICEQU = e.teamFifaId
            INNER JOIN [adm].[DOMFIC] f ON a.PERFICCAT = f.DOMFICCOD

            WHERE a.PERFICMAI = ?
            
            ORDER BY a.PERFICNOM";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]);
                
                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $pass = trim($rowMSSQL['persona_contrasenha']);

                    if (password_verify($val02, $pass)) {
                        if ($rowMSSQL['equipo_codigo'] == 1) {
                            $equipo_codigo  = 39393;
                            $equipo_nombre  = 'CONFEDERACIÓN SUDAMERICANA DE FÚTBOL';
                        } else {
                            $equipo_codigo  = $rowMSSQL['equipo_codigo'];
                            $equipo_nombre  = trim($rowMSSQL['equipo_nombre']);
                        }

                        $persona_fecha_hora = date_format(date_create($rowMSSQL['persona_fecha_hora']), 'd/m/Y H:i:s');
                    
                        if (isset($rowMSSQL['persona_path'])){
                            $persona_path = $rowMSSQL['persona_path'];
                        } else {
                            $persona_path = 'assets/images/users/defaul.png';
                        }

                        $detalle    = array(
                            'persona_codigo'                        => $rowMSSQL['persona_codigo'],
                            'persona_nombre'                        => trim($rowMSSQL['persona_nombre']),
                            'persona_user'                          => trim($rowMSSQL['persona_user']),
                            'persona_contrasenha'                   => trim($rowMSSQL['persona_contrasenha']),
                            'persona_path'                          => $persona_path,
                            'persona_email'                         => trim($rowMSSQL['persona_email']),
                            'persona_telefono'                      => trim($rowMSSQL['persona_telefono']),
                            'persona_observacion'                   => trim($rowMSSQL['persona_observacion']),
                            'persona_usuario'                       => trim($rowMSSQL['persona_usuario']),
                            'persona_fecha_hora'                    => $persona_fecha_hora,
                            'persona_ip'                            => trim($rowMSSQL['persona_ip']),

                            'tipo_estado_codigo'                    => $rowMSSQL['tipo_estado_codigo'],
                            'tipo_estado_nombre_ingles'             => trim($rowMSSQL['tipo_estado_nombre_ingles']),
                            'tipo_estado_nombre_castellano'         => trim($rowMSSQL['tipo_estado_nombre_castellano']),
                            'tipo_estado_nombre_portugues'          => trim($rowMSSQL['tipo_estado_nombre_portugues']),

                            'tipo_acceso_codigo'                    => $rowMSSQL['tipo_acceso_codigo'],
                            'tipo_acceso_nombre_ingles'             => trim($rowMSSQL['tipo_acceso_nombre_ingles']),
                            'tipo_acceso_nombre_castellano'         => trim($rowMSSQL['tipo_acceso_nombre_castellano']),
                            'tipo_acceso_nombre_portugues'          => trim($rowMSSQL['tipo_acceso_nombre_portugues']),

                            'tipo_perfil_codigo'                    => $rowMSSQL['tipo_perfil_codigo'],
                            'tipo_perfil_nombre_ingles'             => trim($rowMSSQL['tipo_perfil_nombre_ingles']),
                            'tipo_perfil_nombre_castellano'         => trim($rowMSSQL['tipo_perfil_nombre_castellano']),
                            'tipo_perfil_nombre_portugues'          => trim($rowMSSQL['tipo_perfil_nombre_portugues']),

                            'equipo_codigo'                         => $equipo_codigo,
                            'equipo_nombre'                         => $equipo_nombre,

                            'tipo_categoria_codigo'                 => $rowMSSQL['tipo_categoria_codigo'],
                            'tipo_categoria_nombre_ingles'          => trim($rowMSSQL['tipo_categoria_nombre_ingles']),
                            'tipo_categoria_nombre_castellano'      => trim($rowMSSQL['tipo_categoria_nombre_castellano']),
                            'tipo_categoria_nombre_portugues'       => trim($rowMSSQL['tipo_categoria_nombre_portugues'])
                        );

                        $result[]   = $detalle;

                        header("Content-Type: application/json; charset=utf-8");
                        $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                    } else {
                        $detalle    = array(
                            'persona_codigo'                        => '',
                            'persona_nombre'                        => '',
                            'persona_user'                          => '',
                            'persona_contrasenha'                   => '',
                            'persona_path'                          => '',
                            'persona_email'                         => '',
                            'persona_telefono'                      => '',
                            'persona_observacion'                   => '',
                            'persona_usuario'                       => '',
                            'persona_fecha_hora'                    => '',
                            'persona_ip'                            => '',

                            'tipo_estado_codigo'                    => '',
                            'tipo_estado_nombre_ingles'             => '',
                            'tipo_estado_nombre_castellano'         => '',
                            'tipo_estado_nombre_portugues'          => '',

                            'tipo_acceso_codigo'                    => '',
                            'tipo_acceso_nombre_ingles'             => '',
                            'tipo_acceso_nombre_castellano'         => '',
                            'tipo_acceso_nombre_portugues'          => '',

                            'tipo_perfil_codigo'                    => '',
                            'tipo_perfil_nombre_ingles'             => '',
                            'tipo_perfil_nombre_castellano'         => '',
                            'tipo_perfil_nombre_portugues'          => '',

                            'equipo_codigo'                         => '',
                            'equipo_nombre'                         => '',

                            'tipo_categoria_codigo'                 => '',
                            'tipo_categoria_nombre_ingles'          => '',
                            'tipo_categoria_nombre_castellano'      => '',
                            'tipo_categoria_nombre_portugues'       => ''
                        );

                        header("Content-Type: application/json; charset=utf-8");
                        $json = json_encode(array('code' => 401, 'status' => 'failure', 'message' => 'Contraseña invalida, vuelve a intentar', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                    }
                }

                if (!isset($result)){
                    $detalle    = array(
                        'persona_codigo'                        => '',
                        'persona_nombre'                        => '',
                        'persona_user'                          => '',
                        'persona_contrasenha'                   => '',
                        'persona_path'                          => '',
                        'persona_email'                         => '',
                        'persona_telefono'                      => '',
                        'persona_observacion'                   => '',
                        'persona_usuario'                       => '',
                        'persona_fecha_hora'                    => '',
                        'persona_ip'                            => '',

                        'tipo_estado_codigo'                    => '',
                        'tipo_estado_nombre_ingles'             => '',
                        'tipo_estado_nombre_castellano'         => '',
                        'tipo_estado_nombre_portugues'          => '',

                        'tipo_acceso_codigo'                    => '',
                        'tipo_acceso_nombre_ingles'             => '',
                        'tipo_acceso_nombre_castellano'         => '',
                        'tipo_acceso_nombre_portugues'          => '',

                        'tipo_perfil_codigo'                    => '',
                        'tipo_perfil_nombre_ingles'             => '',
                        'tipo_perfil_nombre_castellano'         => '',
                        'tipo_perfil_nombre_portugues'          => '',

                        'equipo_codigo'                         => '',
                        'equipo_nombre'                         => '',

                        'tipo_categoria_codigo'                 => '',
                        'tipo_categoria_nombre_ingles'          => '',
                        'tipo_categoria_nombre_castellano'      => '',
                        'tipo_categoria_nombre_portugues'       => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'ERROR: Verifique el usuario', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/000', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_orden'];
        $val03      = $request->getParsedBody()['tipo_nombre_ingles'];
        $val04      = $request->getParsedBody()['tipo_nombre_castellano'];
        $val05      = $request->getParsedBody()['tipo_nombre_portugues'];
        $val06      = $request->getParsedBody()['tipo_path'];
        $val07      = $request->getParsedBody()['tipo_dominio'];
        $val08      = $request->getParsedBody()['tipo_observacion'];
        $val09      = $request->getParsedBody()['tipo_usuario'];
        $val10      = $request->getParsedBody()['tipo_fecha_hora'];
        $val11      = $request->getParsedBody()['tipo_ip'];

        if (isset($val01) && isset($val03) && isset($val04) && isset($val05) && isset($val07) && isset($val09) && isset($val10) && isset($val11)) {
            $sql00  = "INSERT INTO [adm].[DOMFIC] (DOMFICEST, DOMFICORD, DOMFICNOI, DOMFICNOC, DOMFICNOP, DOMFICPAT, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val11]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/100', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_sub_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_codigo'];
        $val03      = $request->getParsedBody()['tipo_sub_orden'];
        $val04      = $request->getParsedBody()['tipo_sub_nombre_ingles'];
        $val05      = $request->getParsedBody()['tipo_sub_nombre_castellano'];
        $val06      = $request->getParsedBody()['tipo_sub_nombre_portugues'];
        $val07      = $request->getParsedBody()['tipo_sub_path'];
        $val08      = $request->getParsedBody()['tipo_sub_dominio'];
        $val09      = $request->getParsedBody()['tipo_sub_observacion'];
        $val10      = $request->getParsedBody()['tipo_sub_usuario'];
        $val11      = $request->getParsedBody()['tipo_sub_fecha_hora'];
        $val12      = $request->getParsedBody()['tipo_sub_ip'];

        if (isset($val01) && isset($val02) && isset($val04) && isset($val05) && isset($val06) && isset($val08) && isset($val10) && isset($val11) && isset($val12)) {
            $sql00  = "INSERT INTO [adm].[DOMSUB] (DOMSUBEST, DOMSUBTIC, DOMSUBORD, DOMSUBNOI, DOMSUBNOC, DOMSUBNOP, DOMSUBPAT, DOMSUBVAL, DOMSUBOBS, DOMSUBAUS, DOMSUBAFH, DOMSUBAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val12]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/400', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_acceso_codigo'];
        $val03      = $request->getParsedBody()['tipo_perfil_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['tipo_categoria_codigo'];
        $val06      = $request->getParsedBody()['persona_nombre'];
        $val07      = $request->getParsedBody()['persona_user'];
        $val08      = password_hash($request->getParsedBody()['persona_contrasenha'], PASSWORD_DEFAULT);
        $val09      = $request->getParsedBody()['persona_path'];
        $val10      = $request->getParsedBody()['persona_email'];
        $val11      = $request->getParsedBody()['persona_telefono'];
        $val12      = $request->getParsedBody()['persona_observacion'];
        $val13      = $request->getParsedBody()['persona_usuario'];
        $val14      = $request->getParsedBody()['persona_fecha_hora'];
        $val15      = $request->getParsedBody()['persona_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08) && isset($val10) && isset($val13) && isset($val14) && isset($val15)) {
            $sql00  = "INSERT INTO [adm].[PERFIC] (PERFICEST, PERFICTIP, PERFICROL, PERFICEQU, PERFICCAT, PERFICNOM, PERFICUSE, PERFICCON, PERFICPAT, PERFICMAI, PERFICTEF, PERFICOBS, PERFICAUS, PERFICAFH, PERFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val15]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/401', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getParsedBody()['competicion_codigo'];
        $val02      = $request->getParsedBody()['persona_codigo'];
        $val03      = $request->getParsedBody()['tipo_modulo_parametro'];
        $val04      = $request->getParsedBody()['competicion_persona_observacion'];
        $val05      = $request->getParsedBody()['competicion_persona_rts'];
        
        
        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "INSERT INTO [adm].[PERCOM] (PERCOMCOC, PERCOMPEC, PERCOMTMC, PERCOMOBS, PERCOMAUS, PERCOMAFH, PERCOMAIP, PERCOMRTS) VALUES (?, ?, (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'USUARIOMODULO' AND DOMFICPAR = ?), ?, ?, GETDATE(), ?, ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $aud01, $aud03, $val05]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: Ya se encuentra asiganda dicha competencia al medico. Verifique!'.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/600', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['competencia_codigo'];
        $val03      = $request->getParsedBody()['juego_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['jugador_codigo'];
        $val06      = $request->getParsedBody()['lesion_fecha_hora'];

        $val07      = $request->getParsedBody()['tipo_clima_codigo'];
        $val08      = $request->getParsedBody()['temperatura_numero'];
        $val09      = $request->getParsedBody()['tipo_distancia_codigo'];
        $val10      = $request->getParsedBody()['tipo_traslado_codigo'];

        $val11      = $request->getParsedBody()['tipo_posicion_codigo'];
        $val12      = $request->getParsedBody()['tipo_minuto_codigo'];
        $val13      = $request->getParsedBody()['tipo_campo_codigo'];

        $val14      = $request->getParsedBody()['tipo_cuerpo_zona_codigo'];
        $val15      = $request->getParsedBody()['tipo_cuerpo_lugar_codigo'];
        $val16      = $request->getParsedBody()['tipo_lesion_tipo_codigo'];
        $val17      = $request->getParsedBody()['tipo_lesion_origen_codigo'];
        $val18      = $request->getParsedBody()['tipo_lesion_reincidencia_codigo'];
        $val19      = $request->getParsedBody()['tipo_lesion_causa_codigo'];
        $val20      = $request->getParsedBody()['tipo_lesion_falta_codigo'];
        $val25      = $request->getParsedBody()['tipo_lesion_retiro_codigo'];

        $val21      = $request->getParsedBody()['tipo_diagnostico_tipo_codigo'];
        $val22      = $request->getParsedBody()['tipo_diagnostico_recuperacion_codigo'];
        $val23      = $request->getParsedBody()['tipo_diagnostico_tiempo_codigo'];
        $val24      = $request->getParsedBody()['diagnostico_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {
            $sql00  = "INSERT INTO [lesion].[LESFIC](LESFICESC, LESFICCOC, LESFICJUC, LESFICEQC, LESFICPEC, LESFICFEC, LESFICCLI, LESFICTEM, LESFICDIS, LESFICTRA, LESFICPOS, LESFICMIN, LESFICCAM, LESFICCUZ, LESFICCUL, LESFICLES, LESFICORI, LESFICREI, LESFICRET, LESFICCAU, LESFICFAL, LESFICDIA, LESFICREC, LESFICTIE, LESFICOBD, LESFICAUS, LESFICAFH, LESFICAIP) VALUES (?, ?, ?, ?, ?, GETDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $val17, $val18, $val25, $val19, $val20, $val21, $val22, $val23, $val24, $aud01, $aud03]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/601', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_concusion_codigo'];
        $val02      = $request->getParsedBody()['pregunta_concusion_codigo'];
        $val03      = $request->getParsedBody()['lesion_codigo'];
        $val04      = $request->getParsedBody()['lesion_concusion_respuesta'];
        $val05      = $request->getParsedBody()['lesion_concusion_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql00  = "INSERT INTO [lesion].[LESCON](LESCONTIC, LESCONPRC, LESCONLEC, LESCONRES, LESCONOBS, LESCONAUS, LESCONAFH, LESCONAIP) VALUES (?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $aud01, $aud03]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $connMSSQL->lastInsertId()), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/800/covid19/prueba', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_covid19_codigo'];
        $val03      = $request->getParsedBody()['disciplina_codigo'];
        $val04      = $request->getParsedBody()['competicion_codigo'];
        $val05      = $request->getParsedBody()['encuentro_codigo'];
        $val06      = $request->getParsedBody()['equipo_codigo'];
        $val07      = $request->getParsedBody()['jugador_codigo'];
        $val08      = $request->getParsedBody()['covid19_periodo'];
        $val09      = $request->getParsedBody()['covid19_fecha_1'];
        $val10      = $request->getParsedBody()['covid19_fecha_2'];
        $val11      = $request->getParsedBody()['covid19_fecha_3'];
        $val12      = $request->getParsedBody()['covid19_persona_adulta'];
        $val13      = $request->getParsedBody()['covid19_persona_menor'];
        $val14      = $request->getParsedBody()['covid19_ciudad'];
        $val15      = $request->getParsedBody()['covid19_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql00  = "INSERT INTO [exa].[COVFIC] (COVFICEST, COVFICTCC, COVFICDIC, COVFICCOC, COVFICENC, COVFICEQC, COVFICJUC, COVFICPER, COVFICFE1, COVFICFE2, COVFICFE3, COVFICACA, COVFICMCA, COVFICCIU, COVFICOBS, COVFICAUS, COVFICAFH, COVFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(COVFICCOD) AS covid19_codigo FROM [exa].[COVFIC]";
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $aud01, $aud03]); 
                
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['covid19_codigo']; 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    }); 

    $app->post('/v2/800/covid19/examen', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_prueba_codigo'];
        $val02      = $request->getParsedBody()['covid19_codigo'];
        $val03      = $request->getParsedBody()['covid19_prueba_valor'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "INSERT INTO [exa].[COVPRU] (COVPRUTPC, COVPRUCOC, COVPRUVAL, COVPRUAUS, COVPRUAFH, COVPRUAIP) VALUES (?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $aud01, $aud03]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/801/examen/prueba', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_examen_codigo'];
        $val03      = $request->getParsedBody()['competicion_codigo'];
        $val04      = $request->getParsedBody()['encuentro_codigo'];
        $val05      = $request->getParsedBody()['equipo_codigo'];
        $val06      = $request->getParsedBody()['persona_codigo'];
        $val07      = $request->getParsedBody()['examen_anterior_codigo'];
        $val08      = $request->getParsedBody()['examen_fecha_1'];
        $val09      = $request->getParsedBody()['examen_cantidad_adulto'];
        $val10      = $request->getParsedBody()['examen_cantidad_menor'];
        $val11      = $request->getParsedBody()['examen_persona_convocado'];
        $val12      = $request->getParsedBody()['examen_persona_posicion'];
        $val13      = $request->getParsedBody()['examen_persona_camiseta'];
        $val14      = $request->getParsedBody()['examen_laboratorio_nombre'];
        $val15      = $request->getParsedBody()['examen_laboratorio_fecha_envio'];
        $val16      = $request->getParsedBody()['examen_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql00  = "INSERT INTO [exa].[EXAFIC] (EXAFICEST, EXAFICTEC, EXAFICCOC, EXAFICENC, EXAFICEQC, EXAFICPEC, EXAFICAEC, EXAFICFE1, EXAFICACA, EXAFICMCA, EXAFICJCO, EXAFICJPO, EXAFICJCA, EXAFICLNO, EXAFICLFE, EXAFICOBS, EXAFICAUS, EXAFICAFH, EXAFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(EXAFICCOD) AS examen_codigo FROM [exa].[EXAFIC]";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $aud01, $aud03]); 
                
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['examen_codigo']; 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/801/examen/test', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_test_codigo'];
        $val02      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_test_dominio'])));
        $val03      = $request->getParsedBody()['examen_codigo'];
        $val04      = $request->getParsedBody()['examen_test_valor'];
        $val05      = $request->getParsedBody()['examen_test_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql00  = "INSERT INTO [exa].[EXATES] (EXATESTTC, EXATESEXC, EXATESVAL, EXATESOBS, EXATESAUS, EXATESAFH, EXATESAIP) VALUES ((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = ? AND DOMFICPAR = ?)?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val02, $val01, $val03, $val04, $val05, $aud01, $aud03]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/200/competicion/persona', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = rand(2, 10000);
        $val01      = $request->getParsedBody()['competicion_codigo'];
        $val02      = $request->getParsedBody()['equipo_codigo'];
        $val03      = $request->getParsedBody()['tipo_persona_codigo'];
        $val04      = $request->getParsedBody()['tipo_genero_codigo'];
        $val05      = strtoupper(strtolower(trim($request->getParsedBody()['persona_nombre'])));
        $val06      = strtoupper(strtolower(trim($request->getParsedBody()['persona_apellido'])));
        $val07      = $request->getParsedBody()['persona_fecha_nacimiento'];
        $val08      = strtoupper(strtolower(trim($request->getParsedBody()['persona_posicion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02)) {
            $sql00  = "SELECT personFifaId AS codigo FROM [comet].[persons] WHERE personFifaId = ?";
            $sql01  = "INSERT INTO [comet].[persons] (personFifaId, internationalFirstName, internationalLastName, firstName, lastName, dateOfBirth, gender, playerPosition, lastUpdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, GETDATE())";
            $sql02  = "INSERT INTO [comet].[competitions_teams_players] (competitionFifaId, teamFifaId, playerFifaId, shirtNumber, playerType, lastUpdate) VALUES (?, ?, ?, ?, ?, GETDATE())";

            try {
                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL02= $connMSSQL->prepare($sql02);

                $stmtMSSQL00->execute([$val00]); 
                $row_mssql00= $stmtMSSQL00->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql00['codigo'];

                while ($codigo != NULL){
                    $val00      = rand(2, 100000);
                    $stmtMSSQL00->execute([$val00]); 
                    $row_mssql00= $stmtMSSQL00->fetch(PDO::FETCH_ASSOC);
                    $codigo     = $row_mssql00['codigo'];
                }

                $stmtMSSQL01->execute([$val00, $val05, $val06, $val05, $val06, $val07, $val04, $val08]);
                $stmtMSSQL02->execute([$val01, $val02, $val00, 0, $val03]);
                $codigo = $val00;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();
                $stmtMSSQL02->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                $stmtMSSQL02 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/200/persona', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = rand(2, 100000);
        $val01      = strtoupper(strtolower(trim($request->getParsedBody()['persona_tipo'])));
        $val02      = strtoupper(strtolower(trim($request->getParsedBody()['persona_nombre'])));
        $val03      = strtoupper(strtolower(trim($request->getParsedBody()['persona_apellido'])));
        $val04      = strtoupper(strtolower(trim($request->getParsedBody()['persona_genero'])));
        $val05      = $request->getParsedBody()['persona_fecha_nacimiento'];
        $val06      = strtoupper(strtolower(trim($request->getParsedBody()['persona_funcion'])));
        $val07      = $request->getParsedBody()['tipo_documento_codigo'];
        $val08      = strtoupper(strtolower(trim($request->getParsedBody()['tipo_documento_numero'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val07) && isset($val08)) {
            $sql00  = "SELECT personFifaId AS codigo FROM [comet].[persons] WHERE personFifaId = ?";
            $sql01  = "INSERT INTO [comet].[persons] (personFifaId, internationalFirstName, internationalLastName, firstName, lastName, dateOfBirth, gender, playerPosition, documentType, documentNumber, personType, lastUpdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE())";
            try {
                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
            
                $stmtMSSQL00->execute([$val00]); 
                $row_mssql00= $stmtMSSQL00->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql00['codigo'];

                while ($codigo != NULL){
                    $val00      = rand(2, 100000);
                    $stmtMSSQL00->execute([$val00]); 
                    $row_mssql00= $stmtMSSQL00->fetch(PDO::FETCH_ASSOC);
                    $codigo     = $row_mssql00['codigo'];
                }

                $stmtMSSQL01->execute([$val00, $val02, $val03, $val02, $val03, $val05, $val04, $val06, $val07, $val08, $val01]);
                $codigo = $val00;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;

            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/200/persona/manual', function($request) {//20201028
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getParsedBody()['competicion_codigo'];
        $val01      = $request->getParsedBody()['equipo_codigo'];
        $val02      = $request->getParsedBody()['persona_codigo'];
        $val03      = strtoupper(strtolower(trim($request->getParsedBody()['persona_tipo'])));
        $val04      = '';
        $val05      = '';
        $val06      = '';
        $val07      = '';
        $val08      = '';
        $val09      = '';
        $val10      = '';
        $val11      = '';
        $val12      = '';
        $val13      = '';
        $val14      = '';
        $val15      = '';
        $val16      = '';
        $val17      = '';
        $val18      = '';
        $xJSON      = '';

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "INSERT INTO  [comet].[persons] (personFifaId, personType, internationalFirstName, firstName, internationalLastName, lastName, gender, nationality, nationalityFIFA, dateOfBirth, countryOfBirth, countryOfBirthFIFA, regionOfBirth, placeOfBirth, place, national_team, playerPosition, homegrown, lastUpdate) SELECT ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE() WHERE NOT EXISTS(SELECT * FROM [comet].[persons] WHERE personFifaId = ?)";
            $sql01  = "INSERT INTO  [comet].competitions_teams_players (competitionFifaId, teamFifaId, playerFifaId, lastUpdate, playerType, shirtNumber) SELECT  ?, ?, ?,  GETDATE(), ?, ? WHERE EXISTS(SELECT *FROM [comet].[persons] WHERE personFifaId = ?) AND NOT EXISTS(SELECT *FROM [comet].[competitions_teams_players] WHERE competitionFifaId = ? AND teamFifaId = ? AND playerFifaId = ?)";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $xJSON      = get_curl('player/'.$val02);
                sleep(15);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } finally {
                $val04      = $xJSON['person']['internationalFirstName'];
                $val05      = $xJSON['person']['internationalLastName'];
                $val06      = $xJSON['person']['gender'];
                $val07      = $xJSON['person']['nationality'];
                $val08      = $xJSON['person']['nationalityFIFA'];
                $val09      = $xJSON['person']['dateOfBirth'];
                $val10      = $xJSON['person']['countryOfBirth'];
                $val11      = $xJSON['person']['countryOfBirthFIFA'];
                $val12      = $xJSON['person']['regionOfBirth'];
                $val13      = $xJSON['person']['placeOfBirth'];
                $val14      = $xJSON['person']['place'];
                $val15      = $xJSON['person']['national_team'];
                $val16      = $xJSON['person']['playerPosition'];
                $val17      = $xJSON['person']['rowNumber'];
                $val18      = $xJSON['person']['homegrown'];

                $stmtMSSQL00->execute([$val02, $val03, $val04, $val04, $val05, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $val18, $val02]);
                $stmtMSSQL01->execute([$val00, $val01, $val02, $val03, $val17, $val02, $val00, $val01, $val02]);

                $codigo     = $val02;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });
/*MODULO NOTIFICACIONES*/
    $app->post('/v2/802/notificacion', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['notificacion_orden'];
        $val03      = $request->getParsedBody()['tipo_notificacion_parametro'];
        $val04      = $request->getParsedBody()['tipo_test_parametro'];
        $val05      = $request->getParsedBody()['notificacion_parametro'];
        $val06      = trim($request->getParsedBody()['notificacion_titulo']);
        $val07      = trim($request->getParsedBody()['notificacion_descripcion']);
        $val08      = $request->getParsedBody()['notificacion_fecha_desde'];
        $val09      = $request->getParsedBody()['notificacion_fecha_hasta'];
        $val10      = trim($request->getParsedBody()['notificacion_observacion']);

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val01) && isset($val03) && isset($val04)) {
            $sql00  = "INSERT INTO [adm].[NOTFIC](                                                    NOTFICEST,  NOTFICORD,                                                                                NOTFICTNC,                                                                                 NOTFICTTC, NOTFICPAC, NOTFICTIT,   NOTFICDES, NOTFICFED, NOTFICFEH, NOTFICFCA ,NOTFICOBS, NOTFICAUS, NOTFICAFH, NOTFICAIP) 
            SELECT  (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR = ?),         ?, (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONTIPO' AND DOMFICPAR = ?), (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOTIPO' AND DOMFICPAR = ?),        ?,          ?,          ?,          ?,        ?,  GETDATE() ,        ?,         ?, GETDATE(),         ?)
                            WHERE NOT EXISTS(SELECT * FROM [adm].[NOTFIC] WHERE NOTFICTTC = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOTIPO' AND DOMFICPAR = ?) AND NOTFICFCA = GETDATE() AND NOTFICTIT = ? AND NOTFICDES = ?)";
           
            $sql01  = "SELECT MAX(NOTFICCOD) AS notificacion_codigo FROM [adm].[NOTFIC]";
            
            try {
                $connMSSQL      =   getConnectionMSSQLv2();
                $stmtMSSQL      =   $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $aud01, $aud03, $val04, $val06, $val07]); 

                $stmtMSSQL01    =   $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                
                $row_mssql01    =   $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo         =   $row_mssql01['notificacion_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/802/notificacioncompeticion', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['notificacion_competicion_orden'];
        $val03      = $request->getParsedBody()['notificacion_codigo'];
        $val04      = $request->getParsedBody()['competicion_codigo'];
        $val05      = $request->getParsedBody()['notificacion_competicion_observacion'];

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val01) && isset($val03) && isset($val04)) {
            $sql00  = "INSERT INTO [adm].[NOTCOM](NOTCOMEST, NOTCOMORD, NOTCOMCOC, NOTCOMNOC, NOTCOMOBS, NOTCOMAUS, NOTCOMAFH, NOTCOMAIP) VALUES((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR = ?), ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(NOTCOMCOD) AS notificacion_competicion_codigo FROM [adm].[NOTCOM]";

            try {
                $connMSSQL      =   getConnectionMSSQLv2();
                $stmtMSSQL      =   $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val04, $val03, $val05, $aud01, $aud03]); 

                $stmtMSSQL01    =   $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                
                $row_mssql01    =   $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo         =   $row_mssql01['notificacion_competicion_codigo'];
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v2/802/notificacionequipo', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['notificacion_equipo_orden'];
        $val03      = $request->getParsedBody()['notificacion_competicion_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['notificacion_equipo_observacion'];

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val01) && isset($val03) && isset($val04)) {
            $sql00  = "INSERT INTO [adm].[NOTEQU](NOTEQUEST, NOTEQUORD, NOTEQUNCM, NOTEQUEQC, NOTEQUOBS, NOTEQUAUS, NOTEQUAFH, NOTEQUAIP) VALUES((SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR = ?), ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(NOTEQUCOD) AS notificacion_equipo_codigo FROM [adm].[NOTEQU]";
            try {
                $connMSSQL      =   getConnectionMSSQLv2();
                $stmtMSSQL      =   $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $aud01, $aud03]); 

                $stmtMSSQL01    =   $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                
                $row_mssql01    =   $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo         =   $row_mssql01['notificacion_equipo_codigo'];

                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

