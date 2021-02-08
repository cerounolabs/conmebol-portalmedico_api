<?php
    require __DIR__.'/../src/connect.php';

    $DOMFICAUS  = 'SFHOLOX';
    $DOMFICAIP  = '0.0.0.0';

    function getAsignarContrasenha($pass){

        global $DOMFICAUS;
        global $DOMFICAIP;
        $CONTRASENHA    = password_hash($pass, PASSWORD_DEFAULT);

        $sql00  =   "UPDATE adm.PERFIC SET PERFICCON = ?,  PERFICAUS = ?, PERFICAFH = GETDATE(), PERFICAIP = ?";

        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$CONTRASENHA, $DOMFICAUS, $DOMFICAIP]);

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00    = null;

        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getContrasenha(): '.$e;
        }

        $connMSSQL  = null;
    }


    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE ACTUALIZACIÓN CONTRASEÑA++++++++++++++++++++++++++";
    echo "\n";

    echo "INICIO getContrasenha() => ".date('Y-m-d H:i:s');
    getAsignarContrasenha('prueba2021');
    echo "\n";
    echo "FIN getContrasenha() => ".date('Y-m-d H:i:s');
    echo "\n";
?>