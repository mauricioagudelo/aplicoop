<?php

session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];


    ?>

    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="coope.css"/>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>ayuda ::: la coope</title>
    </head>

    <body>
    <?php include 'menu.php'; ?>
    <div class="pagina" style="margin-top: 10px;">
        <div class="contenidor_1" style="border: 1px solid #933a82;">
            <p class="h1" style="background: black; text-align: left; padding-left: 20px;">Ayuda</p>
            <p>NOTA: Tutoriales en lengua CATALANA</p>
            <ul type="circle" style="text-align: left; padding-left: 40px;">
                <li><a href="http://vimeo.com/channels/629250/79835667" target="_blank">Hacer un pedido</a></li>
                <li><a href="http://vimeo.com/channels/629250/79836983" target="_blank">Solicitar pedido a los
                        proveedores</a></li>
                <li><a href="http://vimeo.com/channels/629250/79836986" target="_blank">Hacer cestas</a></li>
                <li><a href="http://vimeo.com/channels/629250/79836984" target="_blank">Procesos abiertos de pedido</a>
                </li>
                <li><a href="http://vimeo.com/channels/629250/79916802" target="_blank">Herramientas de comunicación
                        interna</a></li>
                <li><a href="" target="_blank">Funciones de econom&iacute;a</a></li>
                <li><a href="http://vimeo.com/channels/629250/79836988" target="_blank">Funciones de administraci&oacute;n
                        de usuarios</a></li>
                <li><a href="http://vimeo.com/channels/629250/79836989" target="_blank">Funciones de gesti&oacute;n de
                        stock y proveedores</a></li>
            </ul>
            <p></p>

        </div>
    </div>
    </body>
    </html>

    <?php

} else {
    header("Location: index.php");
}
?>