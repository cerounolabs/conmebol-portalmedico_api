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

        if (isset($val01) && isset($val04) && isset($val05) && isset($val06) && isset($val08) && isset($aud01) && isset($aud02) && isset($aud03)) {
            $sql00  = "INSERT INTO [adm].[DOMFIC] (DOMFICEST, DOMFICORD, DOMFICPAR, DOMFICNOI, DOMFICNOC, DOMFICNOP, DOMFICPAT, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $aud01, $aud03]); 
                
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

    $app->post('/v2/000/localidadpais', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['localidad_pais_orden'];
        $val03      = trim(strtoupper(strtolower($request->getParsedBody()['localidad_pais_nombre'])));
        $val04      = trim(strtolower($request->getParsedBody()['localidad_pais_path']));
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['localidad_pais_iso_char2'])));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['localidad_pais_iso_char3'])));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['localidad_pais_iso_num3'])));
        $val08      = trim($request->getParsedBody()['localidad_pais_observacion']);
        $val09      = trim($request->getParsedBody()['localidad_pais_alta_usuario']);
        $val10      = $request->getParsedBody()['localidad_pais_alta_fecha_hora'];
        $val11      = trim($request->getParsedBody()['localidad_pais_alta_ip']);

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if ($val02  == 0 && $val02 == null){
            $val02  = 999;
        }

        if (isset($val01) && isset($val03)) {
            $sql00  = "INSERT INTO [adm].[LOCPAI] (                                                       LOCPAIEST,  LOCPAIORD, LOCPAINOM, LOCPAIPAT, LOCPAIIC2, LOCPAIIC3, LOCPAIIN3, LOCPAIOBS, LOCPAICUS, LOCPAICFH, LOCPAICIP, LOCPAIAUS, LOCPAIAFH, LOCPAIAIP) 
            VALUES ((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'ADMLOCALIDADPAISESTADO' AND DOMFICPAR = ?),          ?,         ?,         ?,         ?,        ?,         ?,          ?,         ?,  GETDATE(),        ?,         ?, GETDATE(),         ?)";

            $sql01  = "SELECT MAX(LOCPAICOD) AS localidad_pais_codigo FROM [adm].[LOCPAI]";

            try {
                $connMSSQL      = getConnectionMSSQLv2();
                $stmtMSSQL      = $connMSSQL->prepare($sql00);
                $stmtMSSQL01    = $connMSSQL->prepare($sql01);

                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val11, $aud01, $aud03]); 
                $stmtMSSQL01->execute();

                $row_mssql01    =   $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo         =   $row_mssql01['localidad_pais_codigo'];
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL      = null;
                $stmtMSSQL01    = null;
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

    $app->post('/v2/000/localidadciudad', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['localidad_pais_codigo'];
        $val03      = $request->getParsedBody()['localidad_ciudad_orden'];
        $val04      = $request->getParsedBody()['localidad_ciudad_parametro'];
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['localidad_ciudad_nombre'])));
        $val06      = trim($request->getParsedBody()['localidad_ciudad_observacion']);
        $val07      = trim($request->getParsedBody()['localidad_ciudad_alta_usuario']);
        $val08      = $request->getParsedBody()['localidad_ciudad_alta_fecha_hora'];
        $val09      = trim($request->getParsedBody()['localidad_ciudad_alta_ip']);

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if ($val03  == 0 && $val03 == null){
            $val03  = 999;
        }

        if (isset($val01) && isset($val02) && isset($val04) && isset($val05)) {
            $sql00  = "INSERT INTO [adm].[LOCCIU](                                                         LOCCIUEST, LOCCIUPAC,  LOCCIUORD,  LOCCIUPAR, LOCCIUNOM, LOCCIUOBS, LOCCIUCUS, LOCCIUCFH, LOCCIUCIP, LOCCIUAUS, LOCCIUAFH, LOCCIUAIP) 
            VALUES((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'ADMLOCALIDADCIUDADESTADO' AND DOMFICPAR = ?),         ?,          ?,         ?,         ?,         ?,         ?,  GETDATE(),       ?,          ?, GETDATE(),        ?)";

            $sql01  = "SELECT MAX(LOCCIUCOD) AS localidad_ciudad_codigo FROM [adm].[LOCCIU]";

            try {
                $connMSSQL      = getConnectionMSSQLv2();
                $stmtMSSQL      = $connMSSQL->prepare($sql00);
                $stmtMSSQL01    = $connMSSQL->prepare($sql01);

                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val09, $aud01, $aud03]); 
                $stmtMSSQL01->execute();

                $row_mssql01    =   $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo         =   $row_mssql01['localidad_ciudad_codigo'];
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL      = null;
                $stmtMSSQL01    = null;
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
        $val03      = $request->getParsedBody()['tipo_modulo_codigo'];
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
            $sql00  = "SELECT EXAFICCOD AS examen_codigo FROM exa.EXAFIC a WHERE a.EXAFICCOC = ? AND a.EXAFICENC = ? AND a.EXAFICEQC = ? AND a.EXAFICPEC = ? AND a.EXAFICEST IN (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOCOVID19ESTADO' AND DOMFICPAR <> 3 AND DOMFICPAR <> 6) AND a.EXAFICTEC = (SELECT  DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOTIPO' AND DOMFICPAR = ?) AND EXAFICAEC = ?";
            $sql01  = "INSERT INTO [exa].[EXAFIC] (EXAFICEST, EXAFICTEC, EXAFICCOC, EXAFICENC, EXAFICEQC, EXAFICPEC, EXAFICAEC, EXAFICFE1, EXAFICACA, EXAFICMCA, EXAFICJCO, EXAFICJPO, EXAFICJCA, EXAFICLNO, EXAFICLFE, EXAFICOBS, EXAFICAUS, EXAFICAFH, EXAFICAIP) VALUES ((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOCOVID19ESTADO' AND DOMFICPAR = ?), (SELECT  DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOTIPO' AND DOMFICPAR = ?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql02  = "SELECT MAX(EXAFICCOD) AS examen_codigo FROM [exa].[EXAFIC]";
            $sql03  = "UPDATE [exa].[EXAFIC] SET EXAFICBAN = 'S' WHERE EXAFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val03, $val04, $val05, $val06, $val02, $val07]);
                $row_mssql00= $stmtMSSQL00->fetch(PDO::FETCH_ASSOC);
                $codAux     = $row_mssql00['examen_codigo'];

                if (empty($codAux)){
                    $stmtMSSQL01= $connMSSQL->prepare($sql01);
                    $stmtMSSQL01->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $aud01, $aud03]); 
                    
                    $stmtMSSQL02= $connMSSQL->prepare($sql02);
                    $stmtMSSQL02->execute();
                    $row_mssql02= $stmtMSSQL02->fetch(PDO::FETCH_ASSOC);
                    $codigo     = $row_mssql02['examen_codigo'];

                    if ($val07 != 0){
                        $stmtMSSQL03= $connMSSQL->prepare($sql03);
                        $stmtMSSQL03->execute([$val07]);
                    }

                    header("Content-Type: application/json; charset=utf-8");
                    $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
    
                    $stmtMSSQL00->closeCursor();
                    $stmtMSSQL01->closeCursor();
                    $stmtMSSQL02->closeCursor();
    
                    $stmtMSSQL00 = null;
                    $stmtMSSQL01 = null;
                    $stmtMSSQL02 = null;

                    if ($val07 != 0){
                        $stmtMSSQL03->closeCursor();
                        $stmtMSSQL03 = null;
                    }
                } else {
                    header("Content-Type: application/json; charset=utf-8");
                    $json       = json_encode(array('code' => 204, 'status' => 'error', 'message' => 'ERROR Ya existe el registro, favor verificar', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
    
                    $stmtMSSQL00->closeCursor();
    
                    $stmtMSSQL00 = null;
                }
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
            $sql00  = "INSERT INTO [exa].[EXATES] (EXATESTTC, EXATESEXC, EXATESVAL, EXATESOBS, EXATESAUS, EXATESAFH, EXATESAIP) VALUES ((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = ? AND DOMFICPAR = ?), ?, ?, ?, ?, GETDATE(), ?)";

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
        $val08      = str_replace('.', '', $val08);
        $val08      = str_replace(',', '', $val08);
        $val08      = str_replace(' ', '', $val08);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val07) && isset($val08) && !empty($val08)) {
            $sql00  = "SELECT personFifaId AS codigo FROM [comet].[persons] WHERE personFifaId = ?";
            $sql01  = "UPDATE comet.persons SET
                        internationalFirstName = ?,
                        internationalLastName = ?,
                        firstName = ?,
                        lastName = ?,
                        dateOfBirth = ?,
                        gender = ?,
                        playerPosition = ?,
                        personType = ?,
                        lastUpdate = GETDATE()
                        WHERE documentType = ? AND documentNumber = ?";
            $sql02  = "INSERT INTO [comet].[persons] (personFifaId, internationalFirstName, internationalLastName, firstName, lastName, dateOfBirth, gender, playerPosition, documentType, documentNumber, personType, lastUpdate) SELECT ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE() WHERE NOT EXISTS(SELECT * FROM comet.persons WHERE documentType = ? AND documentNumber = ?)";
            
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

                $stmtMSSQL01->execute([$val02, $val03, $val02, $val03, $val05, $val04, $val06, $val01, $val07, $val08]);
                $stmtMSSQL02->execute([$val00, $val02, $val03, $val02, $val03, $val05, $val04, $val06, $val07, $val08, $val01, $val07, $val08]);
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

/*MODULO LESION*/
    $app->post('/v2/600/lesion/prueba', function($request) {
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

    $app->post('/v2/600/lesion/concusion', function($request) {
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
/*MODULO LESION*/

/*MODULO NOTIFICACIONES*/
    $app->post('/v2/802/notificacion', function($request) {
        require __DIR__.'/../src/connect.php';

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

        if (isset($val01) && isset($val03)  && isset($val05)) {
            $sql00  = "INSERT INTO [adm].[NOTFIC](                                                                                NOTFICEST,                                                                                NOTFICTNC,                                                                                 NOTFICTTC, NOTFICCOC, NOTFICPAC, NOTFICTIT,   NOTFICDES, NOTFICFED, NOTFICFEH,                           NOTFICFCA, NOTFICDIN, NOTFICDFI, NOTFICOBS, NOTFICAUS, NOTFICAFH, NOTFICAIP) 
                                        SELECT  (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR = ?), (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONTIPO' AND DOMFICPAR = ?), (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOTIPO' AND DOMFICPAR = ?),        ?,         ?,          ?,           ?,          ?,        ?, CONVERT(varchar(10), GETDATE(), 23),         ?,         ?,        ?,         ?, GETDATE(),         ?                                                                                                  
                            WHERE NOT EXISTS(SELECT * FROM [adm].[NOTFIC] WHERE NOTFICTTC = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOTIPO' AND DOMFICPAR = ?) AND NOTFICFCA = CONVERT(varchar(10), GETDATE(), 23) AND NOTFICTIT = ? AND NOTFICDES = ? AND NOTFICCOC = ?)";
            $sql01  = "SELECT MAX(NOTFICCOD) AS notificacion_codigo FROM [adm].[NOTFIC]";
            
            try {
                $connMSSQL      =   getConnectionMSSQLv2();
                $stmtMSSQL      =   $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val12, $val13, $val14, $aud01, $aud03, $val04, $val07, $val08, $val05]); 

                $stmtMSSQL01    =   $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                
                $row_mssql01    =   $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo         =   $row_mssql01['notificacion_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL01->closeCursor();
                
                $stmtMSSQL  = null;
                $stmtMSSQL01= null;
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
        $val03      = $request->getParsedBody()['notificacion_codigo'];
        $val04      = $request->getParsedBody()['equipo_codigo'];
        $val05      = $request->getParsedBody()['notificacion_equipo_fecha_carga'];
        $val06      = $request->getParsedBody()['notificacion_equipo_observacion'];

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val01) && isset($val03) && isset($val04)) {
            $sql00  = "INSERT INTO [adm].[NOTEQU](                                                       NOTEQUEST, NOTEQUNOC, NOTEQUEQC,                          NOTEQUFCA, NOTEQUOBS, NOTEQUAUS, NOTEQUAFH, NOTEQUAIP) 
            SELECT (SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR = ?),         ?,         ?, CONVERT(varchar(10), GETDATE(), 23),        ?,         ?,  GETDATE(),       ? WHERE NOT EXISTS (SELECT * FROM [adm].[NOTEQU] WHERE NOTEQUEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'NOTIFICACIONESTADO' AND DOMFICPAR = ?) AND NOTEQUNOC = ? AND NOTEQUEQC = ?)";
            $sql01  = "SELECT MAX(NOTEQUCOD) AS notificacion_equipo_codigo FROM [adm].[NOTEQU]";

            try {
                $connMSSQL      =   getConnectionMSSQLv2();
                $stmtMSSQL      =   $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val03, $val04, $val06, $aud01, $aud03, $val01, $val03, $val04]); 

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

/*MODULO VACUNACION*/

    $app->post('/v2/700/vacuna', function($request) {
        require __DIR__.'/../src/connect.php';

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

        if($val03    == 0 || $val03  == null){
            $val03   = 999;
        }

        if (isset($val01) && isset($val02)  && isset($val04) && isset($val05)) {
            $sql00  = "INSERT INTO [vac].[VACFIC](                                                       VACFICEST, VACFICPAC, VACFICORD, VACFICNOM, VACFICDOS, VACFICOBS, VACFICCUS, VACFICCFH, VACFICCIP, VACFICAUS, VACFICAFH, VACFICAIP) 
                        VALUES((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'VACVACUNAESTADO' AND DOMFICPAR = ?),         ?,         ?,        ?,          ?,         ?,         ?, GETDATE(),         ?,         ?, GETDATE(), ?)";
                
            $sql01  = "SELECT MAX(VACFICCOD) AS vacuna_codigo FROM [vac].[VACFIC]";
            
            try {
                $connMSSQL      =   getConnectionMSSQLv2();
                $stmtMSSQL      =   $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val09, $aud01, $aud03]); 

                $stmtMSSQL01    =   $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                
                $row_mssql01    =   $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo         =   $row_mssql01['vacuna_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL01->closeCursor();
                
                $stmtMSSQL  = null;
                $stmtMSSQL01= null;
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

    $app->post('/v2/700/vacunacabecera', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['competicion_codigo'];
        $val03      = $request->getParsedBody()['equipo_codigo'];
        $val04      = $request->getParsedBody()['persona_codigo'];
        $val05      = $request->getParsedBody()['vacuna_codigo'];
        $val06      = $request->getParsedBody()['vacuna_cabecera_encuentro_codigo'];
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

        if ($val07 == '' || $val07 != 'SI') {
            $val07 = 'NO';
        }

        if ($val09 == '' || $val09 != 'SI') {
            $val09 = 'NO';
        }

        if (isset($val01) && isset($val02)  && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val09)) {
            
            $sql00  = "SELECT 
                VACFICCOD             AS          vacuna_codigo, 
                VACFICORD             AS          vacuna_orden, 
                VACFICNOM             AS          vacuna_nombre, 
                VACFICDOS             AS          vacuna_cantidad_dosis, 
                VACFICOBS             AS          vacuna_observacion
                
                FROM [vac].[VACFIC] 
                WHERE VACFICCOD = ?";
            
            /*$sql01  = "INSERT INTO [vac].[VACVCA](                                                      VACVCAEST, VACVCACOC, VACVCAENC, VACVCAEQC, VACVCAPEC, VACVCAVAC, VACVCAPOS, VACVCAFEC, VACVCADAP, VACVCAOBS, VACVCACUS, VACVCACFH, VACVCACIP, VACVCAAUS, VACVCAAFH, VACVCAAIP) 
            VALUES((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'VACVACCABECERAESTADO' AND DOMFICPAR =  ?),         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?,         ?, GETDATE(),         ?)";
*/
            $sql02  = "SELECT MAX(VACVCACOD) AS vacuna_cabecera_codigo FROM [vac].[VACVCA]";

            $sql03  = "INSERT INTO [vac].[VACVDE](                                                     VACVDEEST,                                                                                    VACVDETDC,                                               VACVDECIC, VACVDECAC, VACVDEORD,  VACVDEOBS, VACVDECUS, VACVDECFH, VACVDECIP, VACVDEAUS, VACVDEAFH, VACVDEAIP) 
            VALUES((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'VACVACDETALLEESTADO' AND DOMFICPAR = ? ), (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'VACVACDETALLEDOSIS' AND DOMFICPAR = ? ), (SELECT LOCCIUCOD FROM adm.LOCCIU WHERE LOCCIUPAR = 0),          ?,        ?,      ''    ,         ?,  GETDATE(),        ?,         ?, GETDATE(),      ?)";
                                            

            
            try {
                $connMSSQL      =   getConnectionMSSQLv2();
                $stmtMSSQL      =   $connMSSQL->prepare($sql00);
                //$stmtMSSQL01    =   $connMSSQL->prepare($sql01);
                $stmtMSSQL02     =   $connMSSQL->prepare($sql02);
                $stmtMSSQL03    =   $connMSSQL->prepare($sql03);

                $stmtMSSQL->execute([$val05]);
                $row_mssql00    =   $stmtMSSQL->fetch(PDO::FETCH_ASSOC);
                $VACFICDOS      =   $row_mssql00['vacuna_cantidad_dosis'] + 1;

               // $stmtMSSQL01->execute([$val01, $val02, $val06, $val03, $val04, $val05, $val07, $val08, $val09, $val10, $val11, $val13, $aud01, $aud03]);
               $stmtMSSQL02->execute();
               $row_mssql02     =   $stmtMSSQL02->fetch(PDO::FETCH_ASSOC);
                $codigo         =   $row_mssql02['vacuna_cabecera_codigo'];

                for ($i=0; $i < $VACFICDOS; $i++) { 
                    $stmtMSSQL03->execute([$val01, ($i+1), $codigo , ($i+1), $val11, $val13, $aud01, $aud03]);
                }
                
                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                //$stmtMSSQL01->closeCursor();
                $stmtMSSQL02->closeCursor();
                $stmtMSSQL03->closeCursor();
                
                $stmtMSSQL  = null;
                //$stmtMSSQL01= null;
                $stmtMSSQL02= null;
                $stmtMSSQL03= null;
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

    $app->post('/v2/700/vacunadetalle', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['tipo_dosis_parametro'];
        $val03      = $request->getParsedBody()['localidad_ciudad_codigo'];
        $val04      = $request->getParsedBody()['vacuna_cabecera_codigo'];
        $val05      = $request->getParsedBody()['vacuna_detalle_orden'];
        $val06      = trim($request->getParsedBody()['vacuna_detalle_nombre']);
        $val07      = trim($request->getParsedBody()['vacuna_detalle_lugar']);
        $val08      = trim($request->getParsedBody()['vacuna_detalle_adjunto']);
        $val09      = trim($request->getParsedBody()['vacuna_detalle_observacion']);
        $val10      = trim($request->getParsedBody()['vacuna_detalle_alta_usuario']);
        $val11      = $request->getParsedBody()['vacuna_detalle_alta_fecha_hora'];
        $val12      = trim($request->getParsedBody()['vacuna_detalle_alta_ip']);     

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim($request->getParsedBody()['auditoria_ip']);

        if($val05    == 0 || $val05  == null){
            $val05   = 999;
        }

        if (isset($val01) && isset($val02)  && isset($val03) && isset($val04)) {

            $sql00  = "SELECT VACVCAVAC AS vacuna_codigo FROM [vac].[VACVCA] WHERE VACVCACOD = ?";

            $sql01  = "SELECT VACFICDOS AS vacuna_cantidad_dosis FROM [vac].[VACFIC] WHERE VACFICCOD = ?";

            $sql02  = "INSERT INTO [vac].[VACVDE](                                                    VACVDEEST,                                                                                   VACVDETDC, VACVDECIC, VACVDECAC, VACVDEORD,  VACVDENOM, VACVDELUG, VACVDEADJ, VACVDEOBS, VACVDECUS, VACVDECFH, VACVDECIP, VACVDEAUS, VACVDEAFH, VACVDEAIP) 
            SELECT (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'VACVACDETALLEESTADO' AND DOMFICPAR = ?), (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'VACVACDETALLEDOSIS' AND DOMFICPAR = ?),         ?,         ?,         ?,          ?,         ?,         ?,         ?,          ?, GETDATE(),        ?,         ?, GETDATE(),        ?
            WHERE NOT EXISTS (SELECT *FROM [vac].[VACVDE] WHERE VACVDETDC = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'VACVACDETALLEDOSIS' AND DOMFICPAR = ?) AND VACVDECAC = ?)";                                                                            

            $sql03  = "SELECT MAX(VACVDECOD) AS vacuna_codigo FROM [vac].[VACVDE]";

            
            try {
                $connMSSQL      =   getConnectionMSSQLv2();
                $stmtMSSQL      =   $connMSSQL->prepare($sql00);
                $row_mssql      =   $stmtMSSQL->fetch(PDO::FETCH_ASSOC);
                $VACVCAVAC      =   $row_mssql['vacuna_codigo'];
                $stmtMSSQL->execute([$val04]);
                //$stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val12, $aud01, $aud03]); 

                $stmtMSSQL01    =   $connMSSQL->prepare($sql01);
                $row_mssql01    =   $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $VACFICDOS      =   $row_mssql01['vacuna_cantidad_dosis']+1;
                $stmtMSSQL01->execute([$VACVCAVAC]);

                $stmtMSSQL03    =   $connMSSQL->prepare($sql03);
                $stmtMSSQL03->execute();
                $row_mssql03    =   $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);
                $codigo         =   $row_mssql03['vacuna_detalle_codigo'];

                for ($i=0; $i < $VACFICDOS; $i++) { 
                    $stmtMSSQL02->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val12, $val02, $val04, $aud01, $aud03]);
                }

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL->closeCursor();
                $stmtMSSQL01->closeCursor();
                $stmtMSSQL02->closeCursor();
                $stmtMSSQL03->closeCursor();
                
                $stmtMSSQL  = null;
                $stmtMSSQL01= null;
                $stmtMSSQL02= null;
                $stmtMSSQL03= null;
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
