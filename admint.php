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

        <html lang="es">
        <head>
            <?php include 'head.php'; ?>
            <title>aplicoop - admin</title>
        </head>

        <body>
        <?php include 'menu.php'; ?>
        <div class="page">
            <div class="container">
                <h1>Administració</h1>

                <div class="box">

                    <div class="row">
                        <div class="col-md-4">
                            <h2 class="box-subtitle">Comandes</h2>
                            <ul type="circle">
                                <li><a class="link" href='grups_comandes.php'>Grups de comandes i cistelles</a></li>
                                <li><a class="link" href='comandes.php'>Llista de comandes i factures</a></li>
                                <li><a class="link" <?php echo $h5; ?>>Devolucions i factures fora procés</a></li>
                            </ul>

                            <h2 class="box-subtitle">Famílies</h2>
                            <ul type="circle">
                                <li><a class="link" href='families.php'>Llista famílies/as</a></li>
                                <li><a class="link" <?php echo $h2; ?>>Crear i editar famílies</a></li>
                            </ul>

                            <h2 class="box-subtitle">Comunicacions</h2>
                            <ul type="circle">
                                <li><a class="link" href='notes.php'>Introduir notes a l'escriptori</a></li>
                                <li><a class="link" href='cistella_incidencia.php'>Comunicació incidències</a>
                                </li>
                            </ul>

                            <h2 class="box-subtitle">Moneder</h2>
                            <ul type="circle">
                                <li><a class="link" <?php echo $h4; ?>>Introduir línia</a></li>
                                <li><a class="link" href="comptes.php">Història moviments</a></li>
                                <li><a class="link" href="moneder_usuari.php">Llista moneder famílies</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h2 class="box-subtitle">Processos</h2>
                            <ul type="circle">
                                <li><a class="link" href='editprocessos.php'>Crear, editar, eliminar processos</a></li>
                                <li><a class="link" href='associar.php'>Associar processos, grups i categories</a>
                                </li>
                            </ul>
                            <h2 class="box-subtitle">Grups</h2>
                            <ul type="circle">
                                <li><a class="link" href='editgrups.php'>Crear, editar, eliminar grups</a></li>
                            </ul>
                            <h2 class="box-subtitle">Categories i subcategories</h2>
                            <ul type="circle">
                                <li><a class="link" href='categories.php'>Crear, editar, eliminar categories i subcategories</a></li>
                            </ul>
                            <h2 class="box-subtitle">Estadística</h2>
                            <ul type="circle">
                                <li><a class="link" href='estat_consum.php'>Estadística consum</a></li>
                                <li><a class="link" href='estat_iva.php'>Consum IVA</a></li>
                                <li><a class="link" href='estat_iva_prov.php'>Consum IVA (prov.)</a></li>
                            </ul>
                            <h2 class="box-subtitle">Economia Kidekoop</h2>
                            <ul type="circle">
                                <li><a class="link" href='kidekoop.php'>Tancament del mes</a></li>
                                <li><a class="link" href='balances_socios.php'>Balanços de Socis</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h2 class="box-subtitle">Productes</h2>
                            <ul type="circle">
                                <li><a class="link" href='baixa_productes.php'>Activar/desactivar productes</a></li>
                                <li><a class="link" href='productes.php'>Crear, editar, eliminar productes</a></li>
                                <li><a class="link" href='canvi_massiu_productes.php'>Canviar preus, iva i marge en llistat</a></li>
                            </ul>
                            <h2 class="box-subtitle">Proveïdores</h2>
                            <ul type="circle">
                                <li><a class="link" href='proveidores.php'>Crear, editar, eliminar proveïdores</a></li>

                            </ul>
                            <h2 class="box-subtitle">Albarans</h2>
                            <ul type="circle">
                                <li><a class="link" href='albarans.php'>Crear, editar, eliminar albarans</a></li>
                            </ul>

                            <h2 class="box-subtitle">Estoc</h2>
                            <ul type="circle">
                                <li><a class="link" href='inventari2.php'>Veure estoc actual</a></li>
                            </ul>
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
