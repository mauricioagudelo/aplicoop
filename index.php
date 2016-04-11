<?php
// we must never forget to start the session
session_start();

include 'config/configuracio.php';

$errorMessage = '';
if (isset($_POST['txtUserId']) && isset($_POST['txtPassword'])) {
    // first check if the number submitted is correct
    $number = $_POST['txtNumber'];

    if (md5($number) == $_SESSION['image_random_value']) {
        //include 'config/configuracio.php';

        $userId = $_POST['txtUserId'];
        $password = $_POST['txtPassword'];


        // check if the user id and password combination exist
        $sql = "SELECT nom FROM usuaris  WHERE nom = '$userId' AND claudepas ='" . md5($password) . "' AND tipus2='actiu'";

        $result = mysql_query($sql) or
        die('Query failed. ' . mysql_error());

        if (mysql_num_rows($result) == 1) {
            // the user id and password match,
            // check if the user is already active

            list ($nom) = mysql_fetch_row($result);

            // set the session
            $_SESSION['image_is_logged_in'] = true;

            // remove the random value from session
            $_SESSION['image_random_value'] = '';

            // convert in minuscules
            $userId = strtolower($userId);

            // Identify user
            $_SESSION['user'] = $userId;

            //identify date
            date_default_timezone_set('Europe/Madrid');
            $_SESSION['timeinitse'] = time();
            $timeinitse = date("Y:m:d H:i:s", $_SESSION['timeinitse']);


            //keep number session
            $sql2 = "INSERT INTO session (user, date)
          		 VALUES ('$userId', '$timeinitse')";
            mysql_query($sql2) or
            die('Query2 failed. ' . mysql_error());
            $sessionid = mysql_insert_id();
            $_SESSION['sessionid'] = $sessionid;

            // after login we move to the main page
            header('Location: main.php');
            exit;

        } else {
            $errorMessage = 'Lo sentimos, el nombre de socio/a o la plave de paso son err&oacute;neas. Prueba otra vez.';
            include 'config/disconect.php';
        }
    } else {
        $errorMessage = 'Lo sentimos, el n&uacute;mero no es correcto. Prueba otra vez.';
    }
}

?>

<html>
<head>
    <title>login ::: la coope</title>
    <?php include 'head.php'; ?>
</head>

<body>
<div class="login-container">

    <?php
    if ($errorMessage != '') {
        ?>
        <p class="error"><?php echo $errorMessage; ?></p>

        <?php
    }
    ?>

    <div class="u-text-center login-logo">
        <img class="img img--responsive" src="imatges/logo_menu.png" title="applicop">
    </div>

    <form action="" method="post" name="frmLogin" id="frmLogin">

        <div class="box">

            <div class="form-group">
                <label for="txtUserId">Usuario</label>
                <input type="text" id="txtUserId" name="txtUserId" class="form-control">
            </div>

            <div class="form-group">
                <label for="txtPassword">Password</label>
                <input type="password" id="txtPassword" name="txtPassword" class="form-control">
            </div>

            <div class="form-group">
                <label for="txtNumber">Captcha</label>
                <input type="number" id="txtNumber" name="txtNumber" class="form-control">
                <div class="u-text-center">
                    <img class="login-captcha" src="randomImage.php">
                </div>

            </div>

        </div>

        <div class="u-text-center">
            <button type="submit" id="btnLogin" class="button button--animated button--save" name="entrar">
                Entrar
            </button>
        </div>

    </form>

    <div class="contenidor_1" style="padding-top: 60px;">
        <p class="cos2" style="text-align: center;">
            Si tienes cualquier problema notif&iacute;calo <a href="incidencia.php" target="_blank">aqu&iacute;</a>
        </p>
    </div>
</div>
</body>
</html>
