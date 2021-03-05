<?php
    $app->put('/v2/000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
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
            $sql00  = "UPDATE [adm].[DOMFIC] SET DOMFICEST = ?, DOMFICORD = ?, DOMFICNOI = ?, DOMFICNOC = ?, DOMFICNOP = ?, DOMFICPAT = ?, DOMFICOBS = ?, DOMFICAUS = ?, DOMFICAFH = GETDATE(), DOMFICAIP = ? WHERE DOMFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val08,  $val09,  $val11, $val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/100/{codigo}', function($request) {
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

        if (isset($val01) && isset($val02) && isset($val04) && isset($val05) && isset($val06) && isset($val08) && isset($val10) && isset($val11) && isset($val12)) {
            $sql00  = "UPDATE [adm].[DOMSUB] SET DOMSUBEST = ?, DOMSUBTIC = ?, DOMSUBORD = ?, DOMSUBNOI = ?, DOMSUBNOC = ?, DOMSUBNOP = ?, DOMSUBPAT = ?, DOMSUBOBS = ?, DOMSUBAUS = ?, DOMSUBAFH = GETDATE(), DOMSUBAIP = ? WHERE DOMSUBCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val09, $val10, $val12, $val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/200/persona/{codigo}', function($request) {
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

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val07) && isset($val08)){
            $sql00  = "UPDATE [comet].[persons] SET internationalFirstName = ?, internationalLastName = ?, firstName = ?, lastName = ?, dateOfBirth = ?, gender = ?, playerPosition = ?, documentType = ?, documentNumber = ?, personType = ?, lastUpdate = GETDATE() WHERE personFifaId = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val02, $val03, $val02, $val03, $val05, $val04, $val06, $val07, $val08, $val01, $val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/400/{codigo}', function($request) {
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

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val13) && isset($val14) && isset($val15)) {
            $sql00  = "UPDATE [adm].[PERFIC] SET PERFICEST = ?, PERFICTIP = ?, PERFICROL = ?, PERFICEQU = ?,  PERFICCAT = ?, PERFICNOM = ?, PERFICPAT = ?, PERFICTEF = ?, PERFICOBS = ?, PERFICAUS = ?, PERFICAFH = GETDATE(), PERFICAIP = ? WHERE PERFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val09, $val11, $val12, $val13, $val15, $val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/400/reseteo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['persona_user'];
        $val02      = password_hash($request->getParsedBody()['persona_contrasenha'], PASSWORD_DEFAULT);
        $val03      = $request->getParsedBody()['persona_email'];
        $aud01      = $request->getParsedBody()['persona_usuario'];
        $aud02      = $request->getParsedBody()['persona_fecha_hora'];
        $aud03      = $request->getParsedBody()['persona_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($aud01) && isset($aud02) && isset($aud03)) {
            $sql00  = "UPDATE [adm].[PERFIC] SET PERFICCON = ?, PERFICAUS = ?, PERFICAFH = GETDATE(), PERFICAIP = ? WHERE PERFICCOD = ? AND PERFICUSE = ? AND PERFICMAI = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val02, $aud01, $aud03, $val00, $val01, $val03]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success. Se realizo con éxito el cambio de contraseña', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/601/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['lesion_codigo'];
        $val02      = $request->getParsedBody()['tipo_lesion_examen1_codigo'];
        $val03      = $request->getParsedBody()['tipo_lesion_examen2_codigo'];
        $val04      = $request->getParsedBody()['tipo_lesion_examen3_codigo'];
        $val05      = $request->getParsedBody()['tipo_lesion_examen4_codigo'];
        $val06      = $request->getParsedBody()['tipo_lesion_examen5_codigo'];
        $val07      = $request->getParsedBody()['lesion_fecha_retorno'];
        $val08      = $request->getParsedBody()['lesion_cirugia'];
        $val09      = $request->getParsedBody()['tipo_diagnostico_retorno_codigo'];
        $val10      = $request->getParsedBody()['diagnostico_retorno_observacion'];
        $val11      = $request->getParsedBody()['tipo_estado_codigo'];
        $val12      = $request->getParsedBody()['diagnostico_retorno_tratamiento'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01)) {
            $sql00  = "UPDATE [lesion].[LESFIC] SET LESFICESC = ?, LESFICEX1 = ?, LESFICEX2 = ?, LESFICEX3 = ?,  LESFICEX4 = ?, LESFICEX5 = ?, LESFICFER = ?, LESFICCIR = ?, LESFICDIR = ?, LESFICOBR = ?, LESFICTRR = ?, LESFICAUS = ?, LESFICAFH = GETDATE(), LESFICAIP = ? WHERE LESFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val11, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val12, $aud01, $aud03, $val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/602/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['lesion_codigo'];
        $val02      = $request->getParsedBody()['tipo_estado_codigo'];
        $val03      = $request->getParsedBody()['lesion_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01)) {
            $sql00  = "UPDATE [lesion].[LESFIC] SET LESFICESC = ?, LESFICOBS = ?, LESFICAUS = ?, LESFICAFH = GETDATE(), LESFICAIP = ? WHERE LESFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val02, $val03, $aud01, $aud03, $val00]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/801/examen/prueba/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['examen_laboratorio_fecha_recepcion'];
        $val03      = $request->getParsedBody()['examen_laboratorio_resultado'];
        $val04      = $request->getParsedBody()['examen_laboratorio_adjunto'];
        $val05      = $request->getParsedBody()['examen_laboratorio_cuarentena'];
        $val06      = $request->getParsedBody()['examen_laboratorio_test'];
        $val07      = $request->getParsedBody()['examen_laboratorio_fecha_aislamiento'];
        $val08      = $request->getParsedBody()['examen_laboratorio_fecha_finaliza'];
        $val09      = $request->getParsedBody()['examen_laboratorio_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        $pos01      = strpos($val04, '_');
        $res01      = substr($val04, ($pos01+1));
        $pos02      = strpos($res01, '.');
        $res02      = substr($res01, 0, ($pos02));

        if ($val00 == $res02) {
            if (isset($val00)) {
                if ($val03 == 'SI'){
                    $sql00  = "UPDATE [exa].[EXAFIC] SET EXAFICEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOCOVID19ESTADO' AND DOMFICPAR = ?), EXAFICLFR = ?, EXAFICLRE = ?, EXAFICLAD = ?, EXAFICLIC = ?, EXAFICLNT = ?, EXAFICLFA = ?, EXAFICLFF = ?, EXAFICLOB = ?, EXAFICAUS = ?, EXAFICAFH = GETDATE(), EXAFICAIP = ? WHERE EXAFICCOD = ?";
                } else {
                    $sql00  = "UPDATE [exa].[EXAFIC] SET EXAFICEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOCOVID19ESTADO' AND DOMFICPAR = ?), EXAFICLFR = ?, EXAFICLRE = ?, EXAFICLAD = ?, EXAFICLOB = ?, EXAFICAUS = ?, EXAFICAFH = GETDATE(), EXAFICAIP = ? WHERE EXAFICCOD = ?";
                }

                try {
                    $connMSSQL  = getConnectionMSSQLv2();
                    $stmtMSSQL  = $connMSSQL->prepare($sql00);

                    if ($val03 == 'SI'){
                        $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $aud01, $aud03, $val00]);
                    } else {
                        $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val09, $aud01, $aud03, $val00]);
                    }

                    header("Content-Type: application/json; charset=utf-8");
                    $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                    $stmtMSSQL->closeCursor();
                    $stmtMSSQL = null;
                } catch (PDOException $e) {
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, el archivo adjunto tuvo inconveniente.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/801/examen/anular/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['examen_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00)) {
            $sql00  = "UPDATE [exa].[EXAFIC] SET EXAFICEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOCOVID19ESTADO' AND DOMFICPAR = ?), EXAFICFE3 = GETDATE(), EXAFICOBS = ?, EXAFICAUS = ?, EXAFICAFH = GETDATE(), EXAFICAIP = ? WHERE EXAFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $aud01, $aud03, $val00]);
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/801/examen/test/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo'); 
        $val01      = $request->getParsedBody()['tipo_test_parametro'];
        $val02      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_test_dominio'])));
        $val03      = $request->getParsedBody()['examen_codigo'];
        $val04      = $request->getParsedBody()['examen_test_valor'];
        $val05      = $request->getParsedBody()['examen_test_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
                $sql00  = "UPDATE [exa].[EXATES] SET EXATESTTC = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = ? AND DOMFICPAR = ?), EXATESEXC = ?, EXATESVAL = ?, EXATESOBS = ?, EXATESAUS = ?, EXATESAFH = GETDATE(), EXATESAIP = ? WHERE EXATESCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val02, $val01, $val03, $val04, $val05, $aud01, $aud03, $val00]); 

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

/*MODULO PERSONA*/
    $app->put('/v2/200/competicion/medico/{competicion}/{persona}', function($request) {//20201117
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('competicion');
        $val02      = $request->getAttribute('persona');
        $val03      = $request->getParsedBody()['tipo_modulo_codigo'];
        $val04      = $request->getParsedBody()['competicion_persona_observacion'];
        $val05      = $request->getParsedBody()['competicion_persona_rts'];
        
        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "UPDATE [adm].[PERCOM] SET PERCOMTMC = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'USUARIOMODULO' AND DOMFICPAR = ?), PERCOMOBS = ?, PERCOMAUS = ?, PERCOMAFH = GETDATE(), PERCOMAIP = ?, PERCOMRTS = ? WHERE PERCOMCOC = ? AND PERCOMPEC = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val03, $val04, $aud01, $aud03, $val05, $val01, $val02]); 
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val01.', '.$val02), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });


/*MODULO NOTIFICACION*/
    $app->put('/v2/802/notificacion/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo'); 
        $val00_1    = $request->getParsedBody()['tipo_accion_codigo'];
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

        if (isset($val00) && isset($val00_1)) {
            $sql00  = "";

            switch ($val00_1) {
                case 1:
                    $sql00  =   "UPDATE [adm].[NOTFIC] SET NOTFICEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR = ?), NOTFICORD = ?, NOTFICCOC = ?, NOTFICTIT = ?, NOTFICDES = ?, NOTFICFED = ?, NOTFICFEH = ?, NOTFICDIN = ?, NOTFICDFI = ?,NOTFICOBS = ?, NOTFICAUS = ?, NOTFICAFH = GETDATE(), NOTFICAIP = ? WHERE NOTFICCOD = ?";
                break;

                case 2;
                    $sql00  =   "UPDATE adm.NOTFIC SET NOTFICTIT = ?, NOTFICDES = ?, NOTFICAUS = ?, NOTFICAFH = GETDATE(), NOTFICAIP = ? WHERE NOTFICTNC = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONTIPO' AND DOMFICPAR = 1) AND NOTFICCOD = ?";
                break;

                case 3;
                    $sql00  =   "UPDATE adm.NOTFIC SET NOTFICEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR = ?), NOTFICAUS = ?, NOTFICAFH = GETDATE(), NOTFICAIP = ?  WHERE NOTFICCOD = ?";
                break;
            }   
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                switch ($val00_1) {
                    case 1:
                        $stmtMSSQL->execute([$val01, $val02, $val05, $val07, $val08, $val09, $val10, $val12, $val13, $val14, $aud01, $aud03, $val00]);
                    break;

                    case 2:
                        $stmtMSSQL->execute([$val07, $val08, $aud01, $aud03, $val00]);
                    break;

                    case 3:
                        $stmtMSSQL->execute([$val01, $aud01, $aud03, $val00]);
                    break;
                }
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/802/notificacionequipo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo'); 
        $val00_1    = $request->getParsedBody()['tipo_accion_codigo'];
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['notificacion_equipo_orden'];
        $val03      = $request->getParsedBody()['notificacion_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['notificacion_equipo_fecha_carga'];
        $val06      = $request->getParsedBody()['notificacion_equipo_observacion'];

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val00) && isset($val00_1)) {
            $sql00  = "";

            switch ($val00_1) {
                case 1:
                    $sql00  = "UPDATE [adm].[NOTEQU] SET NOTEQUEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR = ?), NOTEQUORD = ?, NOTEQUNOC = ?, NOTEQUEQC = ?, NOTEQUOBS = ?, NOTEQUAUS = ?, NOTEQUAFH = GETDATE(), NOTEQUAIP = ? WHERE NOTEQUCOD = ?";
                    break;

                /*case 2;
                    
                break;*/
            }   
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                switch ($val00_1) {
                    case 1:
                        $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val06, $aud01, $aud03, $val00]);
                    break;

                    /*case 2:
                        
                    break;*/
                }
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/802/notificacionmensaje/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00      = $request->getAttribute('codigo'); 
        $val00_1    = $request->getParsedBody()['tipo_accion_codigo'];
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['notificacion_mensaje_orden'];
        $val03      = $request->getParsedBody()['notificacion_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['persona_codigo'];
        $val06      = $request->getParsedBody()['notificacion_mensaje_encuentro'];
        $val07      = $request->getParsedBody()['notificacion_mensaje_descripcion'];
        $val08      = $request->getParsedBody()['notificacion_mensaje_observacion'];

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val00) && isset($val00_1)) {
            $sql00  = "";

            switch ($val00_1) {
                case 1:
                    $sql00  = "UPDATE [adm].[NOTMEN] SET NOTMENEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONMENSAJEESTADO' AND DOMFICPAR = ?), NOTMENORD = ?, NOTMENENC = ?, NOTMENMEC = ?, NOTMENNOC = ?, NOTEQUEQC = ?, NOTMENMEN = ?, NOTMENOBS = ?, NOTMENAUS = ?, NOTMENAFH = GETDATE(), NOTMENAIP = ? WHERE NOTMENCOD = ?";
                    break;

                case 2;
                    $sql00  = "UPDATE [adm].[NOTMEN] SET NOTMENEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONMENSAJEESTADO' AND DOMFICPAR = ?), NOTMENAUS = ?, NOTMENAFH = GETDATE(), NOTMENAIP = ? WHERE NOTMENCOD = ?";
                    break;
            }   
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                switch ($val00_1) {
                    case 1:
                        $stmtMSSQL->execute([$val01, $val02, $val06, $val05, $val03, $val04, $val07, $val08, $aud01, $aud03, $val00]);
                    break;

                    case 2:
                        $stmtMSSQL->execute([$val01, $aud01, $aud03, $val00]);
                        break;
                }
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });




