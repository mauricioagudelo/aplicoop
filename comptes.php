<?php

session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];
    $superuser = strtoupper($_SESSION['user']);

    $pfam = $_POST['fam'];
    $pdatas = $_POST['datas'];
    $pdatai = $_POST['datai'];

    $gcont = $_GET['id2'];
    $gfam = $_GET['id3'];
    $gpfam = $_GET['id4'];
    $gpdatas = $_GET['id5'];
    $gpdatai = $_GET['id6'];

    if ($gpfam != "") {
        $pfam = $gpfam;
    }
    if ($gcont != "") {
        $pdatas = $gpdatas;
        $pdatai = $gpdatai;
    }

    $superpfam = strtoupper($pfam);

    include 'config/configuracio.php';
    ?>

    <html>
    <head>
        <?php include 'head.php'; ?>
        <title>movimientos ::: la coope</title>

        <script type="text/javascript" src="calendar/calendar.js"></script>
        <script type="text/javascript" src="calendar/lang/calendar-es.js"></script>
        <script type="text/javascript" src="calendar/calendar-setup.js"></script>

    </head>

    <body>
    <?php include 'menu.php'; ?>
    <div class="page">

        <?php
        if ($gfam != "") {
            $title1 = 'Mis cuentas';
            $cap = 'Mis cuentas';
            $cap_link = 'comptes.php?id3=' . $user;
            $pfam = $gfam;
            $superpfam = strtoupper($gfam);

            //calcula realmente el total del moneder
            $select = "SELECT SUM(valor) AS total FROM moneder WHERE familia='" . $gfam . "'";
            $query = mysql_query($select);
            if (!$query) {
                die('Invalid query: ' . mysql_error());
            }
            list($mone) = mysql_fetch_row($query);
            $monea = "Monedero actual: " . $mone . "&#8364;";
        } else {
            $title1 = 'Listado de movimientos';
            $cap = 'Listado de movimientos';
            $cap_link = 'comptes.php';
        }
        ?>

        <div class="container">

            <h1><?php echo $title1; ?></h1>

            <form action="<?php echo $cap_link; ?>" method="post" name="prod" id="prod">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fam">Socio/a</label>
                            <div>
                                <?php
                                if ($gfam != "")
                                {
                                    ?>
                                    <input type="text" value="<?php echo $gfam; ?>" name="fam" id="fam" size="10"
                                           maxlength="30" readonly/>
                                    <?php
                                }
                                else
                                {
                                ?>
                                <select name="fam" id="fam" size="1" maxlength="30" onChange="this.form.submit()">
                                    <option value="">-- Seleccionar --</option>
                                    <?php
                                    $select3 = "SELECT nom FROM usuaris ORDER BY nom";
                                    $query3 = mysql_query($select3);
                                    if (!$query3) {
                                        die('Invalid query3: ' . mysql_error());
                                    }
                                    while (list($sfam) = mysql_fetch_row($query3)) {
                                        if ($pfam == $sfam) {
                                            echo '<option value="' . $sfam . '" selected>' . $sfam . '</option>';
                                            $select = "SELECT SUM(valor) AS total FROM moneder WHERE familia='" . $sfam . "'";
                                            $query = mysql_query($select);
                                            if (!$query) {
                                                die('Invalid query: ' . mysql_error());
                                            }
                                            list($mone) = mysql_fetch_row($query);
                                            $monea = "Monedero actual: " . $mone . "&#8364;";
                                        } else {
                                            echo '<option value="' . $sfam . '">' . $sfam . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Superior a</label>
                            <div>
                                <input type="text" value="<?php echo $pdatas; ?>" name="datas" id="f_date_a" size="8"
                                       maxlength="10" readonly/>
                                <div class="u-text-right u-mt-1">
                                    <button type="text" name="budi" id="f_trigger_a" class="button button--calendar"></button>
                                    <button type="submit" name="okds" id="okds" class="button button--animated">buscar</button>
                                    <script type="text/javascript">
                                        Calendar.setup({
                                            inputField: "f_date_a",     // id of the input field
                                            ifFormat: "%d/%m/%Y",     // format of the input field (even if hidden, this format will be honored)
                                            button: "f_trigger_a",  // trigger for the calendar (button ID)
                                            singleClick: true,
                                            weekNumbers: false
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Inferior a</label>
                            <div>
                                <input type="text" value="<?php echo $pdatai; ?>" name="datai" id="f_date_b" size="8"
                                       maxlength="10" readonly/>
                                <div class="u-text-right u-mt-1">
                                    <button type="text" name="budf" id="f_trigger_b"  class="button button--calendar"></button>
                                    <button type="submit" name="okdi" id="okdi"  class="button button--animated">buscar</button>
                                    <script type="text/javascript">
                                        Calendar.setup({
                                            inputField: "f_date_b",     // id of the input field
                                            ifFormat: "%d/%m/%Y",     // format of the input field (even if hidden, this format will be honored)
                                            button: "f_trigger_b",  // trigger for the calendar (button ID)
                                            singleClick: true,
                                            weekNumbers: false
                                        });
                                    </script>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </form>

            <div class="box">

                <?php
                if ($pfam != "" OR $pdatas != "" OR $pdatai != "") {
                    $datas2 = explode("/", $pdatas);
                    $datai2 = explode("/", $pdatai);
                    $datasup = $datas2[2] . "-" . $datas2[1] . "-" . $datas2[0];
                    $datainf = $datai2[2] . "-" . $datai2[1] . "-" . $datai2[0];

                    if ($pfam != "" AND $pdatas == "" AND $pdatai == "") {
                        $where = "WHERE familia='" . $pfam . "'";
                        $title = "B&uacute;squeda por socio/a: " . $superpfam;
                    } elseif ($pfam != "" AND $pdatas != "" AND $pdatai == "") {
                        $where = "WHERE familia='" . $pfam . "' AND data>='" . $datasup . "'";
                        $title = "B&uacute;squeda por socio/a: " . $superpfam . " i per data superior a " . $pdatas;
                    } elseif ($pfam != "" AND $pdatas == "" AND $pdatai != "") {
                        $where = "WHERE familia='" . $pfam . "' AND data<='" . $datainf . "'";
                        $title = "B&uacute;squeda por socio/a: " . $superpfam . " i per data inferior a " . $pdatai;
                    } elseif ($pfam != "" AND $pdatas != "" AND $pdatai != "") {
                        $where = "WHERE familia='" . $pfam . "' AND  data>='" . $datasup . "' AND data<='" . $datainf . "'";
                        $title = "Recerca per família " . $superpfam . " per data entre " . $pdatas . " i " . $pdatai;
                    } elseif ($pfam == "" AND $pdatas != "" AND $pdatai == "") {
                        $where = "WHERE data>='" . $datasup . "'";
                        $title = "B&uacute;squeda por fecha superior a " . $pdatas;
                    } elseif ($pfam == "" AND $pdatas != "" AND $pdatai != "") {
                        $where = "WHERE data>='" . $datasup . "' AND data<='" . $datainf . "'";
                        $title = "B&uacute;squeda por fecha entre " . $pdatas . " i " . $pdatai;
                    } elseif ($pfam == "" AND $pdatas == "" AND $pdatai != "") {
                        $where = "WHERE data<='" . $datainf . "'";
                        $title = "B&uacute;squeda por fecha inferior a " . $pdatai;
                    }

                } else {
                    $where = "";
                    $title = "Movimientos ordenados por fecha descendente";
                }

                print ('<p class="h1"
		style="background: grey; font-size:14px; text-align: left;
		 padding: .5rem">
		' . $title . '
		<span style="display: inline; float: right; text-align: center; vertical-align: middle;">
		' . $monea . '
		</span>
		</p>');

                print('<table width="100%" align="center" cellspading="5" cellspacing="5">
		<tr class="cos_majus">
		<td align="center" style="font-weight: 600" width="20%">FECHA</td>
		<td align="center" style="font-weight: 600" width="20%">SOCIO/A</td>
		<td align="center" style="font-weight: 600" width="40%">CONCEPTO</td>
		<td align="center" style="font-weight: 600; text-align: right" width="20%">VALOR</td>');
                print('</tr>');

                $sel = "SELECT data FROM moneder " . $where;
                $result = mysql_query($sel);
                if (!$result) {
                    die('Invalid query: ' . mysql_error());
                }
                $rnum = mysql_num_rows($result);

                if (!$gcont) {
                    $cont = 30;
                } else {
                    $cont = $gcont;
                }

                $sel2 = "SELECT data,familia,concepte,valor	FROM moneder " . $where . "	ORDER BY data DESC LIMIT " . $cont;
                $result2 = mysql_query($sel2);
                if (!$result2) {
                    die('Invalid query2: ' . mysql_error());
                }

                $k = 0;
                while (list($data, $fam, $concepte, $valor) = mysql_fetch_row($result2)) {
                    $datarc = explode("-", $data);
                    $datavis = $datarc[2] . '-' . $datarc[1] . '-' . $datarc[0];
                    if ($valor > 0) {
                        $colin = "";
                    } else {
                        $colin = "style='color: red;'";
                    }
                    print('<tr class="cos"' . $colin . '>
				<td align="center"  style="border-bottom: 1px solid">' . $datavis . '</td>
				<td align="center"  style="border-bottom: 1px solid">' . $fam . '</td>
				<td align="center"  style="border-bottom: 1px solid">' . $concepte . '</td>
				<td align="center" style="text-align:right;border-bottom: 1px solid">' . $valor . '</td></tr>');
                    $k++;
                }

                echo "</table>";

                if ($rnum > $cont) {
                    $id = $cont + 30;
                    echo '<p class="u-text-center"><input class="button" type="button" name="mes" value= "30+"
		onClick="javascript:window.location = \'comptes.php?id2=' . $id . '&id4=' . $pfam . '&id5=' . $pdatas . '&id6=' . $pdatai . '\'"></p>';
                }


                ?>
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