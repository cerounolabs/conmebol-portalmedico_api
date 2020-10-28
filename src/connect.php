<?php
    $api = 'https://api-latam.analyticom.de/api/export/comet';
    $aut = 'ZGllZ29nb256YWxlejpkaWVnb2dvbnphbGV6Q09O';

    function getConnectionMSSQLv1(){
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

    function getConnectionMSSQLv2(){
        $serverName = "172.16.50.19";
        $serverPort = "1433";
        $serverDb   = "CSF_LESIONES_V2";
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

    function get_curl($ext){
        global $api;
        global $aut;
        $urlAPI                     = $api.'/'.$ext;
        $ch                         = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json", "Authorization: Basic ".$aut, "Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result                     = curl_exec($ch);
        curl_close($ch);
//        $result                     = json_decode($result, TRUE);
        return $result;
    }