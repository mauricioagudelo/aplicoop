<?php

session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    $user = $_SESSION['user'];


    ?>

    <html>
    <head>
        <?php include 'head.php'; ?>
        <title>aplicoop - ayuda</title>
    </head>

    <body>
    <?php include 'menu.php'; ?>
    <div class="page">
        <div class="container">
            <h1>Ayuda</h1>

            <div class="box">
                <p class="alert alert--info">NOTA: Tutoriales en lengua CATALANA</p>
                <ul type="circle">
                    <li>
                        <a href="http://vimeo.com/channels/629250/79835667" class="link" target="_blank">Hacer un
                            pedido</a>
                    </li>
                    <li>
                        <a href="http://vimeo.com/channels/629250/79836983" class="link" target="_blank">Solicitar
                            pedido a los proveedores</a>
                    </li>
                    <li>
                        <a href="http://vimeo.com/channels/629250/79836986" class="link" target="_blank">Hacer
                            cestas</a>
                    </li>
                    <li>
                        <a href="http://vimeo.com/channels/629250/79836984" class="link" target="_blank">Procesos
                            abiertos de pedido</a>
                    </li>
                    <li>
                        <a href="http://vimeo.com/channels/629250/79916802" class="link" target="_blank">Herramientas de
                            comunicación interna</a>
                    </li>
                    <li>
                        <a href="http://vimeo.com/channels/629250/79836988" class="link" target="_blank">Funciones de administraci&oacute;n
                            de usuarios</a>
                    </li>
                    <li>
                        <a href="http://vimeo.com/channels/629250/79836989" class="link" target="_blank">Funciones de gesti&oacute;n
                            de stock y proveedores</a>
                    </li>
                </ul>
            </div>


        </div>
    </div>
    </body>
    </html>

    <?php

} else {
    header("Location: index.php");
}
?>