<?php 
session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];

    $pyear = $_POST['year'];
    $pmes = $_POST['mes'];

    include 'config/configuracio.php';

    $sel = "SELECT tipus FROM usuaris WHERE nom='$user'";
    $query = mysql_query($sel) or die ('query failed: ' . mysql_error());
    list($priv) = mysql_fetch_row($query);

///sólo entramos si somos "super"////

        if ($priv == 'super') {

        if ($priv != 'user') {
            $h1 = "";
        } else {
            $h1 = "href=''";
        }

        if ($priv == 'admin' OR $priv == 'super') {
            $h2 = "href='editfamilies3.php'";
        } else {
            $h2 = "href=''";
        }

        if ($priv == 'eco' OR $priv == 'super') {
            $h4 = "href='moneder_linia.php'";
            $h5 = "href='devolucions.php'";
        } else {
            $h4 = "href=''";
            $h5 = "href=''";
        }
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
            if (isset($_POST['year'])) {
            print ('<p class="alert alert--info"> Consumo mensual de Soci@s con domiciliacion</p>');
            print('<div class="table-responsive">
                    <table class="table table-condensed table-striped" >
                        <tr >
                            <td width="5%" class="u-text-semibold">No</td>
                            <td width="10%" class="u-text-semibold">Soci@</td>
                            <td width="25%" class="u-text-semibold">Nombre</td>
                            <td width="25%" class="u-text-semibold">IBAN</td>                            
                            <td width="10%" class="u-text-semibold u-text-right">Consumo</td>
                            <td width="5%" class="u-text-semibold u-text-right">Cuota</td>
                            <td width="20%" class="u-text-semibold u-text-right">TOTAL</td>
                        </tr>') ;     

            $sel="SELECT comanda.usuari, usuaris.components, usuaris.IBAN, SUM(comanda_linia.cistella * comanda_linia.preu), usuaris.kuota, SUM(comanda_linia.cistella * comanda_linia.preu) + usuaris.kuota
            FROM comanda 
            JOIN comanda_linia ON comanda.numero=comanda_linia.numero 
            JOIN usuaris on comanda.usuari=usuaris.nom
            WHERE YEAR(comanda.data) = '$pyear'  AND MONTH(comanda.data) = '$pmes' AND usuaris.domiciliacion = 1
            GROUP BY comanda.usuari
            ORDER BY comanda.usuari";

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
                <td class="u-text-right"><?php echo $consumo; ?></td>
                <td class="u-text-right"><?php echo $cuota; ?> €</td>
                <td class="u-text-right"><?php echo $total; ?></td>
            </tr>

            <?php
            $k++;
        }
        print ('</table></div>');
        ?>

        <?php
        print ('<p class="alert alert--info"> Consumo mensual de Soci@s con monedero</p>');
        print('<div class="table-responsive">
                    <table class="table table-condensed table-striped" >
                        <tr>
                            <td width="5%" class="u-text-semibold">No</td>
                            <td width="15%" class="u-text-semibold">Soci@</td>
                            <td width="45%" class="u-text-semibold">Nombre</td>                       
                            <td width="10%" class="u-text-semibold u-text-right">Consumo</td>
                            <td width="5%" class="u-text-semibold u-text-right">Cuota</td>
                            <td width="20%" class="u-text-semibold u-text-right">TOTAL</td>
                        </tr>') ;     

    $sel="SELECT comanda.usuari, usuaris.components, SUM(comanda_linia.cistella * comanda_linia.preu), usuaris.kuota, SUM(comanda_linia.cistella * comanda_linia.preu) + usuaris.kuota
            FROM comanda 
            JOIN comanda_linia ON comanda.numero=comanda_linia.numero 
            JOIN usuaris on comanda.usuari=usuaris.nom
            WHERE YEAR(comanda.data) = '$pyear'  AND MONTH(comanda.data) = '$pmes' AND usuaris.domiciliacion = 0
            GROUP BY comanda.usuari
            ORDER BY comanda.usuari";

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
                <td class="u-text-right"><?php echo $consumo; ?></td>
                <td class="u-text-right"><?php echo $cuota; ?> €</td>
                <td class="u-text-right"><?php echo $total; ?></td>
            </tr>

            <?php
            $k++;
        }
        print ('</table></div>');

        print ('<p class="alert alert--info"> Cuota mensual de Soci@s activ@s con domiciliacion y sin consumo</p>');
        print('<div class="table-responsive">
                    <table class="table table-condensed table-striped" >
                        <tr>
                            <td width="5%" class="u-text-semibold">No</td>
                            <td width="15%" class="u-text-semibold">Soci@</td>
                            <td width="40%" class="u-text-semibold">Nombre</td>                       
                            <td width="30%" class="u-text-semibold">IBAN</td>                       
                            <td width="10%" class="u-text-semibold u-text-right">Cuota</td>
                        </tr>') ;     

        
            $sel="SELECT usuaris.nom, usuaris.components, usuaris.IBAN, usuaris.kuota
            FROM usuaris
            WHERE nom NOT IN (
            SELECT DISTINCT us.nom
                    FROM usuaris AS us
                    JOIN comanda ON us.nom=comanda.usuari
                    WHERE year(comanda.data) = " . $pyear . " AND MONTH(comanda.data) = " . $pmes . "
                 )  AND usuaris.tipus2 = 'actiu' AND usuaris.domiciliacion = 1
                 ORDER BY usuaris.IBAN DESC";
            $result = mysql_query($sel);
            if (!$result) {
            die('Invalid query: ' . mysql_error());
            }
            $k = 0;
            while (list($socio, $nomsocio, $iban, $cuota) = mysql_fetch_row($result)) {
                ?>
           <tr>
                <td><?php echo $k +1; ?></td>
                <td><?php echo $socio; ?></td>
                <td><?php echo $nomsocio; ?></td>
                <td><?php echo $iban; ?></td>
                <td class="u-text-right"><?php echo $cuota; ?> €</td>
            </tr>

            <?php
            $k++;
        }

        print ('</table></div>');

        print ('<p class="alert alert--info"> Cuota mensual de Soci@s activ@s con monedero y sin consumo</p>');
        print('<div class="table-responsive">
                    <table class="table table-condensed table-striped" >
                        <tr>
                            <td width="5%" class="u-text-semibold">No</td>
                            <td width="15%" class="u-text-semibold">Soci@</td>
                            <td width="40%" class="u-text-semibold">Nombre</td>                       
                            <td width="30%" class="u-text-semibold">IBAN</td>                       
                            <td width="10%" class="u-text-semibold u-text-right">Cuota</td>
                        </tr>') ;     
            $sel="SELECT usuaris.nom, usuaris.components, usuaris.IBAN, usuaris.kuota
            FROM usuaris
            WHERE nom NOT IN (
            SELECT DISTINCT us.nom
                    FROM usuaris AS us
                    JOIN comanda ON us.nom=comanda.usuari
                    WHERE year(comanda.data) = " . $pyear . " AND MONTH(comanda.data) = " . $pmes . "
                 )  AND usuaris.tipus2 = 'actiu' AND usuaris.domiciliacion = 0
                 ORDER BY usuaris.IBAN DESC";
            $result = mysql_query($sel);
            if (!$result) {
            die('Invalid query: ' . mysql_error());
            }
            $k = 0;
            while (list($socio, $nomsocio, $iban, $cuota) = mysql_fetch_row($result)) {
                ?>
           <tr>
                <td><?php echo $k +1; ?></td>
                <td><?php echo $socio; ?></td>
                <td><?php echo $nomsocio; ?></td>
                <td><?php echo $iban; ?></td>
                <td class="u-text-right"><?php echo $cuota; ?> €</td>
            </tr>

            <?php
            $k++;
        }

        print ('</table></div>');

        print('</div></div>');
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
