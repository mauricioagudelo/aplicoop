<!-- 
Apartado economia Kidekoop. Este script esta diseniado para la gestion de economia de Kidekoop
kidekoop.org
En concreto, muestra los consumos y cuotas de los socios de cada mes.
La gestion de los monederos que se puede hacer mediante el boton "Actualizar Monederos" no se recomienda utilizar
fuera del contexto del "cierre del mes". En futuras versiones se intentara capar esa opcion para evitar "falsos cierres de mes"
Autor: Leonidas Ioannidis
Contacto: leonidas@cryptolab.net
-->


<?php 
session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];

    $pyear = $_POST['year'];
    $pmes = $_POST['mes'];
    $nextmonth = $pmes+1;
    $fecha1 = $pyear . "-" . $nextmonth . "-01";
    
    
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
        </head>

        <body>
        <?php include 'menu.php'; ?>
        <div class="page">
        	<div class="container">
                <h1>Econom&iacute;a Kidekoop</h1>
                <form action="kidekoop.php" method="post" name="prod" id="prod">
                	<div class="row">
                		<div class="col-md-3">
   		                    <div class="form-group">
   		                    	<label for="year">Año</label>
   		                    	<select name="year" id="year" size="1" maxlength="30">
   		                    	<option value="">-- Seleccionar --</option>
   		                    	<?php
                                $select2 = "SELECT DISTINCT YEAR(data) FROM comanda";
                                $query2 = mysql_query($select2);
                                if (!$query2) {
                                    die('Invalid query2: ' . mysql_error());
                                }
                                while (list($years) = mysql_fetch_row($query2)) {
                                    if ($pyear == $years) {
                                        echo '<option value="' . $years . '" selected>' . $years . '</option>';
                                    } else {
                                        echo '<option value="' . $years . '">' . $years . '</option>';
                                    }
                                }
                                ?>
                            </select>
                    </div>
                </div>
                <div class="col-md-3">
   		                    <div class="form-group">
   		                    	<label for="mes">Mes</label>
   		                    	<select name="mes" id="mes" size="1" maxlength="30">
   		                    	<option value="">-- Seleccionar --</option>
   		                    	<?php
                                $select2 = "SELECT DISTINCT MONTH(data) mes FROM comanda ORDER BY mes ASC ";
                                $query2 = mysql_query($select2);
                                if (!$query2) {
                                    die('Invalid query2: ' . mysql_error());
                                }
                                while (list($meses) = mysql_fetch_row($query2)) {
                                    if ($pmes == $meses) {
                                        echo '<option value="' . $meses . '" selected>' . $meses . '</option>';
                                    } else {
                                        echo '<option value="' . $meses . '">' . $meses . '</option>';
                                    }
                                }
                                ?>
                            </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"><br>
                        <input type="submit" name="submit" value="ENVIAR">
                    </div>
                </div>
            </div>
            </form>

            <?php 
            //When form is send

            if (isset($_POST['year'])) {
                echo "<div><a class='button button--animated button--save u-mt-2 u-mb-1' href='actualizar_monederos.php?year=".$pyear."&month=".$pmes."' title='Actualizar Monederos'>Actualizar Monederos <i class='fa fa-plus-circle' aria-hidden='true'></i></a></div>";
            print ('<p class="alert alert--info"> Consumo mensual de Soci@s con domiciliacion</p>');
            print('<div class="table-responsive">
                    <table class="table table-condensed table-striped" >
                        <tr >
                            <td width="5%" class="u-text-semibold">No</td>
                            <td width="10%" class="u-text-semibold">Soci@</td>
                            <td width="25%" class="u-text-semibold">Nombre</td>
                            <td width="25%" class="u-text-semibold">IBAN</td>                            
                            <td width="10%" class="u-text-semibold u-text-right">Consumo</td>
                            <td width="10%" class="u-text-semibold u-text-right">Cuota</td>
                            <td width="20%" class="u-text-semibold u-text-right">TOTAL</td>
                        </tr>') ;     

            $sel="(
SELECT comanda.usuari, usuaris.components, usuaris.IBAN, SUM(comanda_linia.cistella * comanda_linia.preu), usuaris.kuota, SUM(comanda_linia.cistella * comanda_linia.preu) + usuaris.kuota
FROM comanda 
JOIN comanda_linia ON comanda.numero=comanda_linia.numero 
JOIN usuaris on comanda.usuari=usuaris.nom
WHERE YEAR(comanda.data) = " . $pyear . "  AND MONTH(comanda.data) = " . $pmes . " AND usuaris.domiciliacion = 1
GROUP BY comanda.usuari)
UNION
(
SELECT usuaris.nom, usuaris.components, usuaris.IBAN, '0', usuaris.kuota, usuaris.kuota
            FROM usuaris
            WHERE nom NOT IN (
            SELECT DISTINCT us.nom
                    FROM usuaris AS us
                    JOIN comanda ON us.nom=comanda.usuari
                    WHERE year(comanda.data) = " . $pyear . " AND MONTH(comanda.data) = " . $pmes . "
                 )  AND usuaris.tipus2 = 'actiu' AND usuaris.domiciliacion = 1 AND usuaris.fechaalta <='" . $fecha1 . "')";

            $result = mysql_query($sel);
            if (!$result) {
            die('Invalid query: ' . mysql_error());
            }
            $k = 0;
            while (list($socio, $nomsocio, $iban, $consumo, $cuota, $total) = mysql_fetch_row($result)) {
           ?>
           <tr>
                <td><?php echo $k + 1; ?></td>
                <td><?php echo $socio; ?></td>
                <td><?php echo $nomsocio; ?></td>
                <td><?php echo $iban; ?></td>
                <td class="u-text-right"><?php echo sprintf("%01.2f", $consumo); ?></td>
                <td class="u-text-right"><?php echo $cuota; ?></td>
                <td class="u-text-right"><?php echo sprintf("%01.2f", $total); ?></td>
            </tr>

            <?php
            $k++;
        }
        print ('</table></div>');

        $tot = "SELECT SUM(total)
FROM ((
SELECT comanda.usuari, usuaris.components, usuaris.IBAN, SUM(comanda_linia.cistella * comanda_linia.preu), usuaris.kuota, SUM(comanda_linia.cistella * comanda_linia.preu) + usuaris.kuota as total
FROM comanda 
JOIN comanda_linia ON comanda.numero=comanda_linia.numero 
JOIN usuaris on comanda.usuari=usuaris.nom
WHERE YEAR(comanda.data) = " . $pyear . "  AND MONTH(comanda.data) = " . $pmes . " AND usuaris.domiciliacion = 1
GROUP BY comanda.usuari)
UNION
(
SELECT usuaris.nom, usuaris.components, usuaris.IBAN, '0', usuaris.kuota, usuaris.kuota as total
            FROM usuaris
            WHERE nom NOT IN (
            SELECT DISTINCT us.nom
                    FROM usuaris AS us
                    JOIN comanda ON us.nom=comanda.usuari
                    WHERE year(comanda.data) = " . $pyear . " AND MONTH(comanda.data) = " . $pmes . "
                 )  AND usuaris.tipus2 = 'actiu' AND usuaris.domiciliacion = 1 AND usuaris.fechaalta <='" . $fecha1 . "' ORDER BY usuaris.IBAN DESC
))as sub";
        $result = mysql_query($tot);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
            }
        list($totalof1) = mysql_fetch_row($result);
        ?>
        <tr>
            <td>TOTAL : </td>
            <td> <?php echo sprintf("%01.2f", $totalof1); ?>€</td>
        </tr>

        <?php
        print ('<p class="alert alert--info"> Consumo mensual de Soci@s con monedero</p>');
        print('<div class="table-responsive">
                    <table class="table table-condensed table-striped" >
                        <tr>
                            <td width="5%" class="u-text-semibold">No</td>
                            <td width="15%" class="u-text-semibold">Soci@</td>
                            <td width="45%" class="u-text-semibold">Nombre</td>                       
                            <td width="10%" class="u-text-semibold u-text-right">Consumo</td>
                            <td width="10%" class="u-text-semibold u-text-right">Cuota</td>
                            <td width="15%" class="u-text-semibold u-text-right">TOTAL</td>
                        </tr>') ;     

            $sel="(SELECT comanda.usuari, usuaris.components, SUM(comanda_linia.cistella * comanda_linia.preu), usuaris.kuota, SUM(comanda_linia.cistella * comanda_linia.preu) + usuaris.kuota as total
            FROM comanda 
            JOIN comanda_linia ON comanda.numero=comanda_linia.numero 
            JOIN usuaris on comanda.usuari=usuaris.nom
            WHERE YEAR(comanda.data) = ".$pyear."  AND MONTH(comanda.data) = ".$pmes." AND usuaris.domiciliacion = 0
            GROUP BY comanda.usuari)
UNION
     (SELECT usuaris.nom, usuaris.components, '0', usuaris.kuota,usuaris.kuota
            FROM usuaris
            WHERE nom NOT IN (
            SELECT DISTINCT us.nom
                    FROM usuaris AS us
                    JOIN comanda ON us.nom=comanda.usuari
                    WHERE year(comanda.data) = ".$pyear." AND MONTH(comanda.data) = ".$pmes."
                 )  AND usuaris.tipus2 = 'actiu' AND usuaris.domiciliacion = 0 AND usuaris.kuota != 0 AND usuaris.fechaalta <'".$fecha1."')";

            $result = mysql_query($sel);
            if (!$result) {
            die('Invalid query: ' . mysql_error());
            }
            $k = 0;
            while (list($socio, $nomsocio, $consumo, $cuota, $total) = mysql_fetch_row($result)) {
            ?>
           <tr>
                <td><?php echo $k +1; ?></td>
                <td><?php echo $socio; ?></td>
                <td><?php echo $nomsocio; ?></td>
                <!--<td><?php echo $subcat; ?></td>-->
                <td class="u-text-right"><?php echo sprintf("%01.2f", $consumo); ?></td>
                <td class="u-text-right"><?php echo $cuota; ?></td>
                <td class="u-text-right"><?php echo sprintf("%01.2f", $total); ?></td>
            </tr>

            <?php
            $k++;
        }
        print ('</table></div>');

        $tot = "SELECT SUM(total) FROM (
            (SELECT comanda.usuari, usuaris.components, SUM(comanda_linia.cistella * comanda_linia.preu), usuaris.kuota, SUM(comanda_linia.cistella * comanda_linia.preu) + usuaris.kuota as total
            FROM comanda 
            JOIN comanda_linia ON comanda.numero=comanda_linia.numero 
            JOIN usuaris on comanda.usuari=usuaris.nom
            WHERE YEAR(comanda.data) = ".$pyear."  AND MONTH(comanda.data) = ".$pmes." AND usuaris.domiciliacion = 0
            GROUP BY comanda.usuari)
UNION
     (SELECT usuaris.nom, usuaris.components, '0', usuaris.kuota,usuaris.kuota as total
            FROM usuaris
            WHERE nom NOT IN (
            SELECT DISTINCT us.nom
                    FROM usuaris AS us
                    JOIN comanda ON us.nom=comanda.usuari
                    WHERE year(comanda.data) = ".$pyear." AND MONTH(comanda.data) = ".$pmes."
                 )  AND usuaris.tipus2 = 'actiu' AND usuaris.domiciliacion = 0 AND usuaris.kuota != 0 AND usuaris.fechaalta <'".$fecha1."')) as sub";  
        $result = mysql_query($tot);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
            }
        list($totalof3) = mysql_fetch_row($result);
        ?>
        <tr>
            <td>TOTAL : </td>
            <td> <?php echo sprintf("%01.2f", $totalof3); ?>€</td>
        </tr>
        
        
        <?php
        
    }
    $result = mysql_query("SELECT COUNT(nom) FROM usuaris WHERE MONTH(fechaalta) = MONTH('" . $pyear . "-" . $pmes . "-" . "01" . "') AND YEAR(fechaalta) = YEAR('" . $pyear . "-" . $pmes . "-" . "01" . "')");
    if (!$result) {
            die('Invalid query: ' . mysql_error());
            }
    list($count) = mysql_fetch_row($result);
    $nuevas_altas = $count*20;
    echo "<p>Este més ha havido : " . $count . " nuevas altas con un total importe de : " . $nuevas_altas . " €</p>";
    $overall = $totalof1 + $totalof3 + $nuevas_altas;
    echo "<p>TOTAL de facturas, cuotas y nuevas altas : ". sprintf("%01.2f", $overall) . "€</p>";
    print('</div></div>');
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
