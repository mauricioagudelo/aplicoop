<?php 
session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];

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
   		                    	<div>
   		                    	<SELECT name="year" id="year" size="1" maxlength="30" onChange="this.form.submit()">
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
                </div>
                <div class="col-md-3">
   		                    <div class="form-group">
   		                    	<label for="mes">Mes</label>
   		                    	<div>
   		                    	<SELECT name="mes" id="mes" size="1" maxlength="30" onChange="this.form.submit()">
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
                </div>


            </div>
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
