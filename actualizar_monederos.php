<?php 
session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];
    date_default_timezone_set('Europe/Madrid');
    $session = date("Y-m-d H:i:s", $_SESSION['timeinitse']);
    $data = date("Y-m-d", $_SESSION['timeinitse']);

    $pyear = $_GET['year'];
    $pmes = $_GET['month'];
    
    include 'config/configuracio.php';

    $sel = "SELECT tipus FROM usuaris WHERE nom='$user'";
    $query = mysql_query($sel) or die ('query failed: ' . mysql_error());
    list($priv) = mysql_fetch_row($query);

///sólo entramos si somos "super"////

        if ($priv == 'super') {

        ?>

        <html>
        <head>
            <?php include 'head.php'; ?>
            <title>Econom&iacute;a - Kidekoop</title>
            <script>var respuesta = confirm('Esta operación no se puede deshacer, ¿Estás seguro que quieres seguir?');
            if (respuesta == false) {
            	alert('Operación cancelada.');
            	window.location = "kidekoop.php";
            }
            </script>
        </head>

        <body>
        <?php include 'menu.php'; ?>
        <div class="page">
        <p>Actualizando Monederos ...</p>
        <?php
        //Check that this is the first time
        $concepto = "Ordainketa (dom.) ".$pmes.'/'.$pyear;
        $query_check = "SELECT familia FROM moneder WHERE concepte = '$concepto'";
        $result = mysql_query($query_check);
        if (mysql_num_rows($result)==0) {
        	echo "<p>Consumos y cuotas liquidados por domiciliación bancária del més " . $pmes . "/" . $pyear ."</p>";
	        //Ordainketak
	        $concepto = "Ordainketa (dom.) ".$pmes.'/'.$pyear;
	        $notas = "hecho desde economia kidekoop";
	        $query = "SELECT comanda.usuari, SUM(comanda_linia.cistella * comanda_linia.preu), usuaris.kuota
	            FROM comanda 
	            JOIN comanda_linia ON comanda.numero=comanda_linia.numero 
	            JOIN usuaris on comanda.usuari=usuaris.nom
	            WHERE YEAR(comanda.data) = '$pyear'  AND MONTH(comanda.data) = '$pmes' AND usuaris.domiciliacion = 1
	            GROUP BY comanda.usuari";
			$result = mysql_query($query);
			if (!$result) {
	            die('Invalid query: ' . mysql_error());
	            }
	        while (list($socio,$consumo,$kuota) = mysql_fetch_row($result)) {
	        	$consumo = sprintf("%01.2f", $consumo);
	        	$total = $consumo + $kuota;
	        	echo $socio . " " . $consumo . " + " . $kuota . " = " . $total . "<br>";

	        	$query2 = "INSERT INTO moneder
	 			VALUES ('" . $session . "','" . $user . "','" . $data . "','" . $socio . "','" . $concepto . "','" . $total . "','" . $notas . "')";
	            mysql_query($query2) or die('Error, insert query2 failed');
	            //$query3 = "UPDATE usuaris SET moneder=moneder" . $signe . $absvalor . " WHERE nom = '" . $tfam . "'";
	            //mysql_query($query3) or die('Error, insert query4 failed');
	            //	print ("<p class='comment'>S'han " . $verb . " " . ABS($pvalor) . " euros a " . $tfam . " pel concepte " . $pconcepte . " </p>");
	        }

	        $query="SELECT usuaris.nom, usuaris.kuota
            FROM usuaris
            WHERE nom NOT IN (
            SELECT DISTINCT us.nom
                    FROM usuaris AS us
                    JOIN comanda ON us.nom=comanda.usuari
                    WHERE year(comanda.data) = " . $pyear . " AND MONTH(comanda.data) = " . $pmes . "
                 )  AND usuaris.tipus2 = 'actiu' AND usuaris.domiciliacion = 1";
            $result = mysql_query($query);
            if (!$result) {
            	die('Invalid query: ' . mysql_error());
            }
            
            while (list($socio, $kuota) = mysql_fetch_row($result)) {
            	echo $socio . " " . $kuota . "<br>";
            	$query2 = "INSERT INTO moneder
	 			VALUES ('" . $session . "','" . $user . "','" . $data . "','" . $socio . "','" . $concepto . "','" . $kuota . "','" . $notas . "')";
	            mysql_query($query2) or die('Error, insert query2 failed');
            }

	        //Kuotak
	        echo "<p>Kuotas del més : ". $pmes . "/" . $pyear . "</p>";
	        $concepto = "Kuota ".$pmes.'/'.$pyear;
	        $query = "SELECT nom,kuota FROM `usuaris` WHERE tipus2='actiu' AND kuota != 0";
	        $result = mysql_query($query);
			if (!$result) {
	            die('Invalid query: ' . mysql_error());
	            }
	        while (list($socio,$kuota) = mysql_fetch_row($result)) {
	        	echo $socio . " " . $kuota . "<br>";
	        	$query2 = "INSERT INTO moneder
	 			VALUES ('" . $session . "','" . $user . "','" . $data . "','" . $socio . "','" . $concepto . "','" . -$kuota . "','" . $notas . "')";
	 			mysql_query($query2) or die('Error, insert query2 failed');
			}
		}
		else {
			echo "<p>Esta operación parece que ha sido realizada. Cancelando ... </p><p><a href='kidekoop.php'>Volver</a>";

		}
        ?>
        </div>
        </body>
        </html>
    <?php
        include 'config/disconect.php';
    } else {
        header("Location: escriptori2.php");
    }
} else {
    header("Location: index.php");
}
?>