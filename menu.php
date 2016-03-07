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

<header>
    <nav>
        <ul>
            <li>
                <a href="escriptori2.php">Inicio</a>
            </li>
            <li>
                <a href="comandes.php?id3=<?php echo $user; ?>">Mis pedidos</a>
            </li>
            <li>
                <a href="vis_user.php?id=<?php echo $user; ?>">Mis Datos</a>
            </li>
            <li>
                <a href="comptes.php?id3=<?php echo $user; ?>">Mis Cuentas</a>
            </li>
            <li>
                <a href="admint.php">Administar</a>
            </li>
            <li>
                <a href="ajuda.php">Ayuda</a>
            </li>
            <li>
                <a href="logout.php">Salir</a>
            </li>
        </ul>
        <div>
            <span><?php print (tradueixData($data['weekday']) . ", " . $data['mday'] . " de " . tradueixData($data['month']) . " de " . $data['year'] . " " . $data['hours'] . ":" . date('i')); ?></span>
            <span style="text-transform: uppercase; color: red;"><?php echo $superuser; ?></span>
        </div>
    </nav>
</header>