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
            $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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
            $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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

    $app->get('/v1/200/disciplina/{equipo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        
        if (isset($val01)) {
            $sql00  = "";

            if ($val01 == 39393) {
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
                
                WHERE a.superiorCompetitionFifaId IS NULL

                 ORDER BY a.season DESC, a.competitionFifaId DESC";
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
                
                WHERE a.superiorCompetitionFifaId IS NULL AND c.teamFifaId = ?

                 ORDER BY a.season DESC, a.competitionFifaId DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
                    $stmtMSSQL->execute();
                } else {
                    $stmtMSSQL->execute([$val01]);
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

                    $competicion_nombre         = trim($rowMSSQL['competicion_nombre']);
                    $competicion_nombre         = str_replace('\u00da', 'Ú', $competicion_nombre);
                    $competicion_nombre         = str_replace('\u00d3', 'Ó', $competicion_nombre);
                    $competicion_nombre         = str_replace('\u00c9', 'É', $competicion_nombre);
                    $competicion_nombre         = str_replace('"', '', $competicion_nombre);

                    $competicion_nombre_corto   = trim($rowMSSQL['competicion_nombre_corto']);
                    $competicion_nombre_corto   = str_replace('\u00da', 'Ú', $competicion_nombre_corto);
                    $competicion_nombre_corto   = str_replace('\u00d3', 'Ó', $competicion_nombre_corto);
                    $competicion_nombre_corto   = str_replace('\u00c9', 'É', $competicion_nombre_corto);
                    $competicion_nombre_corto   = str_replace('"', '', $competicion_nombre_corto);

                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim($rowMSSQL['competicion_estado']),
                        'competicion_nombre'                    => $competicion_nombre,
                        'competicion_nombre_corto'              => $competicion_nombre_corto,
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

                 ORDER BY a.season DESC, a.competitionFifaId DESC";
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

                 ORDER BY a.season DESC, a.competitionFifaId DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
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

            ORDER BY a.season DESC, a.competitionFifaId DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val02 == 39393) {
                    $stmtMSSQL->execute([$val01, $val01]); 
                } else {
                    $stmtMSSQL->execute([$val01, $val01, $val02, $val02]); 
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $juego_horario  = date_format(date_create($rowMSSQL['juego_horario']), 'd/m/Y H:i:s');
                    $juego_cierra   = date("Y-m-d", strtotime($rowMSSQL['juego_horario']."+ 10 days"));

                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim($rowMSSQL['competicion_estado']),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],
                        'juego_codigo'                          => $rowMSSQL['juego_codigo'],
                        'juego_fase'                            => trim($rowMSSQL['juego_fase']),
                        'juego_estado'                          => trim($rowMSSQL['juego_estado']),
                        'juego_horario'                         => $juego_horario,
                        'juego_cierra'                         => $juego_cierra,
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
                        'juego_cierra'                          => '',
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

    $app->get('/v1/200/juego/{competicion}/{equipo}/{juego}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('competicion');
        $val02      = $request->getAttribute('equipo');
        $val03      = $request->getAttribute('juego');

        if (isset($val01) && isset($val02) && isset($val03)) {
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
                
                WHERE (a.COMPETICION_ID = ? OR a.COMPETICION_PADRE_ID = ?) AND a.JUEGO_CODIGO = ?
    
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
                
                WHERE (a.COMPETICION_ID = ? OR a.COMPETICION_PADRE_ID = ?) AND (a.EQUIPO_LOCAL_CODIGO = ? OR a.EQUIPO_VISITANTE_CODIGO = ?) AND a.JUEGO_CODIGO = ?
    
                ORDER BY a.COMPETICION_PADRE_ID DESC, a.JUEGO_HORARIO DESC, a.JUEGO_CODIGO DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val02 == 39393) {
                    $stmtMSSQL->execute([$val01, $val01, $val03]); 
                } else {
                    $stmtMSSQL->execute([$val01, $val01, $val02, $val02, $val03]); 
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $juego_horario  = date_format(date_create($rowMSSQL['juego_horario']), 'd/m/Y H:i:s');
                    $juego_cierra   = date("Y-m-d", strtotime($rowMSSQL['juego_horario']."+ 10 days"));

                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim($rowMSSQL['competicion_estado']),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],
                        'juego_codigo'                          => $rowMSSQL['juego_codigo'],
                        'juego_fase'                            => trim($rowMSSQL['juego_fase']),
                        'juego_estado'                          => trim($rowMSSQL['juego_estado']),
                        'juego_horario'                         => $juego_horario,
                        'juego_cierra'                          => $juego_cierra,
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
                        'juego_cierra'                          => '',
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

    $app->get('/v1/200/juegotop4/{competicion}/{equipo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('competicion');
        $val02      = $request->getAttribute('equipo');

        if (isset($val01) && isset($val02)) {
            if ($val02 == 39393) {
                $sql00  = "SELECT TOP 4
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
                $sql00  = "SELECT TOP 4
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
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val02 == 39393) {
                    $stmtMSSQL->execute([$val01, $val01]); 
                } else {
                    $stmtMSSQL->execute([$val01, $val01, $val02, $val02]); 
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $juego_horario  = date_format(date_create($rowMSSQL['juego_horario']), 'd/m/Y H:i:s');
                    $juego_cierra   = date("Y-m-d", strtotime($rowMSSQL['juego_horario']."+ 10 days"));

                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim($rowMSSQL['competicion_estado']),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],
                        'juego_codigo'                          => $rowMSSQL['juego_codigo'],
                        'juego_fase'                            => trim($rowMSSQL['juego_fase']),
                        'juego_estado'                          => trim($rowMSSQL['juego_estado']),
                        'juego_horario'                         => $juego_horario,
                        'juego_cierra'                          => $juego_cierra,
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
                        'juego_cierra'                          => '',
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
            $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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

    $app->get('/v1/400', function($request) {
        require __DIR__.'/../src/connect.php';

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

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

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
                $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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

    $app->get('/v1/401/competicion', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT 
        a.PERCOMOBS                         AS          competicion_persona_observacion,
        
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
        c.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
        c.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
        c.DOMFICNOP                         AS          tipo_estado_nombre_portugues,

        d.DOMFICCOD                         AS          tipo_acceso_codigo,
        d.DOMFICNOI                         AS          tipo_acceso_nombre_ingles,
        d.DOMFICNOC                         AS          tipo_acceso_nombre_castellano,
        d.DOMFICNOP                         AS          tipo_acceso_nombre_portugues,

        e.DOMFICCOD                         AS          tipo_perfil_codigo,
        e.DOMFICNOI                         AS          tipo_perfil_nombre_ingles,
        e.DOMFICNOC                         AS          tipo_perfil_nombre_castellano,
        e.DOMFICNOP                         AS          tipo_perfil_nombre_portugues,

        f.teamFifaId                        AS          equipo_codigo,
        f.internationalShortName            AS          equipo_nombre,

        g.DOMFICCOD                         AS          tipo_categoria_codigo,
        g.DOMFICNOI                         AS          tipo_categoria_nombre_ingles,
        g.DOMFICNOC                         AS          tipo_categoria_nombre_castellano,
        g.DOMFICNOP                         AS          tipo_categoria_nombre_portugues,

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
        i.DOMFICNOI                         AS          tipo_modulo_nombre_ingles,
        i.DOMFICNOC                         AS          tipo_modulo_nombre_castellano,
        i.DOMFICNOP                         AS          tipo_modulo_nombre_portugues
        
        FROM [adm].[PERCOM] a
        INNER JOIN [adm].[PERFIC] b ON a.PERCOMPEC = b.PERFICCOD
        INNER JOIN [adm].[DOMFIC] c ON b.PERFICEST = c.DOMFICCOD
        INNER JOIN [adm].[DOMFIC] d ON b.PERFICTIP = d.DOMFICCOD
        INNER JOIN [adm].[DOMFIC] e ON b.PERFICROL = e.DOMFICCOD
        INNER JOIN [comet].[teams] f ON b.PERFICEQU = f.teamFifaId
        INNER JOIN [adm].[DOMFIC] g ON b.PERFICCAT = g.DOMFICCOD
        INNER JOIN [comet].[competitions] h ON a.PERCOMCOC = h.competitionFifaId
        INNER JOIN [adm].[DOMFIC] i ON a.PERCOMTMC = i.DOMFICCOD
        
        ORDER BY a.PERCOMTMC, a.PERCOMCOC, a.PERCOMPEC";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute([$val01]);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {    
                $auditoria_fecha_hora = date_format(date_create($rowMSSQL['auditoria_fecha_hora']), 'd/m/Y H:i:s');
                
                if (isset($rowMSSQL['persona_path'])){
                    $persona_path = $rowMSSQL['persona_path'];
                } else {
                    $persona_path = 'assets/images/users/defaul.png';
                }

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
                    'competicion_persona_observacion'       => trim($rowMSSQL['competicion_persona_observacion']),
                    'auditoria_usuario'                     => trim($rowMSSQL['auditoria_usuario']),
                    'auditoria_fecha_hora'                  => $auditoria_fecha_hora,
                    'auditoria_ip'                          => trim($rowMSSQL['auditoria_ip']),

                    'persona_codigo'                        => $rowMSSQL['persona_codigo'],
                    'persona_nombre'                        => trim($rowMSSQL['persona_nombre']),
                    'persona_user'                          => trim($rowMSSQL['persona_user']),
                    'persona_path'                          => $persona_path,
                    'persona_email'                         => trim($rowMSSQL['persona_email']),
                    'persona_telefono'                      => trim($rowMSSQL['persona_telefono']),

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
                    'tipo_categoria_nombre_portugues'       => trim($rowMSSQL['tipo_categoria_nombre_portugues']),

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
                    'competicion_imagen_path'               => 'imagen/competencia/img_'.$rowMSSQL['competicion_codigo'].'.'.$ext,
                    'competicion_ultima_actualizacion'      => $rowMSSQL['competicion_ultima_actualizacion'],

                    'tipo_modulo_codigo'                    => $rowMSSQL['tipo_modulo_codigo'],
                    'tipo_modulo_nombre_ingles'             => trim($rowMSSQL['tipo_modulo_nombre_ingles']),
                    'tipo_modulo_nombre_castellano'         => trim($rowMSSQL['tipo_modulo_nombre_castellano']),
                    'tipo_modulo_nombre_portugues'          => trim($rowMSSQL['tipo_modulo_nombre_portugues'])
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'competicion_persona_observacion'       => '',
                    'auditoria_usuario'                     => '',
                    'auditoria_fecha_hora'                  => '',
                    'auditoria_ip'                          => '',

                    'persona_codigo'                        => '',
                    'persona_nombre'                        => '',
                    'persona_user'                          => '',
                    'persona_path'                          => '',
                    'persona_email'                         => '',
                    'persona_telefono'                      => '',

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
                    'tipo_categoria_nombre_portugues'       => '',

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
                    'competicion_ultima_actualizacion'      => '',

                    'tipo_modulo_codigo'                    => '',
                    'tipo_modulo_nombre_ingles'             => '',
                    'tipo_modulo_nombre_castellano'         => '',
                    'tipo_modulo_nombre_portugues'          => ''
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

    $app->get('/v1/401/competicion/{equipo}/{persona}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('equipo');
        $val02  = $request->getAttribute('persona');
        
        if (isset($val01) && isset($val02)) {
            if ($val01 == 39393) {
                $sql00  = "SELECT 
                    a.PERCOMOBS                         AS          competicion_persona_observacion,
                    
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
                    c.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
                    c.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
                    c.DOMFICNOP                         AS          tipo_estado_nombre_portugues,

                    d.DOMFICCOD                         AS          tipo_acceso_codigo,
                    d.DOMFICNOI                         AS          tipo_acceso_nombre_ingles,
                    d.DOMFICNOC                         AS          tipo_acceso_nombre_castellano,
                    d.DOMFICNOP                         AS          tipo_acceso_nombre_portugues,

                    e.DOMFICCOD                         AS          tipo_perfil_codigo,
                    e.DOMFICNOI                         AS          tipo_perfil_nombre_ingles,
                    e.DOMFICNOC                         AS          tipo_perfil_nombre_castellano,
                    e.DOMFICNOP                         AS          tipo_perfil_nombre_portugues,

                    f.teamFifaId                        AS          equipo_codigo,
                    f.internationalShortName            AS          equipo_nombre,

                    g.DOMFICCOD                         AS          tipo_categoria_codigo,
                    g.DOMFICNOI                         AS          tipo_categoria_nombre_ingles,
                    g.DOMFICNOC                         AS          tipo_categoria_nombre_castellano,
                    g.DOMFICNOP                         AS          tipo_categoria_nombre_portugues,

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
                    i.DOMFICNOI                         AS          tipo_modulo_nombre_ingles,
                    i.DOMFICNOC                         AS          tipo_modulo_nombre_castellano,
                    i.DOMFICNOP                         AS          tipo_modulo_nombre_portugues
                    
                    FROM [adm].[PERCOM] a
                    INNER JOIN [adm].[PERFIC] b ON a.PERCOMPEC = b.PERFICCOD
                    INNER JOIN [adm].[DOMFIC] c ON b.PERFICEST = c.DOMFICCOD
                    INNER JOIN [adm].[DOMFIC] d ON b.PERFICTIP = d.DOMFICCOD
                    INNER JOIN [adm].[DOMFIC] e ON b.PERFICROL = e.DOMFICCOD
                    INNER JOIN [comet].[teams] f ON b.PERFICEQU = f.teamFifaId
                    INNER JOIN [adm].[DOMFIC] g ON b.PERFICCAT = g.DOMFICCOD
                    INNER JOIN [comet].[competitions] h ON a.PERCOMCOC = h.competitionFifaId
                    INNER JOIN [adm].[DOMFIC] i ON a.PERCOMTMC = i.DOMFICCOD
                    
                    ORDER BY a.PERCOMTMC, a.PERCOMCOC, a.PERCOMPEC";
            } else {
                $sql00  = "SELECT 
                    a.PERCOMOBS                         AS          competicion_persona_observacion,
                    
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
                    c.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
                    c.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
                    c.DOMFICNOP                         AS          tipo_estado_nombre_portugues,

                    d.DOMFICCOD                         AS          tipo_acceso_codigo,
                    d.DOMFICNOI                         AS          tipo_acceso_nombre_ingles,
                    d.DOMFICNOC                         AS          tipo_acceso_nombre_castellano,
                    d.DOMFICNOP                         AS          tipo_acceso_nombre_portugues,

                    e.DOMFICCOD                         AS          tipo_perfil_codigo,
                    e.DOMFICNOI                         AS          tipo_perfil_nombre_ingles,
                    e.DOMFICNOC                         AS          tipo_perfil_nombre_castellano,
                    e.DOMFICNOP                         AS          tipo_perfil_nombre_portugues,

                    f.teamFifaId                        AS          equipo_codigo,
                    f.internationalShortName            AS          equipo_nombre,

                    g.DOMFICCOD                         AS          tipo_categoria_codigo,
                    g.DOMFICNOI                         AS          tipo_categoria_nombre_ingles,
                    g.DOMFICNOC                         AS          tipo_categoria_nombre_castellano,
                    g.DOMFICNOP                         AS          tipo_categoria_nombre_portugues,

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
                    i.DOMFICNOI                         AS          tipo_modulo_nombre_ingles,
                    i.DOMFICNOC                         AS          tipo_modulo_nombre_castellano,
                    i.DOMFICNOP                         AS          tipo_modulo_nombre_portugues
                    
                    FROM [adm].[PERCOM] a
                    INNER JOIN [adm].[PERFIC] b ON a.PERCOMPEC = b.PERFICCOD
                    INNER JOIN [adm].[DOMFIC] c ON b.PERFICEST = c.DOMFICCOD
                    INNER JOIN [adm].[DOMFIC] d ON b.PERFICTIP = d.DOMFICCOD
                    INNER JOIN [adm].[DOMFIC] e ON b.PERFICROL = e.DOMFICCOD
                    INNER JOIN [comet].[teams] f ON b.PERFICEQU = f.teamFifaId
                    INNER JOIN [adm].[DOMFIC] g ON b.PERFICCAT = g.DOMFICCOD
                    INNER JOIN [comet].[competitions] h ON a.PERCOMCOC = h.competitionFifaId
                    INNER JOIN [adm].[DOMFIC] i ON a.PERCOMTMC = i.DOMFICCOD

                    WHERE a.PERCOMPEC = ? AND b.PERFICEQU = ?
                    
                    ORDER BY a.PERCOMTMC, a.PERCOMCOC, a.PERCOMPEC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                
                if ($val01 == 39393) {
                    $stmtMSSQL->execute();
                } else {
                    $stmtMSSQL->execute([$val02, $val01]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {    
                    $auditoria_fecha_hora = date_format(date_create($rowMSSQL['auditoria_fecha_hora']), 'd/m/Y H:i:s');
                    
                    if (isset($rowMSSQL['persona_path'])){
                        $persona_path = $rowMSSQL['persona_path'];
                    } else {
                        $persona_path = 'assets/images/users/defaul.png';
                    }

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
                        'competicion_persona_observacion'       => trim($rowMSSQL['competicion_persona_observacion']),
                        'auditoria_usuario'                     => trim($rowMSSQL['auditoria_usuario']),
                        'auditoria_fecha_hora'                  => $auditoria_fecha_hora,
                        'auditoria_ip'                          => trim($rowMSSQL['auditoria_ip']),

                        'persona_codigo'                        => $rowMSSQL['persona_codigo'],
                        'persona_nombre'                        => trim($rowMSSQL['persona_nombre']),
                        'persona_user'                          => trim($rowMSSQL['persona_user']),
                        'persona_path'                          => $persona_path,
                        'persona_email'                         => trim($rowMSSQL['persona_email']),
                        'persona_telefono'                      => trim($rowMSSQL['persona_telefono']),

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
                        'tipo_categoria_nombre_portugues'       => trim($rowMSSQL['tipo_categoria_nombre_portugues']),

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
                        'competicion_imagen_path'               => 'imagen/competencia/img_'.$rowMSSQL['competicion_codigo'].'.'.$ext,
                        'competicion_ultima_actualizacion'      => $rowMSSQL['competicion_ultima_actualizacion'],

                        'tipo_modulo_codigo'                    => $rowMSSQL['tipo_modulo_codigo'],
                        'tipo_modulo_nombre_ingles'             => trim($rowMSSQL['tipo_modulo_nombre_ingles']),
                        'tipo_modulo_nombre_castellano'         => trim($rowMSSQL['tipo_modulo_nombre_castellano']),
                        'tipo_modulo_nombre_portugues'          => trim($rowMSSQL['tipo_modulo_nombre_portugues'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'competicion_persona_observacion'       => '',
                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',

                        'persona_codigo'                        => '',
                        'persona_nombre'                        => '',
                        'persona_user'                          => '',
                        'persona_path'                          => '',
                        'persona_email'                         => '',
                        'persona_telefono'                      => '',

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
                        'tipo_categoria_nombre_portugues'       => '',

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
                        'competicion_ultima_actualizacion'      => '',

                        'tipo_modulo_codigo'                    => '',
                        'tipo_modulo_nombre_ingles'             => '',
                        'tipo_modulo_nombre_castellano'         => '',
                        'tipo_modulo_nombre_portugues'          => ''
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
            $connMSSQL  = getConnectionMSSQLv1();
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
                $connMSSQL  = getConnectionMSSQLv1();
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

    $app->get('/v1/600/{equipo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        
        if (isset($val01)) {
            $sql00  = "";

            if ($val01 == 39393) {
                $sql00  = "SELECT
                a.LESFICCOD                 AS          lesion_codigo,
                a.LESFICFEC                 AS          lesion_fecha_alta,
                a.LESFICFER                 AS          lesion_fecha_retorno,
                a.LESFICCIR                 As          lesion_cirugia,
                a.LESFICTEM                 AS          temperatura_numero,
                a.LESFICOBS                 As          lesion_observacion,

                b.DOMFICCOD                 AS          tipo_estado_codigo,
                b.DOMFICNOI                 AS          tipo_estado_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_estado_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_estado_nombre_portugues,

                c.DOMFICCOD                 AS          tipo_clima_codigo,
                c.DOMFICNOI                 AS          tipo_clima_nombre_ingles,
                c.DOMFICNOC                 AS          tipo_clima_nombre_castellano,
                c.DOMFICNOP                 AS          tipo_clima_nombre_portugues,

                d.DOMFICCOD                 AS          tipo_distancia_codigo,
                d.DOMFICNOI                 AS          tipo_distancia_nombre_ingles,
                d.DOMFICNOC                 AS          tipo_distancia_nombre_castellano,
                d.DOMFICNOP                 AS          tipo_distancia_nombre_portugues,

                e.DOMFICCOD                 AS          tipo_traslado_codigo,
                e.DOMFICNOI                 AS          tipo_traslado_nombre_ingles,
                e.DOMFICNOC                 AS          tipo_traslado_nombre_castellano,
                e.DOMFICNOP                 AS          tipo_traslado_nombre_portugues,

                f.DOMFICCOD                 AS          tipo_posicion_codigo,
                f.DOMFICNOI                 AS          tipo_posicion_nombre_ingles,
                f.DOMFICNOC                 AS          tipo_posicion_nombre_castellano,
                f.DOMFICNOP                 AS          tipo_posicion_nombre_portugues,

                g.DOMFICCOD                 AS          tipo_minuto_codigo,
                g.DOMFICNOI                 AS          tipo_minuto_nombre_ingles,
                g.DOMFICNOC                 AS          tipo_minuto_nombre_castellano,
                g.DOMFICNOP                 AS          tipo_minuto_nombre_portugues,

                h.DOMFICCOD                 AS          tipo_campo_codigo,
                h.DOMFICNOI                 AS          tipo_campo_nombre_ingles,
                h.DOMFICNOC                 AS          tipo_campo_nombre_castellano,
                h.DOMFICNOP                 AS          tipo_campo_nombre_portugues,

                i.DOMSUBCOD                 AS          tipo_cuerpo_zona_codigo,
                i.DOMSUBNOI                 AS          tipo_cuerpo_zona_nombre_ingles,
                i.DOMSUBNOC                 AS          tipo_cuerpo_zona_nombre_castellano,
                i.DOMSUBNOP                 AS          tipo_cuerpo_zona_nombre_portugues,

                j.DOMFICCOD                 AS          tipo_cuerpo_lugar_codigo,
                j.DOMFICNOI                 AS          tipo_cuerpo_lugar_nombre_ingles,
                j.DOMFICNOC                 AS          tipo_cuerpo_lugar_nombre_castellano,
                j.DOMFICNOP                 AS          tipo_cuerpo_lugar_nombre_portugues,

                k.DOMFICCOD                 AS          tipo_lesion_codigo,
                k.DOMFICNOI                 AS          tipo_lesion_nombre_ingles,
                k.DOMFICNOC                 AS          tipo_lesion_nombre_castellano,
                k.DOMFICNOP                 AS          tipo_lesion_nombre_portugues,

                l.DOMFICCOD                 AS          tipo_lesion_origen_codigo,
                l.DOMFICNOI                 AS          tipo_lesion_origen_nombre_ingles,
                l.DOMFICNOC                 AS          tipo_lesion_origen_nombre_castellano,
                l.DOMFICNOP                 AS          tipo_lesion_origen_nombre_portugues,

                m.DOMFICCOD                 AS          tipo_lesion_reincidencia_codigo,
                m.DOMFICNOI                 AS          tipo_lesion_reincidencia_nombre_ingles,
                m.DOMFICNOC                 AS          tipo_lesion_reincidencia_nombre_castellano,
                m.DOMFICNOP                 AS          tipo_lesion_reincidencia_nombre_portugues,

                x.DOMFICCOD                 AS          tipo_lesion_retiro_codigo,
                x.DOMFICNOI                 AS          tipo_lesion_retiro_nombre_ingles,
                x.DOMFICNOC                 AS          tipo_lesion_retiro_nombre_castellano,
                x.DOMFICNOP                 AS          tipo_lesion_retiro_nombre_portugues,

                n.DOMFICCOD                 AS          tipo_lesion_causa_codigo,
                n.DOMFICNOI                 AS          tipo_lesion_causa_nombre_ingles,
                n.DOMFICNOC                 AS          tipo_lesion_causa_nombre_castellano,
                n.DOMFICNOP                 AS          tipo_lesion_causa_nombre_portugues,

                w1.DOMFICCOD                AS          tipo_lesion_examen1_codigo,
                w1.DOMFICNOI                AS          tipo_lesion_examen1_nombre_ingles,
                w1.DOMFICNOC                AS          tipo_lesion_examen1_nombre_castellano,
                w1.DOMFICNOP                AS          tipo_lesion_examen1_nombre_portugues,

                w2.DOMFICCOD                AS          tipo_lesion_examen2_codigo,
                w2.DOMFICNOI                AS          tipo_lesion_examen2_nombre_ingles,
                w2.DOMFICNOC                AS          tipo_lesion_examen2_nombre_castellano,
                w2.DOMFICNOP                AS          tipo_lesion_examen2_nombre_portugues,

                w3.DOMFICCOD                AS          tipo_lesion_examen3_codigo,
                w3.DOMFICNOI                AS          tipo_lesion_examen3_nombre_ingles,
                w3.DOMFICNOC                AS          tipo_lesion_examen3_nombre_castellano,
                w3.DOMFICNOP                AS          tipo_lesion_examen3_nombre_portugues,

                w4.DOMFICCOD                AS          tipo_lesion_examen4_codigo,
                w4.DOMFICNOI                AS          tipo_lesion_examen4_nombre_ingles,
                w4.DOMFICNOC                AS          tipo_lesion_examen4_nombre_castellano,
                w4.DOMFICNOP                AS          tipo_lesion_examen4_nombre_portugues,

                w5.DOMFICCOD                AS          tipo_lesion_examen5_codigo,
                w5.DOMFICNOI                AS          tipo_lesion_examen5_nombre_ingles,
                w5.DOMFICNOC                AS          tipo_lesion_examen5_nombre_castellano,
                w5.DOMFICNOP                AS          tipo_lesion_examen5_nombre_portugues,

                o.DOMFICCOD                 AS          tipo_lesion_falta_codigo,
                o.DOMFICNOI                 AS          tipo_lesion_falta_nombre_ingles,
                o.DOMFICNOC                 AS          tipo_lesion_falta_nombre_castellano,
                o.DOMFICNOP                 AS          tipo_lesion_falta_nombre_portugues,

                p.DOMSUBCOD                 AS          tipo_diagnostico_codigo,
                p.DOMSUBNOI                 AS          tipo_diagnostico_nombre_ingles,
                p.DOMSUBNOC                 AS          tipo_diagnostico_nombre_castellano,
                p.DOMSUBNOP                 AS          tipo_diagnostico_nombre_portugues,
                a.LESFICOBD                 AS          tipo_diagnostico_observacion,

                p1.DOMSUBCOD                AS          tipo_diagnostico_retorno_codigo,
                p1.DOMSUBNOI                AS          tipo_diagnostico_retorno_nombre_ingles,
                p1.DOMSUBNOC                AS          tipo_diagnostico_retorno_nombre_castellano,
                p1.DOMSUBNOP                AS          tipo_diagnostico_retorno_nombre_portugues,
                a.LESFICOBR                 AS          tipo_diagnostico_retorno_observacion,
                a.LESFICTRR                 AS          tipo_diagnostico_retorno_tratamiento,

                q.DOMFICCOD                 AS          tipo_diagnostico_recuperacion_codigo,
                q.DOMFICNOI                 AS          tipo_diagnostico_recuperacion_nombre_ingles,
                q.DOMFICNOC                 AS          tipo_diagnostico_recuperacion_nombre_castellano,
                q.DOMFICNOP                 AS          tipo_diagnostico_recuperacion_nombre_portugues,

                r.DOMFICCOD                 AS          tipo_diagnostico_tiempo_codigo,
                r.DOMFICNOI                 AS          tipo_diagnostico_tiempo_nombre_ingles,
                r.DOMFICNOC                 AS          tipo_diagnostico_tiempo_nombre_castellano,
                r.DOMFICNOP                 AS          tipo_diagnostico_tiempo_nombre_portugues,

                s.competitionFifaId         AS          competicion_codigo,
                s.internationalName         AS          competicion_nombre,

                t.JUEGO_CODIGO              AS          juego_codigo,
                t.EQUIPO_LOCAL_NOMBRE       AS          juego_equipo_local,
                t.EQUIPO_VISITANTE_NOMBRE   AS          juego_equpo_visitante,

                u.teamFifaId                AS          equipo_codigo,
                u.internationalName         AS          equipo_nombre,

                v.personFifaId              AS          jugador_codigo,
                v.internationalFirstName    AS          jugador_nombre,
                v.internationalLastName     AS          jugador_apellido,

                a.LESFICAUS                 AS          auditoria_usuario,
                a.LESFICAFH                 AS          auditoria_fecha_hora,
                a.LESFICAIP                 AS          auditoria_ip

                FROM [lesion].[LESFIC] a
                LEFT OUTER JOIN [adm].[DOMFIC] b ON a.LESFICESC = b.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] c ON a.LESFICCLI = c.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] d ON a.LESFICDIS = d.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] e ON a.LESFICTRA = e.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] f ON a.LESFICPOS = f.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] g ON a.LESFICMIN = g.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.LESFICCAM = h.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMSUB] i ON a.LESFICCUZ = i.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMFIC] j ON a.LESFICCUL = j.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] k ON a.LESFICLES = k.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] l ON a.LESFICORI = l.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] m ON a.LESFICREI = m.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] n ON a.LESFICCAU = n.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] o ON a.LESFICFAL = o.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMSUB] p ON a.LESFICDIA = p.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMSUB] p1 ON a.LESFICDIR = p1.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMFIC] q ON a.LESFICREC = q.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] r ON a.LESFICTIE = r.DOMFICCOD
                LEFT OUTER JOIN [comet].[competitions] s ON a.LESFICCOC = s.competitionFifaId
                LEFT OUTER JOIN [view].[juego] t ON a.LESFICJUC = t.JUEGO_CODIGO
                LEFT OUTER JOIN [comet].[teams] u ON a.LESFICEQC = u.teamFifaId
                LEFT OUTER JOIN [comet].[persons] v ON a.LESFICPEC = v.personFifaId
                LEFT OUTER JOIN [adm].[DOMFIC] w1 ON a.LESFICEX1 = w1.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w2 ON a.LESFICEX2 = w2.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w3 ON a.LESFICEX3 = w3.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w4 ON a.LESFICEX4 = w4.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w5 ON a.LESFICEX5 = w5.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] x ON a.LESFICRET = x.DOMFICCOD

                ORDER BY a.LESFICCOD DESC";
            } else {
                $sql00  = "SELECT
                a.LESFICCOD                 AS          lesion_codigo,
                a.LESFICFEC                 AS          lesion_fecha_alta,
                a.LESFICFER                 AS          lesion_fecha_retorno,
                a.LESFICCIR                 As          lesion_cirugia,
                a.LESFICTEM                 AS          temperatura_numero,
                a.LESFICOBS                 As          lesion_observacion,

                b.DOMFICCOD                 AS          tipo_estado_codigo,
                b.DOMFICNOI                 AS          tipo_estado_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_estado_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_estado_nombre_portugues,

                c.DOMFICCOD                 AS          tipo_clima_codigo,
                c.DOMFICNOI                 AS          tipo_clima_nombre_ingles,
                c.DOMFICNOC                 AS          tipo_clima_nombre_castellano,
                c.DOMFICNOP                 AS          tipo_clima_nombre_portugues,

                d.DOMFICCOD                 AS          tipo_distancia_codigo,
                d.DOMFICNOI                 AS          tipo_distancia_nombre_ingles,
                d.DOMFICNOC                 AS          tipo_distancia_nombre_castellano,
                d.DOMFICNOP                 AS          tipo_distancia_nombre_portugues,

                e.DOMFICCOD                 AS          tipo_traslado_codigo,
                e.DOMFICNOI                 AS          tipo_traslado_nombre_ingles,
                e.DOMFICNOC                 AS          tipo_traslado_nombre_castellano,
                e.DOMFICNOP                 AS          tipo_traslado_nombre_portugues,

                f.DOMFICCOD                 AS          tipo_posicion_codigo,
                f.DOMFICNOI                 AS          tipo_posicion_nombre_ingles,
                f.DOMFICNOC                 AS          tipo_posicion_nombre_castellano,
                f.DOMFICNOP                 AS          tipo_posicion_nombre_portugues,

                g.DOMFICCOD                 AS          tipo_minuto_codigo,
                g.DOMFICNOI                 AS          tipo_minuto_nombre_ingles,
                g.DOMFICNOC                 AS          tipo_minuto_nombre_castellano,
                g.DOMFICNOP                 AS          tipo_minuto_nombre_portugues,

                h.DOMFICCOD                 AS          tipo_campo_codigo,
                h.DOMFICNOI                 AS          tipo_campo_nombre_ingles,
                h.DOMFICNOC                 AS          tipo_campo_nombre_castellano,
                h.DOMFICNOP                 AS          tipo_campo_nombre_portugues,

                i.DOMSUBCOD                 AS          tipo_cuerpo_zona_codigo,
                i.DOMSUBNOI                 AS          tipo_cuerpo_zona_nombre_ingles,
                i.DOMSUBNOC                 AS          tipo_cuerpo_zona_nombre_castellano,
                i.DOMSUBNOP                 AS          tipo_cuerpo_zona_nombre_portugues,

                j.DOMFICCOD                 AS          tipo_cuerpo_lugar_codigo,
                j.DOMFICNOI                 AS          tipo_cuerpo_lugar_nombre_ingles,
                j.DOMFICNOC                 AS          tipo_cuerpo_lugar_nombre_castellano,
                j.DOMFICNOP                 AS          tipo_cuerpo_lugar_nombre_portugues,

                k.DOMFICCOD                 AS          tipo_lesion_codigo,
                k.DOMFICNOI                 AS          tipo_lesion_nombre_ingles,
                k.DOMFICNOC                 AS          tipo_lesion_nombre_castellano,
                k.DOMFICNOP                 AS          tipo_lesion_nombre_portugues,

                l.DOMFICCOD                 AS          tipo_lesion_origen_codigo,
                l.DOMFICNOI                 AS          tipo_lesion_origen_nombre_ingles,
                l.DOMFICNOC                 AS          tipo_lesion_origen_nombre_castellano,
                l.DOMFICNOP                 AS          tipo_lesion_origen_nombre_portugues,

                m.DOMFICCOD                 AS          tipo_lesion_reincidencia_codigo,
                m.DOMFICNOI                 AS          tipo_lesion_reincidencia_nombre_ingles,
                m.DOMFICNOC                 AS          tipo_lesion_reincidencia_nombre_castellano,
                m.DOMFICNOP                 AS          tipo_lesion_reincidencia_nombre_portugues,

                x.DOMFICCOD                 AS          tipo_lesion_retiro_codigo,
                x.DOMFICNOI                 AS          tipo_lesion_retiro_nombre_ingles,
                x.DOMFICNOC                 AS          tipo_lesion_retiro_nombre_castellano,
                x.DOMFICNOP                 AS          tipo_lesion_retiro_nombre_portugues,

                n.DOMFICCOD                 AS          tipo_lesion_causa_codigo,
                n.DOMFICNOI                 AS          tipo_lesion_causa_nombre_ingles,
                n.DOMFICNOC                 AS          tipo_lesion_causa_nombre_castellano,
                n.DOMFICNOP                 AS          tipo_lesion_causa_nombre_portugues,

                w1.DOMFICCOD                AS          tipo_lesion_examen1_codigo,
                w1.DOMFICNOI                AS          tipo_lesion_examen1_nombre_ingles,
                w1.DOMFICNOC                AS          tipo_lesion_examen1_nombre_castellano,
                w1.DOMFICNOP                AS          tipo_lesion_examen1_nombre_portugues,

                w2.DOMFICCOD                AS          tipo_lesion_examen2_codigo,
                w2.DOMFICNOI                AS          tipo_lesion_examen2_nombre_ingles,
                w2.DOMFICNOC                AS          tipo_lesion_examen2_nombre_castellano,
                w2.DOMFICNOP                AS          tipo_lesion_examen2_nombre_portugues,

                w3.DOMFICCOD                AS          tipo_lesion_examen3_codigo,
                w3.DOMFICNOI                AS          tipo_lesion_examen3_nombre_ingles,
                w3.DOMFICNOC                AS          tipo_lesion_examen3_nombre_castellano,
                w3.DOMFICNOP                AS          tipo_lesion_examen3_nombre_portugues,

                w4.DOMFICCOD                AS          tipo_lesion_examen4_codigo,
                w4.DOMFICNOI                AS          tipo_lesion_examen4_nombre_ingles,
                w4.DOMFICNOC                AS          tipo_lesion_examen4_nombre_castellano,
                w4.DOMFICNOP                AS          tipo_lesion_examen4_nombre_portugues,

                w5.DOMFICCOD                AS          tipo_lesion_examen5_codigo,
                w5.DOMFICNOI                AS          tipo_lesion_examen5_nombre_ingles,
                w5.DOMFICNOC                AS          tipo_lesion_examen5_nombre_castellano,
                w5.DOMFICNOP                AS          tipo_lesion_examen5_nombre_portugues,

                o.DOMFICCOD                 AS          tipo_lesion_falta_codigo,
                o.DOMFICNOI                 AS          tipo_lesion_falta_nombre_ingles,
                o.DOMFICNOC                 AS          tipo_lesion_falta_nombre_castellano,
                o.DOMFICNOP                 AS          tipo_lesion_falta_nombre_portugues,

                p.DOMSUBCOD                 AS          tipo_diagnostico_codigo,
                p.DOMSUBNOI                 AS          tipo_diagnostico_nombre_ingles,
                p.DOMSUBNOC                 AS          tipo_diagnostico_nombre_castellano,
                p.DOMSUBNOP                 AS          tipo_diagnostico_nombre_portugues,
                a.LESFICOBD                 AS          tipo_diagnostico_observacion,

                p1.DOMSUBCOD                AS          tipo_diagnostico_retorno_codigo,
                p1.DOMSUBNOI                AS          tipo_diagnostico_retorno_nombre_ingles,
                p1.DOMSUBNOC                AS          tipo_diagnostico_retorno_nombre_castellano,
                p1.DOMSUBNOP                AS          tipo_diagnostico_retorno_nombre_portugues,
                a.LESFICOBR                 AS          tipo_diagnostico_retorno_observacion,
                a.LESFICTRR                 AS          tipo_diagnostico_retorno_tratamiento,

                q.DOMFICCOD                 AS          tipo_diagnostico_recuperacion_codigo,
                q.DOMFICNOI                 AS          tipo_diagnostico_recuperacion_nombre_ingles,
                q.DOMFICNOC                 AS          tipo_diagnostico_recuperacion_nombre_castellano,
                q.DOMFICNOP                 AS          tipo_diagnostico_recuperacion_nombre_portugues,

                r.DOMFICCOD                 AS          tipo_diagnostico_tiempo_codigo,
                r.DOMFICNOI                 AS          tipo_diagnostico_tiempo_nombre_ingles,
                r.DOMFICNOC                 AS          tipo_diagnostico_tiempo_nombre_castellano,
                r.DOMFICNOP                 AS          tipo_diagnostico_tiempo_nombre_portugues,

                s.competitionFifaId         AS          competicion_codigo,
                s.internationalName         AS          competicion_nombre,

                t.JUEGO_CODIGO              AS          juego_codigo,
                t.EQUIPO_LOCAL_NOMBRE       AS          juego_equipo_local,
                t.EQUIPO_VISITANTE_NOMBRE   AS          juego_equpo_visitante,

                u.teamFifaId                AS          equipo_codigo,
                u.internationalName         AS          equipo_nombre,

                v.personFifaId              AS          jugador_codigo,
                v.internationalFirstName    AS          jugador_nombre,
                v.internationalLastName     AS          jugador_apellido,

                a.LESFICAUS                 AS          auditoria_usuario,
                a.LESFICAFH                 AS          auditoria_fecha_hora,
                a.LESFICAIP                 AS          auditoria_ip

                FROM [lesion].[LESFIC] a
                LEFT OUTER JOIN [adm].[DOMFIC] b ON a.LESFICESC = b.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] c ON a.LESFICCLI = c.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] d ON a.LESFICDIS = d.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] e ON a.LESFICTRA = e.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] f ON a.LESFICPOS = f.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] g ON a.LESFICMIN = g.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.LESFICCAM = h.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMSUB] i ON a.LESFICCUZ = i.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMFIC] j ON a.LESFICCUL = j.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] k ON a.LESFICLES = k.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] l ON a.LESFICORI = l.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] m ON a.LESFICREI = m.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] n ON a.LESFICCAU = n.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] o ON a.LESFICFAL = o.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMSUB] p ON a.LESFICDIA = p.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMSUB] p1 ON a.LESFICDIR = p1.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMFIC] q ON a.LESFICREC = q.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] r ON a.LESFICTIE = r.DOMFICCOD
                LEFT OUTER JOIN [comet].[competitions] s ON a.LESFICCOC = s.competitionFifaId
                LEFT OUTER JOIN [view].[juego] t ON a.LESFICJUC = t.JUEGO_CODIGO
                LEFT OUTER JOIN [comet].[teams] u ON a.LESFICEQC = u.teamFifaId
                LEFT OUTER JOIN [comet].[persons] v ON a.LESFICPEC = v.personFifaId
                LEFT OUTER JOIN [adm].[DOMFIC] w1 ON a.LESFICEX1 = w1.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w2 ON a.LESFICEX2 = w2.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w3 ON a.LESFICEX3 = w3.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w4 ON a.LESFICEX4 = w4.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w5 ON a.LESFICEX5 = w5.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] x ON a.LESFICRET = x.DOMFICCOD

                WHERE a.LESFICEQC = ?
                
                ORDER BY a.LESFICCOD DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
                    $stmtMSSQL->execute([]);
                } else {
                    $stmtMSSQL->execute([$val01]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $lesion_cirugia_nombre = 'NO';

                    if (trim($rowMSSQL['lesion_cirugia']) == '2'){
                        $lesion_cirugia_nombre = 'SI';
                    }

                    $detalle    = array(
                        'lesion_codigo'                                             => ($rowMSSQL['lesion_codigo']),
                        'competicion_codigo'                                        => ($rowMSSQL['competicion_codigo']),
                        'lesion_fecha_alta'                                         => date_format(date_create($rowMSSQL['lesion_fecha_alta']), 'd/m/Y H:i:s'),
                        'lesion_fecha_retorno'                                      => date_format(date_create($rowMSSQL['lesion_fecha_retorno']), 'd/m/Y'),
                        'temperatura_numero'                                        => trim($rowMSSQL['temperatura_numero']),
                        'lesion_observacion'                                        => trim($rowMSSQL['lesion_observacion']),

                        'lesion_cirugia_codigo'                                     => trim($rowMSSQL['lesion_cirugia']),
                        'lesion_cirugia_nombre'                                     => $lesion_cirugia_nombre,

                        'tipo_estado_codigo'                                        => ($rowMSSQL['tipo_estado_codigo']),
                        'tipo_estado_nombre_ingles'                                 => trim($rowMSSQL['tipo_estado_nombre_ingles']),
                        'tipo_estado_nombre_castellano'                             => trim($rowMSSQL['tipo_estado_nombre_castellano']),
                        'tipo_estado_nombre_portugues'                              => trim($rowMSSQL['tipo_estado_nombre_portugues']),

                        'tipo_clima_codigo'                                         => ($rowMSSQL['tipo_clima_codigo']),
                        'tipo_clima_nombre_ingles'                                  => trim($rowMSSQL['tipo_clima_nombre_ingles']),
                        'tipo_clima_nombre_castellano'                              => trim($rowMSSQL['tipo_clima_nombre_castellano']),
                        'tipo_clima_nombre_portugues'                               => trim($rowMSSQL['tipo_clima_nombre_portugues']),

                        'tipo_distancia_codigo'                                     => ($rowMSSQL['tipo_distancia_codigo']),
                        'tipo_distancia_nombre_ingles'                              => trim($rowMSSQL['tipo_distancia_nombre_ingles']),
                        'tipo_distancia_nombre_castellano'                          => trim($rowMSSQL['tipo_distancia_nombre_castellano']),
                        'tipo_distancia_nombre_portugues'                           => trim($rowMSSQL['tipo_distancia_nombre_portugues']),

                        'tipo_traslado_codigo'                                      => ($rowMSSQL['tipo_traslado_codigo']),
                        'tipo_traslado_nombre_ingles'                               => trim($rowMSSQL['tipo_traslado_nombre_ingles']),
                        'tipo_traslado_nombre_castellano'                           => trim($rowMSSQL['tipo_traslado_nombre_castellano']),
                        'tipo_traslado_nombre_portugues'                            => trim($rowMSSQL['tipo_traslado_nombre_portugues']),

                        'tipo_posicion_codigo'                                      => ($rowMSSQL['tipo_posicion_codigo']),
                        'tipo_posicion_nombre_ingles'                               => trim($rowMSSQL['tipo_posicion_nombre_ingles']),
                        'tipo_posicion_nombre_castellano'                           => trim($rowMSSQL['tipo_posicion_nombre_castellano']),
                        'tipo_posicion_nombre_portugues'                            => trim($rowMSSQL['tipo_posicion_nombre_portugues']),

                        'tipo_minuto_codigo'                                        => ($rowMSSQL['tipo_minuto_codigo']),
                        'tipo_minuto_nombre_ingles'                                 => trim($rowMSSQL['tipo_minuto_nombre_ingles']),
                        'tipo_minuto_nombre_castellano'                             => trim($rowMSSQL['tipo_minuto_nombre_castellano']),
                        'tipo_minuto_nombre_portugues'                              => trim($rowMSSQL['tipo_minuto_nombre_portugues']),

                        'tipo_campo_codigo'                                         => ($rowMSSQL['tipo_campo_codigo']),
                        'tipo_campo_nombre_ingles'                                  => trim($rowMSSQL['tipo_campo_nombre_ingles']),
                        'tipo_campo_nombre_castellano'                              => trim($rowMSSQL['tipo_campo_nombre_castellano']),
                        'tipo_campo_nombre_portugues'                               => trim($rowMSSQL['tipo_campo_nombre_portugues']),

                        'tipo_cuerpo_zona_codigo'                                   => ($rowMSSQL['tipo_cuerpo_zona_codigo']),
                        'tipo_cuerpo_zona_nombre_ingles'                            => trim($rowMSSQL['tipo_cuerpo_zona_nombre_ingles']),
                        'tipo_cuerpo_zona_nombre_castellano'                        => trim($rowMSSQL['tipo_cuerpo_zona_nombre_castellano']),
                        'tipo_cuerpo_zona_nombre_portugues'                         => trim($rowMSSQL['tipo_cuerpo_zona_nombre_portugues']),

                        'tipo_cuerpo_lugar_codigo'                                  => ($rowMSSQL['tipo_cuerpo_lugar_codigo']),
                        'tipo_cuerpo_lugar_nombre_ingles'                           => trim($rowMSSQL['tipo_cuerpo_lugar_nombre_ingles']),
                        'tipo_cuerpo_lugar_nombre_castellano'                       => trim($rowMSSQL['tipo_cuerpo_lugar_nombre_castellano']),
                        'tipo_cuerpo_lugar_nombre_portugues'                        => trim($rowMSSQL['tipo_cuerpo_lugar_nombre_portugues']),

                        'tipo_lesion_codigo'                                        => ($rowMSSQL['tipo_lesion_codigo']),
                        'tipo_lesion_nombre_ingles'                                 => trim($rowMSSQL['tipo_lesion_nombre_ingles']),
                        'tipo_lesion_nombre_castellano'                             => trim($rowMSSQL['tipo_lesion_nombre_castellano']),
                        'tipo_lesion_nombre_portugues'                              => trim($rowMSSQL['tipo_lesion_nombre_portugues']),

                        'tipo_lesion_origen_codigo'                                 => ($rowMSSQL['tipo_lesion_origen_codigo']),
                        'tipo_lesion_origen_nombre_ingles'                          => trim($rowMSSQL['tipo_lesion_origen_nombre_ingles']),
                        'tipo_lesion_origen_nombre_castellano'                      => trim($rowMSSQL['tipo_lesion_origen_nombre_castellano']),
                        'tipo_lesion_origen_nombre_portugues'                       => trim($rowMSSQL['tipo_lesion_origen_nombre_portugues']),

                        'tipo_lesion_reincidencia_codigo'                           => ($rowMSSQL['tipo_lesion_reincidencia_codigo']),
                        'tipo_lesion_reincidencia_nombre_ingles'                    => trim($rowMSSQL['tipo_lesion_reincidencia_nombre_ingles']),
                        'tipo_lesion_reincidencia_nombre_castellano'                => trim($rowMSSQL['tipo_lesion_reincidencia_nombre_castellano']),
                        'tipo_lesion_reincidencia_nombre_portugues'                 => trim($rowMSSQL['tipo_lesion_reincidencia_nombre_portugues']),

                        'tipo_lesion_retiro_codigo'                                 => ($rowMSSQL['tipo_lesion_retiro_codigo']),
                        'tipo_lesion_retiro_nombre_ingles'                          => trim($rowMSSQL['tipo_lesion_retiro_nombre_ingles']),
                        'tipo_lesion_retiro_nombre_castellano'                      => trim($rowMSSQL['tipo_lesion_retiro_nombre_castellano']),
                        'tipo_lesion_retiro_nombre_portugues'                       => trim($rowMSSQL['tipo_lesion_retiro_nombre_portugues']),

                        'tipo_lesion_examen1_codigo'                                => ($rowMSSQL['tipo_lesion_examen1_codigo']),
                        'tipo_lesion_examen1_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen1_nombre_ingles']),
                        'tipo_lesion_examen1_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen1_nombre_castellano']),
                        'tipo_lesion_examen1_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen1_nombre_portugues']),

                        'tipo_lesion_examen2_codigo'                                => ($rowMSSQL['tipo_lesion_examen2_codigo']),
                        'tipo_lesion_examen2_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen2_nombre_ingles']),
                        'tipo_lesion_examen2_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen2_nombre_castellano']),
                        'tipo_lesion_examen2_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen2_nombre_portugues']),

                        'tipo_lesion_examen3_codigo'                                => ($rowMSSQL['tipo_lesion_examen3_codigo']),
                        'tipo_lesion_examen3_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen3_nombre_ingles']),
                        'tipo_lesion_examen3_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen3_nombre_castellano']),
                        'tipo_lesion_examen3_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen3_nombre_portugues']),

                        'tipo_lesion_examen4_codigo'                                => ($rowMSSQL['tipo_lesion_examen4_codigo']),
                        'tipo_lesion_examen4_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen4_nombre_ingles']),
                        'tipo_lesion_examen4_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen4_nombre_castellano']),
                        'tipo_lesion_examen4_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen4_nombre_portugues']),

                        'tipo_lesion_examen5_codigo'                                => ($rowMSSQL['tipo_lesion_examen5_codigo']),
                        'tipo_lesion_examen5_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen5_nombre_ingles']),
                        'tipo_lesion_examen5_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen5_nombre_castellano']),
                        'tipo_lesion_examen5_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen5_nombre_portugues']),

                        'tipo_lesion_causa_codigo'                                  => ($rowMSSQL['tipo_lesion_causa_codigo']),
                        'tipo_lesion_causa_nombre_ingles'                           => trim($rowMSSQL['tipo_lesion_causa_nombre_ingles']),
                        'tipo_lesion_causa_nombre_castellano'                       => trim($rowMSSQL['tipo_lesion_causa_nombre_castellano']),
                        'tipo_lesion_causa_nombre_portugues'                        => trim($rowMSSQL['tipo_lesion_causa_nombre_portugues']),

                        'tipo_lesion_falta_codigo'                                  => ($rowMSSQL['tipo_lesion_falta_codigo']),
                        'tipo_lesion_falta_nombre_ingles'                           => trim($rowMSSQL['tipo_lesion_falta_nombre_ingles']),
                        'tipo_lesion_falta_nombre_castellano'                       => trim($rowMSSQL['tipo_lesion_falta_nombre_castellano']),
                        'tipo_lesion_falta_nombre_portugues'                        => trim($rowMSSQL['tipo_lesion_falta_nombre_portugues']),

                        'tipo_diagnostico_codigo'                                   => ($rowMSSQL['tipo_diagnostico_codigo']),
                        'tipo_diagnostico_nombre_ingles'                            => trim($rowMSSQL['tipo_diagnostico_nombre_ingles']),
                        'tipo_diagnostico_nombre_castellano'                        => trim($rowMSSQL['tipo_diagnostico_nombre_castellano']),
                        'tipo_diagnostico_nombre_portugues'                         => trim($rowMSSQL['tipo_diagnostico_nombre_portugues']),
                        'tipo_diagnostico_observacion'                              => trim($rowMSSQL['tipo_diagnostico_observacion']),

                        'tipo_diagnostico_retorno_codigo'                           => ($rowMSSQL['tipo_diagnostico_retorno_codigo']),
                        'tipo_diagnostico_retorno_nombre_ingles'                    => trim($rowMSSQL['tipo_diagnostico_retorno_nombre_ingles']),
                        'tipo_diagnostico_retorno_nombre_castellano'                => trim($rowMSSQL['tipo_diagnostico_retorno_nombre_castellano']),
                        'tipo_diagnostico_retorno_nombre_portugues'                 => trim($rowMSSQL['tipo_diagnostico_retorno_nombre_portugues']),
                        'tipo_diagnostico_retorno_observacion'                      => trim($rowMSSQL['tipo_diagnostico_retorno_observacion']),
                        'tipo_diagnostico_retorno_tratamiento'                      => trim($rowMSSQL['tipo_diagnostico_retorno_tratamiento']),

                        'tipo_diagnostico_recuperacion_codigo'                      => ($rowMSSQL['tipo_diagnostico_recuperacion_codigo']),
                        'tipo_diagnostico_recuperacion_nombre_ingles'               => trim($rowMSSQL['tipo_diagnostico_recuperacion_nombre_ingles']),
                        'tipo_diagnostico_recuperacion_nombre_castellano'           => trim($rowMSSQL['tipo_diagnostico_recuperacion_nombre_castellano']),
                        'tipo_diagnostico_recuperacion_nombre_portugues'            => trim($rowMSSQL['tipo_diagnostico_recuperacion_nombre_portugues']),
                        'tipo_diagnostico_recuperacion'                             => trim($rowMSSQL['tipo_diagnostico_recuperacion_nombre_castellano']).' '.trim($rowMSSQL['tipo_diagnostico_tiempo_nombre_castellano']),

                        'tipo_diagnostico_tiempo_codigo'                            => ($rowMSSQL['tipo_diagnostico_tiempo_codigo']),
                        'tipo_diagnostico_tiempo_nombre_ingles'                     => trim($rowMSSQL['tipo_diagnostico_tiempo_nombre_ingles']),
                        'tipo_diagnostico_tiempo_nombre_castellano'                 => trim($rowMSSQL['tipo_diagnostico_tiempo_nombre_castellano']),
                        'tipo_diagnostico_tiempo_nombre_portugues'                  => trim($rowMSSQL['tipo_diagnostico_tiempo_nombre_portugues']),

                        'competicion_codigo'                                        => ($rowMSSQL['competicion_codigo']),
                        'competicion_nombre'                                        => trim($rowMSSQL['competicion_nombre']),

                        'juego_codigo'                                              => ($rowMSSQL['juego_codigo']),
                        'juego_nombre'                                              => trim($rowMSSQL['juego_equipo_local']).' vs '.trim($rowMSSQL['juego_equpo_visitante']),

                        'equipo_codigo'                                             => ($rowMSSQL['equipo_codigo']),
                        'equipo_nombre'                                             => trim($rowMSSQL['equipo_nombre']),

                        'jugador_codigo'                                            => ($rowMSSQL['jugador_codigo']),
                        'jugador_nombre'                                            => trim($rowMSSQL['jugador_apellido']).', '.trim($rowMSSQL['jugador_nombre']),

                        'auditoria_usuario'                                         => trim($rowMSSQL['auditoria_usuario']),
                        'auditoria_fecha_hora'                                      => trim($rowMSSQL['auditoria_fecha_hora']),
                        'auditoria_ip'                                              => trim($rowMSSQL['auditoria_ip'])   
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'lesion_codigo'                                             => '',
                        'competicion_codigo'                                        => '',
                        'lesion_fecha_alta'                                         => '',
                        'lesion_fecha_retorno'                                      => '',
                        'temperatura_numero'                                        => '',
                        'lesion_observacion'                                        => '',

                        'lesion_cirugia_codigo'                                     => '',
                        'lesion_cirugia_nombre'                                     => '',

                        'tipo_estado_codigo'                                        => '',
                        'tipo_estado_nombre_ingles'                                 => '',
                        'tipo_estado_nombre_castellano'                             => '',
                        'tipo_estado_nombre_portugues'                              => '',

                        'tipo_clima_codigo'                                         => '',
                        'tipo_clima_nombre_ingles'                                  => '',
                        'tipo_clima_nombre_castellano'                              => '',
                        'tipo_clima_nombre_portugues'                               => '',

                        'tipo_distancia_codigo'                                     => '',
                        'tipo_distancia_nombre_ingles'                              => '',
                        'tipo_distancia_nombre_castellano'                          => '',
                        'tipo_distancia_nombre_portugues'                           => '',

                        'tipo_traslado_codigo'                                      => '',
                        'tipo_traslado_nombre_ingles'                               => '',
                        'tipo_traslado_nombre_castellano'                           => '',
                        'tipo_traslado_nombre_portugues'                            => '',

                        'tipo_posicion_codigo'                                      => '',
                        'tipo_posicion_nombre_ingles'                               => '',
                        'tipo_posicion_nombre_castellano'                           => '',
                        'tipo_posicion_nombre_portugues'                            => '',

                        'tipo_minuto_codigo'                                        => '',
                        'tipo_minuto_nombre_ingles'                                 => '',
                        'tipo_minuto_nombre_castellano'                             => '',
                        'tipo_minuto_nombre_portugues'                              => '',

                        'tipo_campo_codigo'                                         => '',
                        'tipo_campo_nombre_ingles'                                  => '',
                        'tipo_campo_nombre_castellano'                              => '',
                        'tipo_campo_nombre_portugues'                               => '',

                        'tipo_cuerpo_zona_codigo'                                   => '',
                        'tipo_cuerpo_zona_nombre_ingles'                            => '',
                        'tipo_cuerpo_zona_nombre_castellano'                        => '',
                        'tipo_cuerpo_zona_nombre_portugues'                         => '',

                        'tipo_cuerpo_lugar_codigo'                                  => '',
                        'tipo_cuerpo_lugar_nombre_ingles'                           => '',
                        'tipo_cuerpo_lugar_nombre_castellano'                       => '',
                        'tipo_cuerpo_lugar_nombre_portugues'                        => '',

                        'tipo_lesion_codigo'                                        => '',
                        'tipo_lesion_nombre_ingles'                                 => '',
                        'tipo_lesion_nombre_castellano'                             => '',
                        'tipo_lesion_nombre_portugues'                              => '',

                        'tipo_lesion_origen_codigo'                                 => '',
                        'tipo_lesion_origen_nombre_ingles'                          => '',
                        'tipo_lesion_origen_nombre_castellano'                      => '',
                        'tipo_lesion_origen_nombre_portugues'                       => '',

                        'tipo_lesion_reincidencia_codigo'                           => '',
                        'tipo_lesion_reincidencia_nombre_ingles'                    => '',
                        'tipo_lesion_reincidencia_nombre_castellano'                => '',
                        'tipo_lesion_reincidencia_nombre_portugues'                 => '',

                        'tipo_lesion_retiro_codigo'                                 => '',
                        'tipo_lesion_retiro_nombre_ingles'                          => '',
                        'tipo_lesion_retiro_nombre_castellano'                      => '',
                        'tipo_lesion_retiro_nombre_portugues'                       => '',

                        'tipo_lesion_examen1_codigo'                                => '',
                        'tipo_lesion_examen1_nombre_ingles'                         => '',
                        'tipo_lesion_examen1_nombre_castellano'                     => '',
                        'tipo_lesion_examen1_nombre_portugues'                      => '',

                        'tipo_lesion_examen2_codigo'                                => '',
                        'tipo_lesion_examen2_nombre_ingles'                         => '',
                        'tipo_lesion_examen2_nombre_castellano'                     => '',
                        'tipo_lesion_examen2_nombre_portugues'                      => '',

                        'tipo_lesion_examen3_codigo'                                => '',
                        'tipo_lesion_examen3_nombre_ingles'                         => '',
                        'tipo_lesion_examen3_nombre_castellano'                     => '',
                        'tipo_lesion_examen3_nombre_portugues'                      => '',

                        'tipo_lesion_examen4_codigo'                                => '',
                        'tipo_lesion_examen4_nombre_ingles'                         => '',
                        'tipo_lesion_examen4_nombre_castellano'                     => '',
                        'tipo_lesion_examen4_nombre_portugues'                      => '',

                        'tipo_lesion_examen5_codigo'                                => '',
                        'tipo_lesion_examen5_nombre_ingles'                         => '',
                        'tipo_lesion_examen5_nombre_castellano'                     => '',
                        'tipo_lesion_examen5_nombre_portugues'                      => '',

                        'tipo_lesion_causa_codigo'                                  => '',
                        'tipo_lesion_causa_nombre_ingles'                           => '',
                        'tipo_lesion_causa_nombre_castellano'                       => '',
                        'tipo_lesion_causa_nombre_portugues'                        => '',

                        'tipo_lesion_falta_codigo'                                  => '',
                        'tipo_lesion_falta_nombre_ingles'                           => '',
                        'tipo_lesion_falta_nombre_castellano'                       => '',
                        'tipo_lesion_falta_nombre_portugues'                        => '',

                        'tipo_diagnostico_codigo'                                   => '',
                        'tipo_diagnostico_nombre_ingles'                            => '',
                        'tipo_diagnostico_nombre_castellano'                        => '',
                        'tipo_diagnostico_nombre_portugues'                         => '',
                        'tipo_diagnostico_observacion'                              => '',

                        'tipo_diagnostico_retorno_codigo'                           => '',
                        'tipo_diagnostico_retorno_nombre_ingles'                    => '',
                        'tipo_diagnostico_retorno_nombre_castellano'                => '',
                        'tipo_diagnostico_retorno_nombre_portugues'                 => '',
                        'tipo_diagnostico_retorno_observacion'                      => '',
                        'tipo_diagnostico_retorno_tratamiento'                      => '',

                        'tipo_diagnostico_recuperacion_codigo'                      => '',
                        'tipo_diagnostico_recuperacion_nombre_ingles'               => '',
                        'tipo_diagnostico_recuperacion_nombre_castellano'           => '',
                        'tipo_diagnostico_recuperacion_nombre_portugues'            => '',
                        'tipo_diagnostico_recuperacion'                             => '',

                        'tipo_diagnostico_tiempo_codigo'                            => '',
                        'tipo_diagnostico_tiempo_nombre_ingles'                     => '',
                        'tipo_diagnostico_tiempo_nombre_castellano'                 => '',
                        'tipo_diagnostico_tiempo_nombre_portugues'                  => '',

                        'competicion_codigo'                                        => '',
                        'competicion_nombre'                                        => '',

                        'juego_codigo'                                              => '',
                        'juego_nombre'                                              => '',

                        'equipo_codigo'                                             => '',
                        'equipo_nombre'                                             => '',

                        'jugador_codigo'                                            => '',
                        'jugador_nombre'                                            => '',

                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha_hora'                                      => '',
                        'auditoria_ip'                                              => ''
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

    $app->get('/v1/600/{equipo}/{competicion}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        
        if (isset($val01) && isset($val02)) {
            $sql00  = "";

            if ($val01 == 39393) {
                $sql00  = "SELECT
                a.LESFICCOD                 AS          lesion_codigo,
                a.LESFICFEC                 AS          lesion_fecha_alta,
                a.LESFICFER                 AS          lesion_fecha_retorno,
                a.LESFICCIR                 As          lesion_cirugia,
                a.LESFICTEM                 AS          temperatura_numero,
                a.LESFICOBS                 As          lesion_observacion,

                b.DOMFICCOD                 AS          tipo_estado_codigo,
                b.DOMFICNOI                 AS          tipo_estado_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_estado_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_estado_nombre_portugues,

                c.DOMFICCOD                 AS          tipo_clima_codigo,
                c.DOMFICNOI                 AS          tipo_clima_nombre_ingles,
                c.DOMFICNOC                 AS          tipo_clima_nombre_castellano,
                c.DOMFICNOP                 AS          tipo_clima_nombre_portugues,

                d.DOMFICCOD                 AS          tipo_distancia_codigo,
                d.DOMFICNOI                 AS          tipo_distancia_nombre_ingles,
                d.DOMFICNOC                 AS          tipo_distancia_nombre_castellano,
                d.DOMFICNOP                 AS          tipo_distancia_nombre_portugues,

                e.DOMFICCOD                 AS          tipo_traslado_codigo,
                e.DOMFICNOI                 AS          tipo_traslado_nombre_ingles,
                e.DOMFICNOC                 AS          tipo_traslado_nombre_castellano,
                e.DOMFICNOP                 AS          tipo_traslado_nombre_portugues,

                f.DOMFICCOD                 AS          tipo_posicion_codigo,
                f.DOMFICNOI                 AS          tipo_posicion_nombre_ingles,
                f.DOMFICNOC                 AS          tipo_posicion_nombre_castellano,
                f.DOMFICNOP                 AS          tipo_posicion_nombre_portugues,

                g.DOMFICCOD                 AS          tipo_minuto_codigo,
                g.DOMFICNOI                 AS          tipo_minuto_nombre_ingles,
                g.DOMFICNOC                 AS          tipo_minuto_nombre_castellano,
                g.DOMFICNOP                 AS          tipo_minuto_nombre_portugues,

                h.DOMFICCOD                 AS          tipo_campo_codigo,
                h.DOMFICNOI                 AS          tipo_campo_nombre_ingles,
                h.DOMFICNOC                 AS          tipo_campo_nombre_castellano,
                h.DOMFICNOP                 AS          tipo_campo_nombre_portugues,

                i.DOMSUBCOD                 AS          tipo_cuerpo_zona_codigo,
                i.DOMSUBNOI                 AS          tipo_cuerpo_zona_nombre_ingles,
                i.DOMSUBNOC                 AS          tipo_cuerpo_zona_nombre_castellano,
                i.DOMSUBNOP                 AS          tipo_cuerpo_zona_nombre_portugues,

                j.DOMFICCOD                 AS          tipo_cuerpo_lugar_codigo,
                j.DOMFICNOI                 AS          tipo_cuerpo_lugar_nombre_ingles,
                j.DOMFICNOC                 AS          tipo_cuerpo_lugar_nombre_castellano,
                j.DOMFICNOP                 AS          tipo_cuerpo_lugar_nombre_portugues,

                k.DOMFICCOD                 AS          tipo_lesion_codigo,
                k.DOMFICNOI                 AS          tipo_lesion_nombre_ingles,
                k.DOMFICNOC                 AS          tipo_lesion_nombre_castellano,
                k.DOMFICNOP                 AS          tipo_lesion_nombre_portugues,

                l.DOMFICCOD                 AS          tipo_lesion_origen_codigo,
                l.DOMFICNOI                 AS          tipo_lesion_origen_nombre_ingles,
                l.DOMFICNOC                 AS          tipo_lesion_origen_nombre_castellano,
                l.DOMFICNOP                 AS          tipo_lesion_origen_nombre_portugues,

                m.DOMFICCOD                 AS          tipo_lesion_reincidencia_codigo,
                m.DOMFICNOI                 AS          tipo_lesion_reincidencia_nombre_ingles,
                m.DOMFICNOC                 AS          tipo_lesion_reincidencia_nombre_castellano,
                m.DOMFICNOP                 AS          tipo_lesion_reincidencia_nombre_portugues,

                x.DOMFICCOD                 AS          tipo_lesion_retiro_codigo,
                x.DOMFICNOI                 AS          tipo_lesion_retiro_nombre_ingles,
                x.DOMFICNOC                 AS          tipo_lesion_retiro_nombre_castellano,
                x.DOMFICNOP                 AS          tipo_lesion_retiro_nombre_portugues,

                n.DOMFICCOD                 AS          tipo_lesion_causa_codigo,
                n.DOMFICNOI                 AS          tipo_lesion_causa_nombre_ingles,
                n.DOMFICNOC                 AS          tipo_lesion_causa_nombre_castellano,
                n.DOMFICNOP                 AS          tipo_lesion_causa_nombre_portugues,

                w1.DOMFICCOD                AS          tipo_lesion_examen1_codigo,
                w1.DOMFICNOI                AS          tipo_lesion_examen1_nombre_ingles,
                w1.DOMFICNOC                AS          tipo_lesion_examen1_nombre_castellano,
                w1.DOMFICNOP                AS          tipo_lesion_examen1_nombre_portugues,

                w2.DOMFICCOD                AS          tipo_lesion_examen2_codigo,
                w2.DOMFICNOI                AS          tipo_lesion_examen2_nombre_ingles,
                w2.DOMFICNOC                AS          tipo_lesion_examen2_nombre_castellano,
                w2.DOMFICNOP                AS          tipo_lesion_examen2_nombre_portugues,

                w3.DOMFICCOD                AS          tipo_lesion_examen3_codigo,
                w3.DOMFICNOI                AS          tipo_lesion_examen3_nombre_ingles,
                w3.DOMFICNOC                AS          tipo_lesion_examen3_nombre_castellano,
                w3.DOMFICNOP                AS          tipo_lesion_examen3_nombre_portugues,

                w4.DOMFICCOD                AS          tipo_lesion_examen4_codigo,
                w4.DOMFICNOI                AS          tipo_lesion_examen4_nombre_ingles,
                w4.DOMFICNOC                AS          tipo_lesion_examen4_nombre_castellano,
                w4.DOMFICNOP                AS          tipo_lesion_examen4_nombre_portugues,

                w5.DOMFICCOD                AS          tipo_lesion_examen5_codigo,
                w5.DOMFICNOI                AS          tipo_lesion_examen5_nombre_ingles,
                w5.DOMFICNOC                AS          tipo_lesion_examen5_nombre_castellano,
                w5.DOMFICNOP                AS          tipo_lesion_examen5_nombre_portugues,

                o.DOMFICCOD                 AS          tipo_lesion_falta_codigo,
                o.DOMFICNOI                 AS          tipo_lesion_falta_nombre_ingles,
                o.DOMFICNOC                 AS          tipo_lesion_falta_nombre_castellano,
                o.DOMFICNOP                 AS          tipo_lesion_falta_nombre_portugues,

                p.DOMSUBCOD                 AS          tipo_diagnostico_codigo,
                p.DOMSUBNOI                 AS          tipo_diagnostico_nombre_ingles,
                p.DOMSUBNOC                 AS          tipo_diagnostico_nombre_castellano,
                p.DOMSUBNOP                 AS          tipo_diagnostico_nombre_portugues,
                a.LESFICOBD                 AS          tipo_diagnostico_observacion,

                p1.DOMSUBCOD                AS          tipo_diagnostico_retorno_codigo,
                p1.DOMSUBNOI                AS          tipo_diagnostico_retorno_nombre_ingles,
                p1.DOMSUBNOC                AS          tipo_diagnostico_retorno_nombre_castellano,
                p1.DOMSUBNOP                AS          tipo_diagnostico_retorno_nombre_portugues,
                a.LESFICOBR                 AS          tipo_diagnostico_retorno_observacion,
                a.LESFICTRR                 AS          tipo_diagnostico_retorno_tratamiento,

                q.DOMFICCOD                 AS          tipo_diagnostico_recuperacion_codigo,
                q.DOMFICNOI                 AS          tipo_diagnostico_recuperacion_nombre_ingles,
                q.DOMFICNOC                 AS          tipo_diagnostico_recuperacion_nombre_castellano,
                q.DOMFICNOP                 AS          tipo_diagnostico_recuperacion_nombre_portugues,

                r.DOMFICCOD                 AS          tipo_diagnostico_tiempo_codigo,
                r.DOMFICNOI                 AS          tipo_diagnostico_tiempo_nombre_ingles,
                r.DOMFICNOC                 AS          tipo_diagnostico_tiempo_nombre_castellano,
                r.DOMFICNOP                 AS          tipo_diagnostico_tiempo_nombre_portugues,

                s.competitionFifaId         AS          competicion_codigo,
                s.internationalName         AS          competicion_nombre,

                t.JUEGO_CODIGO              AS          juego_codigo,
                t.EQUIPO_LOCAL_NOMBRE       AS          juego_equipo_local,
                t.EQUIPO_VISITANTE_NOMBRE   AS          juego_equpo_visitante,

                u.teamFifaId                AS          equipo_codigo,
                u.internationalName         AS          equipo_nombre,

                v.personFifaId              AS          jugador_codigo,
                v.internationalFirstName    AS          jugador_nombre,
                v.internationalLastName     AS          jugador_apellido,

                a.LESFICAUS                 AS          auditoria_usuario,
                a.LESFICAFH                 AS          auditoria_fecha_hora,
                a.LESFICAIP                 AS          auditoria_ip

                FROM [lesion].[LESFIC] a
                LEFT OUTER JOIN [adm].[DOMFIC] b ON a.LESFICESC = b.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] c ON a.LESFICCLI = c.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] d ON a.LESFICDIS = d.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] e ON a.LESFICTRA = e.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] f ON a.LESFICPOS = f.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] g ON a.LESFICMIN = g.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.LESFICCAM = h.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMSUB] i ON a.LESFICCUZ = i.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMFIC] j ON a.LESFICCUL = j.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] k ON a.LESFICLES = k.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] l ON a.LESFICORI = l.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] m ON a.LESFICREI = m.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] n ON a.LESFICCAU = n.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] o ON a.LESFICFAL = o.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMSUB] p ON a.LESFICDIA = p.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMSUB] p1 ON a.LESFICDIR = p1.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMFIC] q ON a.LESFICREC = q.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] r ON a.LESFICTIE = r.DOMFICCOD
                LEFT OUTER JOIN [comet].[competitions] s ON a.LESFICCOC = s.competitionFifaId
                LEFT OUTER JOIN [view].[juego] t ON a.LESFICJUC = t.JUEGO_CODIGO
                LEFT OUTER JOIN [comet].[teams] u ON a.LESFICEQC = u.teamFifaId
                LEFT OUTER JOIN [comet].[persons] v ON a.LESFICPEC = v.personFifaId
                LEFT OUTER JOIN [adm].[DOMFIC] w1 ON a.LESFICEX1 = w1.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w2 ON a.LESFICEX2 = w2.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w3 ON a.LESFICEX3 = w3.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w4 ON a.LESFICEX4 = w4.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w5 ON a.LESFICEX5 = w5.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] x ON a.LESFICRET = x.DOMFICCOD

                WHERE a.LESFICCOC = ?
                
                ORDER BY a.LESFICCOD DESC";
            } else {
                $sql00  = "SELECT
                a.LESFICCOD                 AS          lesion_codigo,
                a.LESFICFEC                 AS          lesion_fecha_alta,
                a.LESFICFER                 AS          lesion_fecha_retorno,
                a.LESFICCIR                 As          lesion_cirugia,
                a.LESFICTEM                 AS          temperatura_numero,
                a.LESFICOBS                 As          lesion_observacion,

                b.DOMFICCOD                 AS          tipo_estado_codigo,
                b.DOMFICNOI                 AS          tipo_estado_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_estado_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_estado_nombre_portugues,

                c.DOMFICCOD                 AS          tipo_clima_codigo,
                c.DOMFICNOI                 AS          tipo_clima_nombre_ingles,
                c.DOMFICNOC                 AS          tipo_clima_nombre_castellano,
                c.DOMFICNOP                 AS          tipo_clima_nombre_portugues,

                d.DOMFICCOD                 AS          tipo_distancia_codigo,
                d.DOMFICNOI                 AS          tipo_distancia_nombre_ingles,
                d.DOMFICNOC                 AS          tipo_distancia_nombre_castellano,
                d.DOMFICNOP                 AS          tipo_distancia_nombre_portugues,

                e.DOMFICCOD                 AS          tipo_traslado_codigo,
                e.DOMFICNOI                 AS          tipo_traslado_nombre_ingles,
                e.DOMFICNOC                 AS          tipo_traslado_nombre_castellano,
                e.DOMFICNOP                 AS          tipo_traslado_nombre_portugues,

                f.DOMFICCOD                 AS          tipo_posicion_codigo,
                f.DOMFICNOI                 AS          tipo_posicion_nombre_ingles,
                f.DOMFICNOC                 AS          tipo_posicion_nombre_castellano,
                f.DOMFICNOP                 AS          tipo_posicion_nombre_portugues,

                g.DOMFICCOD                 AS          tipo_minuto_codigo,
                g.DOMFICNOI                 AS          tipo_minuto_nombre_ingles,
                g.DOMFICNOC                 AS          tipo_minuto_nombre_castellano,
                g.DOMFICNOP                 AS          tipo_minuto_nombre_portugues,

                h.DOMFICCOD                 AS          tipo_campo_codigo,
                h.DOMFICNOI                 AS          tipo_campo_nombre_ingles,
                h.DOMFICNOC                 AS          tipo_campo_nombre_castellano,
                h.DOMFICNOP                 AS          tipo_campo_nombre_portugues,

                i.DOMSUBCOD                 AS          tipo_cuerpo_zona_codigo,
                i.DOMSUBNOI                 AS          tipo_cuerpo_zona_nombre_ingles,
                i.DOMSUBNOC                 AS          tipo_cuerpo_zona_nombre_castellano,
                i.DOMSUBNOP                 AS          tipo_cuerpo_zona_nombre_portugues,

                j.DOMFICCOD                 AS          tipo_cuerpo_lugar_codigo,
                j.DOMFICNOI                 AS          tipo_cuerpo_lugar_nombre_ingles,
                j.DOMFICNOC                 AS          tipo_cuerpo_lugar_nombre_castellano,
                j.DOMFICNOP                 AS          tipo_cuerpo_lugar_nombre_portugues,

                k.DOMFICCOD                 AS          tipo_lesion_codigo,
                k.DOMFICNOI                 AS          tipo_lesion_nombre_ingles,
                k.DOMFICNOC                 AS          tipo_lesion_nombre_castellano,
                k.DOMFICNOP                 AS          tipo_lesion_nombre_portugues,

                l.DOMFICCOD                 AS          tipo_lesion_origen_codigo,
                l.DOMFICNOI                 AS          tipo_lesion_origen_nombre_ingles,
                l.DOMFICNOC                 AS          tipo_lesion_origen_nombre_castellano,
                l.DOMFICNOP                 AS          tipo_lesion_origen_nombre_portugues,

                m.DOMFICCOD                 AS          tipo_lesion_reincidencia_codigo,
                m.DOMFICNOI                 AS          tipo_lesion_reincidencia_nombre_ingles,
                m.DOMFICNOC                 AS          tipo_lesion_reincidencia_nombre_castellano,
                m.DOMFICNOP                 AS          tipo_lesion_reincidencia_nombre_portugues,

                x.DOMFICCOD                 AS          tipo_lesion_retiro_codigo,
                x.DOMFICNOI                 AS          tipo_lesion_retiro_nombre_ingles,
                x.DOMFICNOC                 AS          tipo_lesion_retiro_nombre_castellano,
                x.DOMFICNOP                 AS          tipo_lesion_retiro_nombre_portugues,

                n.DOMFICCOD                 AS          tipo_lesion_causa_codigo,
                n.DOMFICNOI                 AS          tipo_lesion_causa_nombre_ingles,
                n.DOMFICNOC                 AS          tipo_lesion_causa_nombre_castellano,
                n.DOMFICNOP                 AS          tipo_lesion_causa_nombre_portugues,

                w1.DOMFICCOD                AS          tipo_lesion_examen1_codigo,
                w1.DOMFICNOI                AS          tipo_lesion_examen1_nombre_ingles,
                w1.DOMFICNOC                AS          tipo_lesion_examen1_nombre_castellano,
                w1.DOMFICNOP                AS          tipo_lesion_examen1_nombre_portugues,

                w2.DOMFICCOD                AS          tipo_lesion_examen2_codigo,
                w2.DOMFICNOI                AS          tipo_lesion_examen2_nombre_ingles,
                w2.DOMFICNOC                AS          tipo_lesion_examen2_nombre_castellano,
                w2.DOMFICNOP                AS          tipo_lesion_examen2_nombre_portugues,

                w3.DOMFICCOD                AS          tipo_lesion_examen3_codigo,
                w3.DOMFICNOI                AS          tipo_lesion_examen3_nombre_ingles,
                w3.DOMFICNOC                AS          tipo_lesion_examen3_nombre_castellano,
                w3.DOMFICNOP                AS          tipo_lesion_examen3_nombre_portugues,

                w4.DOMFICCOD                AS          tipo_lesion_examen4_codigo,
                w4.DOMFICNOI                AS          tipo_lesion_examen4_nombre_ingles,
                w4.DOMFICNOC                AS          tipo_lesion_examen4_nombre_castellano,
                w4.DOMFICNOP                AS          tipo_lesion_examen4_nombre_portugues,

                w5.DOMFICCOD                AS          tipo_lesion_examen5_codigo,
                w5.DOMFICNOI                AS          tipo_lesion_examen5_nombre_ingles,
                w5.DOMFICNOC                AS          tipo_lesion_examen5_nombre_castellano,
                w5.DOMFICNOP                AS          tipo_lesion_examen5_nombre_portugues,

                o.DOMFICCOD                 AS          tipo_lesion_falta_codigo,
                o.DOMFICNOI                 AS          tipo_lesion_falta_nombre_ingles,
                o.DOMFICNOC                 AS          tipo_lesion_falta_nombre_castellano,
                o.DOMFICNOP                 AS          tipo_lesion_falta_nombre_portugues,

                p.DOMSUBCOD                 AS          tipo_diagnostico_codigo,
                p.DOMSUBNOI                 AS          tipo_diagnostico_nombre_ingles,
                p.DOMSUBNOC                 AS          tipo_diagnostico_nombre_castellano,
                p.DOMSUBNOP                 AS          tipo_diagnostico_nombre_portugues,
                a.LESFICOBD                 AS          tipo_diagnostico_observacion,

                p1.DOMSUBCOD                AS          tipo_diagnostico_retorno_codigo,
                p1.DOMSUBNOI                AS          tipo_diagnostico_retorno_nombre_ingles,
                p1.DOMSUBNOC                AS          tipo_diagnostico_retorno_nombre_castellano,
                p1.DOMSUBNOP                AS          tipo_diagnostico_retorno_nombre_portugues,
                a.LESFICOBR                 AS          tipo_diagnostico_retorno_observacion,
                a.LESFICTRR                 AS          tipo_diagnostico_retorno_tratamiento,

                q.DOMFICCOD                 AS          tipo_diagnostico_recuperacion_codigo,
                q.DOMFICNOI                 AS          tipo_diagnostico_recuperacion_nombre_ingles,
                q.DOMFICNOC                 AS          tipo_diagnostico_recuperacion_nombre_castellano,
                q.DOMFICNOP                 AS          tipo_diagnostico_recuperacion_nombre_portugues,

                r.DOMFICCOD                 AS          tipo_diagnostico_tiempo_codigo,
                r.DOMFICNOI                 AS          tipo_diagnostico_tiempo_nombre_ingles,
                r.DOMFICNOC                 AS          tipo_diagnostico_tiempo_nombre_castellano,
                r.DOMFICNOP                 AS          tipo_diagnostico_tiempo_nombre_portugues,

                s.competitionFifaId         AS          competicion_codigo,
                s.internationalName         AS          competicion_nombre,

                t.JUEGO_CODIGO              AS          juego_codigo,
                t.EQUIPO_LOCAL_NOMBRE       AS          juego_equipo_local,
                t.EQUIPO_VISITANTE_NOMBRE   AS          juego_equpo_visitante,

                u.teamFifaId                AS          equipo_codigo,
                u.internationalName         AS          equipo_nombre,

                v.personFifaId              AS          jugador_codigo,
                v.internationalFirstName    AS          jugador_nombre,
                v.internationalLastName     AS          jugador_apellido,

                a.LESFICAUS                 AS          auditoria_usuario,
                a.LESFICAFH                 AS          auditoria_fecha_hora,
                a.LESFICAIP                 AS          auditoria_ip

                FROM [lesion].[LESFIC] a
                LEFT OUTER JOIN [adm].[DOMFIC] b ON a.LESFICESC = b.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] c ON a.LESFICCLI = c.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] d ON a.LESFICDIS = d.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] e ON a.LESFICTRA = e.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] f ON a.LESFICPOS = f.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] g ON a.LESFICMIN = g.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.LESFICCAM = h.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMSUB] i ON a.LESFICCUZ = i.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMFIC] j ON a.LESFICCUL = j.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] k ON a.LESFICLES = k.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] l ON a.LESFICORI = l.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] m ON a.LESFICREI = m.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] n ON a.LESFICCAU = n.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] o ON a.LESFICFAL = o.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMSUB] p ON a.LESFICDIA = p.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMSUB] p1 ON a.LESFICDIR = p1.DOMSUBCOD
                LEFT OUTER JOIN [adm].[DOMFIC] q ON a.LESFICREC = q.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] r ON a.LESFICTIE = r.DOMFICCOD
                LEFT OUTER JOIN [comet].[competitions] s ON a.LESFICCOC = s.competitionFifaId
                LEFT OUTER JOIN [view].[juego] t ON a.LESFICJUC = t.JUEGO_CODIGO
                LEFT OUTER JOIN [comet].[teams] u ON a.LESFICEQC = u.teamFifaId
                LEFT OUTER JOIN [comet].[persons] v ON a.LESFICPEC = v.personFifaId
                LEFT OUTER JOIN [adm].[DOMFIC] w1 ON a.LESFICEX1 = w1.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w2 ON a.LESFICEX2 = w2.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w3 ON a.LESFICEX3 = w3.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w4 ON a.LESFICEX4 = w4.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] w5 ON a.LESFICEX5 = w5.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] x ON a.LESFICRET = x.DOMFICCOD

                WHERE a.LESFICEQC = ? AND a.LESFICCOC = ?
                
                ORDER BY a.LESFICCOD DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
                    $stmtMSSQL->execute([$val02]);
                } else {
                    $stmtMSSQL->execute([$val01, $val02]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $lesion_cirugia_nombre = 'NO';

                    if (trim($rowMSSQL['lesion_cirugia']) == '2'){
                        $lesion_cirugia_nombre = 'SI';
                    }

                    $detalle    = array(
                        'lesion_codigo'                                             => ($rowMSSQL['lesion_codigo']),
                        'competicion_codigo'                                        => ($rowMSSQL['competicion_codigo']),
                        'lesion_fecha_alta'                                         => date_format(date_create($rowMSSQL['lesion_fecha_alta']), 'd/m/Y H:i:s'),
                        'lesion_fecha_retorno'                                      => date_format(date_create($rowMSSQL['lesion_fecha_retorno']), 'd/m/Y'),
                        'temperatura_numero'                                        => trim($rowMSSQL['temperatura_numero']),
                        'lesion_observacion'                                        => trim($rowMSSQL['lesion_observacion']),

                        'lesion_cirugia_codigo'                                     => trim($rowMSSQL['lesion_cirugia']),
                        'lesion_cirugia_nombre'                                     => $lesion_cirugia_nombre,

                        'tipo_estado_codigo'                                        => ($rowMSSQL['tipo_estado_codigo']),
                        'tipo_estado_nombre_ingles'                                 => trim($rowMSSQL['tipo_estado_nombre_ingles']),
                        'tipo_estado_nombre_castellano'                             => trim($rowMSSQL['tipo_estado_nombre_castellano']),
                        'tipo_estado_nombre_portugues'                              => trim($rowMSSQL['tipo_estado_nombre_portugues']),

                        'tipo_clima_codigo'                                         => ($rowMSSQL['tipo_clima_codigo']),
                        'tipo_clima_nombre_ingles'                                  => trim($rowMSSQL['tipo_clima_nombre_ingles']),
                        'tipo_clima_nombre_castellano'                              => trim($rowMSSQL['tipo_clima_nombre_castellano']),
                        'tipo_clima_nombre_portugues'                               => trim($rowMSSQL['tipo_clima_nombre_portugues']),

                        'tipo_distancia_codigo'                                     => ($rowMSSQL['tipo_distancia_codigo']),
                        'tipo_distancia_nombre_ingles'                              => trim($rowMSSQL['tipo_distancia_nombre_ingles']),
                        'tipo_distancia_nombre_castellano'                          => trim($rowMSSQL['tipo_distancia_nombre_castellano']),
                        'tipo_distancia_nombre_portugues'                           => trim($rowMSSQL['tipo_distancia_nombre_portugues']),

                        'tipo_traslado_codigo'                                      => ($rowMSSQL['tipo_traslado_codigo']),
                        'tipo_traslado_nombre_ingles'                               => trim($rowMSSQL['tipo_traslado_nombre_ingles']),
                        'tipo_traslado_nombre_castellano'                           => trim($rowMSSQL['tipo_traslado_nombre_castellano']),
                        'tipo_traslado_nombre_portugues'                            => trim($rowMSSQL['tipo_traslado_nombre_portugues']),

                        'tipo_posicion_codigo'                                      => ($rowMSSQL['tipo_posicion_codigo']),
                        'tipo_posicion_nombre_ingles'                               => trim($rowMSSQL['tipo_posicion_nombre_ingles']),
                        'tipo_posicion_nombre_castellano'                           => trim($rowMSSQL['tipo_posicion_nombre_castellano']),
                        'tipo_posicion_nombre_portugues'                            => trim($rowMSSQL['tipo_posicion_nombre_portugues']),

                        'tipo_minuto_codigo'                                        => ($rowMSSQL['tipo_minuto_codigo']),
                        'tipo_minuto_nombre_ingles'                                 => trim($rowMSSQL['tipo_minuto_nombre_ingles']),
                        'tipo_minuto_nombre_castellano'                             => trim($rowMSSQL['tipo_minuto_nombre_castellano']),
                        'tipo_minuto_nombre_portugues'                              => trim($rowMSSQL['tipo_minuto_nombre_portugues']),

                        'tipo_campo_codigo'                                         => ($rowMSSQL['tipo_campo_codigo']),
                        'tipo_campo_nombre_ingles'                                  => trim($rowMSSQL['tipo_campo_nombre_ingles']),
                        'tipo_campo_nombre_castellano'                              => trim($rowMSSQL['tipo_campo_nombre_castellano']),
                        'tipo_campo_nombre_portugues'                               => trim($rowMSSQL['tipo_campo_nombre_portugues']),

                        'tipo_cuerpo_zona_codigo'                                   => ($rowMSSQL['tipo_cuerpo_zona_codigo']),
                        'tipo_cuerpo_zona_nombre_ingles'                            => trim($rowMSSQL['tipo_cuerpo_zona_nombre_ingles']),
                        'tipo_cuerpo_zona_nombre_castellano'                        => trim($rowMSSQL['tipo_cuerpo_zona_nombre_castellano']),
                        'tipo_cuerpo_zona_nombre_portugues'                         => trim($rowMSSQL['tipo_cuerpo_zona_nombre_portugues']),

                        'tipo_cuerpo_lugar_codigo'                                  => ($rowMSSQL['tipo_cuerpo_lugar_codigo']),
                        'tipo_cuerpo_lugar_nombre_ingles'                           => trim($rowMSSQL['tipo_cuerpo_lugar_nombre_ingles']),
                        'tipo_cuerpo_lugar_nombre_castellano'                       => trim($rowMSSQL['tipo_cuerpo_lugar_nombre_castellano']),
                        'tipo_cuerpo_lugar_nombre_portugues'                        => trim($rowMSSQL['tipo_cuerpo_lugar_nombre_portugues']),

                        'tipo_lesion_codigo'                                        => ($rowMSSQL['tipo_lesion_codigo']),
                        'tipo_lesion_nombre_ingles'                                 => trim($rowMSSQL['tipo_lesion_nombre_ingles']),
                        'tipo_lesion_nombre_castellano'                             => trim($rowMSSQL['tipo_lesion_nombre_castellano']),
                        'tipo_lesion_nombre_portugues'                              => trim($rowMSSQL['tipo_lesion_nombre_portugues']),

                        'tipo_lesion_origen_codigo'                                 => ($rowMSSQL['tipo_lesion_origen_codigo']),
                        'tipo_lesion_origen_nombre_ingles'                          => trim($rowMSSQL['tipo_lesion_origen_nombre_ingles']),
                        'tipo_lesion_origen_nombre_castellano'                      => trim($rowMSSQL['tipo_lesion_origen_nombre_castellano']),
                        'tipo_lesion_origen_nombre_portugues'                       => trim($rowMSSQL['tipo_lesion_origen_nombre_portugues']),

                        'tipo_lesion_reincidencia_codigo'                           => ($rowMSSQL['tipo_lesion_reincidencia_codigo']),
                        'tipo_lesion_reincidencia_nombre_ingles'                    => trim($rowMSSQL['tipo_lesion_reincidencia_nombre_ingles']),
                        'tipo_lesion_reincidencia_nombre_castellano'                => trim($rowMSSQL['tipo_lesion_reincidencia_nombre_castellano']),
                        'tipo_lesion_reincidencia_nombre_portugues'                 => trim($rowMSSQL['tipo_lesion_reincidencia_nombre_portugues']),

                        'tipo_lesion_retiro_codigo'                                 => ($rowMSSQL['tipo_lesion_retiro_codigo']),
                        'tipo_lesion_retiro_nombre_ingles'                          => trim($rowMSSQL['tipo_lesion_retiro_nombre_ingles']),
                        'tipo_lesion_retiro_nombre_castellano'                      => trim($rowMSSQL['tipo_lesion_retiro_nombre_castellano']),
                        'tipo_lesion_retiro_nombre_portugues'                       => trim($rowMSSQL['tipo_lesion_retiro_nombre_portugues']),

                        'tipo_lesion_examen1_codigo'                                => ($rowMSSQL['tipo_lesion_examen1_codigo']),
                        'tipo_lesion_examen1_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen1_nombre_ingles']),
                        'tipo_lesion_examen1_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen1_nombre_castellano']),
                        'tipo_lesion_examen1_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen1_nombre_portugues']),

                        'tipo_lesion_examen2_codigo'                                => ($rowMSSQL['tipo_lesion_examen2_codigo']),
                        'tipo_lesion_examen2_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen2_nombre_ingles']),
                        'tipo_lesion_examen2_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen2_nombre_castellano']),
                        'tipo_lesion_examen2_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen2_nombre_portugues']),

                        'tipo_lesion_examen3_codigo'                                => ($rowMSSQL['tipo_lesion_examen3_codigo']),
                        'tipo_lesion_examen3_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen3_nombre_ingles']),
                        'tipo_lesion_examen3_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen3_nombre_castellano']),
                        'tipo_lesion_examen3_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen3_nombre_portugues']),

                        'tipo_lesion_examen4_codigo'                                => ($rowMSSQL['tipo_lesion_examen4_codigo']),
                        'tipo_lesion_examen4_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen4_nombre_ingles']),
                        'tipo_lesion_examen4_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen4_nombre_castellano']),
                        'tipo_lesion_examen4_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen4_nombre_portugues']),

                        'tipo_lesion_examen5_codigo'                                => ($rowMSSQL['tipo_lesion_examen5_codigo']),
                        'tipo_lesion_examen5_nombre_ingles'                         => trim($rowMSSQL['tipo_lesion_examen5_nombre_ingles']),
                        'tipo_lesion_examen5_nombre_castellano'                     => trim($rowMSSQL['tipo_lesion_examen5_nombre_castellano']),
                        'tipo_lesion_examen5_nombre_portugues'                      => trim($rowMSSQL['tipo_lesion_examen5_nombre_portugues']),

                        'tipo_lesion_causa_codigo'                                  => ($rowMSSQL['tipo_lesion_causa_codigo']),
                        'tipo_lesion_causa_nombre_ingles'                           => trim($rowMSSQL['tipo_lesion_causa_nombre_ingles']),
                        'tipo_lesion_causa_nombre_castellano'                       => trim($rowMSSQL['tipo_lesion_causa_nombre_castellano']),
                        'tipo_lesion_causa_nombre_portugues'                        => trim($rowMSSQL['tipo_lesion_causa_nombre_portugues']),

                        'tipo_lesion_falta_codigo'                                  => ($rowMSSQL['tipo_lesion_falta_codigo']),
                        'tipo_lesion_falta_nombre_ingles'                           => trim($rowMSSQL['tipo_lesion_falta_nombre_ingles']),
                        'tipo_lesion_falta_nombre_castellano'                       => trim($rowMSSQL['tipo_lesion_falta_nombre_castellano']),
                        'tipo_lesion_falta_nombre_portugues'                        => trim($rowMSSQL['tipo_lesion_falta_nombre_portugues']),

                        'tipo_diagnostico_codigo'                                   => ($rowMSSQL['tipo_diagnostico_codigo']),
                        'tipo_diagnostico_nombre_ingles'                            => trim($rowMSSQL['tipo_diagnostico_nombre_ingles']),
                        'tipo_diagnostico_nombre_castellano'                        => trim($rowMSSQL['tipo_diagnostico_nombre_castellano']),
                        'tipo_diagnostico_nombre_portugues'                         => trim($rowMSSQL['tipo_diagnostico_nombre_portugues']),
                        'tipo_diagnostico_observacion'                              => trim($rowMSSQL['tipo_diagnostico_observacion']),

                        'tipo_diagnostico_retorno_codigo'                           => ($rowMSSQL['tipo_diagnostico_retorno_codigo']),
                        'tipo_diagnostico_retorno_nombre_ingles'                    => trim($rowMSSQL['tipo_diagnostico_retorno_nombre_ingles']),
                        'tipo_diagnostico_retorno_nombre_castellano'                => trim($rowMSSQL['tipo_diagnostico_retorno_nombre_castellano']),
                        'tipo_diagnostico_retorno_nombre_portugues'                 => trim($rowMSSQL['tipo_diagnostico_retorno_nombre_portugues']),
                        'tipo_diagnostico_retorno_observacion'                      => trim($rowMSSQL['tipo_diagnostico_retorno_observacion']),
                        'tipo_diagnostico_retorno_tratamiento'                      => trim($rowMSSQL['tipo_diagnostico_retorno_tratamiento']),

                        'tipo_diagnostico_recuperacion_codigo'                      => ($rowMSSQL['tipo_diagnostico_recuperacion_codigo']),
                        'tipo_diagnostico_recuperacion_nombre_ingles'               => trim($rowMSSQL['tipo_diagnostico_recuperacion_nombre_ingles']),
                        'tipo_diagnostico_recuperacion_nombre_castellano'           => trim($rowMSSQL['tipo_diagnostico_recuperacion_nombre_castellano']),
                        'tipo_diagnostico_recuperacion_nombre_portugues'            => trim($rowMSSQL['tipo_diagnostico_recuperacion_nombre_portugues']),
                        'tipo_diagnostico_recuperacion'                             => trim($rowMSSQL['tipo_diagnostico_recuperacion_nombre_castellano']).' '.trim($rowMSSQL['tipo_diagnostico_tiempo_nombre_castellano']),

                        'tipo_diagnostico_tiempo_codigo'                            => ($rowMSSQL['tipo_diagnostico_tiempo_codigo']),
                        'tipo_diagnostico_tiempo_nombre_ingles'                     => trim($rowMSSQL['tipo_diagnostico_tiempo_nombre_ingles']),
                        'tipo_diagnostico_tiempo_nombre_castellano'                 => trim($rowMSSQL['tipo_diagnostico_tiempo_nombre_castellano']),
                        'tipo_diagnostico_tiempo_nombre_portugues'                  => trim($rowMSSQL['tipo_diagnostico_tiempo_nombre_portugues']),

                        'competicion_codigo'                                        => ($rowMSSQL['competicion_codigo']),
                        'competicion_nombre'                                        => trim($rowMSSQL['competicion_nombre']),

                        'juego_codigo'                                              => ($rowMSSQL['juego_codigo']),
                        'juego_nombre'                                              => trim($rowMSSQL['juego_equipo_local']).' vs '.trim($rowMSSQL['juego_equpo_visitante']),

                        'equipo_codigo'                                             => ($rowMSSQL['equipo_codigo']),
                        'equipo_nombre'                                             => trim($rowMSSQL['equipo_nombre']),

                        'jugador_codigo'                                            => ($rowMSSQL['jugador_codigo']),
                        'jugador_nombre'                                            => trim($rowMSSQL['jugador_apellido']).', '.trim($rowMSSQL['jugador_nombre']),

                        'auditoria_usuario'                                         => trim($rowMSSQL['auditoria_usuario']),
                        'auditoria_fecha_hora'                                      => trim($rowMSSQL['auditoria_fecha_hora']),
                        'auditoria_ip'                                              => trim($rowMSSQL['auditoria_ip'])   
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'lesion_codigo'                                             => '',
                        'competicion_codigo'                                        => '',
                        'lesion_fecha_alta'                                         => '',
                        'lesion_fecha_retorno'                                      => '',
                        'temperatura_numero'                                        => '',
                        'lesion_observacion'                                        => '',

                        'lesion_cirugia_codigo'                                     => '',
                        'lesion_cirugia_nombre'                                     => '',

                        'tipo_estado_codigo'                                        => '',
                        'tipo_estado_nombre_ingles'                                 => '',
                        'tipo_estado_nombre_castellano'                             => '',
                        'tipo_estado_nombre_portugues'                              => '',

                        'tipo_clima_codigo'                                         => '',
                        'tipo_clima_nombre_ingles'                                  => '',
                        'tipo_clima_nombre_castellano'                              => '',
                        'tipo_clima_nombre_portugues'                               => '',

                        'tipo_distancia_codigo'                                     => '',
                        'tipo_distancia_nombre_ingles'                              => '',
                        'tipo_distancia_nombre_castellano'                          => '',
                        'tipo_distancia_nombre_portugues'                           => '',

                        'tipo_traslado_codigo'                                      => '',
                        'tipo_traslado_nombre_ingles'                               => '',
                        'tipo_traslado_nombre_castellano'                           => '',
                        'tipo_traslado_nombre_portugues'                            => '',

                        'tipo_posicion_codigo'                                      => '',
                        'tipo_posicion_nombre_ingles'                               => '',
                        'tipo_posicion_nombre_castellano'                           => '',
                        'tipo_posicion_nombre_portugues'                            => '',

                        'tipo_minuto_codigo'                                        => '',
                        'tipo_minuto_nombre_ingles'                                 => '',
                        'tipo_minuto_nombre_castellano'                             => '',
                        'tipo_minuto_nombre_portugues'                              => '',

                        'tipo_campo_codigo'                                         => '',
                        'tipo_campo_nombre_ingles'                                  => '',
                        'tipo_campo_nombre_castellano'                              => '',
                        'tipo_campo_nombre_portugues'                               => '',

                        'tipo_cuerpo_zona_codigo'                                   => '',
                        'tipo_cuerpo_zona_nombre_ingles'                            => '',
                        'tipo_cuerpo_zona_nombre_castellano'                        => '',
                        'tipo_cuerpo_zona_nombre_portugues'                         => '',

                        'tipo_cuerpo_lugar_codigo'                                  => '',
                        'tipo_cuerpo_lugar_nombre_ingles'                           => '',
                        'tipo_cuerpo_lugar_nombre_castellano'                       => '',
                        'tipo_cuerpo_lugar_nombre_portugues'                        => '',

                        'tipo_lesion_codigo'                                        => '',
                        'tipo_lesion_nombre_ingles'                                 => '',
                        'tipo_lesion_nombre_castellano'                             => '',
                        'tipo_lesion_nombre_portugues'                              => '',

                        'tipo_lesion_origen_codigo'                                 => '',
                        'tipo_lesion_origen_nombre_ingles'                          => '',
                        'tipo_lesion_origen_nombre_castellano'                      => '',
                        'tipo_lesion_origen_nombre_portugues'                       => '',

                        'tipo_lesion_reincidencia_codigo'                           => '',
                        'tipo_lesion_reincidencia_nombre_ingles'                    => '',
                        'tipo_lesion_reincidencia_nombre_castellano'                => '',
                        'tipo_lesion_reincidencia_nombre_portugues'                 => '',

                        'tipo_lesion_retiro_codigo'                                 => '',
                        'tipo_lesion_retiro_nombre_ingles'                          => '',
                        'tipo_lesion_retiro_nombre_castellano'                      => '',
                        'tipo_lesion_retiro_nombre_portugues'                       => '',

                        'tipo_lesion_examen1_codigo'                                => '',
                        'tipo_lesion_examen1_nombre_ingles'                         => '',
                        'tipo_lesion_examen1_nombre_castellano'                     => '',
                        'tipo_lesion_examen1_nombre_portugues'                      => '',

                        'tipo_lesion_examen2_codigo'                                => '',
                        'tipo_lesion_examen2_nombre_ingles'                         => '',
                        'tipo_lesion_examen2_nombre_castellano'                     => '',
                        'tipo_lesion_examen2_nombre_portugues'                      => '',

                        'tipo_lesion_examen3_codigo'                                => '',
                        'tipo_lesion_examen3_nombre_ingles'                         => '',
                        'tipo_lesion_examen3_nombre_castellano'                     => '',
                        'tipo_lesion_examen3_nombre_portugues'                      => '',

                        'tipo_lesion_examen4_codigo'                                => '',
                        'tipo_lesion_examen4_nombre_ingles'                         => '',
                        'tipo_lesion_examen4_nombre_castellano'                     => '',
                        'tipo_lesion_examen4_nombre_portugues'                      => '',

                        'tipo_lesion_examen5_codigo'                                => '',
                        'tipo_lesion_examen5_nombre_ingles'                         => '',
                        'tipo_lesion_examen5_nombre_castellano'                     => '',
                        'tipo_lesion_examen5_nombre_portugues'                      => '',

                        'tipo_lesion_causa_codigo'                                  => '',
                        'tipo_lesion_causa_nombre_ingles'                           => '',
                        'tipo_lesion_causa_nombre_castellano'                       => '',
                        'tipo_lesion_causa_nombre_portugues'                        => '',

                        'tipo_lesion_falta_codigo'                                  => '',
                        'tipo_lesion_falta_nombre_ingles'                           => '',
                        'tipo_lesion_falta_nombre_castellano'                       => '',
                        'tipo_lesion_falta_nombre_portugues'                        => '',

                        'tipo_diagnostico_codigo'                                   => '',
                        'tipo_diagnostico_nombre_ingles'                            => '',
                        'tipo_diagnostico_nombre_castellano'                        => '',
                        'tipo_diagnostico_nombre_portugues'                         => '',
                        'tipo_diagnostico_observacion'                              => '',

                        'tipo_diagnostico_retorno_codigo'                           => '',
                        'tipo_diagnostico_retorno_nombre_ingles'                    => '',
                        'tipo_diagnostico_retorno_nombre_castellano'                => '',
                        'tipo_diagnostico_retorno_nombre_portugues'                 => '',
                        'tipo_diagnostico_retorno_observacion'                      => '',
                        'tipo_diagnostico_retorno_tratamiento'                      => '',

                        'tipo_diagnostico_recuperacion_codigo'                      => '',
                        'tipo_diagnostico_recuperacion_nombre_ingles'               => '',
                        'tipo_diagnostico_recuperacion_nombre_castellano'           => '',
                        'tipo_diagnostico_recuperacion_nombre_portugues'            => '',
                        'tipo_diagnostico_recuperacion'                             => '',

                        'tipo_diagnostico_tiempo_codigo'                            => '',
                        'tipo_diagnostico_tiempo_nombre_ingles'                     => '',
                        'tipo_diagnostico_tiempo_nombre_castellano'                 => '',
                        'tipo_diagnostico_tiempo_nombre_portugues'                  => '',

                        'competicion_codigo'                                        => '',
                        'competicion_nombre'                                        => '',

                        'juego_codigo'                                              => '',
                        'juego_nombre'                                              => '',

                        'equipo_codigo'                                             => '',
                        'equipo_nombre'                                             => '',

                        'jugador_codigo'                                            => '',
                        'jugador_nombre'                                            => '',

                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha_hora'                                      => '',
                        'auditoria_ip'                                              => ''
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

    $app->get('/v1/600/LESIONESTADO/{equipo}/{competicion}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "";

            if($val01 == 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICESC = b.DOMFICCOD

                WHERE a.LESFICCOC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
                
            } elseif ($val01 == 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICESC = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICESC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICESC = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICESC = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ? AND a.LESFICESC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if($val01 == 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02]);
                    
                } elseif ($val01 == 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val03]);
    
                } elseif ($val01 != 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02, $val01]);
    
                } elseif ($val01 != 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val01, $val03]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_cantidad'                     => ''
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

    $app->get('/v1/600/LESIONTIPO/{equipo}/{competicion}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "";

            if($val01 == 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICLES = b.DOMFICCOD

                WHERE a.LESFICCOC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
                
            } elseif ($val01 == 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICLES = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICLES = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICLES = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICLES = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ? AND a.LESFICLES = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if($val01 == 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02]);
                    
                } elseif ($val01 == 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val03]);
    
                } elseif ($val01 != 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02, $val01]);
    
                } elseif ($val01 != 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val01, $val03]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_cantidad'                     => ''
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

    $app->get('/v1/600/DIAGNOSTICOTIPO/{equipo}/{competicion}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "";

            if($val01 == 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMSUBCOD                 AS          tipo_codigo,
                b.DOMSUBNOI                 AS          tipo_nombre_ingles,
                b.DOMSUBNOC                 AS          tipo_nombre_castellano,
                b.DOMSUBNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMSUB] b ON a.LESFICDIA = b.DOMSUBCOD

                WHERE a.LESFICCOC = ?

                GROUP BY b.DOMSUBCOD, b.DOMSUBNOI, b.DOMSUBNOC, b.DOMSUBNOP";
                
            } elseif ($val01 == 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMSUBCOD                 AS          tipo_codigo,
                b.DOMSUBNOI                 AS          tipo_nombre_ingles,
                b.DOMSUBNOC                 AS          tipo_nombre_castellano,
                b.DOMSUBNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMSUB] b ON a.LESFICDIA = b.DOMSUBCOD

                WHERE a.LESFICCOC = ? AND a.LESFICDIA = ?

                GROUP BY b.DOMSUBCOD, b.DOMSUBNOI, b.DOMSUBNOC, b.DOMSUBNOP";

            } elseif ($val01 != 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMSUBCOD                 AS          tipo_codigo,
                b.DOMSUBNOI                 AS          tipo_nombre_ingles,
                b.DOMSUBNOC                 AS          tipo_nombre_castellano,
                b.DOMSUBNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMSUB] b ON a.LESFICDIA = b.DOMSUBCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ?

                GROUP BY b.DOMSUBCOD, b.DOMSUBNOI, b.DOMSUBNOC, b.DOMSUBNOP";

            } elseif ($val01 != 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMSUBCOD                 AS          tipo_codigo,
                b.DOMSUBNOI                 AS          tipo_nombre_ingles,
                b.DOMSUBNOC                 AS          tipo_nombre_castellano,
                b.DOMSUBNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMSUB] b ON a.LESFICDIA = b.DOMSUBCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ? AND a.LESFICDIA = ?

                GROUP BY b.DOMSUBCOD, b.DOMSUBNOI, b.DOMSUBNOC, b.DOMSUBNOP";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if($val01 == 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02]);
                    
                } elseif ($val01 == 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val03]);
    
                } elseif ($val01 != 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02, $val01]);
    
                } elseif ($val01 != 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val01, $val03]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_cantidad'                     => ''
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

    $app->get('/v1/600/LESIONREINCIDENCIA/{equipo}/{competicion}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "";

            if($val01 == 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICREI = b.DOMFICCOD

                WHERE a.LESFICCOC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
                
            } elseif ($val01 == 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICREI = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICREI = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICREI = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICREI = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ? AND a.LESFICREI = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if($val01 == 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02]);
                    
                } elseif ($val01 == 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val03]);
    
                } elseif ($val01 != 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02, $val01]);
    
                } elseif ($val01 != 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val01, $val03]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_cantidad'                     => ''
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

    $app->get('/v1/600/LESIONCAUSA/{equipo}/{competicion}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "";

            if($val01 == 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICCAU = b.DOMFICCOD

                WHERE a.LESFICCOC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
                
            } elseif ($val01 == 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICCAU = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICCAU = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICCAU = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICCAU = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ? AND a.LESFICCAU = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if($val01 == 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02]);
                    
                } elseif ($val01 == 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val03]);
    
                } elseif ($val01 != 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02, $val01]);
    
                } elseif ($val01 != 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val01, $val03]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_cantidad'                     => ''
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

    $app->get('/v1/600/LESIONFALTA/{equipo}/{competicion}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "";

            if($val01 == 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICFAL = b.DOMFICCOD

                WHERE a.LESFICCOC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
                
            } elseif ($val01 == 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICFAL = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICFAL = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICFAL = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICFAL = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ? AND a.LESFICFAL = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if($val01 == 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02]);
                    
                } elseif ($val01 == 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val03]);
    
                } elseif ($val01 != 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02, $val01]);
    
                } elseif ($val01 != 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val01, $val03]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_cantidad'                     => ''
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

    $app->get('/v1/600/CAMPOPOSICION/{equipo}/{competicion}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "";

            if($val01 == 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICPOS = b.DOMFICCOD

                WHERE a.LESFICCOC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
                
            } elseif ($val01 == 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICPOS = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICPOS = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICPOS = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICPOS = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ? AND a.LESFICPOS = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if($val01 == 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02]);
                    
                } elseif ($val01 == 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val03]);
    
                } elseif ($val01 != 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02, $val01]);
    
                } elseif ($val01 != 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val01, $val03]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_cantidad'                     => ''
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

    $app->get('/v1/600/CUERPOZONA/{equipo}/{competicion}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "";

            if($val01 == 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMSUBCOD                 AS          tipo_codigo,
                b.DOMSUBNOI                 AS          tipo_nombre_ingles,
                b.DOMSUBNOC                 AS          tipo_nombre_castellano,
                b.DOMSUBNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMSUB] b ON a.LESFICCUZ = b.DOMSUBCOD

                WHERE a.LESFICCOC = ?

                GROUP BY b.DOMSUBCOD, b.DOMSUBNOI, b.DOMSUBNOC, b.DOMSUBNOP";
                
            } elseif ($val01 == 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMSUBCOD                 AS          tipo_codigo,
                b.DOMSUBNOI                 AS          tipo_nombre_ingles,
                b.DOMSUBNOC                 AS          tipo_nombre_castellano,
                b.DOMSUBNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMSUB] b ON a.LESFICCUZ = b.DOMSUBCOD

                WHERE a.LESFICCOC = ? AND a.LESFICCUZ = ?

                GROUP BY b.DOMSUBCOD, b.DOMSUBNOI, b.DOMSUBNOC, b.DOMSUBNOP";

            } elseif ($val01 != 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMSUBCOD                 AS          tipo_codigo,
                b.DOMSUBNOI                 AS          tipo_nombre_ingles,
                b.DOMSUBNOC                 AS          tipo_nombre_castellano,
                b.DOMSUBNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMSUB] b ON a.LESFICCUZ = b.DOMSUBCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ?

                GROUP BY b.DOMSUBCOD, b.DOMSUBNOI, b.DOMSUBNOC, b.DOMSUBNOP";

            } elseif ($val01 != 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMSUBCOD                 AS          tipo_codigo,
                b.DOMSUBNOI                 AS          tipo_nombre_ingles,
                b.DOMSUBNOC                 AS          tipo_nombre_castellano,
                b.DOMSUBNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMSUB] b ON a.LESFICCUZ = b.DOMSUBCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ? AND a.LESFICCUZ = ?

                GROUP BY b.DOMSUBCOD, b.DOMSUBNOI, b.DOMSUBNOC, b.DOMSUBNOP";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if($val01 == 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02]);
                    
                } elseif ($val01 == 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val03]);
    
                } elseif ($val01 != 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02, $val01]);
    
                } elseif ($val01 != 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val01, $val03]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_cantidad'                     => ''
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

    $app->get('/v1/600/CUERPOLUGAR/{equipo}/{competicion}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "";

            if($val01 == 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICCUL = b.DOMFICCOD

                WHERE a.LESFICCOC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
                
            } elseif ($val01 == 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICCUL = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICCUL = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 == 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICCUL = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";

            } elseif ($val01 != 39393 && $val03 != 0) {
                $sql00  = "SELECT
                b.DOMFICCOD                 AS          tipo_codigo,
                b.DOMFICNOI                 AS          tipo_nombre_ingles,
                b.DOMFICNOC                 AS          tipo_nombre_castellano,
                b.DOMFICNOP                 AS          tipo_nombre_portugues,
                COUNT(*)                    AS          tipo_cantidad

                FROM [lesion].[LESFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.LESFICCUL = b.DOMFICCOD

                WHERE a.LESFICCOC = ? AND a.LESFICEQC = ? AND a.LESFICCUL = ?

                GROUP BY b.DOMFICCOD, b.DOMFICNOI, b.DOMFICNOC, b.DOMFICNOP";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if($val01 == 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02]);
                    
                } elseif ($val01 == 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val03]);
    
                } elseif ($val01 != 39393 && $val03 == 0) {
                    $stmtMSSQL->execute([$val02, $val01]);
    
                } elseif ($val01 != 39393 && $val03 != 0) {
                    $stmtMSSQL->execute([$val02, $val01, $val03]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre_ingles'                => trim($rowMSSQL['tipo_nombre_ingles']),
                        'tipo_nombre_castellano'            => trim($rowMSSQL['tipo_nombre_castellano']),
                        'tipo_nombre_portugues'             => trim($rowMSSQL['tipo_nombre_portugues']),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre_ingles'                => '',
                        'tipo_nombre_castellano'            => '',
                        'tipo_nombre_portugues'             => '',
                        'tipo_cantidad'                     => ''
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

    $app->get('/v1/800/covid19/prueba/{equipo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        
        if (isset($val01)) {
            $sql00  = "";

            if ($val01 == 39393) {
                $sql00  = "SELECT
                    a.COVFICCOD                         AS          covid19_codigo,
                    a.COVFICPER                         AS          covid19_anho,
                    a.COVFICFE1                         AS          covid19_fecha_1,
                    a.COVFICFE2                         AS          covid19_fecha_2,
                    a.COVFICFE3                         AS          covid19_fecha_3,
                    a.COVFICACA                         AS          covid19_adulto_cantidad,
                    a.COVFICMCA                         AS          covid19_menores_cantidad,
                    a.COVFICCIU                         AS          covid19_ciudad,
                    a.COVFICOBS                         AS          covid19_observacion,
                    
                    a.COVFICAUS                         AS          auditoria_usuario,
                    a.COVFICAFH                         AS          auditoria_fecha_hora,
                    a.COVFICAIP                         AS          auditoria_ip,

                    a.COVFICEST                         AS          tipo_estado_codigo,

                    a.COVFICDIC                         AS          disciplina_codigo,

                    c.competitionFifaId                 AS          competicion_codigo,
                    c.superiorCompetitionFifaId         AS          competicion_codigo_padre,
                    c.status                            AS          competicion_estado,
                    c.internationalName                 AS          competicion_nombre,
                    c.internationalShortName            AS          competicion_nombre_corto,
                    c.season                            AS          competicion_anho,

                    d.JUEGO_CODIGO                      AS          juego_codigo,
                    d.EQUIPO_LOCAL_NOMBRE               AS          juego_equipo_local,
                    d.EQUIPO_VISITANTE_NOMBRE           AS          juego_equpo_visitante,

                    e.teamFifaId                        AS          equipo_codigo,
                    e.internationalName                 AS          equipo_nombre,

                    f.personFifaId                      AS          jugador_codigo,
                    f.internationalFirstName            AS          jugador_nombre,
                    f.internationalLastName             AS          jugador_apellido,

                    g.DOMFICCOD                         AS          tipo_covid19_codigo,
                    g.DOMFICNOI                         AS          tipo_covid19_nombre_ingles,
                    g.DOMFICNOC                         AS          tipo_covid19_nombre_castellano,
                    g.DOMFICNOP                         AS          tipo_covid19_nombre_portugues

                    FROM [exa].[COVFIC] a
                    LEFT OUTER JOIN [comet].[competitions] c ON a.COVFICCOC = c.competitionFifaId
                    LEFT OUTER JOIN [view].[juego] d ON a.COVFICENC = d.JUEGO_CODIGO
                    LEFT OUTER JOIN [comet].[teams] e ON a.COVFICEQC = e.teamFifaId
                    LEFT OUTER JOIN [comet].[persons] f ON a.COVFICJUC = f.personFifaId
                    LEFT OUTER JOIN [adm].[DOMFIC] g ON a.COVFICTCC = g.DOMFICCOD

                    ORDER BY a.COVFICCOD DESC";
            } else {
                $sql00  = "SELECT
                    a.COVFICCOD                         AS          covid19_codigo,
                    a.COVFICPER                         AS          covid19_anho,
                    a.COVFICFE1                         AS          covid19_fecha_1,
                    a.COVFICFE2                         AS          covid19_fecha_2,
                    a.COVFICFE3                         AS          covid19_fecha_3,
                    a.COVFICACA                         AS          covid19_adulto_cantidad,
                    a.COVFICMCA                         AS          covid19_menores_cantidad,
                    a.COVFICCIU                         AS          covid19_ciudad,
                    a.COVFICOBS                         AS          covid19_observacion,
                    
                    a.COVFICAUS                         AS          auditoria_usuario,
                    a.COVFICAFH                         AS          auditoria_fecha_hora,
                    a.COVFICAIP                         AS          auditoria_ip,

                    a.COVFICEST                         AS          tipo_estado_codigo,

                    a.COVFICDIC                         AS          disciplina_codigo,

                    c.competitionFifaId                 AS          competicion_codigo,
                    c.superiorCompetitionFifaId         AS          competicion_codigo_padre,
                    c.status                            AS          competicion_estado,
                    c.internationalName                 AS          competicion_nombre,
                    c.internationalShortName            AS          competicion_nombre_corto,
                    c.season                            AS          competicion_anho,

                    d.JUEGO_CODIGO                      AS          juego_codigo,
                    d.EQUIPO_LOCAL_NOMBRE               AS          juego_equipo_local,
                    d.EQUIPO_VISITANTE_NOMBRE           AS          juego_equpo_visitante,

                    e.teamFifaId                        AS          equipo_codigo,
                    e.internationalName                 AS          equipo_nombre,

                    f.personFifaId                      AS          jugador_codigo,
                    f.internationalFirstName            AS          jugador_nombre,
                    f.internationalLastName             AS          jugador_apellido,

                    g.DOMFICCOD                         AS          tipo_covid19_codigo,
                    g.DOMFICNOI                         AS          tipo_covid19_nombre_ingles,
                    g.DOMFICNOC                         AS          tipo_covid19_nombre_castellano,
                    g.DOMFICNOP                         AS          tipo_covid19_nombre_portugues

                    FROM [exa].[COVFIC] a
                    LEFT OUTER JOIN [comet].[competitions] c ON a.COVFICCOC = c.competitionFifaId
                    LEFT OUTER JOIN [view].[juego] d ON a.COVFICENC = d.JUEGO_CODIGO
                    LEFT OUTER JOIN [comet].[teams] e ON a.COVFICEQC = e.teamFifaId
                    LEFT OUTER JOIN [comet].[persons] f ON a.COVFICJUC = f.personFifaId
                    LEFT OUTER JOIN [adm].[DOMFIC] g ON a.COVFICTCC = g.DOMFICCOD

                    WHERE a.COVFICEQC = ?

                    ORDER BY a.COVFICCOD DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
                    $stmtMSSQL->execute();
                } else {
                    $stmtMSSQL->execute([$val01]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    switch ($rowMSSQL['disciplina_codigo']) {
                        case 'FOOTBALL':
                            $disciplina_nombre = 'Fútbol de Campo';
                            break;
                        
                        case 'FUTSAL':
                            $disciplina_nombre = 'Fútbol de Salón';
                            break;

                        case 'BEACH_SOCCER':
                            $disciplina_nombre = 'Fútbol de Playa';
                            break;
                    }

                    if ($rowMSSQL['tipo_estado_codigo'] === 'A') {
                        $tipo_estado_nombre = 'ACTIVO';
                    } 
                    
                    if ($rowMSSQL['tipo_estado_codigo'] === 'I') {
                        $tipo_estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'covid19_codigo'                                            => $rowMSSQL['covid19_codigo'],
                        'covid19_anho'                                              => $rowMSSQL['covid19_anho'],
                        'covid19_fecha_1'                                           => date_format(date_create($rowMSSQL['covid19_fecha_1']), 'd/m/Y'),
                        'covid19_fecha_2'                                           => date_format(date_create($rowMSSQL['covid19_fecha_2']), 'd/m/Y'),
                        'covid19_fecha_3'                                           => date_format(date_create($rowMSSQL['covid19_fecha_3']), 'd/m/Y'),
                        'covid19_adulto_cantidad'                                   => $rowMSSQL['covid19_adulto_cantidad'],
                        'covid19_menores_cantidad'                                  => trim($rowMSSQL['covid19_menores_cantidad']),
                        'covid19_ciudad'                                            => trim($rowMSSQL['covid19_ciudad']),
                        'covid19_observacion'                                       => trim($rowMSSQL['covid19_observacion']),

                        'tipo_estado_codigo'                                        => trim($rowMSSQL['tipo_estado_codigo']),
                        'tipo_estado_nombre'                                        => trim($tipo_estado_nombre),

                        'disciplina_codigo'                                         => trim($rowMSSQL['disciplina_codigo']),
                        'disciplina_nombre'                                         => trim($disciplina_nombre),
                        
                        'competicion_codigo'                                        => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'                                  => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                                        => trim($rowMSSQL['competicion_estado']),
                        'competicion_nombre'                                        => trim($rowMSSQL['competicion_nombre']),
                        'competicion_nombre_corto'                                  => trim($rowMSSQL['competicion_nombre_corto']),
                        'competicion_anho'                                          => $rowMSSQL['competicion_anho'],

                        'juego_codigo'                                              => ($rowMSSQL['juego_codigo']),
                        'juego_nombre'                                              => trim($rowMSSQL['juego_equipo_local']).' vs '.trim($rowMSSQL['juego_equpo_visitante']),

                        'equipo_codigo'                                             => ($rowMSSQL['equipo_codigo']),
                        'equipo_nombre'                                             => trim($rowMSSQL['equipo_nombre']),

                        'jugador_codigo'                                            => ($rowMSSQL['jugador_codigo']),
                        'jugador_nombre'                                            => trim($rowMSSQL['jugador_apellido']).', '.trim($rowMSSQL['jugador_nombre']),

                        'tipo_covid19_codigo'                                       => $rowMSSQL['tipo_covid19_codigo'],
                        'tipo_covid19_nombre_ingles'                                => trim($rowMSSQL['tipo_covid19_nombre_ingles']),
                        'tipo_covid19_nombre_castellano'                            => trim($rowMSSQL['tipo_covid19_nombre_castellano']),
                        'tipo_covid19_nombre_portugues'                             => trim($rowMSSQL['tipo_covid19_nombre_portugues']),

                        'auditoria_usuario'                                         => trim($rowMSSQL['auditoria_usuario']),
                        'auditoria_fecha_hora'                                      => date_format(date_create($rowMSSQL['auditoria_fecha_hora']), 'd/m/Y'),
                        'auditoria_ip'                                              => trim($rowMSSQL['auditoria_ip'])   
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'covid19_codigo'                                            => '',
                        'covid19_anho'                                              => '',
                        'covid19_fecha_1'                                           => '',
                        'covid19_fecha_2'                                           => '',
                        'covid19_fecha_3'                                           => '',
                        'covid19_adulto_cantidad'                                   => '',
                        'covid19_menores_cantidad'                                  => '',
                        'covid19_ciudad'                                            => '',
                        'covid19_observacion'                                       => '',

                        'tipo_estado_codigo'                                        => '',
                        'tipo_estado_nombre'                                        => '',

                        'disciplina_codigo'                                         => '',
                        'disciplina_nombre'                                         => '',
                        
                        'competicion_codigo'                                        => '',
                        'competicion_codigo_padre'                                  => '',
                        'competicion_estado'                                        => '',
                        'competicion_nombre'                                        => '',
                        'competicion_nombre_corto'                                  => '',
                        'competicion_anho'                                          => '',

                        'juego_codigo'                                              => '',
                        'juego_nombre'                                              => '',

                        'equipo_codigo'                                             => '',
                        'equipo_nombre'                                             => '',

                        'jugador_codigo'                                            => '',
                        'jugador_nombre'                                            => '',

                        'tipo_covid19_codigo'                                       => '',
                        'tipo_covid19_nombre_ingles'                                => '',
                        'tipo_covid19_nombre_castellano'                            => '',
                        'tipo_covid19_nombre_portugues'                             => '',

                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha_hora'                                      => '',
                        'auditoria_ip'                                              => '' 
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

    $app->get('/v1/801/covid19/prueba/{equipo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        
        if (isset($val01)) {
            $sql00  = "";

            if ($val01 == 39393) {
                $sql00  = "SELECT
                    a.COVFICCOD                         AS          covid19_codigo,
                    a.COVFICPER                         AS          covid19_anho,
                    a.COVFICFE1                         AS          covid19_fecha_1,
                    a.COVFICFE2                         AS          covid19_fecha_2,
                    a.COVFICFE3                         AS          covid19_fecha_3,
                    a.COVFICACA                         AS          covid19_adulto_cantidad,
                    a.COVFICMCA                         AS          covid19_menores_cantidad,
                    a.COVFICCIU                         AS          covid19_ciudad,
                    a.COVFICOBS                         AS          covid19_observacion,
                    
                    a.COVFICAUS                         AS          auditoria_usuario,
                    a.COVFICAFH                         AS          auditoria_fecha_hora,
                    a.COVFICAIP                         AS          auditoria_ip,

                    a.COVFICEST                         AS          tipo_estado_codigo,

                    a.COVFICDIC                         AS          disciplina_codigo,

                    c.competitionFifaId                 AS          competicion_codigo,
                    c.superiorCompetitionFifaId         AS          competicion_codigo_padre,
                    c.status                            AS          competicion_estado,
                    c.internationalName                 AS          competicion_nombre,
                    c.internationalShortName            AS          competicion_nombre_corto,
                    c.season                            AS          competicion_anho,

                    d.JUEGO_CODIGO                      AS          juego_codigo,
                    d.EQUIPO_LOCAL_NOMBRE               AS          juego_equipo_local,
                    d.EQUIPO_VISITANTE_NOMBRE           AS          juego_equpo_visitante,

                    e.teamFifaId                        AS          equipo_codigo,
                    e.internationalName                 AS          equipo_nombre,

                    f.personFifaId                      AS          jugador_codigo,
                    f.internationalFirstName            AS          jugador_nombre,
                    f.internationalLastName             AS          jugador_apellido,

                    g.DOMFICCOD                         AS          tipo_covid19_codigo,
                    g.DOMFICNOI                         AS          tipo_covid19_nombre_ingles,
                    g.DOMFICNOC                         AS          tipo_covid19_nombre_castellano,
                    g.DOMFICNOP                         AS          tipo_covid19_nombre_portugues

                    FROM [exa].[COVFICC] a
                    LEFT OUTER JOIN [comet].[competitions] c ON a.COVFICCOC = c.competitionFifaId
                    LEFT OUTER JOIN [view].[juego] d ON a.COVFICENC = d.JUEGO_CODIGO
                    LEFT OUTER JOIN [comet].[teams] e ON a.COVFICEQC = e.teamFifaId
                    LEFT OUTER JOIN [comet].[persons] f ON a.COVFICJUC = f.personFifaId
                    LEFT OUTER JOIN [adm].[DOMFIC] g ON a.COVFICTCC = g.DOMFICCOD

                    ORDER BY a.COVFICCOD DESC";
            } else {
                $sql00  = "SELECT
                    a.COVFICCOD                         AS          covid19_codigo,
                    a.COVFICPER                         AS          covid19_anho,
                    a.COVFICFE1                         AS          covid19_fecha_1,
                    a.COVFICFE2                         AS          covid19_fecha_2,
                    a.COVFICFE3                         AS          covid19_fecha_3,
                    a.COVFICACA                         AS          covid19_adulto_cantidad,
                    a.COVFICMCA                         AS          covid19_menores_cantidad,
                    a.COVFICCIU                         AS          covid19_ciudad,
                    a.COVFICOBS                         AS          covid19_observacion,
                    
                    a.COVFICAUS                         AS          auditoria_usuario,
                    a.COVFICAFH                         AS          auditoria_fecha_hora,
                    a.COVFICAIP                         AS          auditoria_ip,

                    a.COVFICEST                         AS          tipo_estado_codigo,

                    a.COVFICDIC                         AS          disciplina_codigo,

                    c.competitionFifaId                 AS          competicion_codigo,
                    c.superiorCompetitionFifaId         AS          competicion_codigo_padre,
                    c.status                            AS          competicion_estado,
                    c.internationalName                 AS          competicion_nombre,
                    c.internationalShortName            AS          competicion_nombre_corto,
                    c.season                            AS          competicion_anho,

                    d.JUEGO_CODIGO                      AS          juego_codigo,
                    d.EQUIPO_LOCAL_NOMBRE               AS          juego_equipo_local,
                    d.EQUIPO_VISITANTE_NOMBRE           AS          juego_equpo_visitante,

                    e.teamFifaId                        AS          equipo_codigo,
                    e.internationalName                 AS          equipo_nombre,

                    f.personFifaId                      AS          jugador_codigo,
                    f.internationalFirstName            AS          jugador_nombre,
                    f.internationalLastName             AS          jugador_apellido,

                    g.DOMFICCOD                         AS          tipo_covid19_codigo,
                    g.DOMFICNOI                         AS          tipo_covid19_nombre_ingles,
                    g.DOMFICNOC                         AS          tipo_covid19_nombre_castellano,
                    g.DOMFICNOP                         AS          tipo_covid19_nombre_portugues

                    FROM [exa].[COVFICC] a
                    LEFT OUTER JOIN [comet].[competitions] c ON a.COVFICCOC = c.competitionFifaId
                    LEFT OUTER JOIN [view].[juego] d ON a.COVFICENC = d.JUEGO_CODIGO
                    LEFT OUTER JOIN [comet].[teams] e ON a.COVFICEQC = e.teamFifaId
                    LEFT OUTER JOIN [comet].[persons] f ON a.COVFICJUC = f.personFifaId
                    LEFT OUTER JOIN [adm].[DOMFIC] g ON a.COVFICTCC = g.DOMFICCOD

                    WHERE a.COVFICEQC = ?

                    ORDER BY a.COVFICCOD DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
                    $stmtMSSQL->execute();
                } else {
                    $stmtMSSQL->execute([$val01]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    switch ($rowMSSQL['disciplina_codigo']) {
                        case 'FOOTBALL':
                            $disciplina_nombre = 'Fútbol de Campo';
                            break;
                        
                        case 'FUTSAL':
                            $disciplina_nombre = 'Fútbol de Salón';
                            break;

                        case 'BEACH_SOCCER':
                            $disciplina_nombre = 'Fútbol de Playa';
                            break;
                    }

                    if ($rowMSSQL['tipo_estado_codigo'] === 'A') {
                        $tipo_estado_nombre = 'ACTIVO';
                    } 
                    
                    if ($rowMSSQL['tipo_estado_codigo'] === 'I') {
                        $tipo_estado_nombre = 'INACTIVO';
                    }

                    $detalle    = array(
                        'covid19_codigo'                                            => $rowMSSQL['covid19_codigo'],
                        'covid19_anho'                                              => $rowMSSQL['covid19_anho'],
                        'covid19_fecha_1'                                           => date_format(date_create($rowMSSQL['covid19_fecha_1']), 'd/m/Y'),
                        'covid19_fecha_2'                                           => date_format(date_create($rowMSSQL['covid19_fecha_2']), 'd/m/Y'),
                        'covid19_fecha_3'                                           => date_format(date_create($rowMSSQL['covid19_fecha_3']), 'd/m/Y'),
                        'covid19_adulto_cantidad'                                   => $rowMSSQL['covid19_adulto_cantidad'],
                        'covid19_menores_cantidad'                                  => trim($rowMSSQL['covid19_menores_cantidad']),
                        'covid19_ciudad'                                            => trim($rowMSSQL['covid19_ciudad']),
                        'covid19_observacion'                                       => trim($rowMSSQL['covid19_observacion']),

                        'tipo_estado_codigo'                                        => trim($rowMSSQL['tipo_estado_codigo']),
                        'tipo_estado_nombre'                                        => trim($tipo_estado_nombre),

                        'disciplina_codigo'                                         => trim($rowMSSQL['disciplina_codigo']),
                        'disciplina_nombre'                                         => trim($disciplina_nombre),
                        
                        'competicion_codigo'                                        => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'                                  => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                                        => trim($rowMSSQL['competicion_estado']),
                        'competicion_nombre'                                        => trim($rowMSSQL['competicion_nombre']),
                        'competicion_nombre_corto'                                  => trim($rowMSSQL['competicion_nombre_corto']),
                        'competicion_anho'                                          => $rowMSSQL['competicion_anho'],

                        'juego_codigo'                                              => ($rowMSSQL['juego_codigo']),
                        'juego_nombre'                                              => trim($rowMSSQL['juego_equipo_local']).' vs '.trim($rowMSSQL['juego_equpo_visitante']),

                        'equipo_codigo'                                             => ($rowMSSQL['equipo_codigo']),
                        'equipo_nombre'                                             => trim($rowMSSQL['equipo_nombre']),

                        'jugador_codigo'                                            => ($rowMSSQL['jugador_codigo']),
                        'jugador_nombre'                                            => trim($rowMSSQL['jugador_apellido']).', '.trim($rowMSSQL['jugador_nombre']),

                        'tipo_covid19_codigo'                                       => $rowMSSQL['tipo_covid19_codigo'],
                        'tipo_covid19_nombre_ingles'                                => trim($rowMSSQL['tipo_covid19_nombre_ingles']),
                        'tipo_covid19_nombre_castellano'                            => trim($rowMSSQL['tipo_covid19_nombre_castellano']),
                        'tipo_covid19_nombre_portugues'                             => trim($rowMSSQL['tipo_covid19_nombre_portugues']),

                        'auditoria_usuario'                                         => trim($rowMSSQL['auditoria_usuario']),
                        'auditoria_fecha_hora'                                      => date_format(date_create($rowMSSQL['auditoria_fecha_hora']), 'd/m/Y'),
                        'auditoria_ip'                                              => trim($rowMSSQL['auditoria_ip'])   
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'covid19_codigo'                                            => '',
                        'covid19_anho'                                              => '',
                        'covid19_fecha_1'                                           => '',
                        'covid19_fecha_2'                                           => '',
                        'covid19_fecha_3'                                           => '',
                        'covid19_adulto_cantidad'                                   => '',
                        'covid19_menores_cantidad'                                  => '',
                        'covid19_ciudad'                                            => '',
                        'covid19_observacion'                                       => '',

                        'tipo_estado_codigo'                                        => '',
                        'tipo_estado_nombre'                                        => '',

                        'disciplina_codigo'                                         => '',
                        'disciplina_nombre'                                         => '',
                        
                        'competicion_codigo'                                        => '',
                        'competicion_codigo_padre'                                  => '',
                        'competicion_estado'                                        => '',
                        'competicion_nombre'                                        => '',
                        'competicion_nombre_corto'                                  => '',
                        'competicion_anho'                                          => '',

                        'juego_codigo'                                              => '',
                        'juego_nombre'                                              => '',

                        'equipo_codigo'                                             => '',
                        'equipo_nombre'                                             => '',

                        'jugador_codigo'                                            => '',
                        'jugador_nombre'                                            => '',

                        'tipo_covid19_codigo'                                       => '',
                        'tipo_covid19_nombre_ingles'                                => '',
                        'tipo_covid19_nombre_castellano'                            => '',
                        'tipo_covid19_nombre_portugues'                             => '',

                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha_hora'                                      => '',
                        'auditoria_ip'                                              => '' 
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


    /*APARTIR DE AQUI*/
    $app->get('/v1/200/competicion/medico/{equipo}/{persona}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('equipo');
        $val02  = $request->getAttribute('persona');
        
        if (isset($val01) && isset($val02)) {
            if ($val01 == 39393) {
                $sql00  = "SELECT 
                    a.PERCOMOBS                         AS          competicion_persona_observacion,
                    
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
                    c.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
                    c.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
                    c.DOMFICNOP                         AS          tipo_estado_nombre_portugues,

                    d.DOMFICCOD                         AS          tipo_acceso_codigo,
                    d.DOMFICNOI                         AS          tipo_acceso_nombre_ingles,
                    d.DOMFICNOC                         AS          tipo_acceso_nombre_castellano,
                    d.DOMFICNOP                         AS          tipo_acceso_nombre_portugues,

                    e.DOMFICCOD                         AS          tipo_perfil_codigo,
                    e.DOMFICNOI                         AS          tipo_perfil_nombre_ingles,
                    e.DOMFICNOC                         AS          tipo_perfil_nombre_castellano,
                    e.DOMFICNOP                         AS          tipo_perfil_nombre_portugues,

                    f.teamFifaId                        AS          equipo_codigo,
                    f.internationalShortName            AS          equipo_nombre,

                    g.DOMFICCOD                         AS          tipo_categoria_codigo,
                    g.DOMFICNOI                         AS          tipo_categoria_nombre_ingles,
                    g.DOMFICNOC                         AS          tipo_categoria_nombre_castellano,
                    g.DOMFICNOP                         AS          tipo_categoria_nombre_portugues,

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
                    i.DOMFICNOI                         AS          tipo_modulo_nombre_ingles,
                    i.DOMFICNOC                         AS          tipo_modulo_nombre_castellano,
                    i.DOMFICNOP                         AS          tipo_modulo_nombre_portugues
                    
                    FROM [adm].[PERCOM] a
                    INNER JOIN [adm].[PERFIC] b ON a.PERCOMPEC = b.PERFICCOD
                    INNER JOIN [adm].[DOMFIC] c ON b.PERFICEST = c.DOMFICCOD
                    INNER JOIN [adm].[DOMFIC] d ON b.PERFICTIP = d.DOMFICCOD
                    INNER JOIN [adm].[DOMFIC] e ON b.PERFICROL = e.DOMFICCOD
                    INNER JOIN [comet].[teams] f ON b.PERFICEQU = f.teamFifaId
                    INNER JOIN [adm].[DOMFIC] g ON b.PERFICCAT = g.DOMFICCOD
                    INNER JOIN [comet].[competitions] h ON a.PERCOMCOC = h.competitionFifaId
                    INNER JOIN [adm].[DOMFIC] i ON a.PERCOMTMC = i.DOMFICCOD
                    
                    ORDER BY a.PERCOMTMC, a.PERCOMCOC, a.PERCOMPEC";
            } else {
                $sql00  = "SELECT 
                    a.PERCOMOBS                         AS          competicion_persona_observacion,
                    
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
                    c.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
                    c.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
                    c.DOMFICNOP                         AS          tipo_estado_nombre_portugues,

                    d.DOMFICCOD                         AS          tipo_acceso_codigo,
                    d.DOMFICNOI                         AS          tipo_acceso_nombre_ingles,
                    d.DOMFICNOC                         AS          tipo_acceso_nombre_castellano,
                    d.DOMFICNOP                         AS          tipo_acceso_nombre_portugues,

                    e.DOMFICCOD                         AS          tipo_perfil_codigo,
                    e.DOMFICNOI                         AS          tipo_perfil_nombre_ingles,
                    e.DOMFICNOC                         AS          tipo_perfil_nombre_castellano,
                    e.DOMFICNOP                         AS          tipo_perfil_nombre_portugues,

                    f.teamFifaId                        AS          equipo_codigo,
                    f.internationalShortName            AS          equipo_nombre,

                    g.DOMFICCOD                         AS          tipo_categoria_codigo,
                    g.DOMFICNOI                         AS          tipo_categoria_nombre_ingles,
                    g.DOMFICNOC                         AS          tipo_categoria_nombre_castellano,
                    g.DOMFICNOP                         AS          tipo_categoria_nombre_portugues,

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
                    i.DOMFICNOI                         AS          tipo_modulo_nombre_ingles,
                    i.DOMFICNOC                         AS          tipo_modulo_nombre_castellano,
                    i.DOMFICNOP                         AS          tipo_modulo_nombre_portugues
                    
                    FROM [adm].[PERCOM] a
                    INNER JOIN [adm].[PERFIC] b ON a.PERCOMPEC = b.PERFICCOD
                    INNER JOIN [adm].[DOMFIC] c ON b.PERFICEST = c.DOMFICCOD
                    INNER JOIN [adm].[DOMFIC] d ON b.PERFICTIP = d.DOMFICCOD
                    INNER JOIN [adm].[DOMFIC] e ON b.PERFICROL = e.DOMFICCOD
                    INNER JOIN [comet].[teams] f ON b.PERFICEQU = f.teamFifaId
                    INNER JOIN [adm].[DOMFIC] g ON b.PERFICCAT = g.DOMFICCOD
                    INNER JOIN [comet].[competitions] h ON a.PERCOMCOC = h.competitionFifaId
                    INNER JOIN [adm].[DOMFIC] i ON a.PERCOMTMC = i.DOMFICCOD

                    WHERE b.PERFICEQU = ? AND a.PERCOMPEC = ? 
                    
                    ORDER BY a.PERCOMTMC, a.PERCOMCOC, a.PERCOMPEC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                
                if ($val01 == 39393) {
                    $stmtMSSQL->execute();
                } else {
                    $stmtMSSQL->execute([$val01, $val02]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {    
                    $auditoria_fecha_hora = date_format(date_create($rowMSSQL['auditoria_fecha_hora']), 'd/m/Y H:i:s');
                    
                    if (isset($rowMSSQL['persona_path'])){
                        $persona_path = $rowMSSQL['persona_path'];
                    } else {
                        $persona_path = 'assets/images/users/defaul.png';
                    }

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
                        'competicion_persona_observacion'       => trim(strtoupper(strtolower($rowMSSQL['competicion_persona_observacion']))),
                        'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL['auditoria_usuario']))),
                        'auditoria_fecha_hora'                  => $auditoria_fecha_hora,
                        'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL['auditoria_ip']))),

                        'persona_codigo'                        => $rowMSSQL['persona_codigo'],
                        'persona_nombre'                        => trim(strtoupper(strtolower($rowMSSQL['persona_nombre']))),
                        'persona_user'                          => trim(strtoupper(strtolower($rowMSSQL['persona_user']))),
                        'persona_path'                          => trim(strtoupper(strtolower($persona_path))),
                        'persona_email'                         => trim(strtoupper(strtolower($rowMSSQL['persona_email']))),
                        'persona_telefono'                      => trim(strtoupper(strtolower($rowMSSQL['persona_telefono']))),

                        'tipo_estado_codigo'                    => $rowMSSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre_ingles'             => trim(strtoupper(strtolower($rowMSSQL['tipo_estado_nombre_ingles']))),
                        'tipo_estado_nombre_castellano'         => trim(strtoupper(strtolower($rowMSSQL['tipo_estado_nombre_castellano']))),
                        'tipo_estado_nombre_portugues'          => trim(strtoupper(strtolower($rowMSSQL['tipo_estado_nombre_portugues']))),

                        'tipo_acceso_codigo'                    => $rowMSSQL['tipo_acceso_codigo'],
                        'tipo_acceso_nombre_ingles'             => trim(strtoupper(strtolower($rowMSSQL['tipo_acceso_nombre_ingles']))),
                        'tipo_acceso_nombre_castellano'         => trim(strtoupper(strtolower($rowMSSQL['tipo_acceso_nombre_castellano']))),
                        'tipo_acceso_nombre_portugues'          => trim(strtoupper(strtolower($rowMSSQL['tipo_acceso_nombre_portugues']))),

                        'tipo_perfil_codigo'                    => $rowMSSQL['tipo_perfil_codigo'],
                        'tipo_perfil_nombre_ingles'             => trim(strtoupper(strtolower($rowMSSQL['tipo_perfil_nombre_ingles']))),
                        'tipo_perfil_nombre_castellano'         => trim(strtoupper(strtolower($rowMSSQL['tipo_perfil_nombre_castellano']))),
                        'tipo_perfil_nombre_portugues'          => trim(strtoupper(strtolower($rowMSSQL['tipo_perfil_nombre_portugues']))),

                        'equipo_codigo'                         => $rowMSSQL['equipo_codigo'],
                        'equipo_nombre'                         => trim(strtoupper(strtolower($rowMSSQL['equipo_nombre']))),

                        'tipo_categoria_codigo'                 => $rowMSSQL['tipo_categoria_codigo'],
                        'tipo_categoria_nombre_ingles'          => trim(strtoupper(strtolower($rowMSSQL['tipo_categoria_nombre_ingles']))),
                        'tipo_categoria_nombre_castellano'      => trim(strtoupper(strtolower($rowMSSQL['tipo_categoria_nombre_castellano']))),
                        'tipo_categoria_nombre_portugues'       => trim(strtoupper(strtolower($rowMSSQL['tipo_categoria_nombre_portugues']))),

                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim(strtoupper(strtolower($rowMSSQL['competicion_estado']))),
                        'competicion_nombre'                    => trim(strtoupper(strtolower($rowMSSQL['competicion_nombre']))),
                        'competicion_nombre_corto'              => trim(strtoupper(strtolower($rowMSSQL['competicion_nombre_corto']))),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],
                        'competicion_categoria_codigo'          => trim(strtoupper(strtolower($rowMSSQL['competicion_categoria_codigo']))),
                        'competicion_categoria_nombre'          => trim(strtoupper(strtolower($rowMSSQL['competicion_categoria_nombre']))),
                        'competicion_desde'                     => $rowMSSQL['competicion_desde'],
                        'competicion_hasta'                     => $rowMSSQL['competicion_hasta'],
                        'competicion_disciplina'                => trim(strtoupper(strtolower($rowMSSQL['competicion_disciplina']))),
                        'competicion_genero'                    => trim(strtoupper(strtolower($rowMSSQL['competicion_genero']))),
                        'competicion_imagen_codigo'             => $rowMSSQL['competicion_imagen_codigo'],
                        'competicion_multiplicador'             => $rowMSSQL['competicion_multiplicador'],
                        'competicion_naturaleza'                => trim(strtoupper(strtolower($rowMSSQL['competicion_naturaleza']))),
                        'competicion_numero_participante'       => $rowMSSQL['competicion_numero_participante'],
                        'competicion_numero_orden'              => $rowMSSQL['competicion_numero_orden'],
                        'competicion_equipo_tipo'               => trim(strtoupper(strtolower($rowMSSQL['competicion_equipo_tipo']))),
                        'competicion_sustitucion'               => $rowMSSQL['competicion_sustitucion'],
                        'competicion_penal'                     => $rowMSSQL['competicion_penal'],
                        'competicion_tipo'                      => trim(strtoupper(strtolower($rowMSSQL['competicion_tipo']))),
                        'competicion_imagen_tipo'               => trim(strtoupper(strtolower($rowMSSQL['competicion_imagen_tipo']))),
                        'competicion_imagen_path'               => 'imagen/competicion/img_'.$rowMSSQL['competicion_codigo'].'.'.$ext,
                        'competicion_ultima_actualizacion'      => $rowMSSQL['competicion_ultima_actualizacion'],

                        'tipo_modulo_codigo'                    => $rowMSSQL['tipo_modulo_codigo'],
                        'tipo_modulo_nombre_ingles'             => trim(strtoupper(strtolower($rowMSSQL['tipo_modulo_nombre_ingles']))),
                        'tipo_modulo_nombre_castellano'         => trim(strtoupper(strtolower($rowMSSQL['tipo_modulo_nombre_castellano']))),
                        'tipo_modulo_nombre_portugues'          => trim(strtoupper(strtolower($rowMSSQL['tipo_modulo_nombre_portugues'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'competicion_persona_observacion'       => '',
                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',

                        'persona_codigo'                        => '',
                        'persona_nombre'                        => '',
                        'persona_user'                          => '',
                        'persona_path'                          => '',
                        'persona_email'                         => '',
                        'persona_telefono'                      => '',

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
                        'tipo_categoria_nombre_portugues'       => '',

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
                        'competicion_ultima_actualizacion'      => '',

                        'tipo_modulo_codigo'                    => '',
                        'tipo_modulo_nombre_ingles'             => '',
                        'tipo_modulo_nombre_castellano'         => '',
                        'tipo_modulo_nombre_portugues'          => ''
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

    $app->get('/v1/200/competicion/encuentro/{equipo}/{competicion}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');

        if (isset($val01) && isset($val02)) {
            if ($val01 == 39393) {
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
                    
                    WHERE (a.EQUIPO_LOCAL_CODIGO = ? OR a.EQUIPO_VISITANTE_CODIGO = ?) AND (a.COMPETICION_ID = ? OR a.COMPETICION_PADRE_ID = ?)
        
                    ORDER BY a.COMPETICION_PADRE_ID DESC, a.JUEGO_HORARIO DESC, a.JUEGO_CODIGO DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val02 == 39393) {
                    $stmtMSSQL->execute([$val02, $val02]); 
                } else {
                    $stmtMSSQL->execute([$val01, $val01, $val02, $val02]); 
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $juego_horario  = date_format(date_create($rowMSSQL['juego_horario']), 'd/m/Y H:i:s');
                    $juego_cierra   = date("Y-m-d", strtotime($rowMSSQL['juego_horario']."+ 10 days"));

                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim(strtoupper(strtolower($rowMSSQL['competicion_estado']))),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],

                        'juego_codigo'                          => $rowMSSQL['juego_codigo'],
                        'juego_fase'                            => trim(strtoupper(strtolower($rowMSSQL['juego_fase']))),
                        'juego_estado'                          => trim(strtoupper(strtolower($rowMSSQL['juego_estado']))),
                        'juego_horario'                         => $juego_horario,
                        'juego_cierra'                          => $juego_cierra,

                        'equipo_local_codigo'                   => $rowMSSQL['equipo_local_codigo'],
                        'equipo_local_nombre'                   => trim(strtoupper(strtolower($rowMSSQL['equipo_local_nombre']))),
                        'equipo_local_resultado_primer'         => $rowMSSQL['equipo_local_resultado_primer'],
                        'equipo_local_resultado_segundo'        => $rowMSSQL['equipo_local_resultado_segundo'],
                        'equipo_local_resultado_final'          => $rowMSSQL['equipo_local_resultado_segundo'],

                        'equipo_visitante_codigo'               => $rowMSSQL['equipo_visitante_codigo'],
                        'equipo_visitante_nombre'               => trim(strtoupper(strtolower($rowMSSQL['equipo_visitante_nombre']))),
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
                        'juego_cierra'                          => '',

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

    $app->get('/v1/200/competicion/equipo/{equipo}/{competicion}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        
        if (isset($val01) && isset($val02)) {
            if ($val01 == 39393) {
                $sql00  = "SELECT
                    a.competitionFifaId                 AS          competicion_codigo,
                    
                    b.personFifaId                      AS          jugador_codigo,
                    b.internationalLastName             AS          jugador_apellido,
                    b.internationalFirstName            AS          jugador_nombre,
                    b.playerPosition                    AS          jugador_posicion,
                    b.pictureContentType                AS          jugador_imagen_tipo,
                    b.pictureLink                       AS          jugador_imagen_link,
                    b.pictureValue                      AS          jugador_imagen_valor,
                    a.shirtNumber                       AS          jugador_numero
                    
                    FROM [comet].[competitions_teams_players] a
                    INNER JOIN [comet].[persons] b ON a.playerFifaId = b.personFifaId
                    
                    WHERE a.competitionFifaId = ?

                    ORDER BY b.playerPosition, a.shirtNumber";
            } else {
                $sql00  = "SELECT
                    a.competitionFifaId                 AS          competicion_codigo,
                    
                    b.personFifaId                      AS          jugador_codigo,
                    b.internationalLastName             AS          jugador_apellido,
                    b.internationalFirstName            AS          jugador_nombre,
                    b.playerPosition                    AS          jugador_posicion,
                    b.pictureContentType                AS          jugador_imagen_tipo,
                    b.pictureLink                       AS          jugador_imagen_link,
                    b.pictureValue                      AS          jugador_imagen_valor,
                    a.shirtNumber                       AS          jugador_numero
                    
                    FROM [comet].[competitions_teams_players] a
                    INNER JOIN [comet].[persons] b ON a.playerFifaId = b.personFifaId
                    
                    WHERE a.teamFifaId = ? AND a.competitionFifaId = ?

                    ORDER BY b.playerPosition, a.shirtNumber";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
                    $stmtMSSQL->execute([$val02]);
                } else {
                    $stmtMSSQL->execute([$val01, $val02]);
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'competicion_codigo'            => $rowMSSQL['competicion_codigo'],
                        'jugador_codigo'                => $rowMSSQL['jugador_codigo'],
                        'jugador_apellido'              => trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))),
                        'jugador_nombre'                => trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))),
                        'jugador_completo'              => trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))).', '.trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))),
                        'jugador_posicion'              => trim(strtoupper(strtolower($rowMSSQL['jugador_posicion']))),
                        'jugador_imagen_tipo'           => trim(strtolower($rowMSSQL['jugador_imagen_tipo'])),
                        'jugador_imagen_link'           => trim($rowMSSQL['jugador_imagen_link']),
                        'jugador_imagen_valor'          => '',//trim($rowMSSQL['jugador_imagen_valor']),
                        'jugador_numero'                => $rowMSSQL['jugador_numero']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'competicion_codigo'            => '',
                        'jugador_codigo'                => '',
                        'jugador_apellido'              => '',
                        'jugador_nombre'                => '',
                        'jugador_completo'              => '',
                        'jugador_posicion'              => '',
                        'jugador_imagen_tipo'           => '',
                        'jugador_imagen_link'           => '',
                        'jugador_imagen_valor'          => '',
                        'jugador_numero'                => ''
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

    $app->get('/v1/200/competicion/juego/{equipo}/{encuentro}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('encuentro');

        if (isset($val01) && isset($val02)) {
            if ($val01 == 39393) {
                $sql00  = "SELECT
                    a.COMPETICION_ID                                AS          competicion_codigo,
                    a.COMPETICION_PADRE_ID                          AS          competicion_codigo_padre,
                    a.COMPETICION_ESTADO                            AS          competicion_estado,
                    a.COMPETICION_ANHO                              AS          competicion_anho,
                    a.JUEGO_CODIGO                                  AS          juego_codigo,
                    a.JUEGO_NOMBRE                                  AS          juego_fase,
                    a.JUEGO_ESTADO                                  AS          juego_estado,
                    a.JUEGO_HORARIO                                 AS          juego_horario,
                    a.JUEGO_ESTADIO                                 AS          juego_estadio,
                    a.EQUIPO_LOCAL_CODIGO                           AS          equipo_local_codigo,
                    a.EQUIPO_LOCAL_NOMBRE                           AS          equipo_local_nombre,
                    a.EQUIPO_LOCAL_RESULTADO_PRIMER                 AS          equipo_local_resultado_primer,
                    a.EQUIPO_LOCAL_RESULTADO_SEGUNDO                AS          equipo_local_resultado_segundo,
                    a.EQUIPO_VISITANTE_CODIGO                       AS          equipo_visitante_codigo,
                    a.EQUIPO_VISITANTE_NOMBRE                       AS          equipo_visitante_nombre,
                    a.EQUIPO_VISITANTE_RESULTADO_PRIMER             AS          equipo_visitante_resultado_primer,
                    a.EQUIPO_VISITANTE_RESULTADO_SEGUNDO            AS          equipo_visitante_resultado_segundo
                    
                    FROM [view].[juego] a

                    WHERE a.JUEGO_CODIGO = ?

                    ORDER BY a.JUEGO_CODIGO DESC";

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
                    a.JUEGO_ESTADIO                                 AS          juego_estadio,
                    a.EQUIPO_LOCAL_CODIGO                           AS          equipo_local_codigo,
                    a.EQUIPO_LOCAL_NOMBRE                           AS          equipo_local_nombre,
                    a.EQUIPO_LOCAL_RESULTADO_PRIMER                 AS          equipo_local_resultado_primer,
                    a.EQUIPO_LOCAL_RESULTADO_SEGUNDO                AS          equipo_local_resultado_segundo,
                    a.EQUIPO_VISITANTE_CODIGO                       AS          equipo_visitante_codigo,
                    a.EQUIPO_VISITANTE_NOMBRE                       AS          equipo_visitante_nombre,
                    a.EQUIPO_VISITANTE_RESULTADO_PRIMER             AS          equipo_visitante_resultado_primer,
                    a.EQUIPO_VISITANTE_RESULTADO_SEGUNDO            AS          equipo_visitante_resultado_segundo
                    
                    FROM [view].[juego] a
                    
                    WHERE a.JUEGO_CODIGO = ? AND (a.EQUIPO_LOCAL_CODIGO = ? OR a.EQUIPO_VISITANTE_CODIGO = ?)
        
                    ORDER BY a.JUEGO_CODIGO DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val02 == 39393) {
                    $stmtMSSQL->execute([$val02]); 
                } else {
                    $stmtMSSQL->execute([$val02, $val01, $val01]); 
                }

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $juego_horario  = date_format(date_create($rowMSSQL['juego_horario']), 'd/m/Y H:i:s');
                    $juego_cierra   = date("Y-m-d", strtotime($rowMSSQL['juego_horario']."+ 10 days"));

                    $detalle    = array(
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'              => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                    => trim(strtoupper(strtolower($rowMSSQL['competicion_estado']))),
                        'competicion_anho'                      => $rowMSSQL['competicion_anho'],

                        'juego_codigo'                          => $rowMSSQL['juego_codigo'],
                        'juego_fase'                            => trim(strtoupper(strtolower($rowMSSQL['juego_fase']))),
                        'juego_estado'                          => trim(strtoupper(strtolower($rowMSSQL['juego_estado']))),
                        'juego_horario'                         => $juego_horario,
                        'juego_cierra'                          => $juego_cierra,
                        'juego_estadio'                         => trim(strtoupper(strtolower($rowMSSQL['juego_estadio']))),

                        'equipo_local_codigo'                   => $rowMSSQL['equipo_local_codigo'],
                        'equipo_local_nombre'                   => trim(strtoupper(strtolower($rowMSSQL['equipo_local_nombre']))),
                        'equipo_local_resultado_primer'         => $rowMSSQL['equipo_local_resultado_primer'],
                        'equipo_local_resultado_segundo'        => $rowMSSQL['equipo_local_resultado_segundo'],
                        'equipo_local_resultado_final'          => $rowMSSQL['equipo_local_resultado_segundo'],

                        'equipo_visitante_codigo'               => $rowMSSQL['equipo_visitante_codigo'],
                        'equipo_visitante_nombre'               => trim(strtoupper(strtolower($rowMSSQL['equipo_visitante_nombre']))),
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
                        'juego_cierra'                          => '',
                        'juego_estadio'                         => '',

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