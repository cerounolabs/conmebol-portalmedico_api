<?php
    $app->post('/v1/000', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_orden'];
        $val03      = $request->getParsedBody()['tipo_nombre'];
        $val04      = $request->getParsedBody()['tipo_path'];
        $val05      = $request->getParsedBody()['tipo_dominio'];
        $val06      = $request->getParsedBody()['tipo_observacion'];
        $val07      = $request->getParsedBody()['tipo_usuario'];
        $val08      = $request->getParsedBody()['tipo_fecha_hora'];
        $val09      = $request->getParsedBody()['tipo_ip'];

        if (isset($val01) && isset($val03) && isset($val05) && isset($val07) && isset($val08) && isset($val09)) {
            $sql00  = "INSERT INTO [adm].[DOMFIC] (DOMFICEST, DOMFICORD, DOMFICNOM, DOMFICPAT, DOMFICVAL, DOMFICOBS, DOMFICAUS, DOMFICAFH, DOMFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val09]); 
                
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

    $app->post('/v1/100', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_sub_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_codigo'];
        $val03      = $request->getParsedBody()['tipo_sub_orden'];
        $val04      = $request->getParsedBody()['tipo_sub_nombre'];
        $val05      = $request->getParsedBody()['tipo_sub_path'];
        $val06      = $request->getParsedBody()['tipo_sub_dominio'];
        $val07      = $request->getParsedBody()['tipo_sub_observacion'];
        $val08      = $request->getParsedBody()['tipo_sub_usuario'];
        $val09      = $request->getParsedBody()['tipo_sub_fecha_hora'];
        $val10      = $request->getParsedBody()['tipo_sub_ip'];

        if (isset($val01) && isset($val02) && isset($val04) && isset($val06) && isset($val08) && isset($val09) && isset($val10)) {
            $sql00  = "INSERT INTO [adm].[DOMSUB] (DOMSUBEST, DOMSUBTIC, DOMSUBORD, DOMSUBNOM, DOMSUBPAT, DOMSUBVAL, DOMSUBOBS, DOMSUBAUS, DOMSUBAFH, DOMSUBAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val10]); 
                
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