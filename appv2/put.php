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

        if (isset($val00)) {
            if ($val03 == 'SI'){
                $sql00  = "UPDATE [exa].[EXAFIC] SET EXAFICEST = ?, EXAFICLFR = ?, EXAFICLRE = ?, EXAFICLAD = ?, EXAFICLIC = ?, EXAFICLNT = ?, EXAFICLFA = ?, EXAFICLFF = ?, EXAFICLOB = ?, EXAFICAUS = ?, EXAFICAFH = GETDATE(), EXAFICAIP = ? WHERE EXAFICCOD = ?";
            } else {
                $sql00  = "UPDATE [exa].[EXAFIC] SET EXAFICEST = ?, EXAFICLFR = ?, EXAFICLRE = ?, EXAFICLAD = ?, EXAFICLOB = ?, EXAFICAUS = ?, EXAFICAFH = GETDATE(), EXAFICAIP = ? WHERE EXAFICCOD = ?";
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

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/801/examen/test/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute()('codigo');
        $val01      = $request->getParsedBody()['tipo_test_codigo'];
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