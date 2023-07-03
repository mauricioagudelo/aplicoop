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
$title="Productes de la comanda";
$where="";
$pre_arxiu="Productes_comanda".$bd_data."_".$grup."_".$proces.".csv";


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
	$select3 = "SELECT pr.ref,pr.nom,pr.proveidora,ctg.tipus,pr.subcategoria,ctg.estoc,pr.preusi,pr.iva,pr.marge,pr.descompte,pr.unitat,pr.estoc, pr.labels,pr.actiu 
		FROM productes AS pr, categoria AS ctg, proces_linia AS pl
		WHERE pr.categoria=ctg.tipus AND pr.categoria=pl.categoria AND pr.actiu='actiu' AND pl.proces='$proces' AND pl.grup='$grup' AND pl.actiu='activat' ORDER BY pr.categoria, pr.nom ";
                                
	$resultat3=mysql_query($select3);
	if (!$resultat3) {die("Query to show fields from table select3 failed");}
	
	//Afegeix la capçalera de la taula
	$content .= "Referencia;Producte;Proveïdora;Categoria;Subcategoria;Estoc?;Estoc;PreuSenseIVA;IVA;Marge;Descompte;Unitats;Labels;Estat"."\n";
	
	//Genera les files de la taula
	while($row = mysql_fetch_row($resultat3))
	{
		$ref=$row[0];		
		$producte=$row[1];
		$prov=$row[2];
		$categ=$row[3];
		$subcateg=$row[4];
		$estoc=str_replace(".",",",$row[5]);
		$preusi=str_replace(".",",",$row[6]);
		$iva=str_replace(".",",",$row[7]);
		$marge=str_replace(".",",",$row[8]);
		$descompte=str_replace(".",",",$row[9]);
		$unitat=$row[10];
		$estoc2=$row[11];
		$labels=$row[12];
		$estat=$row[13];
		//Afegeix l'ultima fila creada
		$content .= $ref.";".$producte.";".$prov.";".$categ.";".$subcateg.";".$estoc.";".$estoc2.";".$preusi.";".$iva.";".$marge.";".$descompte.";".$unitat.";".$labels.";".$estat."\n";
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
