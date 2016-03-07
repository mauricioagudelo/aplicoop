<?php

$user = $_SESSION['user'];
$superuser = strtoupper($_SESSION['user']);

date_default_timezone_set('Europe/Madrid');
function tradueixData($d)
{
    $angles = array("/Monday/",
        "/Tuesday/",
        "/Wednesday/",
        "/Thursday/",
        "/Friday/",
        "/Saturday/",
        "/Sunday/",
        "/Mon/",
        "/Tue/",
        "/Wed/",
        "/Thu/",
        "/Fri/",
        "/Sat/",
        "/Sun/",
        "/January/",
        "/February/",
        "/March/",
        "/April/",
        "/May/",
        "/June/",
        "/July/",
        "/August/",
        "/September/",
        "/October/",
        "/November/",
        "/December/",
        "/Jan/",
        "/Feb/",
        "/Mar/",
        "/Apr/",
        "/May/",
        "/Jun/",
        "/Jul/",
        "/Aug/",
        "/Sep/",
        "/Oct/",
        "/Nov/",
        "/Dec/");

    $catala = array("Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
        "Domingo",
        "Lun",
        "Mar",
        "Mie",
        "Jue",
        "Vie",
        "Sab",
        "Dom",
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
        "En",
        "Feb",
        "Mar",
        "Abr",
        "May",
        "Jun",
        "Jul",
        "Ago",
        "Sep",
        "Oct",
        "Nov",
        "Dic");

    $ret1 = preg_replace($angles, $catala, $d);
    return $ret1;
}

$data = getdate();

?>

<header class="navbar navbar-default navbar-fixed-top">

    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">aplicoop</a>
        </div>

        <div id="menu" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="escriptori2.php">inicio</a>
                </li>
                <li>
                    <a href="comandes.php?id3=<?php /*echo $user; */?>">mis pedidos</a>
                </li>
                <li>
                    <a href="vis_user.php?id=<?php /*echo $user; */?>">mis datos</a>
                </li>
                <li>
                    <a href="comptes.php?id3=<?php /*echo $user; */?>">mis cuentas</a>
                </li>
                <li>
                    <a href="admint.php">administrar</a>
                </li>
                <li>
                    <a href="ajuda.php">ayuda</a>
                </li>
                <li>
                    <a href="logout.php">salir</a>
                </li>

            </ul>
        </div>
    </div>

   <!-- <nav>
        <ul>

        </ul>
        <div>
            <span><?php /*print (tradueixdata($data['weekday']) . ", " . $data['mday'] . " de " . tradueixdata($data['month']) . " de " . $data['year'] . " " . $data['hours'] . ":" . date('i')); */?></span>
            <span style="text-transform: uppercase; color: red;"><?php /*echo $superuser; */?></span>
        </div>
    </nav>-->
</header>