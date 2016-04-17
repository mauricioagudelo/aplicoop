<?php

session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];

    $pcat = $_POST['cat'];
    $psubcat = $_POST['subcat'];
    $pprov = $_POST['prov'];

    include 'config/configuracio.php';
    ?>

    <html>
    <head>
        <?php include 'head.php'; ?>
        <title>productes ::: la coope</title>
    </head>


    <body>
    <?php include 'menu.php'; ?>
    <div class="page">
        <div class="container">

            <div class="u-cf">
                <h1 class="pull-left">Productos </h1>

                <div class="pull-right u-mt-1">
                    <button class="button button--animated" onClick="javascript:window.location = 'editprod.php'">Crear
                        producto
                    </button>
                </div>
            </div>



            <form action="productes.php" method="post" name="prod" id="prod">

                <div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cat">Categorias</label>
                                <div>
                                    <SELECT name="cat" id="cat" size="1" maxlength="30" onChange="this.form.submit()">
                                        <option value="">--elegir--</option>

                                        <?php

                                        $select2 = "SELECT tipus FROM categoria ORDER BY tipus";
                                        $query2 = mysql_query($select2);
                                        if (!$query2) {
                                            die('Invalid query2: ' . mysql_error());
                                        }

                                        while (list($scat) = mysql_fetch_row($query2)) {
                                            if ($pcat == $scat) {
                                                echo '<option value="' . $scat . '" selected>' . $scat . '</option>';
                                            } else {
                                                echo '<option value="' . $scat . '">' . $scat . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subcat">Subcategorias</label>
                                <div>
                                    <?php
                                    $dis_sc = "disabled";
                                    $opt_sc = '<OPTION value="">--elegir--</option>';
                                    if ($pcat != "") {
                                        $dis_sc = "";
                                        $opt_sc = '<OPTION value="">';
                                    }

                                    ?>

                                        <SELECT name="subcat" id="subcat" size="1" maxlength="30" <?php echo $dis_sc; ?>
                                                onChange="this.form.submit()">

                                            <?php
                                            echo $opt_sc;
                                            if ($pcat != "") {
                                                $select2 = "SELECT subcategoria FROM subcategoria
WHERE categoria='" . $pcat . "' ORDER BY subcategoria";
                                                $query2 = mysql_query($select2);
                                                if (!$query2) {
                                                    die('Invalid query2: ' . mysql_error());
                                                }

                                                while (list($scat) = mysql_fetch_row($query2)) {
                                                    if ($psubcat == $scat) {
                                                        echo '<option value="' . $scat . '" selected>' . $scat . '</option>';
                                                    } else {
                                                        echo '<option value="' . $scat . '">' . $scat . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                            </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="prov">Proveedores</label>
                                <div>
                                    <SELECT name="prov" id="prov" size="1" maxlength="30" onChange="this.form.submit()">
                                        <option value="">--elegir--</option>

                                        <?php
                                        $select3 = "SELECT nom FROM proveidores ORDER BY nom";
                                        $query3 = mysql_query($select3);
                                        if (!$query3) {
                                            die('Invalid query3: ' . mysql_error());
                                        }

                                        while (list($sprov) = mysql_fetch_row($query3)) {
                                            if ($pprov == $sprov) {
                                                echo '<option value="' . $sprov . '" selected>' . $sprov . '</option>';
                                            } else {
                                                echo '<option value="' . $sprov . '">' . $sprov . '</option>';
                                            }

                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            <div class="box">

                <div >


                    <?php
                    if ($pcat != "" OR $pprov != "") {
                        if ($pcat == "") {
                            $where = "proveidora='" . $pprov . "'";
                            $title = "Recerca per proveïdora " . $pprov;
                        } else {
                            if ($psubcat == "" AND $pprov == "") {
                                $where = "categoria='" . $pcat . "'";
                                $title = "Recerca per categoria " . $pcat;
                            } elseif ($psubcat != "" AND $pprov == "") {
                                $where = "categoria='" . $pcat . "' AND subcategoria='" . $psubcat . "'";
                                $title = "Recerca per categoria " . $pcat . " i subcategoria " . $psubcat;
                            } elseif ($psubcat == "" AND $pprov != "") {
                                $where = "categoria='" . $pcat . "' AND proveidora='" . $pprov . "'";
                                $title = "Recerca per categoria " . $pcat . " i proveïdora " . $pprov;
                            } elseif ($psubcat != "" AND $pprov != "") {
                                $where = "categoria='" . $pcat . "' AND subcategoria='" . $psubcat . "' AND proveidora='" . $pprov . "'";
                                $title = "Recerca per categoria " . $pcat . ", subcategoria " . $psubcat . " i proveïdora " . $pprov;
                            }
                        }

                        print ('<p class="alert alert--info">' . $title . '</p>');

                        print('<div class="row">');

                        $sel = "SELECT ref,nom,proveidora FROM productes
	WHERE " . $where . " ORDER BY nom";
                        $result = mysql_query($sel);
                        if (!$result) {
                            die('Invalid query: ' . mysql_error());
                        }

                        $i = 0;
                        while (list($ref, $nomprod, $nomprov) = mysql_fetch_row($result)) {

                            print('<div class="col-lg-6"><a id="color" class="link"  href="editprod.php?id=' . $ref . '">' . $nomprod . '</a></div>');

                        }
                        print ('</div></div>');

                    } else {
                        print ('<p class="alert alert--info">Ordenación alfabética de productos</p>');

                        print('<div class="row">');

                        $sel = "SELECT ref,nom,proveidora FROM productes ORDER BY nom";
                        $result = mysql_query($sel);
                        if (!$result) {
                            die('Invalid query: ' . mysql_error());
                        }

                        $i = 0;
                        while (list($ref, $nomprod, $nomprov) = mysql_fetch_row($result)) {

                            print('<div class="col-lg-6"><a id="color" class="link" href="editprod.php?id=' . $ref . '">' . $nomprod . '</a></div>');

                        }
                        print ('</div></div>');
                    }

                    ?>

                    <p class="alert alert--info">
                        Per crear un nou producte clica el botó CREAR NOU PRODUCTE. Per editar o eliminar
                        un producte clica sobre el seu nom i t'apareixerà la seva fitxa. Pots buscar productes
                        per categoria i/o per proveïdora. Per defecte apareixen tots els productes ordenats per ordre
                        alfabètic.</p>
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