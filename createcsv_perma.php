<?php

session_start();

if ($_SESSION['image_is_logged_in'] == 'true' ) {

$user = $_SESSION['user'];

$bd_data=$_GET['id'];
$proces=$_GET['id2'];
$grup=$_GET['id3'];
$estoc=$_GET['id4'];

$data=date("d-m-Y", strtotime ($bd_data));

////////////////////////////////////////
///GET id4 genera la variable estoc que no s'utilitza ///
/// Aquesta pot ser 				///
/// 0: comanda sense estoc			///
/// 1: comanda amb estoc 			///
/// 2: factures 					////
///////////////////////////////////////

$link="";///"totalcomanda.php?id=".$data."&id2=".$proces."&id3=".$grup."&id4=1";
$title="Informe de permanencia";
$where="";
$pre_arxiu="informe_permanencia".$bd_data."_".$grup."_".$proces.".csv";


?>

<html lang="es">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
		<link rel="stylesheet" type="text/css" href="coope.css" />
		<title>crea arxiu csv ::: la coope</title>

<style type="text/css">
	a#color:link, a#color:visited {color:white; border: 1px solid #9cff00;}
	a#color:hover {color:black; border: 1px solid #9cff00;   -moz-border-radius: 10%;}
   a#color:active {color:white; border: 1px solid #9cff00;  -moz-border-radius: 10%;}
</style>
</head>

<body>
<div class="pagina" style="margin-top: 10px;">

<div class="contenidor_1" style="border: 1px solid green;">
<p class='path'> 
><a href='admint.php'>administració</a> 
>><a href='grups_comandes.php'>grups de comandes i cistelles</a> 
>>><a href='<?php echo $link; ?>'> <?php echo $title." ".$proces."-".$grup."-".$data; ?></a>
</p>
<p class="h1" style="background: green; text-align: left; padding-left: 20px;">
<?php echo $title." ".$proces."-".$grup."-".$data; ?></p>

<?php

include 'config/configuracio.php';
	
	$select3="SELECT pr.nom, cl.ref, pr.proveidora, pr.categoria, c.usuari, cl.quantitat, cl.cistella, pr.unitat
		FROM comanda AS c, comanda_linia AS cl, productes AS pr
		WHERE cl.numero = c.numero AND c.data = '$bd_data' AND c.proces='$proces' AND c.grup='$grup' AND cl.quantitat != cl.cistella AND cl.ref = pr.ref";
	
	$resultat3=mysql_query($select3);
	if (!$resultat3) {die("Query to show fields from table select3 failed");}
	
	//Afegeix la capçalera de la taula
	$content .= "Producte;Referencia;Proveïdora;Categoria;Família;Quantitat;Cistella;Unitats"."\n";
	
	//Genera les files de la taula
	while($row = mysql_fetch_row($resultat3))
	{
		$producte=$row[0];
		$ref=$row[1];
		$prov=$row[2];
		$categ=$row[3];
		$usuari=$row[4];
		$quant=str_replace(".",",",$row[5]);
		$cistella=str_replace(".",",",$row[6]);
		$unitat=$row[7];
		//Afegeix l'ultima fila creada
		$content .= $producte.";".$ref.";".$prov.";".$categ.";".$usuari.";".$quant.";".$cistella.";".$unitat."\n";
	}
	
	

/// Creem l'arxiu, la variable pre_arxiu està definida al principi ///
$arxiu=str_replace(" ","",$pre_arxiu);
$arxiu_dir= "download/".$arxiu;
$fp=fopen($arxiu_dir,"w");

fwrite($fp,$content);
fclose($fp);

if (!$fp) { die("No s'han pogut crear els arxius desitjats");}

else{
$exit="L'arxiu ".$arxiu." s'ha creat amb exit";
}

?>

<div class="contenidor_fac">
<p class='cos2'><?php echo $exit; ?></p>
<p class='cos2'><?php echo $exit2; ?></p>
<p class="linia_button2" style="padding:4px 0px; height: 20px; background: green; text-align: center; vertical-align: middle;">
<input class="button2" type="button" value="BAIXA-TE'L"  
onClick="javascript:window.location = '<?php echo $arxiu_dir; ?>'">
</p>
<p class='cos2'>Recorda: Joc de caracters Unicode(UTF8) i Separat per PUNT I COMA.</p> 
</div>
<div class="contenidor_fac" style="padding-bottom: 20px;">
<p class="cos" style="white-space: -moz-pre-wrap; word-wrap: break-word;"><?php echo $content; ?></p>
</div>
</div>
</div>


</body>
</html>


<?php
include 'config/disconect.php';
} 
else {
header("Location: index.php"); 
}
?>