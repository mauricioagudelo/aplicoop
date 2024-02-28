<?php
$user = $_SESSION['user'];
$superuser = strtoupper($_SESSION['user']);
?>

<header class="navbar navbar-fixed-top hidden-print">

    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu"
                    aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="escriptori2.php" class="navbar-logo pull-left">
                <img <?php echo 'src="'.$logo_menu.'"' ?> title="applicop">
            </a>
            <div class="navbar-info visible-lg-inline-block  pull-left">
                <div class="navbar-family"><?php echo $superuser; ?></div>
                <div class="navbar-time">
                    <span id="hour" class="navbar-hour"></span>
                    <span id="date" class="navbar-date"></span>
                </div>
            </div>

        </div>

        <div id="menu" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="escriptori2.php">Inici</a>
                </li>
                <li>
                    <a href="comandes.php?id3=<?php echo $user;?>">Les meves comandes</a>
                </li>
                <li>
                    <a href="vis_user.php?id=<?php echo $user;?>">Les meves dades</a>
                </li>
                <li>
                    <a href="comptes.php?id3=<?php echo $user;?>">Els meus comptes</a>
                </li>
                <li>
                    <a href="admint.php">Administració</a>
                </li>
                <li>
                    <a href="ajuda.php">Ajuda</a>
                </li>
                <li>
                    <a href="logout.php">Sortir</a>
                </li>

            </ul>
        </div>
    </div>

    <!-- <nav>
        <ul>

        </ul>
        <div>
            <span><?php /*print (tradueixdata($data['weekday']) . ", " . $data['mday'] . " de " . tradueixdata($data['month']) . " de " . $data['year'] . " " . $data['hours'] . ":" . date('i')); */ ?></span>
            <span style="text-transform: uppercase; color: red;"><?php /*echo $superuser; */ ?></span>
        </div>
    </nav>-->
</header>

<script>

    var $date = $('#date');
    var $hour = $('#hour');

    var setHour = function () {
        var now = moment();
        $hour.text(now.format("HH:mm"));
        $date.text(now.format("dddd, DD/MM/YYYY"));
        setTimeout(setHour, 1000 * 60);
    };

    setHour();


</script>
