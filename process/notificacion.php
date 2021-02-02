<?php
    require __DIR__.'/../src/connect.php';

    $DOMFICAUS  = 'SFHOLOX';
    $DOMFICAIP  = '0.0.0.0';
    $NOTMENOBS  = '';

    function getMensaje(){
        global $DOMFICEST;
        global $DOMFICORD;
        global $DOMFICAUS;
        global $DOMFICAIP;
        global $NOTMENOBS;
       
        
        $sql00  =   "SELECT 
            a.NOTFICCOD     AS  notificacion_codigo,
            a.NOTFICORD     AS  notificacion_orden,  	
            a.NOTFICPAC     AS  notificacion_parametro,
            a.NOTFICTIT     AS  notificacion_titulo,	
            a.NOTFICDES     AS  notificacion_descripcion,	
            a.NOTFICFED     AS  notificacion_fecha_desde,	
            a.NOTFICFEH     AS  notificacion_fecha_hasta,
            a.NOTFICFCA     AS  notificacion_fecha_carga,
            a.NOTFICOBS     AS  notificacion_observacion,
                
            a.NOTFICAUS     AS  auditoria_usuario,
            a.NOTFICAFH     AS  auditoria_fecha_hora,	
            a.NOTFICAIP     AS  auditoria_ip,
            
            b.DOMFICCOD     AS  tipo_estado_codigo,
            b.DOMFICORD     AS  tipo_estado_orden,
            b.DOMFICNOI     AS  tipo_estado_ingles,
            b.DOMFICNOC     AS  tipo_estado_castellano,
            b.DOMFICNOP     AS  tipo_estado_portugues,
            b.DOMFICPAT     AS  tipo_estado_path,
            b.DOMFICVAL     AS  tipo_estado_dominio,
            b.DOMFICPAR     AS  tipo_estado_parametro,
            b.DOMFICOBS     AS  tipo_estado_observacion,
            
            c.DOMFICCOD     AS  tipo_notificacion_codigo,
            c.DOMFICORD     AS  tipo_notificacion_orden,
            c.DOMFICNOI     AS  tipo_notificacion_ingles,
            c.DOMFICNOC     AS  tipo_notificacion_castellano,
            c.DOMFICNOP     AS  tipo_notificacion_portugues,
            c.DOMFICPAT     AS  tipo_notificacion_path,
            c.DOMFICVAL     AS  tipo_notificacion_dominio,
            c.DOMFICPAR     AS  tipo_notificacion_parametro,
            c.DOMFICOBS     AS  tipo_notificacion_observacion,
            
            d.DOMFICCOD     AS  tipo_test_codigo,
            d.DOMFICORD     AS  tipo_test_orden,
            d.DOMFICNOI     AS  tipo_test_ingles,
            d.DOMFICNOC     AS  tipo_test_castellano,
            d.DOMFICNOP     AS  tipo_test_portugues,
            d.DOMFICPAT     AS  tipo_test_path,
            d.DOMFICVAL     AS  tipo_test_dominio,
            d.DOMFICPAR     AS  tipo_test_parametro,
            d.DOMFICOBS     AS  tipo_test_observacion
            
            FROM [adm].[NOTFIC] a

            INNER JOIN [adm].[DOMFIC] b ON a.NOTFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.NOTFICTNC = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON a.NOTFICTTC = d.DOMFICCOD
            
            WHERE b.DOMFICPAR = 1 AND c.DOMFICPAR = 2 AND a.NOTFICFED >= CONVERT(varchar(10), GETDATE(), 23) AND a.NOTFICFEH <= CONVERT(varchar(10), GETDATE(), 23)
     
            ORDER BY a.NOTFICCOD ASC";
            echo "antes de la conexion mensaje=> ";
        try {
            $connMSSQL  = getConnectionMSSQLv1();
            echo "dentro de la conexion mensaje=> ";
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00    = null;

        } catch (PDOException $e) {
            echo "exception  mensaje=> ";
            echo "\n";
            echo 'Error getMensaje(): '.$e;
        }

        $connMSSQL  = null;
        echo "sale  mensaje=> ";
    }

    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE NOTIFICACIÓN++++++++++++++++++++++++++";

    echo "INICIO getMensaje() => ".date('Y-m-d H:i:s');
    getMensaje();
    echo "\n";
    echo "FIN getMensaje() => ".date('Y-m-d H:i:s');
    echo "\n";
?>