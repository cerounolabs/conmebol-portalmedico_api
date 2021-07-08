<?php
    $app->delete('/v1/000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_orden'];
        $val03      = $request->getParsedBody()['tipo_parametro'];
        $val04      = $request->getParsedBody()['tipo_nombre_ingles'];
        $val05      = $request->getParsedBody()['tipo_nombre_castellano'];
        $val06      = $request->getParsedBody()['tipo_nombre_portugues'];
        $val07      = $request->getParsedBody()['tipo_path'];
        $val08      = $request->getParsedBody()['tipo_dominio'];
        $val09      = $request->getParsedBody()['tipo_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val04) && isset($val05) && isset($val06) && isset($val08) && isset($aud01) && isset($aud02) && isset($aud03)) {
            $sql00  = "DELETE FROM [adm].[DOMFIC] WHERE DOMFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/000/localidadpais/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo'); 
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['localidad_pais_orden'];
        $val03      = trim($request->getParsedBody()['localidad_pais_nombre']);
        $val04      = trim($request->getParsedBody()['localidad_pais_path']);
        $val05      = trim($request->getParsedBody()['localidad_pais_iso_char2']);
        $val06      = trim($request->getParsedBody()['localidad_pais_iso_char3']);
        $val07      = trim($request->getParsedBody()['localidad_pais_iso_num3']);
        $val08      = trim($request->getParsedBody()['localidad_pais_observacion']);
        $val09      = trim($request->getParsedBody()['localidad_pais_alta_usuario']);
        $val10      = $request->getParsedBody()['localidad_pais_alta_fecha_hora'];
        $val11      = trim($request->getParsedBody()['localidad_pais_alta_ip']);

    
        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val01) && isset($val02)) {
            $sql00  = "UPDATE [adm].[LOCPAI] SET LOCPAIAUS = ?,	LOCPAIAFH = GETDATE(), LOCPAIAIP = ? WHERE LOCPAICOD = ?";
            $sql01  = "DELETE FROM [adm].[LOCPAI] WHERE LOCPAICOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });  

    $app->delete('/v1/000/localidadciudad/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo'); 
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['localidad_pais_codigo'];
        $val03      = $request->getParsedBody()['localidad_ciudad_orden'];
        $val04      = $request->getParsedBody()['localidad_ciudad_parametro'];
        $val05      = trim($request->getParsedBody()['localidad_ciudad_nombre']);
        $val06      = trim($request->getParsedBody()['localidad_ciudad_observacion']);
        $val07      = trim($request->getParsedBody()['localidad_ciudad_alta_usuario']);
        $val08      = $request->getParsedBody()['localidad_ciudad_alta_fecha_hora'];
        $val09      = trim($request->getParsedBody()['localidad_ciudad_alta_ip']);
    
        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val00) && isset($val01) && isset($val02) && isset($val04) && isset($val05)) {
            $sql00  = "UPDATE [adm].[LOCCIU] SET LOCCIUAUS = ?,	LOCCIUAFH = GETDATE(), LOCCIUAIP = ? WHERE LOCCIUCOD = ?";
            $sql01  = "DELETE FROM [adm].[LOCCIU] WHERE LOCCIUCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });  

    $app->delete('/v1/100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
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

        if (isset($val00)) {
            $sql00  = "DELETE FROM [adm].[DOMSUB] WHERE DOMFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_acceso_codigo'];
        $val03      = $request->getParsedBody()['tipo_perfil_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['tipo_categoria_codigo'];
        $val06      = $request->getParsedBody()['persona_nombre'];
        $val07      = $request->getParsedBody()['persona_user'];
        $val08      = $request->getParsedBody()['persona_contrasenha'];
        $val09      = $request->getParsedBody()['persona_path'];
        $val10      = $request->getParsedBody()['persona_email'];
        $val11      = $request->getParsedBody()['persona_telefono'];
        $val12      = $request->getParsedBody()['persona_observacion'];
        $val13      = $request->getParsedBody()['persona_usuario'];
        $val14      = $request->getParsedBody()['persona_fecha_hora'];
        $val15      = $request->getParsedBody()['persona_ip'];

        if (isset($val00)) {
            $sql00  = "DELETE FROM [adm].[PERFIC] WHERE PERFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/200/persona/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
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

        if (isset($val00)) {
            $sql00  = "DELETE FROM [comet].[persons] WHERE personFifaId = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });
    /*MODULO PERSONA*/
    $app->delete('/v1/200/competicion/medico/{competicion}/{persona}', function($request) {
            require __DIR__.'/../src/connect.php';
    
            $val01      = $request->getAttribute('competicion');
            $val02      = $request->getAttribute('persona');
            $val03      = $request->getParsedBody()['tipo_modulo_parametro'];
            $val04      = $request->getParsedBody()['competicion_persona_observacion'];
            $val05      = $request->getParsedBody()['competicion_persona_rts'];
            
            $aud01      = $request->getParsedBody()['auditoria_usuario'];
            $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
            $aud03      = $request->getParsedBody()['auditoria_ip'];
    
            if (isset($val01) && isset($val02)) {
                $sql00  = "UPDATE [adm].[PERCOM] SET PERCOMAUS = ?, PERCOMAFH = GETDATE(), PERCOMAIP = ? WHERE PERCOMCOC = ? AND PERCOMPEC = ?";
                $sql01  = "DELETE FROM [adm].[PERCOM] WHERE PERCOMCOC = ? AND PERCOMPEC = ?";
    
                try {
                    $connMSSQL  = getConnectionMSSQLv1();
                    $stmtMSSQL00= $connMSSQL->prepare($sql00);
                    $stmtMSSQL01= $connMSSQL->prepare($sql01);
    
                    $stmtMSSQL00->execute([$aud01, $aud03, $val01, $val02]);
                    $stmtMSSQL01->execute([$val01, $val02]);
    
                    $stmtMSSQL00->closeCursor();
                    $stmtMSSQL01->closeCursor();
    
                    $stmtMSSQL00 = null;
                    $stmtMSSQL01 = null;
                    
                    header("Content-Type: application/json; charset=utf-8");
                    $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val01.', '.$val02), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
    
                } catch (PDOException $e) {
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
    
            $connMSSQL  = null;
            
            return $json;
        });

/*MODULO NOTIFICACION*/
    $app->delete('/v1/802/notificacion/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo'); 
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['notificacion_orden'];
        $val03      = $request->getParsedBody()['tipo_notificacion_parametro'];
        $val04      = $request->getParsedBody()['tipo_test_parametro'];
        $val05      = $request->getParsedBody()['competicion_codigo'];
        $val06      = $request->getParsedBody()['notificacion_parametro'];
        $val07      = trim($request->getParsedBody()['notificacion_titulo']);
        $val08      = trim($request->getParsedBody()['notificacion_descripcion']);
        $val09      = $request->getParsedBody()['notificacion_fecha_desde'];
        $val10      = $request->getParsedBody()['notificacion_fecha_hasta'];
        $val11      = $request->getParsedBody()['notificacion_fecha_carga'];
        $val12      = $request->getParsedBody()['notificacion_dia_inicio'];
        $val13      = $request->getParsedBody()['notificacion_dia_fin'];
        $val14      = trim($request->getParsedBody()['notificacion_observacion']);

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);


        if (isset($val00) && isset($val01) && isset($val03) && isset($val04)) {
            $sql00  = "UPDATE [adm].[NOTFIC] SET NOTFICAUS = ?,	NOTFICAFH = GETDATE(), NOTFICAIP = ? WHERE NOTFICCOD = ?";
            $sql01  = "DELETE FROM [adm].[NOTFIC] WHERE NOTFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/802/notificacionequipo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo'); 
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['notificacion_equipo_orden'];
        $val03      = $request->getParsedBody()['notificacion_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['notificacion_equipo_fecha_carga'];
        $val06      = $request->getParsedBody()['notificacion_equipo_observacion'];

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val00) && isset($val01) && isset($val03) && isset($val04)) {
            $sql00  = "UPDATE [adm].[NOTEQU] SET NOTEQUAUS = ?,	NOTEQUAFH = GETDATE(), NOTEQUAIP = ? WHERE NOTEQUCOD = ?";
            $sql01  = "DELETE FROM [adm].[NOTEQU] WHERE NOTEQUCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/802/notificacionmensaje/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo'); 
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['notificacion_mensaje_orden'];
        $val03      = $request->getParsedBody()['notificacion_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['persona_codigo'];
        $val06      = $request->getParsedBody()['notificacion_mensaje_fecha_proceso'];
        $val07      = $request->getParsedBody()['notificacion_mensaje_encuentro'];
        $val08      = trim($request->getParsedBody()['notificacion_mensaje_descripcion']);
        $val09      = trim($request->getParsedBody()['notificacion_equipo_observacion']);

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val00) && isset($val01) && isset($val03) && isset($val04) && isset($val05)) {
            $sql00  = "UPDATE [adm].[NOTMEN] SET NOTMENAUS = ?,	NOTMENAFH = GETDATE(), NOTMENAIP = ? WHERE NOTMENCOD = ?";
            $sql01  = "DELETE FROM [adm].[NOTMEN] WHERE NOTMENCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

/*MODULO VACUNACION*/

    $app->delete('/v1/900/vacuna/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo'); 
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['localidad_pais_codigo'];
        $val03      = $request->getParsedBody()['vacuna_orden'];
        $val04      = trim($request->getParsedBody()['vacuna_nombre']);
        $val05      = $request->getParsedBody()['vacuna_cantidad_dosis'];
        $val06      = trim($request->getParsedBody()['vacuna_observacion']);
        $val07      = trim($request->getParsedBody()['vacuna_alta_usuario']);
        $val08      = $request->getParsedBody()['vacuna_alta_fecha_hora'];
        $val09      = trim($request->getParsedBody()['vacuna_alta_ip']);

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);


        if (isset($val00) && isset($val01) && isset($val02) && isset($val04) && isset($val05)) {
            $sql00  = "UPDATE [vac].[VACFIC] SET VACFICAUS = ?,	VACFICAFH = GETDATE(), VACFICAIP = ? WHERE VACFICCOD = ?";
            $sql01  = "DELETE FROM [vac].[VACFIC] WHERE VACFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/900/vacunacabecera/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo'); 
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['competicion_codigo'];
        $val03      = $request->getParsedBody()['equipo_codigo'];
        $val04      = $request->getParsedBody()['persona_codigo'];
        $val05      = $request->getParsedBody()['vacuna_codigo'];
        $val06      = $request->getParsedBody()['encuentro_codigo'];
        $val07      = strtoupper(strtolower(trim($request->getParsedBody()['vacuna_cabecera_adquirio_covid'])));
        $val08      = $request->getParsedBody()['vacuna_cabecera_fecha'];
        $val09      = strtoupper(strtolower(trim($request->getParsedBody()['vacuna_cabecera_dosis_aplicada'])));
        $val10      = trim($request->getParsedBody()['vacuna_cabecera_observacion']);
        $val11      = trim($request->getParsedBody()['vacuna_cabecera_alta_usuario']);
        $val12      = $request->getParsedBody()['vacuna_cabecera_alta_fecha_hora'];
        $val13      = trim($request->getParsedBody()['vacuna_cabecera_alta_ip']);     
    
        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val00) && isset($val01) && isset($val03) && isset($val04) && isset($val05) && isset($val07) && isset($val09)) {
            $sql00  = "UPDATE [vac].[VACVCA] SET VACVCAAUS = ?,	VACVCAAFH = GETDATE(), VACVCAAIP = ? WHERE VACVCACOD = ?";
            $sql01  = "DELETE FROM [vac].[VACVCA] WHERE VACVCACOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/900/vacunadetalle/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo'); 
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['tipo_dosis_parametro'];
        $val03      = $request->getParsedBody()['localidad_ciudad_codigo'];
        $val04      = $request->getParsedBody()['vacuna_cabecera_codigo'];
        $val05      = $request->getParsedBody()['vacuna_detalle_orden'];
        $val06      = trim($request->getParsedBody()['vacuna_detalle_nombre']);
        $val07      = $request->getParsedBody()['vacuna_detalle_fecha'];
        $val08      = trim($request->getParsedBody()['vacuna_detalle_lugar']);
        $val09      = trim(strtolower($request->getParsedBody()['vacuna_detalle_adjunto']));
        $val10      = trim($request->getParsedBody()['vacuna_detalle_observacion']);
        $val11      = trim($request->getParsedBody()['vacuna_detalle_alta_usuario']);
        $val12      = $request->getParsedBody()['vacuna_detalle_alta_fecha_hora'];
        $val13      = trim($request->getParsedBody()['vacuna_detalle_alta_ip']);      
    
        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val00) && isset($val01) && isset($val02)  && isset($val03) && isset($val04)) {
            $sql00  = "UPDATE [vac].[VACVDE] SET VACVDEAUS = ?,	VACVDEAFH = GETDATE(), VACVDEAIP = ? WHERE VACVDECOD = ?";
            $sql01  = "DELETE FROM [vac].[VACVDE] WHERE VACVDECOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });