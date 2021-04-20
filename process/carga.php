<?php
    require __DIR__.'/../src/connect.php';

    $DOMFICAUS  =   'SFHOLOX';
    $DOMFICAIP  =   '0.0.0.0';
    $DOMFICPAR  =   1;
    $EXATESVAL  = 'SI';
    $EXATESOBS  = '';

    function getCargaTest(){
        global $DOMFICPAR;
        global $EXATESVAL;
        global $EXATESOBS;
        global $DOMFICAUS;
        global $DOMFICAIP;

        $sql00  =   "SELECT a.EXAFICCOD AS examen_codigo FROM exa.EXAFIC a WHERE a.EXAFICAUS = 'WILMERSALASNICOFABRI55445' AND a.EXAFICENC = 59414586 AND a.EXAFICEQC = 55445 AND a.EXAFICTEC = 174 and NOT EXISTS (SELECT * FROM exa.EXATES b WHERE b.EXATESEXC = a.EXAFICCOD )";
        $sql01  =   "INSERT INTO [exa].[EXATES](                                                           EXATESTTC,   EXATESEXC,  EXATESVAL,  EXATESOBS,  EXATESAUS, EXATESAFH, EXATESAIP) 
        VALUES((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'EXAMENMEDICOCOVID19SEROLOGIA' AND DOMFICPAR = ?),           ?,          ?,           ?,         ?,GETDATE(), ?)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();

            $stmtMSSQL00    =   $connMSSQL->prepare($sql00);
            //$stmtMSSQL01    =   $connMSSQL->prepare($sql01);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {//recorre NOTFIC
                $examenCodigo   =    $rowMSSQL00['examen_codigo'];

                echo ('codigos a insertar => '.$examenCodigo);

                /*while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {//recorre NOTFIC

                   // $stmtMSSQL01->execute([$DOMFICPAR, $EXATESVAL, $EXATESOBS, $DOMFICAUS, $DOMFICAIP]);
                   
                }*/

            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00    = null;
            
           // $stmtMSSQL01->closeCursor();
            //$stmtMSSQL01    = null;

        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getCargaTest(): '.$e;
        }

        $connMSSQL  = null;
    }

    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE CARGA TEST++++++++++++++++++++++++++";
    echo "\n";

    echo "INICIO getCargaTest() => ".date('Y-m-d H:i:s');
    getCargaTest();
    echo "\n";
    echo "FIN getCargaTest() => ".date('Y-m-d H:i:s');
    echo "\n";
?>