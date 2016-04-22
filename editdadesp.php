<?php

session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];
    $superuser = strtoupper($_SESSION['user']);

    $nom = $_GET['id'];

    $modcdp = '';
    $hidden = "";
    $hidden2 = "";
    $hidden3 = "";
    $new = "";

    if ($nom == "" OR $nom == $user) {
        $nom = $user;
        $link = ">><a href='families.php'>llistat famílies</a>";
        $modcdp = '<button class="button button--animated"  onclick="javascript:window.location = \'editpass.php\';">Modificar contraseña</button>';
    } else {
        $link = ">><a href='editfamilies3.php'>crear y editar socios/as</a>";
    }

    $supernom = strtoupper($nom);

    $p_tip = $_POST['tipus'];
    $p_tip2 = $_POST['tip2'];
    $p_dia = $_POST['dia'];
    $p_comp = $_POST['comp'];
    $p_tlf1 = $_POST['tlf1'];
    $p_tlf2 = $_POST['tlf2'];
    $p_email1 = $_POST['email1'];
    $p_email2 = $_POST['email2'];
    $p_nomf = $_POST['nomf'];
    $p_adressf = $_POST['adressf'];
    $p_niff = $_POST['niff'];
    $p_nota = $_POST['nota'];


    include('config/configuracio.php');

    ?>

    <html>
    <head>
        <?php include 'head.php'; ?>
        <title>aplicoop - editar familia</title>
    </head>

    <body>
    <?php include 'menu.php'; ?>
    <div class="page">
        <div class="container">


            <div class="u-cf">
                <h1 class="pull-left"> Editar família <?php echo $supernom; ?> </h1>

                <div class="pull-right u-mt-1">
                   <?php echo $modcdp; ?>
                </div>
            </div>

            <?php
            if ($p_tip2 != "" OR $p_dia != "" OR $p_comp != "" OR $p_tip != "") {
                $query2 = "UPDATE usuaris
	SET tipus='" . $p_tip . "', tipus2='" . $p_tip2 . "', dia='" . $p_dia . "', components='" . $p_comp . "',
	tel1='" . $p_tlf1 . "', tel2='" . $p_tlf2 . "', email1='" . $p_email1 . "', email2='" . $p_email2 . "',
	nomf='" . $p_nomf . "', adressf='" . $p_adressf . "', niff='" . $p_niff . "',
	nota='" . $p_nota . "'
	WHERE nom='" . $nom . "' ";

                mysql_query($query2) or die('Error, insert query2 failed');

                echo "<p class='error' style='font-size: 14px;'>Los cambios de socio/a " . $supernom . " se han guardado correctamente</p>";

            }
            ?>

            <div class="box">
                <form action="editdadesp.php?id=<?php echo $nom; ?>" method="post" name="frmeditdadesp"
                      id="frmeditdadesp">

                    <table style="padding: 10px;" width="100%" align="center" cellspading="5" cellspacing="5">

                        <?php

                        $select = "SELECT nom,tipus,tipus2,dia,components,tel1,tel2,email1,email2,nomf,adressf,niff,nota
FROM usuaris WHERE nom='$nom'";

                        $query = mysql_query($select);

                        if (!$query) {
                            die('Invalid query: ' . mysql_error());
                        }

                        list($nom, $tip, $tip2, $dia, $comp, $tlf1, $tlf2, $email1, $email2, $nomf, $adressf, $niff, $nota) = mysql_fetch_row($query);

                        if ($nom == "" OR $nom == $user) {
                            $hidden = '<input type="hidden" name="tip2" id="tip2" value="' . $tip2 . '">';
                            $hidden2 = '<input type="hidden" name="dia" id="dia" value="' . $dia . '">';
                            $hidden3 = '<input type="hidden" name="tipus" id="tipus" value="' . $tip . '">';
                            $new = "2";
                        }

                        ?>

                        <tr>
                            <td class="cos_majus">Actiu/Baixa</td>
                            <td class="cos">
                                <SELECT name="tip2<?php echo $new; ?>" id="tip2<?php echo $new; ?>" size="1"
                                        maxlength="5">

                                    <?php
                                    if ($tip2 == 'actiu') {
                                        $checked1 = 'selected';
                                        $checked2 = "";
                                    }
                                    if ($tip2 == 'baixa') {
                                        $checked2 = 'selected';
                                        $checked1 = "";
                                    }
                                    ?>

                                    <option value="actiu" <?php echo $checked1; ?>>activo</option>
                                    <option value="baixa" <?php echo $checked2; ?>>baja</option>
                                </select>
                                <?php echo $hidden; ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="cos_majus">Grup</td>
                            <td class="cos">
                                <SELECT name="dia<?php echo $new; ?>" id="dia<?php echo $new; ?>" size="1"
                                        maxlength="12">

                                    <?php
                                    $select3 = "SELECT nom FROM grups ORDER BY nom";
                                    $query3 = mysql_query($select3);
                                    if (!$query3) {
                                        die('Invalid query3: ' . mysql_error());
                                    }

                                    while (list($sgrup) = mysql_fetch_row($query3)) {
                                        if ($dia == $sgrup) {
                                            echo '<option value="' . $sgrup . '" selected>' . $sgrup . '</option>';
                                        } else {
                                            echo '<option value="' . $sgrup . '">' . $sgrup . '</option>';
                                        }
                                    }
                                    ?>

                                </select>
                                <?php echo $hidden2; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="cos_majus">Tipus d'usuari (permisos)</td>
                            <td class="cos">
                                <SELECT name="tipus<?php echo $new; ?>" id="tipus<?php echo $new; ?>" size="1"
                                        maxlength="10">
                                    <?php
                                    if ($tip == 'user') {
                                        $checked3 = 'selected';
                                        $checked4 = "";
                                        $checked5 = "";
                                        $checked6 = "";
                                        $checked7 = "";
                                        $checked8 = "";
                                    } elseif ($tip == 'admin') {
                                        $checked3 = '';
                                        $checked4 = "selected";
                                        $checked5 = "";
                                        $checked6 = "";
                                        $checked7 = "";
                                        $checked8 = "";
                                    } elseif ($tip == 'eco') {
                                        $checked3 = '';
                                        $checked4 = "";
                                        $checked5 = "selected";
                                        $checked6 = "";
                                        $checked7 = "";
                                        $checked8 = "";
                                    } elseif ($tip == 'prov') {
                                        $checked3 = '';
                                        $checked4 = "";
                                        $checked5 = "";
                                        $checked6 = "selected";
                                        $checked7 = "";
                                        $checked8 = "";
                                    } elseif ($tip == 'cist') {
                                        $checked3 = '';
                                        $checked4 = "";
                                        $checked5 = "";
                                        $checked6 = "";
                                        $checked7 = "selected";
                                        $checked8 = "";
                                    } elseif ($tip == 'super') {
                                        $checked3 = '';
                                        $checked4 = "";
                                        $checked5 = "";
                                        $checked6 = "";
                                        $checked7 = "";
                                        $checked8 = "selected";
                                    }
                                    echo '
<option value="user" ' . $checked3 . '>user</option>
<option value="admin" ' . $checked4 . '>admin</option>
<option value="eco" ' . $checked5 . '>eco</option>
<option value="prov" ' . $checked6 . '>prov</option>
<option value="cist" ' . $checked7 . '>cist</option>
<option value="super" ' . $checked8 . '>super</option>';
                                    ?>

                                </select>
                                <?php echo $hidden3; ?>
                            </td>
                        </tr>
                        <tr class="cos_majus">
                            <td>Components de la família</td>
                            <td>
                                <input type="text" name="comp" value="<?php echo $comp; ?>" size="30" maxlength="100">
                            </td>
                        </tr>
                        <tr class="cos_majus">
                            <td>Telèfon 1</td>
                            <td>
                                <input type="text" name="tlf1" value="<?php echo $tlf1; ?>" size="9" maxlength="9"></td>
                        </tr>
                        <tr class="cos_majus">
                            <td>Telèfon 2</td>
                            <td>
                                <input type="text" name="tlf2" value="<?php echo $tlf2; ?>" size="9" maxlength="9"></td>
                        </tr>
                        <tr class="cos_majus">
                            <td>E-mail 1</td>
                            <td>
                                <input type="text" name="email1" value="<?php echo $email1; ?>" size="30"
                                       maxlength="50"></td>
                        </tr>
                        <tr class="cos_majus">
                            <td>E-mail 2</td>
                            <td>
                                <input type="text" name="email2" value="<?php echo $email2; ?>" size="30"
                                       maxlength="50"></td>
                        </tr>
                        <tr class="cos_majus">
                            <td>Nom a efectes de la factura</td>
                            <td>
                                <input type="text" name="nomf" value="<?php echo $nomf; ?>" size="30" maxlength="100">
                            </td>
                        </tr>
                        <tr class="cos_majus">
                            <td>Adreça a efectes de la factura</td>
                            <td>
                                <input type="text" name="adressf" value="<?php echo $adressf; ?>" size="30"
                                       maxlength="200"></td>
                        </tr>
                        <tr class="cos_majus">
                            <td>NIF a efectes de la factura</td>
                            <td>
                                <input type="text" name="niff" value="<?php echo $niff; ?>" size="9" maxlength="9"></td>
                        </tr>
                        <tr class="cos_majus">
                            <td>comentaris</td>
                            <td>
                                <textarea name="nota" cols="35" rows="4" id="nota"><?php echo $nota; ?></textarea></td>
                        </tr>
                    </table>

                    <div class="u-text-center u-mt-1">
                        <button class="button button--animated button--save" type="submit">Guardar <i class="fa fa-floppy-o" aria-hidden="true"></i></button>

                    </div>
            </div>

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