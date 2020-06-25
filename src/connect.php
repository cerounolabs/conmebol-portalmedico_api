<?php
    function getConnectionMSSQL(){
        $serverName = "10.10.10.17";
        $serverPort = "1433";
        $serverDb   = "CSF_Lesiones";
        $serverUser = "user_lesiones";
        $serverPass = "C0nm3b0l..!LESIONES";

        $serverName = "172.16.50.19";
        $serverPort = "1433";
        $serverDb   = "CSF_LESIONES";
        $serverUser = "user_sfholox";
        $serverPass = "D1pl0d0cus2020";

        try {
            $conn = new PDO("sqlsrv:Server=$serverName,$serverPort;Database=$serverDb;ConnectionPooling=0", $serverUser, $serverPass,
                array(
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error Connecting to MSSQL: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            die();
        }

        return $conn;
    }