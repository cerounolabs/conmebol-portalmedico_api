<?php
    $app->get('/v1/000', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.DOMFICCOD         AS          tipo_codigo,
        a.DOMFICEST         AS          tipo_estado_codigo,
        a.DOMFICORD         AS          tipo_orden,
        a.DOMFICNOI         AS          tipo_nombre_ingles,
        a.DOMFICNOC         AS          tipo_nombre_castellano,
        a.DOMFICNOP         AS          tipo_nombre_portugues,
        a.DOMFICPAT         AS          tipo_path,
        a.DOMFICVAL         AS          tipo_dominio,
        a.DOMFICOBS         AS          tipo_observacion,
        a.DOMFICAUS         AS          tipo_usuario,
        a.DOMFICAFH         AS          tipo_fecha_hora,
        a.DOMFICAIP         AS          tipo_ip
        
        FROM [adm].[DOMFIC] a

        ORDER BY a.DOMFICVAL, a.DOMFICORD, a.DOMFICNOC";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                if ($rowMSSQL['tipo_estado_codigo'] === 'A') {
                    $tipo_estado_nombre = 'ACTIVO';
                } 
                
                if ($rowMSSQL['tipo_estado_codigo'] === 'I') {
                    $tipo_estado_nombre = 'INACTIVO';
                }

                $detalle    = array(
                    'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                    'tipo_estado_codigo'                => $rowMSSQL['tipo_estado_codigo'],
                    'tipo_estado_nombre'                => $tipo_estado_nombre,
                    'tipo_orden'                        => $rowMSSQL['tipo_orden'],
                    'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                    'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                    'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                    'tipo_path'                         => trim($rowMSSQL['tipo_path']),
                    'tipo_dominio'                      => trim($rowMSSQL['tipo_dominio']),
                    'tipo_observacion'                  => trim($rowMSSQL['tipo_observacion']),
                    'tipo_usuario'                      => trim($rowMSSQL['tipo_usuario']),
                    'tipo_fecha_hora'                   => $rowMSSQL['tipo_fecha_hora'],
                    'tipo_ip'                           => trim($rowMSSQL['tipo_ip'])
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_codigo'                       => '',
                    'tipo_estado_codigo'                => '',
                    'tipo_estado_nombre'                => '',
                    'tipo_orden'                        => '',
                    'tipo_nombre_ingles'                => '',
                    'tipo_nombre_castellano'            => '',
                    'tipo_nombre_portugues'             => '',
                    'tipo_path'                         => '',
                    'tipo_dominio'                      => '',
                    'tipo_observacion'                  => '',
                    'tipo_usuario'                      => '',
                    'tipo_fecha_hora'                   => '',
                    'tipo_ip'                           => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMFICCOD         AS          tipo_codigo,
            a.DOMFICEST         AS          tipo_estado_codigo,
            a.DOMFICORD         AS          tipo_orden,
            a.DOMFICNOI         AS          tipo_nombre_ingles,
            a.DOMFICNOC         AS          tipo_nombre_castellano,
            a.DOMFICNOP         AS          tipo_nombre_portugues,
            a.DOMFICPAT         AS          tipo_path,
            a.DOMFICVAL         AS          tipo_dominio,
            a.DOMFICOBS         AS          tipo_observacion,
            a.DOMFICAUS         AS          tipo_usuario,
            a.DOMFICAFH         AS          tipo_fecha_hora,
            a.DOMFICAIP         AS          tipo_ip
            
            FROM [adm].[DOMFIC] a
            
            WHERE a.DOMFICCOD = ?
            
            ORDER BY a.DOMFICVAL, a.DOMFICORD, a.DOMFICNOC";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['tipo_estado_codigo'] === 'A') {
                        $tipo_estado_nombre = 'ACTIVO';
                    } 
                    
                    if ($rowMSSQL['tipo_estado_codigo'] === 'I') {
                        $tipo_estado_nombre = 'INACTIVO';
                    }
    
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_estado_codigo'                => $rowMSSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'                => $tipo_estado_nombre,
                        'tipo_orden'                        => $rowMSSQL['tipo_orden'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_path'                         => trim($rowMSSQL['tipo_path']),
                        'tipo_dominio'                      => trim($rowMSSQL['tipo_dominio']),
                        'tipo_observacion'                  => trim($rowMSSQL['tipo_observacion']),
                        'tipo_usuario'                      => trim($rowMSSQL['tipo_usuario']),
                        'tipo_fecha_hora'                   => $rowMSSQL['tipo_fecha_hora'],
                        'tipo_ip'                           => trim($rowMSSQL['tipo_ip'])
                    );
    
                    $result[]   = $detalle;
                }
    
                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_estado_codigo'                => '',
                        'tipo_estado_nombre'                => '',
                        'tipo_orden'                        => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_path'                         => '',
                        'tipo_dominio'                      => '',
                        'tipo_observacion'                  => '',
                        'tipo_usuario'                      => '',
                        'tipo_fecha_hora'                   => '',
                        'tipo_ip'                           => ''
                    );
    
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMFICCOD         AS          tipo_codigo,
            a.DOMFICEST         AS          tipo_estado_codigo,
            a.DOMFICORD         AS          tipo_orden,
            a.DOMFICNOI         AS          tipo_nombre_ingles,
            a.DOMFICNOC         AS          tipo_nombre_castellano,
            a.DOMFICNOP         AS          tipo_nombre_portugues,
            a.DOMFICPAT         AS          tipo_path,
            a.DOMFICVAL         AS          tipo_dominio,
            a.DOMFICOBS         AS          tipo_observacion,
            a.DOMFICAUS         AS          tipo_usuario,
            a.DOMFICAFH         AS          tipo_fecha_hora,
            a.DOMFICAIP         AS          tipo_ip
            
            FROM [adm].[DOMFIC] a
            
            WHERE a.DOMFICVAL = ?

            ORDER BY a.DOMFICVAL, a.DOMFICORD, a.DOMFICNOC";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['tipo_estado_codigo'] === 'A') {
                        $tipo_estado_nombre = 'ACTIVO';
                    } 
                    
                    if ($rowMSSQL['tipo_estado_codigo'] === 'I') {
                        $tipo_estado_nombre = 'INACTIVO';
                    }
    
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_estado_codigo'                => $rowMSSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre'                => $tipo_estado_nombre,
                        'tipo_orden'                        => $rowMSSQL['tipo_orden'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_path'                         => trim($rowMSSQL['tipo_path']),
                        'tipo_dominio'                      => trim($rowMSSQL['tipo_dominio']),
                        'tipo_observacion'                  => trim($rowMSSQL['tipo_observacion']),
                        'tipo_usuario'                      => trim($rowMSSQL['tipo_usuario']),
                        'tipo_fecha_hora'                   => $rowMSSQL['tipo_fecha_hora'],
                        'tipo_ip'                           => trim($rowMSSQL['tipo_ip'])
                    );
    
                    $result[]   = $detalle;
                }
    
                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_estado_codigo'                => '',
                        'tipo_estado_nombre'                => '',
                        'tipo_orden'                        => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_path'                         => '',
                        'tipo_dominio'                      => '',
                        'tipo_observacion'                  => '',
                        'tipo_usuario'                      => '',
                        'tipo_fecha_hora'                   => '',
                        'tipo_ip'                           => ''
                    );
    
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/auditoria/{dominio}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('dominio');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMFICAIDD            AS          auditoria_codigo,
            a.DOMFICAMET            AS          auditoria_metodo,
            a.DOMFICAUSU            AS          auditoria_usuario,
            a.DOMFICAFEC            AS          auditoria_fecha_hora,
            a.DOMFICADIP            AS          auditoria_ip,
            a.DOMFICACOD            AS          auditoria_tipo_codigo,
            a.DOMFICAEST            AS          auditoria_tipo_estado_codigo,
            a.DOMFICAORD            AS          auditoria_tipo_orden,
            a.DOMFICANOI            AS          auditoria_tipo_nombre_ingles,
            a.DOMFICANOC            AS          auditoria_tipo_nombre_castellano,
            a.DOMFICANOP            AS          auditoria_tipo_nombre_portugues,
            a.DOMFICAPAT            AS          auditoria_tipo_path,
            a.DOMFICAVAL            AS          auditoria_tipo_dominio,
            a.DOMFICAOBS            AS          auditoria_tipo_observacion
            
            FROM [adm].[DOMFICA] a
            
            WHERE a.DOMFICAVAL = ?
            
            ORDER BY a.DOMFICAIDD DESC";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['auditoria_tipo_estado_codigo'] === 'A') {
                        $tipo_estado_nombre   = 'ACTIVO';
                    }

                    if ($rowMSSQL['auditoria_tipo_estado_codigo'] === 'I') {
                        $tipo_estado_nombre   = 'INACTIVO';
                    }

                    $detalle    = array(
                        'auditoria_codigo'                          => $rowMSSQL['auditoria_codigo'],
                        'auditoria_metodo'                          => trim($rowMSSQL['auditoria_metodo']),
                        'auditoria_usuario'                         => trim($rowMSSQL['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL['auditoria_ip']),
                        'auditoria_tipo_codigo'                     => $rowMSSQL['auditoria_tipo_codigo'],
                        'auditoria_tipo_estado_codigo'              => $rowMSSQL['auditoria_tipo_estado_codigo'],
                        'auditoria_tipo_estado_nombre'              => $tipo_estado_nombre,
                        'auditoria_tipo_orden'                      => $rowMSSQL['auditoria_tipo_orden'],
                        'auditoria_tipo_nombre_ingles'              => trim($rowMSSQL['auditoria_tipo_nombre_ingles']),
                        'auditoria_tipo_nombre_castellano'          => trim($rowMSSQL['auditoria_tipo_nombre_castellano']),
                        'auditoria_tipo_nombre_portugues'           => trim($rowMSSQL['auditoria_tipo_nombre_portugues']),
                        'auditoria_tipo_path'                       => trim($rowMSSQL['auditoria_tipo_path']),
                        'auditoria_tipo_dominio'                    => trim($rowMSSQL['auditoria_tipo_dominio']),
                        'auditoria_tipo_observacion'                => trim($rowMSSQL['auditoria_tipo_observacion'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'auditoria_codigo'                          => '',
                        'auditoria_metodo'                          => '',
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',
                        'auditoria_tipo_codigo'                     => '',
                        'auditoria_tipo_estado_codigo'              => '',
                        'auditoria_tipo_estado_nombre'              => '',
                        'auditoria_tipo_orden'                      => '',
                        'auditoria_tipo_nombre_ingles'              => '',
                        'auditoria_tipo_nombre_castellano'          => '',
                        'auditoria_tipo_nombre_portugues'           => '',
                        'auditoria_tipo_path'                       => '',
                        'auditoria_tipo_dominio'                    => '',
                        'auditoria_tipo_observacion'                => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.DOMSUBCOD         AS          tipo_sub_codigo,
        a.DOMSUBEST         AS          tipo_sub_estado_codigo,
        a.DOMSUBORD         AS          tipo_sub_orden,
        a.DOMSUBNOI         AS          tipo_sub_nombre_ingles,
        a.DOMSUBNOC         AS          tipo_sub_nombre_castellano,
        a.DOMSUBNOP         AS          tipo_sub_nombre_portugues,
        a.DOMSUBPAT         AS          tipo_sub_path,
        a.DOMSUBVAL         AS          tipo_sub_dominio,
        a.DOMSUBOBS         AS          tipo_sub_observacion,
        a.DOMSUBAUS         AS          tipo_sub_usuario,
        a.DOMSUBAFH         AS          tipo_sub_fecha_hora,
        a.DOMSUBAIP         AS          tipo_sub_ip,

        b.DOMFICCOD         AS          tipo_codigo,
        b.DOMFICNOI         AS          tipo_nombre_ingles,
        b.DOMFICNOC         AS          tipo_nombre_castellano,
        b.DOMFICNOP         AS          tipo_nombre_portugues       
        
        FROM [adm].[DOMSUB] a
        INNER JOIN [adm].[DOMFIC] b ON a.DOMSUBTIC = b.DOMFICCOD

        ORDER BY a.DOMSUBVAL, a.DOMSUBORD, b.DOMFICNOC, a.DOMSUBNOC";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                if ($rowMSSQL['tipo_sub_estado_codigo'] === 'A') {
                    $tipo_sub_estado_nombre = 'ACTIVO';
                } 
                
                if ($rowMSSQL['tipo_sub_estado_codigo'] === 'I') {
                    $tipo_sub_estado_nombre = 'INACTIVO';
                }

                $detalle    = array(
                    'tipo_sub_codigo'                       => $rowMSSQL['tipo_sub_codigo'],
                    'tipo_sub_estado_codigo'                => $rowMSSQL['tipo_sub_estado_codigo'],
                    'tipo_sub_estado_nombre'                => $tipo_sub_estado_nombre,
                    'tipo_codigo'                           => $rowMSSQL['tipo_codigo'],
                    'tipo_nombre_ingles'                    => trim($rowMSSQL['tipo_nombre_ingles']),
                    'tipo_nombre_castellano'                => trim($rowMSSQL['tipo_nombre_castellano']),
                    'tipo_nombre_portugues'                 => trim($rowMSSQL['tipo_nombre_portugues']),
                    'tipo_sub_orden'                        => $rowMSSQL['tipo_sub_orden'],
                    'tipo_sub_nombre_ingles'                => trim($rowMSSQL['tipo_sub_nombre_ingles']),
                    'tipo_sub_nombre_castellano'            => trim($rowMSSQL['tipo_sub_nombre_castellano']),
                    'tipo_sub_nombre_portugues'             => trim($rowMSSQL['tipo_sub_nombre_portugues']),
                    'tipo_sub_path'                         => trim($rowMSSQL['tipo_sub_path']),
                    'tipo_sub_dominio'                      => trim($rowMSSQL['tipo_sub_dominio']),
                    'tipo_sub_observacion'                  => trim($rowMSSQL['tipo_sub_observacion']),
                    'tipo_sub_usuario'                      => trim($rowMSSQL['tipo_sub_usuario']),
                    'tipo_sub_fecha_hora'                   => $rowMSSQL['tipo_sub_fecha_hora'],
                    'tipo_sub_ip'                           => trim($rowMSSQL['tipo_sub_ip'])
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_sub_codigo'                       => '',
                    'tipo_sub_estado_codigo'                => '',
                    'tipo_sub_estado_nombre'                => '',
                    'tipo_codigo'                           => '',
                    'tipo_nombre_ingles'                    => '',
                    'tipo_nombre_castellano'                => '',
                    'tipo_nombre_portugues'                 => '',
                    'tipo_sub_orden'                        => '',
                    'tipo_sub_nombre_ingles'                => '',
                    'tipo_sub_nombre_castellano'            => '',
                    'tipo_sub_nombre_portugues'             => '',
                    'tipo_sub_path'                         => '',
                    'tipo_sub_dominio'                      => '',
                    'tipo_sub_observacion'                  => '',
                    'tipo_sub_usuario'                      => '',
                    'tipo_sub_fecha_hora'                   => '',
                    'tipo_sub_ip'                           => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMSUBCOD         AS          tipo_sub_codigo,
            a.DOMSUBEST         AS          tipo_sub_estado_codigo,
            a.DOMSUBORD         AS          tipo_sub_orden,
            a.DOMSUBNOI         AS          tipo_sub_nombre_ingles,
            a.DOMSUBNOC         AS          tipo_sub_nombre_castellano,
            a.DOMSUBNOP         AS          tipo_sub_nombre_portugues,
            a.DOMSUBPAT         AS          tipo_sub_path,
            a.DOMSUBVAL         AS          tipo_sub_dominio,
            a.DOMSUBOBS         AS          tipo_sub_observacion,
            a.DOMSUBAUS         AS          tipo_sub_usuario,
            a.DOMSUBAFH         AS          tipo_sub_fecha_hora,
            a.DOMSUBAIP         AS          tipo_sub_ip,

            b.DOMFICCOD         AS          tipo_codigo,
            b.DOMFICNOI         AS          tipo_nombre_ingles,
            b.DOMFICNOC         AS          tipo_nombre_castellano,
            b.DOMFICNOP         AS          tipo_nombre_portugues
            
            FROM [adm].[DOMSUB] a
            INNER JOIN [adm].[DOMFIC] b ON a.DOMSUBTIC = b.DOMFICCOD

            WHERE a.DOMSUBCOD = ?

            ORDER BY a.DOMSUBVAL, a.DOMSUBORD, b.DOMFICNOC, a.DOMSUBNOC";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['tipo_sub_estado_codigo'] === 'A') {
                        $tipo_sub_estado_nombre = 'ACTIVO';
                    } 
                    
                    if ($rowMSSQL['tipo_sub_estado_codigo'] === 'I') {
                        $tipo_sub_estado_nombre = 'INACTIVO';
                    }
    
                    $detalle    = array(
                        'tipo_sub_codigo'                       => $rowMSSQL['tipo_sub_codigo'],
                        'tipo_sub_estado_codigo'                => $rowMSSQL['tipo_sub_estado_codigo'],
                        'tipo_sub_estado_nombre'                => $tipo_sub_estado_nombre,
                        'tipo_codigo'                           => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                    => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'                => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'                 => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_sub_orden'                        => $rowMSSQL['tipo_sub_orden'],
                        'tipo_sub_nombre_ingles'                => trim($rowMSSQL['tipo_sub_nombre_ingles']),
                        'tipo_sub_nombre_castellano'            => trim($rowMSSQL['tipo_sub_nombre_castellano']),
                        'tipo_sub_nombre_portugues'             => trim($rowMSSQL['tipo_sub_nombre_portugues']),
                        'tipo_sub_path'                         => trim($rowMSSQL['tipo_sub_path']),
                        'tipo_sub_dominio'                      => trim($rowMSSQL['tipo_sub_dominio']),
                        'tipo_sub_observacion'                  => trim($rowMSSQL['tipo_sub_observacion']),
                        'tipo_sub_usuario'                      => trim($rowMSSQL['tipo_sub_usuario']),
                        'tipo_sub_fecha_hora'                   => $rowMSSQL['tipo_sub_fecha_hora'],
                        'tipo_sub_ip'                           => trim($rowMSSQL['tipo_sub_ip'])
                    );
    
                    $result[]   = $detalle;
                }
    
                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_sub_codigo'                       => '',
                        'tipo_sub_estado_codigo'                => '',
                        'tipo_sub_estado_nombre'                => '',
                        'tipo_codigo'                           => '',
                        'tipo_nombre_ingles'                    => '',
                        'tipo_nombre_castellano'                => '',
                        'tipo_nombre_portugues'                 => '',
                        'tipo_sub_orden'                        => '',
                        'tipo_sub_nombre_ingles'                => '',
                        'tipo_sub_nombre_castellano'            => '',
                        'tipo_sub_nombre_portugues'             => '',
                        'tipo_sub_path'                         => '',
                        'tipo_sub_dominio'                      => '',
                        'tipo_sub_observacion'                  => '',
                        'tipo_sub_usuario'                      => '',
                        'tipo_sub_fecha_hora'                   => '',
                        'tipo_sub_ip'                           => ''
                    );
    
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMSUBCOD         AS          tipo_sub_codigo,
            a.DOMSUBEST         AS          tipo_sub_estado_codigo,
            a.DOMSUBORD         AS          tipo_sub_orden,
            a.DOMSUBNOI         AS          tipo_sub_nombre_ingles,
            a.DOMSUBNOC         AS          tipo_sub_nombre_castellano,
            a.DOMSUBNOP         AS          tipo_sub_nombre_portugues,
            a.DOMSUBPAT         AS          tipo_sub_path,
            a.DOMSUBVAL         AS          tipo_sub_dominio,
            a.DOMSUBOBS         AS          tipo_sub_observacion,
            a.DOMSUBAUS         AS          tipo_sub_usuario,
            a.DOMSUBAFH         AS          tipo_sub_fecha_hora,
            a.DOMSUBAIP         AS          tipo_sub_ip,

            b.DOMFICCOD         AS          tipo_codigo,
            b.DOMFICNOI         AS          tipo_nombre_ingles,
            b.DOMFICNOC         AS          tipo_nombre_castellano,
            b.DOMFICNOP         AS          tipo_nombre_portugues        
            
            FROM [adm].[DOMSUB] a
            INNER JOIN [adm].[DOMFIC] b ON a.DOMSUBTIC = b.DOMFICCOD

            WHERE a.DOMSUBVAL = ?

            ORDER BY a.DOMSUBVAL, a.DOMSUBORD, b.DOMFICNOC, a.DOMSUBNOC";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['tipo_sub_estado_codigo'] === 'A') {
                        $tipo_sub_estado_nombre = 'ACTIVO';
                    } 
                    
                    if ($rowMSSQL['tipo_sub_estado_codigo'] === 'I') {
                        $tipo_sub_estado_nombre = 'INACTIVO';
                    }
    
                    $detalle    = array(
                        'tipo_sub_codigo'                       => $rowMSSQL['tipo_sub_codigo'],
                        'tipo_sub_estado_codigo'                => $rowMSSQL['tipo_sub_estado_codigo'],
                        'tipo_sub_estado_nombre'                => $tipo_sub_estado_nombre,
                        'tipo_codigo'                           => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                    => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'                => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'                 => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_sub_orden'                        => $rowMSSQL['tipo_sub_orden'],
                        'tipo_sub_nombre_ingles'                => trim($rowMSSQL['tipo_sub_nombre_ingles']),
                        'tipo_sub_nombre_castellano'            => trim($rowMSSQL['tipo_sub_nombre_castellano']),
                        'tipo_sub_nombre_portugues'             => trim($rowMSSQL['tipo_sub_nombre_portugues']),
                        'tipo_sub_path'                         => trim($rowMSSQL['tipo_sub_path']),
                        'tipo_sub_dominio'                      => trim($rowMSSQL['tipo_sub_dominio']),
                        'tipo_sub_observacion'                  => trim($rowMSSQL['tipo_sub_observacion']),
                        'tipo_sub_usuario'                      => trim($rowMSSQL['tipo_sub_usuario']),
                        'tipo_sub_fecha_hora'                   => $rowMSSQL['tipo_sub_fecha_hora'],
                        'tipo_sub_ip'                           => trim($rowMSSQL['tipo_sub_ip'])
                    );
    
                    $result[]   = $detalle;
                }
    
                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_sub_codigo'                       => '',
                        'tipo_sub_estado_codigo'                => '',
                        'tipo_sub_estado_nombre'                => '',
                        'tipo_codigo'                           => '',
                        'tipo_nombre_ingles'                    => '',
                        'tipo_nombre_castellano'                => '',
                        'tipo_nombre_portugues'                 => '',
                        'tipo_sub_orden'                        => '',
                        'tipo_sub_nombre_ingles'                => '',
                        'tipo_sub_nombre_castellano'            => '',
                        'tipo_sub_nombre_portugues'             => '',
                        'tipo_sub_path'                         => '',
                        'tipo_sub_dominio'                      => '',
                        'tipo_sub_observacion'                  => '',
                        'tipo_sub_usuario'                      => '',
                        'tipo_sub_fecha_hora'                   => '',
                        'tipo_sub_ip'                           => ''
                    );
    
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/100/auditoria/{dominio}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('dominio');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMSUBAIDD            AS          auditoria_codigo,
            a.DOMSUBAMET            AS          auditoria_metodo,
            a.DOMSUBAUSU            AS          auditoria_usuario,
            a.DOMSUBAFEC            AS          auditoria_fecha_hora,
            a.DOMSUBADIP            AS          auditoria_ip,
            a.DOMSUBACOD            AS          auditoria_tipo_sub_codigo,
            a.DOMSUBAEST            AS          auditoria_tipo_sub_estado_codigo,
            a.DOMSUBAORD            AS          auditoria_tipo_sub_orden,
            a.DOMSUBANOI            AS          auditoria_tipo_sub_nombre_ingles,
            a.DOMSUBANOC            AS          auditoria_tipo_sub_nombre_castellano,
            a.DOMSUBANOP            AS          auditoria_tipo_sub_nombre_portugues,
            a.DOMSUBAPAT            AS          auditoria_tipo_sub_path,
            a.DOMSUBAVAL            AS          auditoria_tipo_sub_dominio,
            a.DOMSUBAOBS            AS          auditoria_tipo_sub_observacion,
            b.DOMFICCOD             AS          auditoria_tipo_codigo,
            b.DOMFICNOI             AS          auditoria_tipo_nombre_ingles,
            b.DOMFICNOC             AS          auditoria_tipo_nombre_castellano,
            b.DOMFICNOP             AS          auditoria_tipo_nombre_portugues
            
            FROM [adm].[DOMSUBA] a
            
            WHERE a.DOMSUBAVAL
            INNER JOIN [adm].[DOMFIC] b ON a.DOMSUBATIC = b1.DOMFICCOD
            
            ORDER BY a.DOMSUBAIDD DESC";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['auditoria_tipo_sub_estado_codigo'] === 'A') {
                        $tipo_sub_estado_nombre   = 'ACTIVO';
                    }

                    if ($rowMSSQL['auditoria_tipo_sub_estado_codigo'] === 'I') {
                        $tipo_sub_estado_nombre   = 'INACTIVO';
                    }

                    $detalle    = array(
                        'auditoria_codigo'                              => $rowMSSQL['auditoria_codigo'],
                        'auditoria_metodo'                              => $rowMSSQL['auditoria_metodo'],
                        'auditoria_usuario'                             => trim($rowMSSQL['auditoria_usuario']),
                        'auditoria_fecha_hora'                          => $rowMSSQL['auditoria_fecha_hora'],
                        'auditoria_ip'                                  => $rowMSSQL['auditoria_ip'],
                        'auditoria_tipo_sub_codigo'                     => $rowMSSQL['auditoria_tipo_sub_codigo'],
                        'auditoria_tipo_sub_estado_codigo'              => $rowMSSQL['auditoria_tipo_sub_estado_codigo'],
                        'auditoria_tipo_sub_estado_nombre'              => $tipo_sub_estado_nombre,
                        'auditoria_tipo_sub_orden'                      => $rowMSSQL['auditoria_tipo_sub_orden'],
                        'auditoria_tipo_sub_nombre_ingles'              => trim($rowMSSQL['auditoria_tipo_sub_nombre_ingles']),
                        'auditoria_tipo_sub_nombre_castellano'          => trim($rowMSSQL['auditoria_tipo_sub_nombre_castellano']),
                        'auditoria_tipo_sub_nombre_portugues'           => trim($rowMSSQL['auditoria_tipo_sub_nombre_portugues']),
                        'auditoria_tipo_sub_path'                       => trim($rowMSSQL['auditoria_tipo_sub_path']),
                        'auditoria_tipo_sub_dominio'                    => trim($rowMSSQL['auditoria_tipo_sub_dominio']),
                        'auditoria_tipo_sub_observacion'                => $rowMSSQL['auditoria_tipo_sub_observacion'],
                        'auditoria_tipo_codigo'                         => $rowMSSQL['auditoria_tipo_codigo'],
                        'auditoria_tipo_nombre_ingles'                  => trim($rowMSSQL['auditoria_tipo_nombre_ingles']),
                        'auditoria_tipo_nombre_castellano'              => trim($rowMSSQL['auditoria_tipo_nombre_castellano']),
                        'auditoria_tipo_nombre_portugues'               => trim($rowMSSQL['auditoria_tipo_nombre_portugues'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'auditoria_codigo'                              => '',
                        'auditoria_metodo'                              => '',
                        'auditoria_usuario'                             => '',
                        'auditoria_fecha_hora'                          => '',
                        'auditoria_ip'                                  => '',
                        'auditoria_tipo_sub_codigo'                     => '',
                        'auditoria_tipo_sub_estado_codigo'              => '',
                        'auditoria_tipo_sub_estado_nombre'              => '',
                        'auditoria_tipo_sub_orden'                      => '',
                        'auditoria_tipo_sub_nombre_ingles'              => '',
                        'auditoria_tipo_sub_nombre_castellano'          => '',
                        'auditoria_tipo_sub_nombre_portugues'           => '',
                        'auditoria_tipo_sub_path'                       => '',
                        'auditoria_tipo_sub_dominio'                    => '',
                        'auditoria_tipo_sub_observacion'                => '',
                        'auditoria_tipo_codigo'                         => '',
                        'auditoria_tipo_nombre_ingles'                  => '',
                        'auditoria_tipo_nombre_castellano'              => '',
                        'auditoria_tipo_nombre_portugues'               => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/disciplina/{codigo}/{equipo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        $val02      = $request->getAttribute('equipo');
        
        if (isset($val01)) {
            $sql00  = "";

            if ($val02 == 39393) {
                $sql00  = "SELECT
                a.competitionFifaId                 AS          competicion_codigo,
                a.superiorCompetitionFifaId         AS          competicion_codigo_padre,
                a.status                            AS          competicion_estado,
                a.internationalName                 AS          competicion_nombre,
                a.internationalShortName            AS          competicion_nombre_corto,
                a.season                            AS          competicion_anho,
                a.ageCategory                       AS          competicion_categoria_codigo,
                a.ageCategoryName                   AS          competicion_categoria_nombre,
                a.dateFrom                          AS          competicion_desde,
                a.dateTo                            AS          competicion_hasta,
                a.discipline                        AS          competicion_disciplina,
                a.gender                            AS          competicion_genero,
                a.imageId                           AS          competicion_imagen_codigo,
                a.multiplier                        AS          competicion_multiplicador,
                a.nature                            AS          competicion_naturaleza,
                a.numberOfParticipants              AS          competicion_numero_participante,
                a.orderNumber                       AS          competicion_numero_orden,
                a.teamCharacter                     AS          competicion_equipo_tipo,
                a.flyingSubstitutions               AS          competicion_sustitucion,
                a.penaltyShootout                   AS          competicion_penal,
                a.matchType                         AS          competicion_tipo,
                a.pictureContentType                AS          competicion_imagen_tipo,
                a.pictureLink                       AS          competicion_image_link,
                a.pictureValue                      AS          competicion_imagen_valor,
                a.lastUpdate                        AS          competicion_ultima_actualizacion,

                b.organisationFifaId                AS          organizacion_codigo,
                b.organisationName                  AS          organizacion_nombre
                
                FROM [comet].[competitions] a
                LEFT JOIN [comet].[organisations] b ON a.organisationFifaId = b.organisationFifaId
                
                WHERE a.superiorCompetitionFifaId IS NULL AND a.discipline = ?

                ORDER BY a.discipline, a.season, a.competitionFifaId";
            } else {
                $sql00  = "SELECT
                a.competitionFifaId                 AS          competicion_codigo,
                a.superiorCompetitionFifaId         AS          competicion_codigo_padre,
                a.status                            AS          competicion_estado,
                a.internationalName                 AS          competicion_nombre,
                a.internationalShortName            AS          competicion_nombre_corto,
                a.season                            AS          competicion_anho,
                a.ageCategory                       AS          competicion_categoria_codigo,
                a.ageCategoryName                   AS          competicion_categoria_nombre,
                a.dateFrom                          AS          competicion_desde,
                a.dateTo                            AS          competicion_hasta,
                a.discipline                        AS          competicion_disciplina,
                a.gender                            AS          competicion_genero,
                a.imageId                           AS          competicion_imagen_codigo,
                a.multiplier                        AS          competicion_multiplicador,
                a.nature                            AS          competicion_naturaleza,
                a.numberOfParticipants              AS          competicion_numero_participante,
                a.orderNumber                       AS          competicion_numero_orden,
                a.teamCharacter                     AS          competicion_equipo_tipo,
                a.flyingSubstitutions               AS          competicion_sustitucion,
                a.penaltyShootout                   AS          competicion_penal,
                a.matchType                         AS          competicion_tipo,
                a.pictureContentType                AS          competicion_imagen_tipo,
                a.pictureLink                       AS          competicion_image_link,
                a.pictureValue                      AS          competicion_imagen_valor,
                a.lastUpdate                        AS          competicion_ultima_actualizacion,

                b.organisationFifaId                AS          organizacion_codigo,
                b.organisationName                  AS          organizacion_nombre
                
                FROM [comet].[competitions] a
                LEFT JOIN [comet].[organisations] b ON a.organisationFifaId = b.organisationFifaId
                INNER JOIN [comet].[competitions_teams] c ON a.competitionFifaId = c.competitionFifaId
                
                WHERE a.superiorCompetitionFifaId IS NULL AND a.discipline = ? AND c.teamFifaId = ?

                ORDER BY a.discipline, a.season, a.competitionFifaId";
            }

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val02 == 39393) {
                    $stmtMSSQL->execute([$val01]);
                } else {
                    $stmtMSSQL->execute([$val01, $val02]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    switch ($rowMSSQL['competicion_imagen_tipo']) {
                        case 'image/jpeg':
                            $ext = 'jpeg';
                            break;
                        
                        case 'image/jpg':
                            $ext = 'jpg';
                            break;

                        case 'image/png':
                            $ext = 'png';
                            break;

                        case 'image/gif':
                            $ext = 'gif';
                            break;
                    }

                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim($rowMSSQL['competicion_estado']),
                        'competicion_nombre'                    => trim($rowMSSQL['competicion_nombre']),
                        'competicion_nombre_corto'              => trim($rowMSSQL['competicion_nombre_corto']),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],
                        'competicion_categoria_codigo'          => trim($rowMSSQL['competicion_categoria_codigo']),
                        'competicion_categoria_nombre'          => trim($rowMSSQL['competicion_categoria_nombre']),
                        'competicion_desde'                     => $rowMSSQL['competicion_desde'],
                        'competicion_hasta'                     => $rowMSSQL['competicion_hasta'],
                        'competicion_disciplina'                => trim($rowMSSQL['competicion_disciplina']),
                        'competicion_genero'                    => trim($rowMSSQL['competicion_genero']),
                        'competicion_imagen_codigo'             => $rowMSSQL['competicion_imagen_codigo'],
                        'competicion_multiplicador'             => $rowMSSQL['competicion_multiplicador'],
                        'competicion_naturaleza'                => trim($rowMSSQL['competicion_naturaleza']),
                        'competicion_numero_participante'       => $rowMSSQL['competicion_numero_participante'],
                        'competicion_numero_orden'              => $rowMSSQL['competicion_numero_orden'],
                        'competicion_equipo_tipo'               => trim($rowMSSQL['competicion_equipo_tipo']),
                        'competicion_sustitucion'               => $rowMSSQL['competicion_sustitucion'],
                        'competicion_penal'                     => $rowMSSQL['competicion_penal'],
                        'competicion_tipo'                      => trim($rowMSSQL['competicion_tipo']),
                        'competicion_imagen_tipo'               => trim($rowMSSQL['competicion_imagen_tipo']),
                        'competicion_image_link'                => trim($rowMSSQL['competicion_image_link']),
                        'competicion_imagen_valor'              => trim($rowMSSQL['competicion_imagen_valor']),
                        'competicion_imagen_path'               => 'imagen/competencia/img_'.$rowMSSQL['competicion_codigo'].'.'.$ext,
                        'competicion_ultima_actualizacion'      => $rowMSSQL['competicion_ultima_actualizacion'],
                        'organizacion_codigo'                   => $rowMSSQL['organizacion_codigo'],
                        'organizacion_nombre'                   => trim($rowMSSQL['organizacion_nombre'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'competicion_codigo'                    => '',
                        'competicion_codigo_padre'              => '',
                        'competicion_estado'                    => '',
                        'competicion_nombre'                    => '',
                        'competicion_nombre_corto'              => '',
                        'competicion_anho'                      => '',
                        'competicion_categoria_codigo'          => '',
                        'competicion_categoria_nombre'          => '',
                        'competicion_desde'                     => '',
                        'competicion_hasta'                     => '',
                        'competicion_disciplina'                => '',
                        'competicion_genero'                    => '',
                        'competicion_imagen_codigo'             => '',
                        'competicion_multiplicador'             => '',
                        'competicion_naturaleza'                => '',
                        'competicion_numero_participante'       => '',
                        'competicion_numero_orden'              => '',
                        'competicion_equipo_tipo'               => '',
                        'competicion_sustitucion'               => '',
                        'competicion_penal'                     => '',
                        'competicion_tipo'                      => '',
                        'competicion_imagen_tipo'               => '',
                        'competicion_image_link'                => '',
                        'competicion_imagen_valor'              => '',
                        'competicion_imagen_path'               => '',
                        'competicion_ultima_actualizacion'      => '',
                        'organizacion_codigo'                   => '',
                        'organizacion_nombre'                   => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/competicion/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.competitionFifaId                 AS          competicion_codigo,
            a.superiorCompetitionFifaId         AS          competicion_codigo_padre,
            a.status                            AS          competicion_estado,
            a.internationalName                 AS          competicion_nombre,
            a.internationalShortName            AS          competicion_nombre_corto,
            a.season                            AS          competicion_anho,
            a.ageCategory                       AS          competicion_categoria_codigo,
            a.ageCategoryName                   AS          competicion_categoria_nombre,
            a.dateFrom                          AS          competicion_desde,
            a.dateTo                            AS          competicion_hasta,
            a.discipline                        AS          competicion_disciplina,
            a.gender                            AS          competicion_genero,
            a.imageId                           AS          competicion_imagen_codigo,
            a.multiplier                        AS          competicion_multiplicador,
            a.nature                            AS          competicion_naturaleza,
            a.numberOfParticipants              AS          competicion_numero_participante,
            a.orderNumber                       AS          competicion_numero_orden,
            a.teamCharacter                     AS          competicion_equipo_tipo,
            a.flyingSubstitutions               AS          competicion_sustitucion,
            a.penaltyShootout                   AS          competicion_penal,
            a.matchType                         AS          competicion_tipo,
            a.pictureContentType                AS          competicion_imagen_tipo,
            a.pictureLink                       AS          competicion_image_link,
            a.pictureValue                      AS          competicion_imagen_valor,
            a.lastUpdate                        AS          competicion_ultima_actualizacion,

            b.organisationFifaId                AS          organizacion_codigo,
            b.organisationName                  AS          organizacion_nombre
            
            FROM [comet].[competitions] a
            LEFT JOIN [comet].[organisations] b ON a.organisationFifaId = b.organisationFifaId
            
            WHERE a.superiorCompetitionFifaId = ?

            ORDER BY a.discipline, a.season, a.competitionFifaId";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    switch ($rowMSSQL['competicion_imagen_tipo']) {
                        case 'image/jpeg':
                            $ext = 'jpeg';
                            break;
                        
                        case 'image/jpg':
                            $ext = 'jpg';
                            break;

                        case 'image/png':
                            $ext = 'png';
                            break;

                        case 'image/gif':
                            $ext = 'gif';
                            break;
                    }

                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim($rowMSSQL['competicion_estado']),
                        'competicion_nombre'                    => trim($rowMSSQL['competicion_nombre']),
                        'competicion_nombre_corto'              => trim($rowMSSQL['competicion_nombre_corto']),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],
                        'competicion_categoria_codigo'          => trim($rowMSSQL['competicion_categoria_codigo']),
                        'competicion_categoria_nombre'          => trim($rowMSSQL['competicion_categoria_nombre']),
                        'competicion_desde'                     => $rowMSSQL['competicion_desde'],
                        'competicion_hasta'                     => $rowMSSQL['competicion_hasta'],
                        'competicion_disciplina'                => trim($rowMSSQL['competicion_disciplina']),
                        'competicion_genero'                    => trim($rowMSSQL['competicion_genero']),
                        'competicion_imagen_codigo'             => $rowMSSQL['competicion_imagen_codigo'],
                        'competicion_multiplicador'             => $rowMSSQL['competicion_multiplicador'],
                        'competicion_naturaleza'                => trim($rowMSSQL['competicion_naturaleza']),
                        'competicion_numero_participante'       => $rowMSSQL['competicion_numero_participante'],
                        'competicion_numero_orden'              => $rowMSSQL['competicion_numero_orden'],
                        'competicion_equipo_tipo'               => trim($rowMSSQL['competicion_equipo_tipo']),
                        'competicion_sustitucion'               => $rowMSSQL['competicion_sustitucion'],
                        'competicion_penal'                     => $rowMSSQL['competicion_penal'],
                        'competicion_tipo'                      => trim($rowMSSQL['competicion_tipo']),
                        'competicion_imagen_tipo'               => trim($rowMSSQL['competicion_imagen_tipo']),
                        'competicion_image_link'                => trim($rowMSSQL['competicion_image_link']),
                        'competicion_imagen_valor'              => trim($rowMSSQL['competicion_imagen_valor']),
                        'competicion_imagen_path'               => 'imagen/competencia/img_'.$rowMSSQL['competicion_codigo'].'.'.$ext,
                        'competicion_ultima_actualizacion'      => $rowMSSQL['competicion_ultima_actualizacion'],
                        'organizacion_codigo'                   => $rowMSSQL['organizacion_codigo'],
                        'organizacion_nombre'                   => trim($rowMSSQL['organizacion_nombre'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'competicion_codigo'                    => '',
                        'competicion_codigo_padre'              => '',
                        'competicion_estado'                    => '',
                        'competicion_nombre'                    => '',
                        'competicion_nombre_corto'              => '',
                        'competicion_anho'                      => '',
                        'competicion_categoria_codigo'          => '',
                        'competicion_categoria_nombre'          => '',
                        'competicion_desde'                     => '',
                        'competicion_hasta'                     => '',
                        'competicion_disciplina'                => '',
                        'competicion_genero'                    => '',
                        'competicion_imagen_codigo'             => '',
                        'competicion_multiplicador'             => '',
                        'competicion_naturaleza'                => '',
                        'competicion_numero_participante'       => '',
                        'competicion_numero_orden'              => '',
                        'competicion_equipo_tipo'               => '',
                        'competicion_sustitucion'               => '',
                        'competicion_penal'                     => '',
                        'competicion_tipo'                      => '',
                        'competicion_imagen_tipo'               => '',
                        'competicion_image_link'                => '',
                        'competicion_imagen_valor'              => '',
                        'competicion_imagen_path'               => '',
                        'competicion_ultima_actualizacion'      => '',
                        'organizacion_codigo'                   => '',
                        'organizacion_nombre'                   => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/juego/{competicion}/{equipo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('competicion');
        $val02      = $request->getAttribute('equipo');

        if (isset($val01) && isset($val02)) {
            if ($val02 == 39393) {
                $sql00  = "SELECT
                a.COMPETICION_ID                                AS          competicion_codigo,
                a.COMPETICION_PADRE_ID                          AS          competicion_codigo_padre,
                a.COMPETICION_ESTADO                            AS          competicion_estado,
                a.COMPETICION_ANHO                              AS          competicion_anho,
                a.JUEGO_CODIGO                                  AS          juego_codigo,
                a.JUEGO_NOMBRE                                  AS          juego_fase,
                a.JUEGO_ESTADO                                  AS          juego_estado,
                a.JUEGO_HORARIO                                 AS          juego_horario,
                a.EQUIPO_LOCAL_CODIGO                           AS          equipo_local_codigo,
                a.EQUIPO_LOCAL_NOMBRE                           AS          equipo_local_nombre,
                a.EQUIPO_LOCAL_RESULTADO_PRIMER                 AS          equipo_local_resultado_primer,
                a.EQUIPO_LOCAL_RESULTADO_SEGUNDO                AS          equipo_local_resultado_segundo,
                a.EQUIPO_VISITANTE_CODIGO                       AS          equipo_visitante_codigo,
                a.EQUIPO_VISITANTE_NOMBRE                       AS          equipo_visitante_nombre,
                a.EQUIPO_VISITANTE_RESULTADO_PRIMER             AS          equipo_visitante_resultado_primer,
                a.EQUIPO_VISITANTE_RESULTADO_SEGUNDO            AS          equipo_visitante_resultado_segundo
                
                FROM [view].[juego] a
                
                WHERE a.COMPETICION_ID = ? OR a.COMPETICION_PADRE_ID = ?
    
                ORDER BY a.COMPETICION_PADRE_ID DESC";
            } else {
                $sql00  = "SELECT
                a.COMPETICION_ID                                AS          competicion_codigo,
                a.COMPETICION_PADRE_ID                          AS          competicion_codigo_padre,
                a.COMPETICION_ESTADO                            AS          competicion_estado,
                a.COMPETICION_ANHO                              AS          competicion_anho,
                a.JUEGO_CODIGO                                  AS          juego_codigo,
                a.JUEGO_NOMBRE                                  AS          juego_fase,
                a.JUEGO_ESTADO                                  AS          juego_estado,
                a.JUEGO_HORARIO                                 AS          juego_horario,
                a.EQUIPO_LOCAL_CODIGO                           AS          equipo_local_codigo,
                a.EQUIPO_LOCAL_NOMBRE                           AS          equipo_local_nombre,
                a.EQUIPO_LOCAL_RESULTADO_PRIMER                 AS          equipo_local_resultado_primer,
                a.EQUIPO_LOCAL_RESULTADO_SEGUNDO                AS          equipo_local_resultado_segundo,
                a.EQUIPO_VISITANTE_CODIGO                       AS          equipo_visitante_codigo,
                a.EQUIPO_VISITANTE_NOMBRE                       AS          equipo_visitante_nombre,
                a.EQUIPO_VISITANTE_RESULTADO_PRIMER             AS          equipo_visitante_resultado_primer,
                a.EQUIPO_VISITANTE_RESULTADO_SEGUNDO            AS          equipo_visitante_resultado_segundo
                
                FROM [view].[juego] a
                
                WHERE (a.COMPETICION_ID = ? OR a.COMPETICION_PADRE_ID = ?) AND (a.EQUIPO_LOCAL_CODIGO = ? OR a.EQUIPO_VISITANTE_CODIGO = ?)
    
                ORDER BY a.COMPETICION_PADRE_ID DESC, a.JUEGO_HORARIO DESC, a.JUEGO_CODIGO DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val02 == 39393) {
                    $stmtMSSQL->execute([$val01, $val01]); 
                } else {
                    $stmtMSSQL->execute([$val01, $val01, $val02, $val02]); 
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $juego_horario = date_format(date_create($rowMSSQL['juego_horario']), 'd/m/Y H:i:s');

                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim($rowMSSQL['competicion_estado']),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],
                        'juego_codigo'                          => $rowMSSQL['juego_codigo'],
                        'juego_fase'                            => trim($rowMSSQL['juego_fase']),
                        'juego_estado'                          => trim($rowMSSQL['juego_estado']),
                        'juego_horario'                         => $juego_horario,
                        'equipo_local_codigo'                   => $rowMSSQL['equipo_local_codigo'],
                        'equipo_local_nombre'                   => trim($rowMSSQL['equipo_local_nombre']),
                        'equipo_local_resultado_primer'         => $rowMSSQL['equipo_local_resultado_primer'],
                        'equipo_local_resultado_segundo'        => $rowMSSQL['equipo_local_resultado_segundo'],
                        'equipo_local_resultado_final'          => $rowMSSQL['equipo_local_resultado_segundo'],
                        'equipo_visitante_codigo'               => $rowMSSQL['equipo_visitante_codigo'],
                        'equipo_visitante_nombre'               => trim($rowMSSQL['equipo_visitante_nombre']),
                        'equipo_visitante_resultado_primer'     => $rowMSSQL['equipo_visitante_resultado_primer'],
                        'equipo_visitante_resultado_segundo'    => $rowMSSQL['equipo_visitante_resultado_segundo'],
                        'equipo_visitante_resultado_final'      => $rowMSSQL['equipo_visitante_resultado_segundo']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'competicion_codigo'                    => '',
                        'competicion_codigo'                    => '',
                        'competicion_codigo_padre'              => '',
                        'competicion_estado'                    => '',
                        'competicion_anho'                      => '',
                        'juego_fase'                            => '',
                        'juego_estado'                          => '',
                        'juego_horario'                         => '',
                        'equipo_local_codigo'                   => '',
                        'equipo_local_nombre'                   => '',
                        'equipo_local_resultado_primer'         => '',
                        'equipo_local_resultado_segundo'        => '',
                        'equipo_local_resultado_final'          => '',
                        'equipo_visitante_codigo'               => '',
                        'equipo_visitante_nombre'               => '',
                        'equipo_visitante_resultado_primer'     => '',
                        'equipo_visitante_resultado_segundo'    => '',
                        'equipo_visitante_resultado_final'      => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/300', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.teamFifaId                        AS          equipo_codigo,
        a.status                            AS          equipo_estado,
        a.internationalName                 AS          equipo_nombre,
        a.internationalShortName            AS          equipo_nombre_corto,
        a.organisationNature                AS          equipo_naturaleza,
        a.country                           AS          equipo_pais,
        a.region                            AS          equipo_region,
        a.town                              AS          equipo_ciudad,
        a.postalCode                        AS          equipo_postal_codigo,
        a.lastUpdate                        AS          equipo_ultima_actualizacion,

        b.organisationFifaId                AS          organizacion_codigo,
        b.organisationName                  AS          organizacion_nombre,
        b.organisationShortName             AS          organizacion_nombre_corto,
        b.pictureContentType                AS          organizacion_imagen_tipo,
        b.pictureLink                       AS          organizacion_image_link,
        b.pictureValue                      AS          organizacion_imagen_valor
        
        FROM [comet].[teams] a
        INNER JOIN [comet].[organisations] b ON a.organisationFifaId = b.organisationFifaId
        
        ORDER BY a.internationalName";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $juego_horario = date_format(date_create($rowMSSQL['equipo_ultima_actualizacion']), 'd/m/Y H:i:s');

                switch ($rowMSSQL['organizacion_imagen_tipo']) {
                    case 'image/jpeg':
                        $ext = 'jpeg';
                        break;
                    
                    case 'image/jpg':
                        $ext = 'jpg';
                        break;

                    case 'image/png':
                        $ext = 'png';
                        break;

                    case 'image/gif':
                        $ext = 'gif';
                        break;
                }

                $detalle    = array(
                    'equipo_codigo'                         => $rowMSSQL['equipo_codigo'],
                    'equipo_estado'                         => trim($rowMSSQL['equipo_estado']),
                    'equipo_nombre'                         => trim($rowMSSQL['equipo_nombre']),
                    'equipo_nombre_corto'                   => trim($rowMSSQL['equipo_nombre_corto']),
                    'equipo_naturaleza'                     => trim($rowMSSQL['equipo_naturaleza']),
                    'equipo_pais'                           => trim($rowMSSQL['equipo_pais']),
                    'equipo_region'                         => trim($rowMSSQL['equipo_region']),
                    'equipo_ciudad'                         => trim($rowMSSQL['equipo_ciudad']),
                    'equipo_postal_codigo'                  => $rowMSSQL['equipo_postal_codigo'],
                    'equipo_ultima_actualizacion'           => $juego_horario,
                    'organizacion_codigo'                   => $rowMSSQL['organizacion_codigo'],
                    'organizacion_nombre'                   => trim($rowMSSQL['organizacion_nombre']),
                    'organizacion_nombre_corto'             => trim($rowMSSQL['organizacion_nombre_corto']),
                    'organizacion_imagen_tipo'              => trim($rowMSSQL['organizacion_imagen_tipo']),
                    'organizacion_image_link'               => trim($rowMSSQL['organizacion_image_link']),
                    'organizacion_imagen_valor'             => $rowMSSQL['organizacion_imagen_valor'],
                    'organizacion_imagen_path'              => 'imagen/organizacion/img_'.$rowMSSQL['organizacion_codigo'].'.'.$ext
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'equipo_codigo'                         => '',
                    'equipo_estado'                         => '',
                    'equipo_nombre'                         => '',
                    'equipo_nombre_corto'                   => '',
                    'equipo_naturaleza'                     => '',
                    'equipo_pais'                           => '',
                    'equipo_region'                         => '',
                    'equipo_ciudad'                         => '',
                    'equipo_postal_codigo'                  => '',
                    'equipo_ultima_actualizacion'           => '',
                    'organizacion_codigo'                   => '',
                    'organizacion_nombre'                   => '',
                    'organizacion_nombre_corto'             => '',
                    'organizacion_imagen_tipo'              => '',
                    'organizacion_image_link'               => '',
                    'organizacion_imagen_valor'             => '',
                    'organizacion_imagen_path'              => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/300/equipo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.teamFifaId                        AS          equipo_codigo,
            a.status                            AS          equipo_estado,
            a.internationalName                 AS          equipo_nombre,
            a.internationalShortName            AS          equipo_nombre_corto,
            a.organisationNature                AS          equipo_naturaleza,
            a.country                           AS          equipo_pais,
            a.region                            AS          equipo_region,
            a.town                              AS          equipo_ciudad,
            a.postalCode                        AS          equipo_postal_codigo,
            a.lastUpdate                        AS          equipo_ultima_actualizacion,

            b.organisationFifaId                AS          organizacion_codigo,
            b.organisationName                  AS          organizacion_nombre,
            b.organisationShortName             AS          organizacion_nombre_corto,
            b.pictureContentType                AS          organizacion_imagen_tipo,
            b.pictureLink                       AS          organizacion_image_link,
            b.pictureValue                      AS          organizacion_imagen_valor
            
            FROM [comet].[teams] a
            INNER JOIN [comet].[organisations] b ON a.organisationFifaId = b.organisationFifaId
            
            WHERE a.teamFifaId = ?
            
            ORDER BY a.internationalName";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {    
                    $juego_horario = date_format(date_create($rowMSSQL['equipo_ultima_actualizacion']), 'd/m/Y H:i:s');

                    switch ($rowMSSQL['organizacion_imagen_tipo']) {
                        case 'image/jpeg':
                            $ext = 'jpeg';
                            break;
                        
                        case 'image/jpg':
                            $ext = 'jpg';
                            break;

                        case 'image/png':
                            $ext = 'png';
                            break;

                        case 'image/gif':
                            $ext = 'gif';
                            break;
                    }

                    $detalle    = array(
                        'equipo_codigo'                         => $rowMSSQL['equipo_codigo'],
                        'equipo_estado'                         => trim($rowMSSQL['equipo_estado']),
                        'equipo_nombre'                         => trim($rowMSSQL['equipo_nombre']),
                        'equipo_nombre_corto'                   => trim($rowMSSQL['equipo_nombre_corto']),
                        'equipo_naturaleza'                     => trim($rowMSSQL['equipo_naturaleza']),
                        'equipo_pais'                           => trim($rowMSSQL['equipo_pais']),
                        'equipo_region'                         => trim($rowMSSQL['equipo_region']),
                        'equipo_ciudad'                         => trim($rowMSSQL['equipo_ciudad']),
                        'equipo_postal_codigo'                  => $rowMSSQL['equipo_postal_codigo'],
                        'equipo_ultima_actualizacion'           => $juego_horario,
                        'organizacion_codigo'                   => $rowMSSQL['organizacion_codigo'],
                        'organizacion_nombre'                   => trim($rowMSSQL['organizacion_nombre']),
                        'organizacion_nombre_corto'             => trim($rowMSSQL['organizacion_nombre_corto']),
                        'organizacion_imagen_tipo'              => trim($rowMSSQL['organizacion_imagen_tipo']),
                        'organizacion_image_link'               => trim($rowMSSQL['organizacion_image_link']),
                        'organizacion_imagen_valor'             => $rowMSSQL['organizacion_imagen_valor'],
                        'organizacion_imagen_path'              => 'imagen/organizacion/img_'.$rowMSSQL['organizacion_codigo'].'.'.$ext
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'equipo_codigo'                         => '',
                        'equipo_estado'                         => '',
                        'equipo_nombre'                         => '',
                        'equipo_nombre_corto'                   => '',
                        'equipo_naturaleza'                     => '',
                        'equipo_pais'                           => '',
                        'equipo_region'                         => '',
                        'equipo_ciudad'                         => '',
                        'equipo_postal_codigo'                  => '',
                        'equipo_ultima_actualizacion'           => '',
                        'organizacion_codigo'                   => '',
                        'organizacion_nombre'                   => '',
                        'organizacion_nombre_corto'             => '',
                        'organizacion_imagen_tipo'              => '',
                        'organizacion_image_link'               => '',
                        'organizacion_imagen_valor'             => '',
                        'organizacion_imagen_path'              => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/300/organizacion/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.teamFifaId                        AS          equipo_codigo,
            a.status                            AS          equipo_estado,
            a.internationalName                 AS          equipo_nombre,
            a.internationalShortName            AS          equipo_nombre_corto,
            a.organisationNature                AS          equipo_naturaleza,
            a.country                           AS          equipo_pais,
            a.region                            AS          equipo_region,
            a.town                              AS          equipo_ciudad,
            a.postalCode                        AS          equipo_postal_codigo,
            a.lastUpdate                        AS          equipo_ultima_actualizacion,

            b.organisationFifaId                AS          organizacion_codigo,
            b.organisationName                  AS          organizacion_nombre,
            b.organisationShortName             AS          organizacion_nombre_corto,
            b.pictureContentType                AS          organizacion_imagen_tipo,
            b.pictureLink                       AS          organizacion_image_link,
            b.pictureValue                      AS          organizacion_imagen_valor
            
            FROM [comet].[teams] a
            INNER JOIN [comet].[organisations] b ON a.organisationFifaId = b.organisationFifaId
            
            WHERE a.organisationFifaId = ?
            
            ORDER BY a.internationalName";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {    
                    $juego_horario = date_format(date_create($rowMSSQL['equipo_ultima_actualizacion']), 'd/m/Y H:i:s');

                    switch ($rowMSSQL['organizacion_imagen_tipo']) {
                        case 'image/jpeg':
                            $ext = 'jpeg';
                            break;
                        
                        case 'image/jpg':
                            $ext = 'jpg';
                            break;

                        case 'image/png':
                            $ext = 'png';
                            break;

                        case 'image/gif':
                            $ext = 'gif';
                            break;
                    }

                    $detalle    = array(
                        'equipo_codigo'                         => $rowMSSQL['equipo_codigo'],
                        'equipo_estado'                         => trim($rowMSSQL['equipo_estado']),
                        'equipo_nombre'                         => trim($rowMSSQL['equipo_nombre']),
                        'equipo_nombre_corto'                   => trim($rowMSSQL['equipo_nombre_corto']),
                        'equipo_naturaleza'                     => trim($rowMSSQL['equipo_naturaleza']),
                        'equipo_pais'                           => trim($rowMSSQL['equipo_pais']),
                        'equipo_region'                         => trim($rowMSSQL['equipo_region']),
                        'equipo_ciudad'                         => trim($rowMSSQL['equipo_ciudad']),
                        'equipo_postal_codigo'                  => $rowMSSQL['equipo_postal_codigo'],
                        'equipo_ultima_actualizacion'           => $juego_horario,
                        'organizacion_codigo'                   => $rowMSSQL['organizacion_codigo'],
                        'organizacion_nombre'                   => trim($rowMSSQL['organizacion_nombre']),
                        'organizacion_nombre_corto'             => trim($rowMSSQL['organizacion_nombre_corto']),
                        'organizacion_imagen_tipo'              => trim($rowMSSQL['organizacion_imagen_tipo']),
                        'organizacion_image_link'               => trim($rowMSSQL['organizacion_image_link']),
                        'organizacion_imagen_valor'             => $rowMSSQL['organizacion_imagen_valor'],
                        'organizacion_imagen_path'              => 'imagen/organizacion/img_'.$rowMSSQL['organizacion_codigo'].'.'.$ext
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'equipo_codigo'                         => '',
                        'equipo_estado'                         => '',
                        'equipo_nombre'                         => '',
                        'equipo_nombre_corto'                   => '',
                        'equipo_naturaleza'                     => '',
                        'equipo_pais'                           => '',
                        'equipo_region'                         => '',
                        'equipo_ciudad'                         => '',
                        'equipo_postal_codigo'                  => '',
                        'equipo_ultima_actualizacion'           => '',
                        'organizacion_codigo'                   => '',
                        'organizacion_nombre'                   => '',
                        'organizacion_nombre_corto'             => '',
                        'organizacion_imagen_tipo'              => '',
                        'organizacion_image_link'               => '',
                        'organizacion_imagen_valor'             => '',
                        'organizacion_imagen_path'              => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
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
            e.internationalShortName            AS          equipo_nombre,

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

            WHERE a.PERFICCOD = ?
            
            ORDER BY a.PERFICNOM";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]);

                while ($rowMSSQL = $stmtMSSQL->fetch()) {    
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

                        'equipo_codigo'                         => $rowMSSQL['equipo_codigo'],
                        'equipo_nombre'                         => trim($rowMSSQL['equipo_nombre']),

                        'tipo_categoria_codigo'                 => $rowMSSQL['tipo_categoria_codigo'],
                        'tipo_categoria_nombre_ingles'          => trim($rowMSSQL['tipo_categoria_nombre_ingles']),
                        'tipo_categoria_nombre_castellano'      => trim($rowMSSQL['tipo_categoria_nombre_castellano']),
                        'tipo_categoria_nombre_portugues'       => trim($rowMSSQL['tipo_categoria_nombre_portugues'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
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
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/400/equipo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            if ($val01 == 39393) {
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
                e.internationalShortName            AS          equipo_nombre,

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
                
                ORDER BY a.PERFICNOM";
            } else {
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
                e.internationalShortName            AS          equipo_nombre,

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

                WHERE e.teamFifaId = ?
                
                ORDER BY a.PERFICNOM";
            }

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
                    $stmtMSSQL->execute();
                } else {
                    $stmtMSSQL->execute([$val01]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
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

                        'equipo_codigo'                         => $rowMSSQL['equipo_codigo'],
                        'equipo_nombre'                         => trim($rowMSSQL['equipo_nombre']),

                        'tipo_categoria_codigo'                 => $rowMSSQL['tipo_categoria_codigo'],
                        'tipo_categoria_nombre_ingles'          => trim($rowMSSQL['tipo_categoria_nombre_ingles']),
                        'tipo_categoria_nombre_castellano'      => trim($rowMSSQL['tipo_categoria_nombre_castellano']),
                        'tipo_categoria_nombre_portugues'       => trim($rowMSSQL['tipo_categoria_nombre_portugues'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
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
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/500', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.organisationFifaId            AS          organizacion_codigo,
        a.status                        AS          organizacion_estado,
        a.organisationName              AS          organizacion_nombre,
        a.organisationShortName         AS          organizacion_nombre_corto,
        a.pictureContentType            AS          organizacion_imagen_tipo,
        a.pictureLink                   AS          organizacion_image_link,
        a.pictureValue                  AS          organizacion_imagen_valor,
        a.lastUpdate                    AS          organizacion_ultima_actualizacion
        
        FROM [comet].[organisations] a
        
        ORDER BY a.organisationShortName";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $actualizacion_horario = date_format(date_create($rowMSSQL['organizacion_ultima_actualizacion']), 'd/m/Y H:i:s');

                switch ($rowMSSQL['organizacion_imagen_tipo']) {
                    case 'image/jpeg':
                        $ext = 'jpeg';
                        break;
                    
                    case 'image/jpg':
                        $ext = 'jpg';
                        break;

                    case 'image/png':
                        $ext = 'png';
                        break;

                    case 'image/gif':
                        $ext = 'gif';
                        break;
                }

                $detalle    = array(
                    'organizacion_codigo'                       => $rowMSSQL['organizacion_codigo'],
                    'organizacion_nombre'                       => trim($rowMSSQL['organizacion_nombre']),
                    'organizacion_nombre_corto'                 => trim($rowMSSQL['organizacion_nombre_corto']),
                    'organizacion_imagen_tipo'                  => trim($rowMSSQL['organizacion_imagen_tipo']),
                    'organizacion_image_link'                   => trim($rowMSSQL['organizacion_image_link']),
                    'organizacion_imagen_valor'                 => $rowMSSQL['organizacion_imagen_valor'],
                    'organizacion_imagen_path'                  => 'imagen/organizacion/img_'.$rowMSSQL['organizacion_codigo'].'.'.$ext,
                    'organizacion_ultima_actualizacion'         => $actualizacion_horario,
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'organizacion_codigo'                       => '',
                    'organizacion_nombre'                       => '',
                    'organizacion_nombre_corto'                 => '',
                    'organizacion_imagen_tipo'                  => '',
                    'organizacion_image_link'                   => '',
                    'organizacion_imagen_valor'                 => '',
                    'organizacion_imagen_path'                  => '',
                    'organizacion_ultima_actualizacion'         => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/700/{competicion}/{equipo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('competicion');
        $val02      = $request->getAttribute('equipo');
        
        if (isset($val01) && isset($val02)) {
            $sql00  = "";

            if ($val02 == 39393) {
                $sql00  = "SELECT
                a.competitionFifaId                 AS          competicion_codigo,
                b.personFifaId                      AS          jugador_codigo,
                b.internationalLastName             AS          jugador_apellido,
                b.internationalFirstName            AS          jugador_nombre
                
                FROM [comet].[competitions_teams_players] a
                INNER JOIN [comet].[persons] b ON a.playerFifaId = b.personFifaId
                
                WHERE a.competitionFifaId = ?

                ORDER BY a.competitionFifaId";
            } else {
                $sql00  = "SELECT
                a.competitionFifaId                 AS          competicion_codigo,
                b.personFifaId                      AS          jugador_codigo,
                b.internationalLastName             AS          jugador_apellido,
                b.internationalFirstName            AS          jugador_nombre
                
                FROM [comet].[competitions_teams_players] a
                INNER JOIN [comet].[persons] b ON a.playerFifaId = b.personFifaId
                
                WHERE a.competitionFifaId = ? AND a.teamFifaId = ?

                ORDER BY a.competitionFifaId";
            }

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val02 == 39393) {
                    $stmtMSSQL->execute([$val01]);
                } else {
                    $stmtMSSQL->execute([$val01, $val02]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'jugador_codigo'                        => trim($rowMSSQL['jugador_codigo']),
                        'jugador_apellido'                      => trim($rowMSSQL['jugador_apellido']),
                        'jugador_nombre'                        => trim($rowMSSQL['jugador_nombre']),
                        'jugador_completo'                      => trim($rowMSSQL['jugador_apellido']).', '.trim($rowMSSQL['jugador_nombre'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'competicion_codigo'                    => '',
                        'jugador_apellido'                      => '',
                        'jugador_nombre'                        => '',
                        'jugador_completo'                      => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });