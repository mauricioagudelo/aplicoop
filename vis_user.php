<?php

session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];

    $nom = $_GET['id'];
    $supernom = strtoupper($nom);

    include 'config/configuracio.php';

    $select = "SELECT nom,tipus,tipus2,dia,components,tel1,tel2,email1,email2,nomf,adressf,niff,nota FROM usuaris WHERE nom='$nom'";

    $query = mysql_query($select);

    if (!$query) {
        die('Invalid query: ' . mysql_error());
    }

    list($nom, $tip, $tip2, $dia, $components, $tel1, $tel2, $email1, $email2, $nomf, $adressf, $niff, $nota) = mysql_fetch_row($query);

    ?>

    <html>
    <head>
        <?php include 'head.php'; ?>
        <title>aplicoop - ficha</title>
    </head>

    <body>
    <?php include 'menu.php'; ?>

    <div class="page">
        <div class="container">

            <h1>Ver Socio/a: <?php echo $nom; ?></h1>

            <div class="box">

                <table class="table table-striped">
                    <tr class="cos_majus">
                        <td width="50%" class="u-text-semibold u-text-right u-text-right">Nombre:</td>
                        <td width="50%"  ><?php echo $nom; ?></td>
                    </tr>
                    <tr class="cos_majus">
                        <td class="u-text-semibold u-text-right">D&iacute;a de recogida:</td>
                        <td ><?php echo $dia; ?></td>
                    </tr>
                    <tr class="cos_majus">
                        <td class="u-text-semibold u-text-right">Componentes:</td>
                        <td ><?php echo $components; ?></td>
                    </tr>
                    <tr class="cos_majus">
                        <td class="u-text-semibold u-text-right">Tel&eacute;fono principal:</td>
                        <td ><?php echo $tel1; ?></td>
                    </tr>
                    <tr class="cos_majus">
                        <td class="u-text-semibold u-text-right">Tel&eacute;fono alternativo:</td>
                        <td ><?php echo $tel2; ?></td>
                    </tr>
                    <tr>
                        <td class="u-text-semibold u-text-right">e-mail principal:</td>
                        <td class="cos" ><?php echo $email1; ?></td>
                    </tr>
                    <tr>
                        <td class="u-text-semibold u-text-right">e-mail alternativo:</td>
                        <td class="cos" ><?php echo $email2; ?></td>
                    </tr>
                    <tr>
                        <td class="u-text-semibold u-text-right">Nombre para la factura:</td>
                        <td class="cos" ><?php echo $nomf; ?></td>
                    </tr>
                    <tr>
                        <td class="u-text-semibold u-text-right">Direcci&oacute;n para la factura:</td>
                        <td class="cos" ><?php echo $adressf; ?></td>
                    </tr>
                    <tr>
                        <td class="u-text-semibold u-text-right">NIF para la factura:</td>
                        <td class="cos" ><?php echo $niff; ?></td>
                    </tr>
                    <tr>
                        <td class="u-text-semibold u-text-right">Comentarios:</td>
                        <td class="cos" ><?php echo $nota; ?></td>
                    </tr>
                    <tr>
                        <td  class="u-text-semibold u-text-right">Permisos:</td>
                        <td ><?php echo $tip; ?></td>
                    </tr>
                </table>



            </div>

            <?php
            if ($nom == $user) {

                ?>

                <div class="u-text-center">
                    <button class="button button--animated" onClick="javascript:window.location = 'editdadesp.php';">editar  <i class="fa fa-pencil" aria-hidden="true"></i></button>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
    </body>
    </html>

    <?php
    include 'config/disconect.php';
} else {
    header("Location: index.php");
}
?>