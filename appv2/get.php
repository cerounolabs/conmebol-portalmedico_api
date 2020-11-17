<?php
    $app->get('/v2/000', function($request) {
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
            $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/000/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/000/dominio/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/000/auditoria/{dominio}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/100', function($request) {
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
            $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/100/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/100/dominio/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/100/auditoria/{dominio}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/200/disciplina/{equipo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/200/disciplina/{codigo}/{equipo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/200/competicion/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/200/juego/{competicion}/{equipo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/200/juego/{competicion}/{equipo}/{juego}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/200/juegotop4/{competicion}/{equipo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/300', function($request) {
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
            $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/300/equipo/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/300/organizacion/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/400', function($request) {
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
            $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/400/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/400/equipo/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/401/competicion', function($request) {
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
            $connMSSQL  = getConnectionMSSQLv2();
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
                    'competicion_imagen_path'               => 'imagen/competicion/img_'.$rowMSSQL['competicion_codigo'].'.'.$ext,
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

    $app->get('/v2/401/competicion/{equipo}/{persona}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/500', function($request) {
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
            $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/700/{competicion}/{equipo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/{equipo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/{equipo}/{competicion}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/LESIONESTADO/{equipo}/{competicion}/{estado}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/LESIONTIPO/{equipo}/{competicion}/{estado}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/DIAGNOSTICOTIPO/{equipo}/{competicion}/{estado}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/LESIONREINCIDENCIA/{equipo}/{competicion}/{estado}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/LESIONCAUSA/{equipo}/{competicion}/{estado}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/LESIONFALTA/{equipo}/{competicion}/{estado}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/CAMPOPOSICION/{equipo}/{competicion}/{estado}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/CUERPOZONA/{equipo}/{competicion}/{estado}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/600/CUERPOLUGAR/{equipo}/{competicion}/{estado}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->get('/v2/800/covid19/prueba/{equipo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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
    $app->get('/v2/100/equipo/codigo/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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
                        'equipo_estado'                         => trim(strtoupper(strtolower($rowMSSQL['equipo_estado']))),
                        'equipo_nombre'                         => trim(strtoupper(strtolower($rowMSSQL['equipo_nombre']))),
                        'equipo_nombre_corto'                   => trim(strtoupper(strtolower($rowMSSQL['equipo_nombre_corto']))),
                        'equipo_naturaleza'                     => trim(strtoupper(strtolower($rowMSSQL['equipo_naturaleza']))),
                        'equipo_pais'                           => trim(strtoupper(strtolower($rowMSSQL['equipo_pais']))),
                        'equipo_region'                         => trim(strtoupper(strtolower($rowMSSQL['equipo_region']))),
                        'equipo_ciudad'                         => trim(strtoupper(strtolower($rowMSSQL['equipo_ciudad']))),
                        'equipo_postal_codigo'                  => $rowMSSQL['equipo_postal_codigo'],
                        'equipo_ultima_actualizacion'           => $juego_horario,

                        'organizacion_codigo'                   => $rowMSSQL['organizacion_codigo'],
                        'organizacion_nombre'                   => trim(strtoupper(strtolower($rowMSSQL['organizacion_nombre']))),
                        'organizacion_nombre_corto'             => trim(strtoupper(strtolower($rowMSSQL['organizacion_nombre_corto']))),
                        'organizacion_imagen_tipo'              => trim(strtoupper(strtolower($rowMSSQL['organizacion_imagen_tipo']))),
                        'organizacion_image_link'               => trim(strtoupper(strtolower($rowMSSQL['organizacion_image_link']))),
                        'organizacion_imagen_valor'             => '',//$rowMSSQL['organizacion_imagen_valor'],
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

    $app->get('/v2/200/persona', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            a.personFifaId                  AS          persona_codigo,
            a.personType                    AS          persona_tipo,
            a.internationalFirstName        AS          persona_nombre,
            a.internationalLastName         AS          persona_apellido,
            a.gender                        AS          persona_genero,
            a.dateOfBirth                   AS          persona_fecha_nacimiento,
            a.playerPosition                AS          persona_funcion,

            b.DOMFICCOD                     AS          tipo_documento_codigo,
            b.DOMFICNOI                     AS          tipo_documento_nombre_ingles,
            b.DOMFICNOC                     AS          tipo_documento_nombre_castellano,
            b.DOMFICNOP                     AS          tipo_documento_nombre_portugues,
            a.documentNumber                AS          tipo_documento_numero
            
            FROM comet.persons a
            INNER JOIN adm.DOMFIC b ON a.documentType = b.DOMFICCOD
            
            WHERE a.personFifaId < 100001
            
            ORDER BY a.documentNumber";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                if ($rowMSSQL['persona_fecha_nacimiento'] == '1900-01-01' || $rowMSSQL['persona_fecha_nacimiento'] == null){
                    $persona_fecha_nacimiento_1 = '';
                    $persona_fecha_nacimiento_2 = '';
                } else {
                    $persona_fecha_nacimiento_1 = $rowMSSQL['persona_fecha_nacimiento'];
                    $persona_fecha_nacimiento_2 = date('d/m/Y', strtotime($rowMSSQL['persona_fecha_nacimiento']));
                }

                $detalle    = array(
                    'persona_codigo'                        => $rowMSSQL['persona_codigo'],
                    'persona_tipo'                          => strtoupper(strtolower(trim($rowMSSQL['persona_tipo']))),
                    'persona_nombre'                        => strtoupper(strtolower(trim($rowMSSQL['persona_nombre']))),
                    'persona_apellido'                      => strtoupper(strtolower(trim($rowMSSQL['persona_apellido']))),
                    'persona_genero'                        => strtoupper(strtolower(trim($rowMSSQL['persona_genero']))),
                    'persona_fecha_nacimiento_1'            => $persona_fecha_nacimiento_1,
                    'persona_fecha_nacimiento_2'            => $persona_fecha_nacimiento_2,
                    'persona_funcion'                       => strtoupper(strtolower(trim($rowMSSQL['persona_funcion']))),
                    
                    'tipo_documento_codigo'                 => $rowMSSQL['tipo_documento_codigo'],
                    'tipo_documento_nombre_ingles'          => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_nombre_ingles']))),
                    'tipo_documento_nombre_castellano'      => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_nombre_castellano']))),
                    'tipo_documento_nombre_portugues'       => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_nombre_portugues']))),
                    'tipo_documento_numero'                 => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_numero'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'persona_codigo'                        => '',
                    'persona_tipo'                          => '',
                    'persona_nombre'                        => '',
                    'persona_apellido'                      => '',
                    'persona_genero'                        => '',
                    'persona_fecha_nacimiento_1'            => '',
                    'persona_fecha_nacimiento_2'            => '',
                    'persona_funcion'                       => '',
                    
                    'tipo_documento_codigo'                 => '',
                    'tipo_documento_nombre_ingles'          => '',
                    'tipo_documento_nombre_castellano'      => '',
                    'tipo_documento_nombre_portugues'       => '',
                    'tipo_documento_numero'                 => ''
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

       //20201022
    $app->get('/v2/200/persona/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');

        if (isset($val01)) {
            $sql00  = "SELECT
                a.personFifaId                  AS          persona_codigo,
                a.personType                    AS          persona_tipo,
                a.internationalFirstName        AS          persona_nombre,
                a.internationalLastName         AS          persona_apellido,
                a.gender                        AS          persona_genero,
                a.dateOfBirth                   AS          persona_fecha_nacimiento,
                a.playerPosition                AS          persona_funcion,

                b.DOMFICCOD                     AS          tipo_documento_codigo,
                b.DOMFICNOI                     AS          tipo_documento_nombre_ingles,
                b.DOMFICNOC                     AS          tipo_documento_nombre_castellano,
                b.DOMFICNOP                     AS          tipo_documento_nombre_portugues,
                a.documentNumber                AS          tipo_documento_numero
                
                FROM comet.persons a
                INNER JOIN adm.DOMFIC b ON a.documentType = b.DOMFICCOD
                
                WHERE  a.personFifaId = ? 

                ORDER BY a.documentNumber";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]);

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['persona_fecha_nacimiento'] == '1900-01-01' || $rowMSSQL['persona_fecha_nacimiento'] == null){
                        $persona_fecha_nacimiento_1 = '';
                        $persona_fecha_nacimiento_2 = '';
                    } else {
                        $persona_fecha_nacimiento_1 = $rowMSSQL['persona_fecha_nacimiento'];
                        $persona_fecha_nacimiento_2 = date('d/m/Y', strtotime($rowMSSQL['persona_fecha_nacimiento']));
                    }

                    $detalle    = array(
                        'persona_codigo'                        => $rowMSSQL['persona_codigo'],
                        'persona_tipo'                          => strtoupper(strtolower(trim($rowMSSQL['persona_tipo']))),
                        'persona_nombre'                        => strtoupper(strtolower(trim($rowMSSQL['persona_nombre']))),
                        'persona_apellido'                      => strtoupper(strtolower(trim($rowMSSQL['persona_apellido']))),
                        'persona_genero'                        => strtoupper(strtolower(trim($rowMSSQL['persona_genero']))),
                        'persona_fecha_nacimiento_1'            => $persona_fecha_nacimiento_1,
                        'persona_fecha_nacimiento_2'            => $persona_fecha_nacimiento_2,
                        'persona_funcion'                       => strtoupper(strtolower(trim($rowMSSQL['persona_funcion']))),
                        
                        'tipo_documento_codigo'                 => $rowMSSQL['tipo_documento_codigo'],
                        'tipo_documento_nombre_ingles'          => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_nombre_ingles']))),
                        'tipo_documento_nombre_castellano'      => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_nombre_castellano']))),
                        'tipo_documento_nombre_portugues'       => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_nombre_portugues']))),
                        'tipo_documento_numero'                 => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_numero'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'persona_codigo'                        => '',
                        'persona_tipo'                          => '',
                        'persona_nombre'                        => '',
                        'persona_apellido'                      => '',
                        'persona_genero'                        => '',
                        'persona_fecha_nacimiento_1'            => '',
                        'persona_fecha_nacimiento_2'            => '',
                        'persona_funcion'                       => '',
                        
                        'tipo_documento_codigo'                 => '',
                        'tipo_documento_nombre_ingles'          => '',
                        'tipo_documento_nombre_castellano'      => '',
                        'tipo_documento_nombre_portugues'       => '',
                        'tipo_documento_numero'                 => ''
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

    $app->get('/v2/200/competicion/persona/zona1/{competicion}/{tipo}/{encuentro}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('competicion');
        $val02      = $request->getAttribute('tipo');
        $val03      = $request->getAttribute('encuentro');

        $sql00  = "SELECT
            a.personFifaId                      AS          jugador_codigo,
            a.internationalLastName             AS          jugador_apellido,
            a.internationalFirstName            AS          jugador_nombre,
            a.playerPosition                    AS          jugador_posicion,
            a.pictureContentType                AS          jugador_imagen_tipo,
            a.pictureLink                       AS          jugador_imagen_link,
            a.pictureValue                      AS          jugador_imagen_valor,

            b.DOMFICCOD                         AS          tipo_documento_codigo,
            b.DOMFICNOI                         AS          tipo_documento_nombre_ingles,
            b.DOMFICNOC                         AS          tipo_documento_nombre_castellano,
            b.DOMFICNOP                         AS          tipo_documento_nombre_portugues,
            a.documentNumber                    AS          tipo_documento_numero

            FROM comet.persons a
            INNER JOIN adm.DOMFIC b ON a.documentType = b.DOMFICCOD

            WHERE a.personFifaId < 100001 AND
            NOT EXISTS (SELECT * FROM exa.EXAFIC a1 WHERE a1.EXAFICPEC = a.personFifaId AND a1.EXAFICTEC = ? AND a1.EXAFICENC = ?)

            ORDER BY a.personFifaId";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute([$val02, $val03]);

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'competicion_codigo'                    => $val01,
                    'jugador_codigo'                        => $rowMSSQL['jugador_codigo'],
                    'jugador_completo'                      => strtoupper(strtolower(trim($rowMSSQL['jugador_nombre']))).' '.strtoupper(strtolower(trim($rowMSSQL['jugador_apellido']))),
                    'jugador_apellido'                      => strtoupper(strtolower(trim($rowMSSQL['jugador_apellido']))),
                    'jugador_nombre'                        => strtoupper(strtolower(trim($rowMSSQL['jugador_nombre']))),
                    'jugador_posicion'                      => strtoupper(strtolower(trim($rowMSSQL['jugador_posicion']))),
                    'jugador_imagen_tipo'                   => strtoupper(strtolower(trim($rowMSSQL['jugador_imagen_tipo']))),
                    'jugador_imagen_link'                   => strtoupper(strtolower(trim($rowMSSQL['jugador_imagen_link']))),
                    'jugador_imagen_valor'                  => strtoupper(strtolower(trim($rowMSSQL['jugador_imagen_valor']))),
                    
                    'tipo_documento_codigo'                 => $rowMSSQL['tipo_documento_codigo'],
                    'tipo_documento_nombre_ingles'          => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_nombre_ingles']))),
                    'tipo_documento_nombre_castellano'      => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_nombre_castellano']))),
                    'tipo_documento_nombre_portugues'       => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_nombre_portugues']))),
                    'tipo_documento_numero'                 => strtoupper(strtolower(trim($rowMSSQL['tipo_documento_numero'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'competicion_codigo'                    => '',
                    'jugador_codigo'                        => '',
                    'jugador_completo'                      => '',
                    'jugador_apellido'                      => '',
                    'jugador_nombre'                        => '',
                    'jugador_posicion'                      => '',
                    'jugador_imagen_tipo'                   => '',
                    'jugador_imagen_link'                   => '',
                    'jugador_imagen_valor'                  => '',
                    
                    'tipo_documento_codigo'                 => '',
                    'tipo_documento_nombre_ingles'          => '',
                    'tipo_documento_nombre_castellano'      => '',
                    'tipo_documento_nombre_portugues'       => '',
                    'tipo_documento_numero'                 => ''
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

    $app->get('/v2/200/competicion/listado/cabecera', function($request) {
        require __DIR__.'/../src/connect.php';

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

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute();

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

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/200/competicion/medico/{equipo}/{persona}', function($request) {//20201117
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('equipo');
        $val02  = $request->getAttribute('persona');
        
        if (isset($val01) && isset($val02)) {
            if ($val01 == 39393) {
                $sql00  = "SELECT 
                    a.PERCOMOBS                         AS          competicion_persona_observacion,
                    a.PERCOMRTS                         AS          competicion_persona_RTS,

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

                    WHERE b.PERFICCOD = ?
                    
                    ORDER BY a.PERCOMTMC, a.PERCOMCOC, a.PERCOMPEC";
            } else {
                $sql00  = "SELECT 
                    a.PERCOMOBS                         AS          competicion_persona_observacion,
                    a.PERCOMRTS                         AS          competicion_persona_RTS,
                    
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
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                
                if ($val01 == 39393) {
                    $stmtMSSQL->execute([$val02]);
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
                        'competicion_persona_observacion'       => trim($rowMSSQL['competicion_persona_observacion']),
                        'competicion_persona_RTS'               => trim($rowMSSQL['competicion_persona_RTS']),

                        'auditoria_usuario'                     => $rowMSSQL['auditoria_usuario'],
                        'auditoria_fecha_hora'                  => $auditoria_fecha_hora,
                        'auditoria_ip'                          => $rowMSSQL['auditoria_ip'],

                        'persona_codigo'                        => $rowMSSQL['persona_codigo'],
                        'persona_nombre'                        => trim(strtoupper(strtolower($rowMSSQL['persona_nombre']))),
                        'persona_user'                          => trim(strtoupper(strtolower($rowMSSQL['persona_user']))),
                        'persona_path'                          => trim($persona_path),
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
                        'competicion_tipo'                      => trim(strtoupper(strtolower($rowMSSQL['competicion_tipo']))),
                        'competicion_imagen_tipo'               => trim(strtoupper(strtolower($rowMSSQL['competicion_imagen_tipo']))),
                        'competicion_imagen_path'               => 'imagen/competicion/img_'.$rowMSSQL['competicion_codigo'].'.'.$ext,
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
                        'competicion_persona_RTS'               =>'' ,

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

    $app->get('/v2/200/competicion/equipo/participante/{competicion}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('competicion');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.competitionFifaId                 AS          competicion_codigo,
                
                b.teamFifaId                        AS          equipo_codigo,
                b.status                            AS          equipo_estado,
                b.internationalName                 AS          equipo_nombre,
                b.internationalShortName            AS          equipo_nombre_corto,
                b.organisationNature                AS          equipo_naturaleza,
                b.country                           AS          equipo_pais,
                b.region                            AS          equipo_region,
                b.town                              AS          equipo_ciudad,
                b.postalCode                        AS          equipo_postal_codigo,
                b.lastUpdate                        AS          equipo_ultima_actualizacion,

                c.organisationFifaId                AS          organizacion_codigo,
                c.organisationName                  AS          organizacion_nombre,
                c.organisationShortName             AS          organizacion_nombre_corto,
                c.pictureContentType                AS          organizacion_imagen_tipo,
                c.pictureLink                       AS          organizacion_image_link,
                c.pictureValue                      AS          organizacion_imagen_valor
                
                FROM [comet].[competitions_teams] a
                LEFT OUTER JOIN [comet].[teams] b ON a.teamFifaId = b.teamFifaId
                LEFT OUTER JOIN [comet].[organisations] c ON b.organisationFifaId = c.organisationFifaId

                WHERE a.competitionFifaId = ?

                ORDER BY a.competitionFifaId";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
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
                        'competicion_codigo'                    => $rowMSSQL['competicion_codigo'],

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
                        'organizacion_imagen_valor'             => '',//$rowMSSQL['organizacion_imagen_valor'],
                        'organizacion_imagen_path'              => 'imagen/organizacion/img_'.$rowMSSQL['organizacion_codigo'].'.'.$ext
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'competicion_codigo'                    => '',
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

    $app->get('/v2/200/competicion/equipo/{equipo}/{competicion}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        
        if (isset($val01) && isset($val02)) {
            if ($val01 == 39393) {
                $sql00  = "SELECT
                    a.competitionFifaId                 AS          competicion_codigo,
                    
                    c.personFifaId                      AS          jugador_codigo,
                    c.internationalLastName             AS          jugador_apellido,
                    c.internationalFirstName            AS          jugador_nombre,
                    b.roleDescription                   AS          jugador_posicion,
                    c.pictureContentType                AS          jugador_imagen_tipo,
                    c.pictureLink                       AS          jugador_imagen_link,
                    c.pictureValue                      AS          jugador_imagen_valor
                    
                    FROM [comet].[matches] a
                    LEFT OUTER JOIN [comet].[matches_officials] b ON a.matchFifaId = b.matchFifaId
                    LEFT OUTER JOIN [comet].[persons] c ON b.personFifaId = c.personFifaId
                    
                    ORDER BY c.personFifaId";
            } else {
                $sql00  = "SELECT
                    a.competitionFifaId                 AS          competicion_codigo,
                    
                    b.personFifaId                      AS          jugador_codigo,
                    b.internationalLastName             AS          jugador_apellido,
                    b.internationalFirstName            AS          jugador_nombre,
                    b.playerPosition                    AS          jugador_posicion,
                    b.role                              AS          jugador_rol_1,
                    b.cometRoleName                     AS          jugador_rol_2,
                    b.cometRoleNameKey                  AS          jugador_rol_3,
                    b.pictureContentType                AS          jugador_imagen_tipo,
                    b.pictureLink                       AS          jugador_imagen_link,
                    b.pictureValue                      AS          jugador_imagen_valor,
                    a.playerType                        AS          jugador_tipo,
                    a.shirtNumber                       AS          jugador_numero
                    
                    FROM [comet].[competitions_teams_players] a
                    INNER JOIN [comet].[persons] b ON a.playerFifaId = b.personFifaId
                    
                    WHERE a.teamFifaId = ? AND a.competitionFifaId = ?

                    ORDER BY b.playerPosition, a.shirtNumber";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
                    $stmtMSSQL->execute();

                    while ($rowMSSQL = $stmtMSSQL->fetch()) {
                        $jugador_posicion = trim(strtoupper(strtolower($rowMSSQL['jugador_posicion'])));
                        $jugador_posicion = str_replace('LABEL', '', $jugador_posicion);
                        $jugador_posicion = str_replace('.', ' ', $jugador_posicion);
                        $jugador_posicion = str_replace('REFEREEOBSERVER', 'REFEREE OBSERVER', $jugador_posicion);
                        $jugador_posicion = str_replace('FIELDDOCTOR', 'FIELD DOCTOR', $jugador_posicion);
                        $jugador_posicion = str_replace('MATCHCOORDINATOR', 'MATCH COORDINATOR', $jugador_posicion);

                        $detalle    = array(
                            'competicion_codigo'            => $rowMSSQL['competicion_codigo'],
                            'jugador_codigo'                => $rowMSSQL['jugador_codigo'],
                            'jugador_apellido'              => trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))),
                            'jugador_nombre'                => trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))),
                            'jugador_completo'              => trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))).', '.trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))),
                            'jugador_posicion'              => $jugador_posicion,
                            'jugador_imagen_tipo'           => trim(strtolower($rowMSSQL['jugador_imagen_tipo'])),
                            'jugador_imagen_link'           => trim($rowMSSQL['jugador_imagen_link']),
                            'jugador_rol_1'                 => '',
                            'jugador_rol_2'                 => '',
                            'jugador_rol_3'                 => '',
                            'jugador_imagen_valor'          => '',
                            'jugador_tipo'                  => '',
                            'jugador_numero'                => ''
                        );
    
                        $result[]   = $detalle;
                    }
                } else {
                    $stmtMSSQL->execute([$val01, $val02]);

                    while ($rowMSSQL = $stmtMSSQL->fetch()) {
                        $detalle    = array(
                            'competicion_codigo'            => $rowMSSQL['competicion_codigo'],
                            'jugador_codigo'                => $rowMSSQL['jugador_codigo'],
                            'jugador_apellido'              => trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))),
                            'jugador_nombre'                => trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))),
                            'jugador_completo'              => trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))).', '.trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))),
                            'jugador_posicion'              => trim(strtoupper(strtolower($rowMSSQL['jugador_posicion']))),
                            'jugador_rol_1'                 => trim(strtoupper(strtolower($rowMSSQL['jugador_rol_1']))),
                            'jugador_rol_2'                 => trim(strtoupper(strtolower($rowMSSQL['jugador_rol_2']))),
                            'jugador_rol_3'                 => trim(strtoupper(strtolower($rowMSSQL['jugador_rol_3']))),
                            'jugador_imagen_tipo'           => trim(strtolower($rowMSSQL['jugador_imagen_tipo'])),
                            'jugador_imagen_link'           => trim($rowMSSQL['jugador_imagen_link']),
                            'jugador_imagen_valor'          => '',
                            'jugador_tipo'                  => trim(strtoupper(strtolower($rowMSSQL['jugador_tipo']))),
                            'jugador_numero'                => $rowMSSQL['jugador_numero']
                        );
    
                        $result[]   = $detalle;
                    }
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
                        'jugador_rol_1'                 => '',
                        'jugador_rol_2'                 => '',
                        'jugador_rol_3'                 => '',
                        'jugador_imagen_tipo'           => '',
                        'jugador_imagen_link'           => '',
                        'jugador_imagen_valor'          => '',
                        'jugador_tipo'                  => '',
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

    $app->get('/v2/200/competicion/equipo/alta/{equipo}/{competicion}/{tipo}/{encuentro}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('tipo');
        $val04      = $request->getAttribute('encuentro');
        
        if (isset($val01) && isset($val02)) {
            if ($val01 == 39393) {
                if ($val04 == 0) {
                    $sql00  = "SELECT
                        a.competitionFifaId                 AS          competicion_codigo,
                        d.personFifaId                      AS          jugador_codigo,
                        d.internationalLastName             AS          jugador_apellido,
                        d.internationalFirstName            AS          jugador_nombre,
                        c.roleDescription                   AS          jugador_posicion,
                        d.pictureContentType                AS          jugador_imagen_tipo,
                        d.pictureLink                       AS          jugador_imagen_link,
                        d.pictureValue                      AS          jugador_imagen_valor

                        FROM [comet].[competitions] a
                        LEFT OUTER JOIN [comet].[matches] b ON a.competitionFifaId = b.competitionFifaId
                        LEFT OUTER JOIN [comet].[matches_officials] c ON b.matchFifaId = c.matchFifaId
                        LEFT OUTER JOIN [comet].[persons] d ON c.personFifaId = d.personFifaId

                        WHERE a.superiorCompetitionFifaId = ? AND d.personFifaId IS NOT NULL AND NOT EXISTS (SELECT * FROM exa.EXAFIC a1 WHERE a1.EXAFICPEC = c.personFifaId AND a1.EXAFICTEC = ? AND a1.EXAFICENC = ?)

                        ORDER BY d.personFifaId";

                    $sql00  = "SELECT
                        a.competitionFifaId                 AS          competicion_codigo,
                        d.personFifaId                      AS          jugador_codigo,
                        d.internationalLastName             AS          jugador_apellido,
                        d.internationalFirstName            AS          jugador_nombre,
                        c.roleDescription                   AS          jugador_posicion,
                        d.pictureContentType                AS          jugador_imagen_tipo,
                        d.pictureLink                       AS          jugador_imagen_link,
                        d.pictureValue                      AS          jugador_imagen_valor

                        FROM [comet].[competitions] a
                        LEFT OUTER JOIN [comet].[matches] b ON a.competitionFifaId = b.competitionFifaId
                        LEFT OUTER JOIN [comet].[matches_officials] c ON b.matchFifaId = c.matchFifaId
                        LEFT OUTER JOIN [comet].[persons] d ON c.personFifaId = d.personFifaId

                        WHERE a.superiorCompetitionFifaId = ? AND d.personFifaId IS NOT NULL

                        ORDER BY d.personFifaId";
                        
                } else {
                    $val02  = $val04;
                    $sql00  = "SELECT
                        a.competitionFifaId                 AS          competicion_codigo,
                        
                        c.personFifaId                      AS          jugador_codigo,
                        c.internationalLastName             AS          jugador_apellido,
                        c.internationalFirstName            AS          jugador_nombre,
                        b.roleDescription                   AS          jugador_posicion,
                        c.pictureContentType                AS          jugador_imagen_tipo,
                        c.pictureLink                       AS          jugador_imagen_link,
                        c.pictureValue                      AS          jugador_imagen_valor
                        
                        FROM [comet].[matches] a
                        LEFT OUTER JOIN [comet].[matches_officials] b ON a.matchFifaId = b.matchFifaId
                        LEFT OUTER JOIN [comet].[persons] c ON b.personFifaId = c.personFifaId
                        
                        WHERE a.matchFifaId = ? AND NOT EXISTS (SELECT * FROM exa.EXAFIC c WHERE c.EXAFICPEC = b.personFifaId AND c.EXAFICTEC = ? AND c.EXAFICENC = ?)

                        ORDER BY c.personFifaId";
                }
            } else {
                $sql00  = "SELECT
                    a.competitionFifaId                 AS          competicion_codigo,
                    
                    b.personFifaId                      AS          jugador_codigo,
                    b.internationalLastName             AS          jugador_apellido,
                    b.internationalFirstName            AS          jugador_nombre,
                    b.playerPosition                    AS          jugador_posicion,
                    b.role                              AS          jugador_rol_1,
                    b.cometRoleName                     AS          jugador_rol_2,
                    b.cometRoleNameKey                  AS          jugador_rol_3,
                    b.pictureContentType                AS          jugador_imagen_tipo,
                    b.pictureLink                       AS          jugador_imagen_link,
                    b.pictureValue                      AS          jugador_imagen_valor,
                    a.playerType                        AS          jugador_tipo,
                    a.shirtNumber                       AS          jugador_numero
                    
                    FROM [comet].[competitions_teams_players] a
                    INNER JOIN [comet].[persons] b ON a.playerFifaId = b.personFifaId
                    
                    WHERE a.teamFifaId = ? AND a.competitionFifaId = ? AND NOT EXISTS (SELECT * FROM exa.EXAFIC c WHERE c.EXAFICPEC = a.playerFifaId AND c.EXAFICTEC = ? AND c.EXAFICENC = ?)

                    ORDER BY b.playerPosition, a.shirtNumber";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
                    $stmtMSSQL->execute([$val02, $val03, $val04]);
                    $jugador_codigo = 0;

                    while ($rowMSSQL = $stmtMSSQL->fetch()) {
                        if ($jugador_codigo != $rowMSSQL['jugador_codigo']) {
                            $jugador_posicion   = trim(strtoupper(strtolower($rowMSSQL['jugador_posicion'])));
                            $jugador_posicion   = str_replace('LABEL', '', $jugador_posicion);
                            $jugador_posicion   = str_replace('.', ' ', $jugador_posicion);
                            $jugador_posicion   = str_replace('REFEREEOBSERVER', 'REFEREE OBSERVER', $jugador_posicion);
                            $jugador_posicion   = str_replace('FIELDDOCTOR', 'FIELD DOCTOR', $jugador_posicion);
                            $jugador_posicion   = str_replace('MATCHCOORDINATOR', 'MATCH COORDINATOR', $jugador_posicion);

                            $detalle    = array(
                                'competicion_codigo'            => $rowMSSQL['competicion_codigo'],

                                'jugador_codigo'                => $rowMSSQL['jugador_codigo'],
                                'jugador_apellido'              => trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))),
                                'jugador_nombre'                => trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))),
                                'jugador_completo'              => trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))).', '.trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))),
                                'jugador_posicion'              => $jugador_posicion,
                                'jugador_imagen_tipo'           => trim(strtolower($rowMSSQL['jugador_imagen_tipo'])),
                                'jugador_imagen_link'           => trim($rowMSSQL['jugador_imagen_link']),
                                'jugador_rol_1'                 => '',
                                'jugador_rol_2'                 => '',
                                'jugador_rol_3'                 => '',
                                'jugador_imagen_valor'          => '',
                                'jugador_tipo'                  => '',
                                'jugador_numero'                => ''
                            );
        
                            $result[]       = $detalle;
                            $jugador_codigo = $rowMSSQL['jugador_codigo'];
                        }
                    }
                } else {
                    $stmtMSSQL->execute([$val01, $val02, $val03, $val04]);

                    while ($rowMSSQL = $stmtMSSQL->fetch()) {
                        $detalle    = array(
                            'competicion_codigo'            => $rowMSSQL['competicion_codigo'],

                            'jugador_codigo'                => $rowMSSQL['jugador_codigo'],
                            'jugador_apellido'              => trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))),
                            'jugador_nombre'                => trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))),
                            'jugador_completo'              => trim(strtoupper(strtolower($rowMSSQL['jugador_apellido']))).', '.trim(strtoupper(strtolower($rowMSSQL['jugador_nombre']))),
                            'jugador_posicion'              => trim(strtoupper(strtolower($rowMSSQL['jugador_posicion']))),
                            'jugador_rol_1'                 => trim(strtoupper(strtolower($rowMSSQL['jugador_rol_1']))),
                            'jugador_rol_2'                 => trim(strtoupper(strtolower($rowMSSQL['jugador_rol_2']))),
                            'jugador_rol_3'                 => trim(strtoupper(strtolower($rowMSSQL['jugador_rol_3']))),
                            'jugador_imagen_tipo'           => trim(strtolower($rowMSSQL['jugador_imagen_tipo'])),
                            'jugador_imagen_link'           => trim($rowMSSQL['jugador_imagen_link']),
                            'jugador_imagen_valor'          => '',
                            'jugador_tipo'                  => trim(strtoupper(strtolower($rowMSSQL['jugador_tipo']))),
                            'jugador_numero'                => $rowMSSQL['jugador_numero']
                        );
    
                        $result[]   = $detalle;
                    }
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
                        'jugador_rol_1'                 => '',
                        'jugador_rol_2'                 => '',
                        'jugador_rol_3'                 => '',
                        'jugador_imagen_tipo'           => '',
                        'jugador_imagen_link'           => '',
                        'jugador_imagen_valor'          => '',
                        'jugador_tipo'                  => '',
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

    $app->get('/v2/200/competicion/home/ultimoencuentro/{equipo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('equipo');

        if (isset($val00)) {
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
                
                
                WHERE (a.EQUIPO_LOCAL_CODIGO = ? OR a.EQUIPO_VISITANTE_CODIGO = ?) AND a.JUEGO_NOMBRE IS NOT NULL
                
                ORDER BY a.JUEGO_CODIGO DESC";
           

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                    $stmtMSSQL->execute([$val00, $val00]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['juego_horario'] == '1900-01-01' || $rowMSSQL['juego_horario'] == null){
                        $juego_horario  = '';
                        $juego_cierra   = '';
                    } else {
                        $juego_horario  = date_format(date_create($rowMSSQL['juego_horario']), 'd/m/Y H:i:s');
                        $juego_cierra   = date("Y-m-d", strtotime($rowMSSQL['juego_horario']."+ 10 days"));
                    }

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
    $app->get('/v2/200/competicion/home/resultado/{equipo}', function($request) {//20201109
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('equipo');

        if (isset($val00)) {
                $sql00  = "SELECT 
                a.EXAFICENC AS encuentro_codigo,
                d.EQUIPO_LOCAL_CODIGO AS encuentro_equipo_local_codigo,
                d.EQUIPO_VISITANTE_CODIGO AS encuentro_equipo_visitante_codigo,
                d.EQUIPO_LOCAL_NOMBRE AS encuentro_equipo_local_nombre,
                d.EQUIPO_VISITANTE_NOMBRE AS encuentro_equipo_visitante_nombre,
                d.JUEGO_HORARIO AS encuentro_fecha,
                (SELECT COUNT(e1.EXAFICCOD)FROM exa.EXAFIC e1 WHERE e1.EXAFICENC = a.EXAFICENC AND e1.EXAFICEQC = a.EXAFICEQC AND e1.EXAFICTEC = b.DOMFICCOD AND e1.EXAFICEST = c.DOMFICCOD AND e1.EXAFICLRE = 'SI') AS encuentro_cantidad_positivo,
                (SELECT COUNT(e1.EXAFICCOD)FROM exa.EXAFIC e1 WHERE e1.EXAFICENC = a.EXAFICENC AND e1.EXAFICEQC = a.EXAFICEQC AND e1.EXAFICTEC = b.DOMFICCOD AND e1.EXAFICEST = c.DOMFICCOD AND e1.EXAFICLRE = 'NO') AS encuentro_cantidad_negativo
                
                FROM exa.EXAFIC a
                
                INNER JOIN adm.DOMFIC b ON a.EXAFICTEC = b.DOMFICCOD
                INNER JOIN adm.DOMFIC c ON a.EXAFICEST = c.DOMFICCOD
                INNER JOIN [view].juego d ON a.EXAFICENC = d.JUEGO_CODIGO AND (a.EXAFICEQC = d.EQUIPO_LOCAL_CODIGO OR a.EXAFICEQC = d.EQUIPO_VISITANTE_CODIGO) 
                
                WHERE a.EXAFICEQC = ? AND b.DOMFICVAL = 'EXAMENMEDICOTIPO' AND b.DOMFICPAR = 1 AND c.DOMFICVAL = 'EXAMENMEDICOCOVID19ESTADO' AND c.DOMFICPAR = 1 and a.EXAFICLRE IS NOT NULL
                GROUP BY a.EXAFICENC, d.EQUIPO_LOCAL_CODIGO, d.EQUIPO_VISITANTE_CODIGO,d.EQUIPO_LOCAL_NOMBRE, d.EQUIPO_VISITANTE_NOMBRE, a.EXAFICEQC, b.DOMFICCOD, c.DOMFICCOD, d.JUEGO_HORARIO";
           

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                $stmtMSSQL->execute([$val00]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['encuentro_fecha'] == '1900-01-01' || $rowMSSQL['encuentro_fecha'] == null){
                        $encuentro_fecha_1 = '';
                        $encuentro_fecha_2 = '';
                    } else {
                        $encuentro_fecha_1 = $rowMSSQL['encuentro_fecha'];
                        $encuentro_fecha_2 = date('d/m/Y', strtotime($rowMSSQL['encuentro_fecha']));
                    }

                    $aux = 'vs';
                    if ($rowMSSQL['encuentro_equipo_local_codigo'] != $val00){
                        $nomEquipo =  $aux.' '.$rowMSSQL['encuentro_equipo_local_nombre'];
                    } else {
                        $nomEquipo =  $aux.' '.$rowMSSQL['encuentro_equipo_visitante_nombre'];
                    }

                    $detalle    = array(
                        'encuentro_codigo'                    => $rowMSSQL['encuentro_codigo'],
                        'encuentro_equipo'                    =>trim(strtoupper(strtolower($nomEquipo))),

                        'encuentro_fecha_1'                   => $encuentro_fecha_1,
                        'encuentro_fecha_2'                   => $encuentro_fecha_2,
                        'encuentro_cantidad_positivo'         => $rowMSSQL['encuentro_cantidad_positivo'],
                        'encuentro_cantidad_negativo'         => $rowMSSQL['encuentro_cantidad_negativo']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'encuentro_codigo'                    => '',
                        'encuentro_equipo'                    => '',
                        'encuentro_cantidad_positivo'         => '',
                        'encuentro_cantidad_negativo'         => ''
                       
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


    $app->get('/v2/200/competicion/encuentro/{equipo}/{competicion}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                if ($val01 == 39393) {
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

    $app->get('/v2/200/competicion/juego/{equipo}/{encuentro}', function($request) {
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
                    a.JUEGO_CIUDAD                                 AS           juego_ciudad,
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
                    a.JUEGO_CIUDAD                                 AS           juego_ciudad,
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
                $connMSSQL  = getConnectionMSSQLv2();
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
                        'juego_ciudad'                          => trim(strtoupper(strtolower($rowMSSQL['juego_ciudad']))),

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
                        'juego_ciudad'                          => '',

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

    $app->get('/v2/400/medico/usuario', function($request) {
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
            $connMSSQL  = getConnectionMSSQLv2();
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
                    'persona_nombre'                        => trim(strtoupper(strtolower($rowMSSQL['persona_nombre']))),
                    'persona_user'                          => trim(strtoupper(strtolower($rowMSSQL['persona_user']))),
                    'persona_contrasenha'                   => trim(strtoupper(strtolower($rowMSSQL['persona_contrasenha']))),
                    'persona_path'                          => $persona_path,
                    'persona_email'                         => trim(strtoupper(strtolower($rowMSSQL['persona_email']))),
                    'persona_telefono'                      => trim(strtoupper(strtolower($rowMSSQL['persona_telefono']))),
                    'persona_observacion'                   => trim(strtoupper(strtolower($rowMSSQL['persona_observacion']))),
                    'persona_usuario'                       => trim(strtoupper(strtolower($rowMSSQL['persona_usuario']))),
                    'persona_fecha_hora'                    => $persona_fecha_hora,
                    'persona_ip'                            => trim(strtoupper(strtolower($rowMSSQL['persona_ip']))),

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
                    'tipo_categoria_nombre_portugues'       => trim(strtoupper(strtolower($rowMSSQL['tipo_categoria_nombre_portugues'])))
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

    $app->get('/v2/400/medico/competicion', function($request) {
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
            $connMSSQL  = getConnectionMSSQLv2();
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
                    'competicion_persona_observacion'       => trim(strtoupper(strtolower($rowMSSQL['competicion_persona_observacion']))),
                    'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL['auditoria_usuario']))),
                    'auditoria_fecha_hora'                  => $auditoria_fecha_hora,
                    'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL['auditoria_ip']))),

                    'persona_codigo'                        => $rowMSSQL['persona_codigo'],
                    'persona_nombre'                        => trim(strtoupper(strtolower($rowMSSQL['persona_nombre']))),
                    'persona_user'                          => trim(strtoupper(strtolower($rowMSSQL['persona_user']))),
                    'persona_path'                          => $persona_path,
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

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/801/examen/prueba/{equipo}/{encuentro}', function($request) {
        require __DIR__.'/../src/connect.php';
 
        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('encuentro');

        if (isset($val01)) {
            if ($val01 == 39393) {
                $val01  = $val02;
                $sql00  = "SELECT
                    a.EXAFICCOD                         AS          examen_codigo,
                    a.EXAFICFE1                         AS          examen_fecha_1,
                    a.EXAFICFE2                         AS          examen_fecha_2,
                    a.EXAFICFE3                         AS          examen_fecha_3,
                    a.EXAFICACA                         AS          examen_cantidad_adulto,
                    a.EXAFICMCA                         AS          examen_cantidad_menor,
                    a.EXAFICJCO                         AS          examen_persona_convocado,
                    a.EXAFICJPO                         AS          examen_persona_posicion,
                    a.EXAFICJCA                         AS          examen_persona_camiseta,
                    a.EXAFICLNO                         AS          examen_laboratorio_nombre,
                    a.EXAFICLFE                         AS          examen_laboratorio_fecha_envio,
                    a.EXAFICLFR                         AS          examen_laboratorio_fecha_recepcion,
                    a.EXAFICLFA                         AS          examen_laboratorio_fecha_aislamiento,
                    a.EXAFICLFF                         AS          examen_laboratorio_fecha_finaliza,
                    a.EXAFICLRE                         AS          examen_laboratorio_resultado,
                    a.EXAFICLIC                         AS          examen_laboratorio_cuarentena,
                    a.EXAFICLNT                         AS          examen_laboratorio_test,
                    a.EXAFICLAD                         AS          examen_laboratorio_adjunto,
                    a.EXAFICLOB                         AS          examen_laboratorio_observacion,
                    a.EXAFICBAN                         AS          examen_bandera,
                    a.EXAFICOBS                         AS          examen_observacion,
                    
                    a.EXAFICAUS                         AS          auditoria_usuario,
                    a.EXAFICAFH                         AS          auditoria_fecha_hora,
                    a.EXAFICAIP                         AS          auditoria_ip,

                    b.DOMFICCOD                         AS          tipo_estado_codigo,
                    b.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
                    b.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
                    b.DOMFICNOP                         AS          tipo_estado_nombre_portugues,

                    c.DOMFICCOD                         AS          tipo_examen_codigo,
                    c.DOMFICNOI                         AS          tipo_examen_nombre_ingles,
                    c.DOMFICNOC                         AS          tipo_examen_nombre_castellano,
                    c.DOMFICNOP                         AS          tipo_examen_nombre_portugues,

                    d.competitionFifaId                 AS          competicion_codigo,
                    d.superiorCompetitionFifaId         AS          competicion_codigo_padre,
                    d.status                            AS          competicion_estado,
                    d.internationalName                 AS          competicion_nombre,
                    d.internationalShortName            AS          competicion_nombre_corto,
                    d.season                            AS          competicion_anho,

                    e.JUEGO_CODIGO                      AS          encuentro_codigo,
                    e.EQUIPO_LOCAL_CODIGO               AS          encuentro_local_codigo,
                    e.EQUIPO_LOCAL_NOMBRE               AS          encuentro_local_equipo,
                    e.EQUIPO_VISITANTE_CODIGO           AS          encuentro_visitante_codigo,
                    e.EQUIPO_VISITANTE_NOMBRE           AS          encuentro_visitante_equipo,

                    f.teamFifaId                        AS          equipo_codigo,
                    f.internationalName                 AS          equipo_nombre,

                    g.personFifaId                      AS          persona_codigo,
                    g.internationalFirstName            AS          persona_nombre,
                    g.internationalLastName             AS          persona_apellido,

                    h.EXAFICCOD                         AS          examen_anterior_codigo,
                    h.EXAFICFE1                         AS          examen_anterior_fecha_1,
                    h.EXAFICFE2                         AS          examen_anterior_fecha_2,
                    h.EXAFICFE3                         AS          examen_anterior_fecha_3,
                    h.EXAFICACA                         AS          examen_anterior_cantidad_adulto,
                    h.EXAFICMCA                         AS          examen_anterior_cantidad_menor,
                    h.EXAFICJCO                         AS          examen_anterior_persona_convocado,
                    h.EXAFICJPO                         AS          examen_anterior_persona_posicion,
                    h.EXAFICJCA                         AS          examen_anterior_persona_camiseta,
                    h.EXAFICLNO                         AS          examen_anterior_laboratorio_nombre,
                    h.EXAFICLFE                         AS          examen_anterior_laboratorio_fecha_envio,
                    h.EXAFICLFR                         AS          examen_anterior_laboratorio_fecha_recepcion,
                    h.EXAFICLFA                         AS          examen_anterior_laboratorio_fecha_aislamiento,
                    h.EXAFICLRE                         AS          examen_anterior_laboratorio_resultado,
                    h.EXAFICLIC                         AS          examen_anterior_laboratorio_cuarentena,
                    h.EXAFICLNT                         AS          examen_anterior_laboratorio_test,
                    h.EXAFICLAD                         AS          examen_anterior_laboratorio_adjunto,
                    h.EXAFICLOB                         AS          examen_anterior_laboratorio_observacion,
                    h.EXAFICOBS                         AS          examen_anterior_observacion

                    FROM [exa].[EXAFIC] a
                    LEFT OUTER JOIN [adm].[DOMFIC] b ON a.EXAFICEST = b.DOMFICCOD
                    LEFT OUTER JOIN [adm].[DOMFIC] c ON a.EXAFICTEC = c.DOMFICCOD
                    LEFT OUTER JOIN [comet].[competitions] d ON a.EXAFICCOC = d.competitionFifaId
                    LEFT OUTER JOIN [view].[juego] e ON a.EXAFICENC = e.JUEGO_CODIGO
                    LEFT OUTER JOIN [comet].[teams] f ON a.EXAFICEQC = f.teamFifaId
                    LEFT OUTER JOIN [comet].[persons] g ON a.EXAFICPEC = g.personFifaId
                    LEFT OUTER JOIN [exa].[EXAFIC] h ON a.EXAFICAEC = h.EXAFICCOD

                    WHERE a.EXAFICENC = ? AND a.EXAFICENC = ?

                    ORDER BY a.EXAFICENC ASC, a.EXAFICPEC ASC";
            } else {
                $sql00  = "SELECT
                    a.EXAFICCOD                         AS          examen_codigo,
                    a.EXAFICFE1                         AS          examen_fecha_1,
                    a.EXAFICFE2                         AS          examen_fecha_2,
                    a.EXAFICFE3                         AS          examen_fecha_3,
                    a.EXAFICACA                         AS          examen_cantidad_adulto,
                    a.EXAFICMCA                         AS          examen_cantidad_menor,
                    a.EXAFICJCO                         AS          examen_persona_convocado,
                    a.EXAFICJPO                         AS          examen_persona_posicion,
                    a.EXAFICJCA                         AS          examen_persona_camiseta,
                    a.EXAFICLNO                         AS          examen_laboratorio_nombre,
                    a.EXAFICLFE                         AS          examen_laboratorio_fecha_envio,
                    a.EXAFICLFR                         AS          examen_laboratorio_fecha_recepcion,
                    a.EXAFICLFA                         AS          examen_laboratorio_fecha_aislamiento,
                    a.EXAFICLFF                         AS          examen_laboratorio_fecha_finaliza,
                    a.EXAFICLRE                         AS          examen_laboratorio_resultado,
                    a.EXAFICLIC                         AS          examen_laboratorio_cuarentena,
                    a.EXAFICLNT                         AS          examen_laboratorio_test,
                    a.EXAFICLAD                         AS          examen_laboratorio_adjunto,
                    a.EXAFICLOB                         AS          examen_laboratorio_observacion,
                    a.EXAFICBAN                         AS          examen_bandera,
                    a.EXAFICOBS                         AS          examen_observacion,
                    
                    a.EXAFICAUS                         AS          auditoria_usuario,
                    a.EXAFICAFH                         AS          auditoria_fecha_hora,
                    a.EXAFICAIP                         AS          auditoria_ip,

                    b.DOMFICCOD                         AS          tipo_estado_codigo,
                    b.DOMFICNOI                         AS          tipo_estado_nombre_ingles,
                    b.DOMFICNOC                         AS          tipo_estado_nombre_castellano,
                    b.DOMFICNOP                         AS          tipo_estado_nombre_portugues,

                    c.DOMFICCOD                         AS          tipo_examen_codigo,
                    c.DOMFICNOI                         AS          tipo_examen_nombre_ingles,
                    c.DOMFICNOC                         AS          tipo_examen_nombre_castellano,
                    c.DOMFICNOP                         AS          tipo_examen_nombre_portugues,

                    d.competitionFifaId                 AS          competicion_codigo,
                    d.superiorCompetitionFifaId         AS          competicion_codigo_padre,
                    d.status                            AS          competicion_estado,
                    d.internationalName                 AS          competicion_nombre,
                    d.internationalShortName            AS          competicion_nombre_corto,
                    d.season                            AS          competicion_anho,

                    e.JUEGO_CODIGO                      AS          encuentro_codigo,
                    e.EQUIPO_LOCAL_CODIGO               AS          encuentro_local_codigo,
                    e.EQUIPO_LOCAL_NOMBRE               AS          encuentro_local_equipo,
                    e.EQUIPO_VISITANTE_CODIGO           AS          encuentro_visitante_codigo,
                    e.EQUIPO_VISITANTE_NOMBRE           AS          encuentro_visitante_equipo,

                    f.teamFifaId                        AS          equipo_codigo,
                    f.internationalName                 AS          equipo_nombre,

                    g.personFifaId                      AS          persona_codigo,
                    g.internationalFirstName            AS          persona_nombre,
                    g.internationalLastName             AS          persona_apellido,

                    h.EXAFICCOD                         AS          examen_anterior_codigo,
                    h.EXAFICFE1                         AS          examen_anterior_fecha_1,
                    h.EXAFICFE2                         AS          examen_anterior_fecha_2,
                    h.EXAFICFE3                         AS          examen_anterior_fecha_3,
                    h.EXAFICACA                         AS          examen_anterior_cantidad_adulto,
                    h.EXAFICMCA                         AS          examen_anterior_cantidad_menor,
                    h.EXAFICJCO                         AS          examen_anterior_persona_convocado,
                    h.EXAFICJPO                         AS          examen_anterior_persona_posicion,
                    h.EXAFICJCA                         AS          examen_anterior_persona_camiseta,
                    h.EXAFICLNO                         AS          examen_anterior_laboratorio_nombre,
                    h.EXAFICLFE                         AS          examen_anterior_laboratorio_fecha_envio,
                    h.EXAFICLFR                         AS          examen_anterior_laboratorio_fecha_recepcion,
                    h.EXAFICLFA                         AS          examen_anterior_laboratorio_fecha_aislamiento,
                    h.EXAFICLRE                         AS          examen_anterior_laboratorio_resultado,
                    h.EXAFICLIC                         AS          examen_anterior_laboratorio_cuarentena,
                    h.EXAFICLNT                         AS          examen_anterior_laboratorio_test,
                    h.EXAFICLAD                         AS          examen_anterior_laboratorio_adjunto,
                    h.EXAFICLOB                         AS          examen_anterior_laboratorio_observacion,
                    h.EXAFICOBS                         AS          examen_anterior_observacion

                    FROM [exa].[EXAFIC] a
                    LEFT OUTER JOIN [adm].[DOMFIC] b ON a.EXAFICEST = b.DOMFICCOD
                    LEFT OUTER JOIN [adm].[DOMFIC] c ON a.EXAFICTEC = c.DOMFICCOD
                    LEFT OUTER JOIN [comet].[competitions] d ON a.EXAFICCOC = d.competitionFifaId
                    LEFT OUTER JOIN [view].[juego] e ON a.EXAFICENC = e.JUEGO_CODIGO
                    LEFT OUTER JOIN [comet].[teams] f ON a.EXAFICEQC = f.teamFifaId
                    LEFT OUTER JOIN [comet].[persons] g ON a.EXAFICPEC = g.personFifaId
                    LEFT OUTER JOIN [exa].[EXAFIC] h ON a.EXAFICAEC = h.EXAFICCOD

                    WHERE a.EXAFICEQC = ? AND a.EXAFICENC = ? AND NOT EXISTS (SELECT *FROM comet.matches_officials d WHERE a.EXAFICPEC = d.personFifaId)

                    ORDER BY a.EXAFICENC ASC, a.EXAFICPEC ASC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02]);

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['examen_fecha_1'] == NULL) {
                        $examen_fecha_1 = '';
                    } else {
                        $examen_fecha_1 = date('d/m/Y', strtotime($rowMSSQL['examen_fecha_1']));
                    }

                    if ($rowMSSQL['examen_fecha_2'] == NULL) {
                        $examen_fecha_2 = '';
                    } else {
                        $examen_fecha_2 = date('d/m/Y', strtotime($rowMSSQL['examen_fecha_2']));
                    }

                    if ($rowMSSQL['examen_fecha_3'] == NULL) {
                        $examen_fecha_3 = '';
                    } else {
                        $examen_fecha_3 = date('d/m/Y', strtotime($rowMSSQL['examen_fecha_3']));
                    }

                    if ($rowMSSQL['examen_laboratorio_fecha_envio'] == NULL) {
                        $examen_laboratorio_fecha_envio = '';
                    } else {
                        $examen_laboratorio_fecha_envio = date('d/m/Y', strtotime($rowMSSQL['examen_laboratorio_fecha_envio']));
                    }

                    if ($rowMSSQL['examen_laboratorio_fecha_recepcion'] == NULL) {
                        $examen_laboratorio_fecha_recepcion = '';
                    } else {
                        $examen_laboratorio_fecha_recepcion = date('d/m/Y', strtotime($rowMSSQL['examen_laboratorio_fecha_recepcion']));
                    }

                    if ($rowMSSQL['examen_laboratorio_fecha_aislamiento'] == NULL) {
                        $examen_laboratorio_fecha_aislamiento = '';
                    } else {
                        $examen_laboratorio_fecha_aislamiento = date('d/m/Y', strtotime($rowMSSQL['examen_laboratorio_fecha_aislamiento']));
                    }

                    if ($rowMSSQL['examen_laboratorio_fecha_finaliza'] == NULL) {
                        $examen_laboratorio_fecha_finaliza = '';
                    } else {
                        $examen_laboratorio_fecha_finaliza = date('d/m/Y', strtotime($rowMSSQL['examen_laboratorio_fecha_finaliza']));
                    }

                    if ($rowMSSQL['examen_anterior_fecha_1'] == NULL) {
                        $examen_anterior_fecha_1 = '';
                    } else {
                        $examen_anterior_fecha_1 = date('d/m/Y', strtotime($rowMSSQL['examen_anterior_fecha_1']));
                    }

                    if ($rowMSSQL['examen_anterior_fecha_2'] == NULL) {
                        $examen_anterior_fecha_2 = '';
                    } else {
                        $examen_anterior_fecha_2 = date('d/m/Y', strtotime($rowMSSQL['examen_anterior_fecha_2']));
                    }

                    if ($rowMSSQL['examen_anterior_fecha_3'] == NULL) {
                        $examen_anterior_fecha_3 = '';
                    } else {
                        $examen_anterior_fecha_3 = date('d/m/Y', strtotime($rowMSSQL['examen_anterior_fecha_3']));
                    }

                    if ($rowMSSQL['examen_anterior_laboratorio_fecha_envio'] == NULL) {
                        $examen_anterior_laboratorio_fecha_envio = '';
                    } else {
                        $examen_anterior_laboratorio_fecha_envio = date('d/m/Y', strtotime($rowMSSQL['examen_anterior_laboratorio_fecha_envio']));
                    }

                    if ($rowMSSQL['examen_anterior_laboratorio_fecha_recepcion'] == NULL) {
                        $examen_anterior_laboratorio_fecha_recepcion = '';
                    } else {
                        $examen_anterior_laboratorio_fecha_recepcion = date('d/m/Y', strtotime($rowMSSQL['examen_anterior_laboratorio_fecha_recepcion']));
                    }

                    if ($rowMSSQL['examen_anterior_laboratorio_fecha_aislamiento'] == NULL) {
                        $examen_anterior_laboratorio_fecha_aislamiento = '';
                    } else {
                        $examen_anterior_laboratorio_fecha_aislamiento = date('d/m/Y', strtotime($rowMSSQL['examen_anterior_laboratorio_fecha_aislamiento']));
                    }

                    if ($rowMSSQL['encuentro_codigo'] != NULL){
                        $encuentro_codigo = $rowMSSQL['encuentro_codigo'];
                    } else {
                        $encuentro_codigo = 0;
                    }

                    $detalle    = array(
                        'examen_codigo'                                 => $rowMSSQL['examen_codigo'],
                        'examen_fecha_1'                                => $examen_fecha_1,
                        'examen_fecha_2'                                => $examen_fecha_2,
                        'examen_fecha_3'                                => $examen_fecha_3,
                        'examen_cantidad_adulto'                        => $rowMSSQL['examen_cantidad_adulto'],
                        'examen_cantidad_menor'                         => $rowMSSQL['examen_cantidad_menor'],
                        'examen_persona_convocado'                      => trim(strtoupper(strtolower($rowMSSQL['examen_persona_convocado']))),
                        'examen_persona_posicion'                       => trim(strtoupper(strtolower($rowMSSQL['examen_persona_posicion']))),
                        'examen_persona_camiseta'                       => trim(strtoupper(strtolower($rowMSSQL['examen_persona_camiseta']))),
                        'examen_laboratorio_nombre'                     => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_nombre']))),
                        'examen_laboratorio_fecha_envio'                => $examen_laboratorio_fecha_envio,
                        'examen_laboratorio_fecha_recepcion'            => $examen_laboratorio_fecha_recepcion,
                        'examen_laboratorio_fecha_aislamiento'          => $examen_laboratorio_fecha_aislamiento,
                        'examen_laboratorio_fecha_finaliza'             => $examen_laboratorio_fecha_finaliza,
                        'examen_laboratorio_resultado'                  => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_resultado']))),
                        'examen_laboratorio_cuarentena'                 => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_cuarentena']))),
                        'examen_laboratorio_test'                       => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_test']))),
                        'examen_laboratorio_adjunto'                    => trim(strtolower($rowMSSQL['examen_laboratorio_adjunto'])),
                        'examen_laboratorio_observacion'                => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_observacion']))),
                        'examen_bandera'                                => trim(strtoupper(strtolower($rowMSSQL['examen_bandera']))),
                        'examen_observacion'                            => trim(strtoupper(strtolower($rowMSSQL['examen_observacion']))),

                        'tipo_estado_codigo'                            => $rowMSSQL['tipo_estado_codigo'],
                        'tipo_estado_nombre_ingles'                     => trim(strtoupper(strtolower($rowMSSQL['tipo_estado_nombre_ingles']))),
                        'tipo_estado_nombre_castellano'                 => trim(strtoupper(strtolower($rowMSSQL['tipo_estado_nombre_castellano']))),
                        'tipo_estado_nombre_portugues'                  => trim(strtoupper(strtolower($rowMSSQL['tipo_estado_nombre_portugues']))),

                        'tipo_examen_codigo'                            => $rowMSSQL['tipo_examen_codigo'],
                        'tipo_examen_nombre_ingles'                     => trim(strtoupper(strtolower($rowMSSQL['tipo_examen_nombre_ingles']))),
                        'tipo_examen_nombre_castellano'                 => trim(strtoupper(strtolower($rowMSSQL['tipo_examen_nombre_castellano']))),
                        'tipo_examen_nombre_portugues'                  => trim(strtoupper(strtolower($rowMSSQL['tipo_examen_nombre_portugues']))),

                        'competicion_codigo'                            => $rowMSSQL['competicion_codigo'],
                        'competicion_codigo_padre'                      => $rowMSSQL['competicion_codigo_padre'],
                        'competicion_estado'                            => trim(strtoupper(strtolower($rowMSSQL['competicion_estado']))),
                        'competicion_nombre'                            => trim(strtoupper(strtolower($rowMSSQL['competicion_nombre']))),
                        'competicion_nombre_corto'                      => trim(strtoupper(strtolower($rowMSSQL['competicion_nombre_corto']))),
                        'competicion_anho'                              => $rowMSSQL['competicion_anho'],

                        'encuentro_codigo'                              => $encuentro_codigo,
                        'encuentro_local_codigo'                        => $rowMSSQL['encuentro_local_codigo'],
                        'encuentro_visitante_codigo'                    => $rowMSSQL['encuentro_visitante_codigo'],
                        'encuentro_nombre'                              => trim(strtoupper(strtolower($rowMSSQL['encuentro_local_equipo']))).' vs '.trim(strtoupper(strtolower($rowMSSQL['encuentro_visitante_equipo']))),

                        'equipo_codigo'                                 => $rowMSSQL['equipo_codigo'],
                        'equipo_nombre'                                 => trim(strtoupper(strtolower($rowMSSQL['equipo_nombre']))),

                        'persona_codigo'                                => $rowMSSQL['persona_codigo'],
                        'persona_nombre'                                => trim(strtoupper(strtolower($rowMSSQL['persona_nombre']))).', '.trim(strtoupper(strtolower($rowMSSQL['persona_apellido']))),

                        'examen_anterior_codigo'                        => $rowMSSQL['examen_anterior_codigo'],
                        'examen_anterior_fecha_1'                       => $examen_anterior_fecha_1,
                        'examen_anterior_fecha_2'                       => $examen_anterior_fecha_2,
                        'examen_anterior_fecha_3'                       => $examen_anterior_fecha_3,
                        'examen_anterior_cantidad_adulto'               => $rowMSSQL['examen_anterior_cantidad_adulto'],
                        'examen_anterior_cantidad_menor'                => $rowMSSQL['examen_anterior_cantidad_menor'],
                        'examen_anterior_persona_convocado'             => trim(strtoupper(strtolower($rowMSSQL['examen_anterior_persona_convocado']))),
                        'examen_anterior_persona_posicion'              => trim(strtoupper(strtolower($rowMSSQL['examen_anterior_persona_posicion']))),
                        'examen_anterior_persona_camiseta'              => trim(strtoupper(strtolower($rowMSSQL['examen_anterior_persona_camiseta']))),
                        'examen_anterior_laboratorio_nombre'            => trim(strtoupper(strtolower($rowMSSQL['examen_anterior_laboratorio_nombre']))),
                        'examen_anterior_laboratorio_fecha_envio'       => $examen_anterior_laboratorio_fecha_envio,
                        'examen_anterior_laboratorio_fecha_recepcion'   => $examen_anterior_laboratorio_fecha_recepcion,
                        'examen_anterior_laboratorio_fecha_aislamiento' => $examen_anterior_laboratorio_fecha_aislamiento,
                        'examen_anterior_laboratorio_resultado'         => trim(strtoupper(strtolower($rowMSSQL['examen_anterior_laboratorio_resultado']))),
                        'examen_anterior_laboratorio_cuarentena'        => trim(strtoupper(strtolower($rowMSSQL['examen_anterior_laboratorio_cuarentena']))),
                        'examen_anterior_laboratorio_test'              => trim(strtoupper(strtolower($rowMSSQL['examen_anterior_laboratorio_test']))),
                        'examen_anterior_laboratorio_adjunto'           => trim(strtolower($rowMSSQL['examen_anterior_laboratorio_adjunto'])),
                        'examen_anterior_laboratorio_observacion'       => trim(strtoupper(strtolower($rowMSSQL['examen_anterior_laboratorio_observacion']))),
                        'examen_anterior_observacion'                   => trim(strtoupper(strtolower($rowMSSQL['examen_anterior_observacion']))),

                        'auditoria_usuario'                             => trim($rowMSSQL['auditoria_usuario']),
                        'auditoria_fecha_hora'                          => date('d/m/Y', strtotime($rowMSSQL['auditoria_fecha_hora'])),
                        'auditoria_ip'                                  => trim($rowMSSQL['auditoria_ip'])
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'examen_codigo'                                 => '',
                        'examen_fecha_1'                                => '',
                        'examen_fecha_2'                                => '',
                        'examen_fecha_3'                                => '',
                        'examen_cantidad_adulto'                        => '',
                        'examen_cantidad_menor'                         => '',
                        'examen_persona_convocado'                      => '',
                        'examen_persona_posicion'                       => '',
                        'examen_persona_camiseta'                       => '',
                        'examen_laboratorio_nombre'                     => '',
                        'examen_laboratorio_fecha_envio'                => '',
                        'examen_laboratorio_fecha_recepcion'            => '',
                        'examen_laboratorio_fecha_aislamiento'          => '',
                        'examen_laboratorio_resultado'                  => '',
                        'examen_laboratorio_cuarentena'                 => '',
                        'examen_laboratorio_fecha_finaliza'             => '',
                        'examen_laboratorio_test'                       => '',
                        'examen_laboratorio_adjunto'                    => '',
                        'examen_laboratorio_observacion'                => '',
                        'examen_bandera'                                => '',
                        'examen_observacion'                            => '',

                        'tipo_estado_codigo'                            => '',
                        'tipo_estado_nombre_ingles'                     => '',
                        'tipo_estado_nombre_castellano'                 => '',
                        'tipo_estado_nombre_portugues'                  => '',

                        'tipo_examen_codigo'                            => '',
                        'tipo_examen_nombre_ingles'                     => '',
                        'tipo_examen_nombre_castellano'                 => '',
                        'tipo_examen_nombre_portugues'                  => '',

                        'competicion_codigo'                            => '',
                        'competicion_codigo_padre'                      => '',
                        'competicion_estado'                            => '',
                        'competicion_nombre'                            => '',
                        'competicion_nombre_corto'                      => '',
                        'competicion_anho'                              => '',

                        'encuentro_codigo'                              => '',
                        'encuentro_local_codigo'                        => '',
                        'encuentro_visitante_codigo'                    => '',
                        'encuentro_nombre'                              => '',

                        'equipo_codigo'                                 => '',
                        'equipo_nombre'                                 => '',

                        'persona_codigo'                                => '',
                        'persona_nombre'                                => '',

                        'examen_anterior_codigo'                        => '',
                        'examen_anterior_fecha_1'                       => '',
                        'examen_anterior_fecha_2'                       => '',
                        'examen_anterior_fecha_3'                       => '',
                        'examen_anterior_cantidad_adulto'               => '',
                        'examen_anterior_cantidad_menor'                => '',
                        'examen_anterior_persona_convocado'             => '',
                        'examen_anterior_persona_posicion'              => '',
                        'examen_anterior_persona_camiseta'              => '',
                        'examen_anterior_laboratorio_nombre'            => '',
                        'examen_anterior_laboratorio_fecha_envio'       => '',
                        'examen_anterior_laboratorio_fecha_recepcion'   => '',
                        'examen_anterior_laboratorio_fecha_aislamiento' => '',
                        'examen_anterior_laboratorio_resultado'         => '',
                        'examen_anterior_laboratorio_cuarentena'        => '',
                        'examen_anterior_laboratorio_test'              => '',
                        'examen_anterior_laboratorio_adjunto'           => '',
                        'examen_anterior_laboratorio_observacion'       => '',
                        'examen_anterior_observacion'                   => '',

                        'auditoria_usuario'                             => '',
                        'auditoria_fecha_hora'                          => '',
                        'auditoria_ip'                                  => ''
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
    
    $app->get('/v2/801/examen/prueba/detalle/consulta/{codigo}', function($request) {//20201111
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');

        if (isset($val00)) {
                $sql00  = "SELECT
                a.EXATESCOD        AS          examen_test_codigo,
                a.EXATESVAL        AS          examen_test_valor,
                a.EXATESOBS        AS          examen_test_observacion,
                
                a.EXATESAUS        AS          auditoria_usuario,
                a.EXATESAFH        AS          auditoria_fecha_hora,
                a.EXATESAIP        AS          auditoria_ip,
                
                b.DOMFICCOD        AS          tipo_test_codigo,
                b.DOMFICNOI        AS          tipo_test_nombre_ingles,
                b.DOMFICNOC        AS          tipo_test_nombre_castellano,
                b.DOMFICNOP        AS          tipo_test_nombre_portugues,
                b.DOMFICVAL        AS          tipo_test_dominio,
                b.DOMFICPAR        AS          tipo_test_parametro,
                
                c.EXAFICCOD        AS          examen_codigo,
                c.EXAFICFE1        AS          examen_fecha_1,
                c.EXAFICFE2        AS          examen_fecha_2,
                c.EXAFICFE3        AS          examen_fecha_3,
                c.EXAFICACA        AS          examen_cantidad_adulto,
                c.EXAFICMCA        AS          examen_cantidad_menor,
                c.EXAFICJCO        AS          examen_persona_convocado,
                c.EXAFICJPO        AS          examen_persona_posicion,
                c.EXAFICJCA        AS          examen_persona_camiseta,
                c.EXAFICLNO        AS          examen_laboratorio_nombre,
                c.EXAFICLFE        AS          examen_laboratorio_fecha_envio,
                c.EXAFICLFR        AS          examen_laboratorio_fecha_recepcion,
                c.EXAFICLFA        AS          examen_laboratorio_fecha_aislamiento,
                c.EXAFICLFF        AS          examen_laboratorio_fecha_finaliza,
                c.EXAFICLRE        AS          examen_laboratorio_resultado,
                c.EXAFICLIC        AS          examen_laboratorio_cuarentena,
                c.EXAFICLNT        AS          examen_laboratorio_test,
                c.EXAFICLAD        AS          examen_laboratorio_adjunto,
                c.EXAFICLOB        AS          examen_laboratorio_observacion,
                c.EXAFICBAN        AS          examen_bandera,
                c.EXAFICOBS        AS          examen_observacion
                
                FROM exa.EXATES a
                INNER JOIN adm.DOMFIC b ON a.EXATESTTC = b.DOMFICCOD
                INNER JOIN exa.EXAFIC c ON a.EXATESEXC = c.EXAFICCOD
                
                WHERE a.EXATESEXC = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);

                $stmtMSSQL->execute([$val00]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    if ($rowMSSQL['examen_fecha_1'] == '1900-01-01' || $rowMSSQL['examen_fecha_1'] == null){
                        $examen_fecha_1_1 = '';
                        $examen_fecha_1_2 = '';
                    } else {
                        $examen_fecha_1_1 = $rowMSSQL['examen_fecha_1'];
                        $examen_fecha_1_2 = date('d/m/Y', strtotime($rowMSSQL['examen_fecha_1']));
                    }

                    if ($rowMSSQL['examen_fecha_2'] == '1900-01-01' || $rowMSSQL['examen_fecha_2'] == null){
                        $examen_fecha_2_1 = '';
                        $examen_fecha_2_2 = '';
                    } else {
                        $examen_fecha_2_1 = $rowMSSQL['examen_fecha_2'];
                        $examen_fecha_2_2 = date('d/m/Y', strtotime($rowMSSQL['examen_fecha_2']));
                    }

                    if ($rowMSSQL['examen_fecha_3'] == '1900-01-01' || $rowMSSQL['examen_fecha_3'] == null){
                        $examen_fecha_3_1 = '';
                        $examen_fecha_3_2 = '';
                    } else {
                        $examen_fecha_3_1 = $rowMSSQL['examen_fecha_3'];
                        $examen_fecha_3_2 = date('d/m/Y', strtotime($rowMSSQL['examen_fecha_3']));
                    }

                    if ($rowMSSQL['examen_laboratorio_fecha_envio'] == '1900-01-01' || $rowMSSQL['examen_laboratorio_fecha_envio'] == null){
                        $examen_laboratorio_fecha_envio_1 = '';
                        $examen_laboratorio_fecha_envio_2 = '';
                    } else {
                        $examen_laboratorio_fecha_envio_1 = $rowMSSQL['examen_laboratorio_fecha_envio'];
                        $examen_laboratorio_fecha_envio_2 = date('d/m/Y', strtotime($rowMSSQL['examen_laboratorio_fecha_envio']));
                    }
                    
                    if ($rowMSSQL['examen_laboratorio_fecha_recepcion'] == '1900-01-01' || $rowMSSQL['examen_laboratorio_fecha_recepcion'] == null){
                        $examen_laboratorio_fecha_recepcion_1 = '';
                        $examen_laboratorio_fecha_recepcion_2 = '';
                    } else {
                        $examen_laboratorio_fecha_recepcion_1 = $rowMSSQL['examen_laboratorio_fecha_recepcion'];
                        $examen_laboratorio_fecha_recepcion_2 = date('d/m/Y', strtotime($rowMSSQL['examen_laboratorio_fecha_recepcion']));
                    }
                    
                    if ($rowMSSQL['examen_laboratorio_fecha_aislamiento'] == '1900-01-01' || $rowMSSQL['examen_laboratorio_fecha_aislamiento'] == null){
                        $examen_laboratorio_fecha_aislamiento_1 = '';
                        $examen_laboratorio_fecha_aislamiento_2 = '';
                    } else {
                        $examen_laboratorio_fecha_aislamiento_1 = $rowMSSQL['examen_laboratorio_fecha_aislamiento'];
                        $examen_laboratorio_fecha_aislamiento_2 = date('d/m/Y', strtotime($rowMSSQL['examen_laboratorio_fecha_aislamiento']));
                    }
                                    
                    if ($rowMSSQL['examen_laboratorio_fecha_finaliza'] == '1900-01-01' || $rowMSSQL['examen_laboratorio_fecha_finaliza'] == null){
                        $examen_laboratorio_fecha_finaliza_1 = '';
                        $examen_laboratorio_fecha_finaliza_2 = '';
                    } else {
                        $examen_laboratorio_fecha_finaliza_1 = $rowMSSQL['examen_laboratorio_fecha_finaliza'];
                        $examen_laboratorio_fecha_finaliza_2 = date('d/m/Y', strtotime($rowMSSQL['examen_laboratorio_fecha_finaliza']));
                    }
                    
                    

                    $detalle    = array(
                        'examen_test_codigo'                            => $rowMSSQL['examen_test_codigo'],
                        'examen_test_valor'                             => trim(strtoupper(strtolower($rowMSSQL['examen_test_valor']))),
                        'examen_test_observacion'                       => trim($rowMSSQL['examen_test_observacion']),

                        'auditoria_usuario'                             => trim(strtoupper(strtolower($rowMSSQL['auditoria_usuario']))),
                        'auditoria_fecha_hora'                          => date("d/m/Y", strtotime($rowMSSQL['auditoria_fecha_hora'])),
                        'auditoria_ip'                                  => trim(strtoupper(strtolower($rowMSSQL['auditoria_ip']))),

                        'tipo_test_codigo'                              => $rowMSSQL['tipo_test_codigo'],
                        'tipo_test_nombre_ingles'                       => trim(strtoupper(strtolower($rowMSSQL['tipo_test_nombre_ingles']))),
                        'tipo_test_nombre_castellano'                   => trim(strtoupper(strtolower($rowMSSQL['tipo_test_nombre_castellano']))),
                        'tipo_test_nombre_portugues'                    => trim(strtoupper(strtolower($rowMSSQL['tipo_test_nombre_portugues']))),
                        'tipo_test_parametro'                           => $rowMSSQL['tipo_test_parametro'],
                        'tipo_test_dominio'                             => trim(strtoupper(strtolower($rowMSSQL['tipo_test_dominio']))),                           
                        
                        'examen_codigo'                                 => $rowMSSQL['examen_codigo'],
                        'examen_fecha_1_1'                              => $examen_fecha_1_1,
                        'examen_fecha_1_2'                              => $examen_fecha_1_2,
                        'examen_fecha_2_1'                              => $examen_fecha_2_1,
                        'examen_fecha_2_2'                              => $examen_fecha_2_2,
                        'examen_fecha_3_1'                              => $examen_fecha_3_1,
                        'examen_fecha_3_2'                              => $examen_fecha_3_2,
                        'examen_cantidad_adulto'                        => $rowMSSQL['examen_cantidad_adulto'],
                        'examen_cantidad_menor'                         => $rowMSSQL['examen_cantidad_menor'],
                        'examen_persona_convocado'                      => trim(strtoupper(strtolower($rowMSSQL['examen_persona_convocado']))),
                        'examen_persona_posicion'                       => trim(strtoupper(strtolower($rowMSSQL['examen_persona_posicion']))),
                        'examen_persona_camiseta'                       => trim(strtoupper(strtolower($rowMSSQL['examen_persona_camiseta']))),
                        'examen_laboratorio_nombre'                     => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_nombre']))),
                        'examen_laboratorio_fecha_envio_1'              => $examen_laboratorio_fecha_envio_1,
                        'examen_laboratorio_fecha_envio_2'              => $examen_laboratorio_fecha_envio_2,
                        'examen_laboratorio_fecha_recepcion_1'          => $examen_laboratorio_fecha_recepcion_1,
                        'examen_laboratorio_fecha_recepcion_2'          => $examen_laboratorio_fecha_recepcion_2,
                        'examen_laboratorio_fecha_aislamiento_1'        => $examen_laboratorio_fecha_aislamiento_1,
                        'examen_laboratorio_fecha_aislamiento_2'        => $examen_laboratorio_fecha_aislamiento_2,
                        'examen_laboratorio_fecha_finaliza_1'           => $examen_laboratorio_fecha_finaliza_1,
                        'examen_laboratorio_fecha_finaliza_2'           => $examen_laboratorio_fecha_finaliza_2,
                        'examen_laboratorio_resultado'                  => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_resultado']))),
                        'examen_laboratorio_cuarentena'                 => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_cuarentena']))),
                        'examen_laboratorio_test'                       => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_test']))),
                        'examen_laboratorio_adjunto'                    => trim(strtolower($rowMSSQL['examen_laboratorio_adjunto'])),
                        'examen_laboratorio_observacion'                => trim(strtoupper(strtolower($rowMSSQL['examen_laboratorio_observacion']))),
                        'examen_bandera'                                => trim(strtoupper(strtolower($rowMSSQL['examen_bandera']))),
                        'examen_observacion'                            => trim(strtoupper(strtolower($rowMSSQL['examen_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'examen_test_codigo'                            => '',
                        'examen_test_valor'                             => '',
                        'examen_test_observacion'                       => '',

                        'auditoria_usuario'                             => '',
                        'auditoria_fecha_hora'                          => '',
                        'auditoria_ip'                                  => '',

                        'tipo_test_codigo'                              => '',
                        'tipo_test_nombre_ingles'                       => '',
                        'tipo_test_nombre_castellano'                   => '',
                        'tipo_test_nombre_portugues'                    => '',
                        'tipo_test_parametro'                           => '',
                        'tipo_test_dominio'                             => '',
                        
                        'examen_codigo'                                 => '',
                        'examen_fecha_1_1'                              => '',
                        'examen_fecha_1_2'                              => '',
                        'examen_fecha_2_1'                              => '',
                        'examen_fecha_2_2'                              => '',
                        'examen_fecha_3_1'                              => '',
                        'examen_fecha_3_2'                              => '',
                        'examen_cantidad_adulto'                        => '',
                        'examen_cantidad_menor'                         => '',
                        'examen_persona_convocado'                      => '',
                        'examen_persona_posicion'                       => '',
                        'examen_persona_camiseta'                       => '',
                        'examen_laboratorio_nombre'                     => '',
                        'examen_laboratorio_fecha_envio_1'              => '',
                        'examen_laboratorio_fecha_envio_2'              => '',
                        'examen_laboratorio_fecha_recepcion_1'          => '',
                        'examen_laboratorio_fecha_recepcion_2'          => '',
                        'examen_laboratorio_fecha_aislamiento_1'        => '',
                        'examen_laboratorio_fecha_aislamiento_2'        => '',
                        'examen_laboratorio_fecha_finaliza_1'           => '',
                        'examen_laboratorio_fecha_finaliza_2'           => '',
                        'examen_laboratorio_resultado'                  => '',
                        'examen_laboratorio_cuarentena'                 => '',
                        'examen_laboratorio_test'                       => '',
                        'examen_laboratorio_adjunto'                    => '',
                        'examen_laboratorio_observacion'                => '',
                        'examen_bandera'                                => '',
                        'examen_observacion'                            => ''
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

    $app->get('/v2/801/examen/competicion/chart01/{equipo}/{competicion}/{examen}/{encuentro}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('equipo');
        $val02      = $request->getAttribute('competicion');
        $val03      = $request->getAttribute('examen');
        $val04      = $request->getAttribute('encuentro');

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql00  = "";

            if($val01 == 39393) {
                $sql00  = "SELECT
                    '1'                         AS     tipo_codigo,
                    'TOTAL PERSONA'             AS     tipo_nombre,
                    ((SELECT COUNT(*) from comet.competitions_teams_players b1 WHERE (b1.competitionFifaId = a.COMPETICION_ID OR b1.competitionFifaId = a.COMPETICION_PADRE_ID) AND b1.teamFifaId = a.EQUIPO_LOCAL_CODIGO) +
                    (SELECT COUNT(*) from comet.competitions_teams_players b2 WHERE (b2.competitionFifaId = a.COMPETICION_ID OR b2.competitionFifaId = a.COMPETICION_PADRE_ID) AND b2.teamFifaId = a.EQUIPO_VISITANTE_CODIGO)) AS cantidad_persona
                        
                    FROM [VIEW].juego a
                        
                    WHERE (a.COMPETICION_PADRE_ID = ? OR a.COMPETICION_ID = ?) AND a.JUEGO_CODIGO = ?";

                $sql01  = "SELECT
                    a.DOMFICCOD                  AS  tipo_codigo,
                    a.DOMFICNOC                  AS  tipo_nombre,
                    COUNT(*)                     AS  cantidad_persona
                    
                    FROM adm.DOMFIC a 
                    LEFT OUTER JOIN exa.EXAFIC b ON a.DOMFICCOD = b.EXAFICEST 
                    INNER JOIN comet.competitions c ON b.EXAFICCOC = c.competitionFifaId
                    
                    WHERE b.EXAFICTEC = ? AND (c.superiorCompetitionFifaId = ? OR c.competitionFifaId = ?) AND a.DOMFICVAL = 'EXAMENMEDICOCOVID19ESTADO' AND b.EXAFICENC = ?
                    /*AND NOT EXISTS (SELECT *FROM comet.matches_officials d WHERE b.EXAFICPEC = d.personFifaId)*/
                    
                    GROUP BY a.DOMFICCOD, a.DOMFICNOC";

                $sql02 = "SELECT
                    '2'                           AS     tipo_codigo,
                    'PENDIENTE DE CARGA'          AS     tipo_nombre,
                    (((SELECT COUNT(*) from comet.competitions_teams_players b1 WHERE (b1.competitionFifaId = a.COMPETICION_ID OR b1.competitionFifaId = a.COMPETICION_PADRE_ID) AND b1.teamFifaId = a.EQUIPO_LOCAL_CODIGO) +
                    ( SELECT COUNT(*) from comet.competitions_teams_players b2 WHERE (b2.competitionFifaId = a.COMPETICION_ID OR b2.competitionFifaId = a.COMPETICION_PADRE_ID) AND b2.teamFifaId = a.EQUIPO_VISITANTE_CODIGO)) -
                    
                    ((SELECT COUNT(DISTINCT(b3.EXAFICPEC)) FROM exa.EXAFIC b3 WHERE (b3.EXAFICCOC = a.COMPETICION_ID OR b3.EXAFICCOC = a.COMPETICION_PADRE_ID) AND b3.EXAFICEQC = a.EQUIPO_LOCAL_CODIGO AND b3.EXAFICTEC = ? AND b3.EXAFICENC = a.JUEGO_CODIGO)+
                    (SELECT COUNT(DISTINCT(b4.EXAFICPEC)) FROM exa.EXAFIC b4 WHERE (b4.EXAFICCOC = a.COMPETICION_ID OR b4.EXAFICCOC = a.COMPETICION_PADRE_ID) AND b4.EXAFICEQC = a.EQUIPO_VISITANTE_CODIGO AND b4.EXAFICTEC = ? AND b4.EXAFICENC = a.JUEGO_CODIGO))) AS cantidad_persona 
                    
                    FROM [VIEW].juego a
                    
                    WHERE (a.COMPETICION_PADRE_ID = ? OR a.COMPETICION_ID = ?) AND a.JUEGO_CODIGO = ?";
            } else {
                $sql00  = "SELECT
                    '1'                                          AS     tipo_codigo,
                    'TOTAL PERSONA'                              AS     tipo_nombre,
                    COUNT(*)                                     AS     cantidad_persona
                    
                    FROM comet.competitions_teams_players a
                    
                    WHERE a.competitionFifaId = ? AND a.teamFifaId = ? AND a.playerType <> 'Z'
                    GROUP BY a.competitionFifaId";

                $sql01  = "SELECT
                    a.DOMFICCOD                  AS  tipo_codigo,
                    a.DOMFICNOC                  AS  tipo_nombre,
                    COUNT(*)                     AS  cantidad_persona
                    
                    FROM adm.DOMFIC a 
                    LEFT OUTER JOIN exa.EXAFIC b ON a.DOMFICCOD = b.EXAFICEST 
                    INNER JOIN comet.competitions c ON b.EXAFICCOC = c.competitionFifaId
                    
                    WHERE b.EXAFICTEC = ? AND b.EXAFICEQC = ? AND (c.superiorCompetitionFifaId = ? OR c.competitionFifaId = ?) AND a.DOMFICVAL = 'EXAMENMEDICOCOVID19ESTADO' AND b.EXAFICENC = ?
                    /*AND NOT EXISTS (SELECT *FROM comet.matches_officials d WHERE b.EXAFICPEC = d.personFifaId)*/
                    AND NOT EXISTS (SELECT * FROM comet.competitions_teams_players e WHERE (e.competitionFifaId = c.competitionFifaId OR e.competitionFifaId = c.superiorCompetitionFifaId) AND e.playerType = 'Z' AND e.playerFifaId = b.EXAFICPEC)
                    GROUP BY a.DOMFICCOD, a.DOMFICNOC";

                $sql02 = "SELECT
                    '2'                          AS     tipo_codigo,
                    'PENDIENTE DE CARGA'         AS     tipo_nombre,
                    COUNT(*)                     AS     cantidad_persona

                    FROM comet.competitions_teams_players  a
                    WHERE a.competitionFifaId = ?  AND a.teamFifaId = ? AND a.playerType <> 'Z' AND
                    NOT EXISTS
                        (SELECT * 
                            FROM exa.EXAFIC b 
                            INNER JOIN adm.DOMFIC c ON b.EXAFICEST = c.DOMFICCOD
                            INNER JOIN comet.competitions d ON (b.EXAFICCOC = d.competitionFifaId OR b.EXAFICCOC = d.superiorCompetitionFifaId)
                        
                            WHERE c.DOMFICVAL = 'EXAMENMEDICOCOVID19ESTADO' AND b.EXAFICPEC = a.playerFifaId AND b.EXAFICTEC = ?  AND b.EXAFICENC = ?
                        )
                    GROUP BY a.competitionFifaId";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL02= $connMSSQL->prepare($sql02);

                if ($val01 == 39393) {
                    $stmtMSSQL00->execute([$val02, $val02, $val04]);
                    $stmtMSSQL01->execute([$val03, $val02, $val02, $val04]);
                    $stmtMSSQL02->execute([$val03, $val03, $val02, $val02, $val04]);
                } else {
                    $stmtMSSQL00->execute([$val02, $val01]);
                    $stmtMSSQL01->execute([$val03, $val01, $val02, $val02, $val04]);
                    $stmtMSSQL02->execute([$val02, $val01, $val03, $val04]);
                }
                while ($rowMSSQL = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'               => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre'               => trim(strtoupper(strtolower($rowMSSQL['tipo_nombre']))),
                        'cantidad_persona'          => $rowMSSQL['cantidad_persona']
                    );

                    $result[]   = $detalle;
                }

                while ($rowMSSQL = $stmtMSSQL01->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'               => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre'               => trim(strtoupper(strtolower($rowMSSQL['tipo_nombre']))),
                        'cantidad_persona'          => $rowMSSQL['cantidad_persona']
                    );

                    $result[]   = $detalle;
                }

                while ($rowMSSQL = $stmtMSSQL02->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'               => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre'               => trim(strtoupper(strtolower($rowMSSQL['tipo_nombre']))),
                        'cantidad_persona'          => $rowMSSQL['cantidad_persona']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'               => '',
                        'tipo_nombre'               => '',
                        'cantidad_persona'          => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();
                $stmtMSSQL02->closeCursor();
                
                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                $stmtMSSQL02 = null;
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