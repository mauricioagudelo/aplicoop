<?php

session_start();

$user=$_SESSION['user'];
$superuser=strtoupper($_SESSION['user']);

// $logo_menu prove de l'arxiu de configuració
include 'config/configuracio.php';

date_default_timezone_set('Europe/Madrid');
function tradueixData($d)
{
				$angles = array(    "/Monday/",
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

 				$catala = array(    "Lunes",
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

<html lang="es">
<head>
		<meta http-equiv="content-type" content="="text/ht; charset=UTF-8" >
		<link rel="stylesheet" type="text/css" href="coope.css" />
      <title>capçalera ::: la coope</title>
</head>

<style type="text/css">

#fig {display: block;
  overflow: visible;
  text-align: center;
  margin: auto;}

</style>

<body>
<div class="cap">
	<div class="contenidor_1">
		<div class="contenidor_4" style="float:left;">
			<img id="fig" style="width:175px; height:85px; padding: 10px 0px 20px 0px ;" src="<?php echo $logo_menu; ?>">
		</div>
		<div class="contenidor_4_3" style="float:right;">
			<div>
				<p class="h2" style="text-align: right; margin-right:25px; margin-top:8px;">
				Família: <span style="text-transform: uppercase; color: red;"><?php echo $superuser; ?></span>
				<br/>
				<?php print (tradueixData($data['weekday']). ", " .$data['mday']. " de " .tradueixData($data['month']). " de " .$data['year']." ".$data['hours'].":".date('i')); ?>
				</p>
			</div>
			<div class="menu">
  			 <a target="_parent" href="logout.php" style="margin-right: 25px;"><span>Salir</span></a>
   		 <a  href="ajuda.php"><span>Ayuda</span></a>
  			  <a  href="admint.php"><span>Administar</span></a>
 		 	  <a  href="comptes.php?id3=<?php echo $user; ?>"><span>Mis Cuentas</span></a>
 		 	  <a  href="vis_user.php?id=<?php echo $user; ?>"><span>Mis Datos</span></a>
  			  <a  href="comandes.php?id3=<?php echo $user; ?>"><span>Mis pedidos</span></a>
 		 	  <a  href="escriptori2.php"><span>Inicio</span></a>
 	 		 </div>
		</div>
	</div>
	<div class="contenidor_1" style="">
			<img style="width:956px;height:10px" src="imatges/senefa.jpg">
	</div>
</div>
</body>
</html>

