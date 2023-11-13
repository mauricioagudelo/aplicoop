<?php

session_start();

if ($_SESSION['image_is_logged_in'] == 'true' ) 
{
	$user = $_SESSION['user'];
	$sessionid=$_SESSION['sessionid'];

	$gprodref=$_GET['id'];
	$gdata=$_GET['id2'];
	$gproces=$_GET['id3'];
	$ggrup=$_GET['id4'];
	$gvis=$_GET['id5'];
	$gnumfact=$_GET['id6'];
	
	//vol evitar que algú es col·li escrivint codi directament a l'adreça html //
	if ($_SESSION['codi_cistella'] != 'in')
	{
		$gvis=0;
	}
	////
	
	list($mdiatdx, $mestdx, $anytdx ) = explode("-", $gdata);
	$gbd_data=$anytdx."-".$mestdx."-".$mdiatdx;

/// Hi ha dos possbile retorns POST ///
/// Un de cistella_prod.php///
	$post_cistella=$_POST["num"];
	$post_familia=$_POST["nom"];
	$post_numcmda=$_POST["numcmda"];
/// Un altre de cistella_mes.php ///	
	$paddfam=$_POST['nouf'];
	$pprov=$_POST['prov'];
	$pprod=$_POST['prod'];
	$pref=$_POST['ref'];
	$pnum=$_POST['num'];
	
	// si hi ha un numero comanda de factura //
	if ($gnumfact!=""){$aw='AND c.numero='.$gnumfact; $id6='&id6='.$gnumfact; $id8='&id8='.$gnumfact;}
	else {$aw=""; $id6=""; $id8="";}
//

	include 'config/configuracio.php';
	$nota="";
	
	
	////////////////////////////////////////////
	/// Si hi ha un POST procedent de cistella_mes.php ///
	/// llavors s'ha d'afegir el producte al proces ///
	/// creant si no existeix una comanda per a una família ///
	//////////////////////////////////////////////
	
	if ($paddfam)
	{		
		if($pnum!="") 
		{		
			$query2 = "INSERT INTO comanda_linia (numero, ref, quantitat, cistella)
				VALUES ('$pnum', '$pref', '1', '0')";
			mysql_query($query2) or die('Error, insert query2 failed');
		}
		else 
		{
			$query3 = "INSERT INTO comanda ( `usuari` , `proces`, `grup`, `sessionid` , `data` )
				VALUES ('$paddfam', '$gproces', '$ggrup', '$sessionid', '$gbd_data')";
			mysql_query($query3) or die('Error, insert query3 failed');
			$inumcmda=mysql_insert_id(); 		

			$query4 = "INSERT INTO comanda_linia (numero, ref, quantitat, cistella)
				VALUES ('$inumcmda', '$pref', '1', '0')";
			mysql_query($query4) or die('Error, insert query4 failed'); 	
		}	
	}	
	
	
	
	////////////////////////////////////////////
	// si hi ha dades d'un producte GET id i POST llavors les guarda //
	// implica retorn de cistelles_prod.php /////////
	// amb informació de les cistelles per guardar //
	/////////////////////////////////////////////////
	
	if ($gprodref!="") 
	{
		$files = count($post_cistella);
	
	/// Busquem nomprod i nomprov a partir de prodref ////
	$query0= "SELECT nom, proveidora FROM productes WHERE ref='$gprodref'";
	$result0=mysql_query($query0);
	if (!$result0) { die("Query0 to show fields from table failed");}

	list($gnomprod,$gprov)=mysql_fetch_row($result0);
	///////////
				
		$select9= "SELECT pr.categoria, cat.estoc
		FROM productes AS pr, categoria AS cat
		WHERE pr.categoria=cat.tipus AND pr.ref='$gprodref'";
		$result9 = mysql_query($select9);
		if (!$result9) { die('Invalid query select9: ' . mysql_error());}

		list($scat,$sestoc)= mysql_fetch_row($result9);
		
		$count=0;
		for ($i=0; $i<$files; $i++) 
		{
			
			if ($post_cistella[$i]==""){$post_cistella[$i]=0;}

			$select= "SELECT cistella 
			FROM comanda_linia 
			WHERE numero='$post_numcmda[$i]' AND ref='$gprodref'";
			$result = mysql_query($select);
			if (!$result) { die('Invalid query select: ' . mysql_error());}

			list($c)= mysql_fetch_row($result);
			
			// Si estem editant la variable cistella, primer introdueix el seu valor a l estoc ///
						
				if ($c!="" AND $sestoc=='si')
				{
				$query6= "UPDATE productes 
				SET estoc=estoc+'$c'
				WHERE ref='$gprodref'";
				mysql_query($query6) or die('Error, insert query6 failed');
				}
			
			///////////////////////////////////////
			/// Calculem el pvp sense iva. Preu*marge ///
			///////////////////////////////////////			
			
				$select10= "SELECT preusi, iva, marge, descompte FROM productes WHERE ref='$gprodref'";
				$result10 = mysql_query($select10);
				if (!$result10) { die('Invalid query select10: ' . mysql_error());}
				list($spreusi,$siva,$smarge,$sdescompte)= mysql_fetch_row($result10);
											
				$pvp=$spreusi*(1+$smarge);
				$pvp=sprintf("%01.2f", $pvp);		
				$pvp2=$pvp*(1-$sdescompte);
				$pvp2=sprintf("%01.2f", $pvp2);
						
				$query= "UPDATE comanda_linia
					SET cistella='$post_cistella[$i]', preu='$pvp', iva='$siva', descompte='$sdescompte'
				WHERE numero='$post_numcmda[$i]' AND ref='$gprodref'";
				mysql_query($query) or die('Error, insert query failed');
			
				if ($sestoc=='si')
				{
					$query7= "UPDATE productes 
					SET estoc=estoc-'$post_cistella[$i]'
					WHERE ref='$gprodref'";
					mysql_query($query7) or die('Error, insert query7 failed');
			}	
		}

		$nota="<div class='alert alert--info u-mb-1'>Se han introducido correctamente los datos de la cesta del producto ".$gnomprod."-".$gprov."</div>";
	}
	
	?>

	<html lang="es">
		<head>
			<?php include 'head.php'; ?>						
			<title>aplicoop - editar pedido</title>		
		</head>

		<script language="javascript" type="text/javascript">
			function confirma()
			{
				var answer;
				var answer = confirm("Estas cerrando el apartado de HACER CESTAS \nSe mandará una notificación electrónica a todas las familias y se generara un código de edición\nAceptar: ir a facturacion \nCancelar: continuar haciendo cestas");
				if (answer)
				{
	  				window.location = 'cistella_check1.php?id=<?php echo $gproces."&id2=".$ggrup."&id3=".$gbd_data; ?>';
				}
			}
		</script>

<?php

	$taula3 = "SELECT check1
			FROM cistella_check
			WHERE proces='$gproces' AND grup='$ggrup' AND data='$gbd_data'";			
	$result3 = mysql_query($taula3);
	if (!$result3) {die('Invalid query3: ' . mysql_error());}
	list($check)=mysql_fetch_row($result3);
	
	/// Si no es pot editar (gvis=0) no hi ha botó de "pas segúent" ni d'"introduir nou producte" ///
	if ($gvis==0) 
	{
		$link_cap="<a class='link' href='cistelles.php?id2=".$gdata."&id3=".$gproces."&id4=".$ggrup."&id5=0'>Ver cesta ".$gdata." - ".$gproces." - ".$ggrup."</a>";
		$title="Ver pedido ".$gdata." - ".$gproces." - ".$ggrup;
		$button='<button class="button  button--white button--animated" onClick="javascript:window.location = \'createcsv.php?id='.$gbd_data.'&id2='.$gproces.'&id3='.$ggrup.'&id4=2\'">CSV <i class="fa fa-table" aria-hidden="true"></i></button>';
		$sty="";
		$nouproducte="";
	}
	else
	{
		$button='<button class="button button button--save button--animated" name="Gcodi" type="button"  onClick="confirma()">Facturar Cistella <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>';
		$sty="";
		$nouproducte='<div class="u-cf"><button class="button button--animated u-mb-1 pull-right " type="button" 
		onClick="javascript:window.location = \'cistella_mes.php?id3='.$gdata.'&id5='.$gvis.'&id6='.$gproces.'&id7='.$ggrup.'\'">Añadir nuevo producto <i class="fa fa-plus" aria-hidden="true"></i></button></div>';
		if ($check==0)
		{
			$link_cap="<a class='link' href='cistelles.php?id2=".$gdata."&id3=".$gproces."&id4=".$ggrup."&id5=1'>Ver cesta ".$gdata." - ".$gproces." - ".$ggrup."</a>";
			$title="Ver cesta ".$gdata." - ".$gproces." - ".$ggrup;
		}
		else
		{
			$link_cap="<a class='link' href='cistelles.php?id2=".$gdata."&id3=".$gproces."&id4=".$ggrup."&id5=1".$id6."'>Editar cesta ".$gdata." - ".$gproces." - ".$ggrup."</a>";
			$title="Editar cesta ".$gdata." - ".$gproces." - ".$ggrup;
		}	
	}
?>
<body>
<?php include 'menu.php'; ?>
<div class="page">
    <div class="container">
	<div class="u-cf">
		<h1 class="pull-left"><?php echo $link_cap; ?></h1> 
			<button class="button button--animated u-mb-1 pull-right "  type="button" 
onClick="javascript:window.location = 'cistelles2.php?id2=<?php echo $gdata.'&id3='.$gproces.'&id4='.$ggrup.'&id5='.$gvis; ?>'">Pedidos por familia</button>


<?php echo $nouproducte; ?>

<?php
//Botones para modificar las variables del producto con referencia $prodref de la comanda abierta.
if(isset($_POST['btn0'])) { //Copia los valores del producto seleccionado, las variables "cistella" se igualan con "quantitat"
	$prodref_post0 = $_POST['productref'];
	$query8= "UPDATE comanda AS c, 
					 comanda_linia AS cl, 
					 categoria AS cat, 
					 productes AS pr 
					 SET cl.cistella = cl.quantitat, 
					 cl.preu = pr.preusi*(1+pr.marge), 
					 cl.iva = pr.iva, 
					 cl.descompte = pr.descompte, 
					 pr.estoc = IF(cat.estoc = 'si', pr.estoc-cl.quantitat, 0.000) 
					 WHERE 
					 cl.ref = '$prodref_post0' 
					 AND 
					 cl.numero = c.numero 
					 AND 
					 c.data='$gbd_data' 
					 AND 
					 pr.ref = cl.ref 
					 AND 
					 cat.tipus = pr.categoria";


	mysql_query($query8) or die('Error, insert query8 failed');
	$nota="<div class='alert alert--info u-mb-1'>S'han modificat correctament les cistelles del producte</div>";
}
if(isset($_POST['btn1'])) { //Pone a cero los valores del producto seleccionado
	$prodref_post1 = $_POST['productref'];
	$query9= "UPDATE comanda AS c, comanda_linia AS cl, categoria AS cat, productes AS pr SET cl.cistella = 0.000, cl.preu = 0.00, cl.iva = 0.00, cl.descompte = 0.000, pr.estoc = IF(cat.estoc = 'si', pr.estoc+cl.cistella, 0.000) WHERE cl.ref = '$prodref_post1' AND cl.numero = c.numero AND c.data='$gbd_data' AND pr.ref = cl.ref AND cat.tipus = pr.categoria";
	mysql_query($query9) or die('Error, insert query9 failed');
	$nota="<div class='alert alert--info u-mb-1'>S'ha posat a zero les cistelles del producte</div>";
}
?>
                 
<?php //Botón para acceder a “createcsv_prod.php” que permite descargarse la lista de productos activos en la comanda.
$button_productes='<button class="button  button-- button--animated pull-right" onClick="javascript:window.location = \'createcsv_prod.php?id='.$gbd_data.'&id2='.$gproces.'&id3='.$ggrup.'&id4=2\'">CSV productes<i class="fa fa-table" aria-hidden="true"></i></button>'; ?>

<?php //Botón para acceder a “createcsv_perma.php” que permite descargarse la lista de productos con diferencias entre “cistella” y “quantitat”.
$button_perma='<button class="button  button-- button--animated pull-right" onClick="javascript:window.location = \'createcsv_perma.php?id='.$gbd_data.'&id2='.$gproces.'&id3='.$ggrup.'&id4=2\'">CSV permanencia<i class="fa fa-table" aria-hidden="true"></i></button>'; ?>

<?php //echo $button_perma; ?>
		
<?php //Muestra solo los botones cuando la comanda esta abierta
if ($gvis!=0) {
	echo $button_productes;
	echo $button_perma;
}
?>

</div>

<?php echo $nota; ?>


<?php
	echo'<div class="box"><div>';
	$color2 = array("#1abc9c", "#e74c3c", "#34495e", "#b20000", "#9b59b6", "#f1c40f", "#f39c12", "#c0392b", "#2980b9");
	$cc=0;
	$sel = "SELECT tipus FROM categoria ORDER BY tipus";
	$result = mysql_query($sel);
	if (!$result) {die('Invalid query: ' . mysql_error()); }
	while (list($cat)= mysql_fetch_row($result))
	{	
		$taula2 = "SELECT cl.ref, pr.nom, pr.proveidora, pr.unitat, pr.categoria, c.numero, c.data
		FROM comanda AS c, comanda_linia AS cl, productes AS pr
		WHERE c.numero=cl.numero AND cl.ref=pr.ref
		AND c.data='$gbd_data' AND pr.categoria='$cat' ".$aw;
		$result2 = mysql_query($taula2);
		if (!$result2) {die('Invalid query2: ' . mysql_error());}
	
		if (mysql_num_rows($result2)>0)
		{
			print ('<a href="#'.$cat.'" id="color" class="link u-text-semibold"  style="border-bottom: 1px solid transparent;color: '.$color2[$cc].'; 
				margin-bottom: 5px; margin-right: 3px; margin-right: 1rem;">
				<span>'.$cat.'</span></a>');
				$cc++;
				if ($cc==7){$cc=0;}
		}
	}
	echo'</div>
	<hr class="box-separator"/>
	<div  style="overflow: auto; height: 44vh;">';
	$cc=0;
	$sel = "SELECT tipus FROM categoria ORDER BY tipus";
	$result = mysql_query($sel);
	if (!$result) {die('Invalid query: ' . mysql_error()); }
	while (list($cat)= mysql_fetch_row($result))
	{	
	
	$taula2 = "SELECT cl.ref, pr.nom, pr.proveidora, pr.unitat, pr.categoria, c.numero, c.data, SUM(cl.quantitat) AS sum, SUM(cl.cistella) AS csum
	FROM comanda AS c, comanda_linia AS cl, productes AS pr
	WHERE c.numero=cl.numero AND cl.ref=pr.ref AND c.data='$gbd_data' 
	AND c.proces='$gproces' AND c.grup='$ggrup' AND pr.categoria='$cat' ".$aw."
	GROUP BY cl.ref
	ORDER BY pr.categoria, pr.proveidora, pr.nom";

	$result2 = mysql_query($taula2);
	if (!$result2) {die('Invalid query2: ' . mysql_error());}
	
	if (mysql_num_rows($result2)>0)
	{
		print ('<a name="'.$cat.'"></a>
	  	<h2 style="color: '.$color2[$cc].'">'.$cat.'</h2>');
		echo '<div class="u-mb-2" style="padding-right: 1rem;">';
		echo '<table class="table table-striped table-bordered">';
		echo "<tr  class='u-text-semibold'><td width='60%'>Producto</td>";
		echo "<td width='20%'  class='u-text-semibold  u-text-center'>Total pedido</td>";
		echo "<td width='20%'  class='u-text-semibold  u-text-center'>Total cesta</td>";
		if ($gvis!=0) { //Añade la columna "Modificar" cuando se puede editar la commanda
			echo "<td  class='u-text-semibold  u-text-center'>Modificar</td>";
		}
		echo "</tr>";

		while (list($prodref,$nom_prod,$nom_prov,$uni,$t,$n,$d,$sum,$csum)=mysql_fetch_row($result2))
		{
			$suma = sprintf("%01.2f", $sum); // pedido
			$csuma= sprintf("%01.2f", $csum); // cesta
			$estil="";

			if ($csuma != 0 AND $csuma == $suma) 
			{
				$estil="u-color-ok";
			}

			if ($suma != 0 AND $csuma == 0) 
			{
				$estil="u-color-error";
			}
			
			if ($csuma != 0 AND $csuma <> $suma) 
			{				
				$estil="u-color-warning";
			}
			
			$link="<a id='color2' class='link link--visitable' href='cistella_prod.php?id=".$prodref."&id3=".$gdata."&id4=".$cat."&id5=".$gvis."&id6=".$gproces."&id7=".$ggrup.$id8."'>".$nom_prod."-".$nom_prov."</a>";
	
			?>

			<tr>
				<td><?php echo $link; ?></td>
				<td align="center" class="<?php echo $estil; ?>"><?php echo $suma; ?> <?php echo $uni; ?></td>
				<td align="center" class="<?php echo $estil; ?>"><?php echo $csuma; ?> <?php echo $uni; ?></td>
				<?php
				//Formulario que contiene los botones btn0 y btn1 para modificar las variables del producto con referencia $prodref de comanda abierta.
				//Comenta el formulario cuando se ha cerrado la comanda
				if ($gvis==0) {
					echo "<!--";
				} 
				?>
				<form method="post">
					<td align="center">
						<input type="hidden" name="productref" value="<?php echo $prodref; ?>">
						<input type="submit" name="btn0" value="=" onclick="return confirm('Es procedeix a assignar els valors de comanda a la cistella en el producte seleccionat \nAceptar: MODIFICA cistelles \nCancelar: NO MODIFICA cistelles');"/> 
						<input type="submit" name="btn1" value="0" onclick="return confirm('Es procedeix a posar a zero la cistella del producte seleccionat \nAceptar: MODIFICA cistelles \nCancelar: NO MODIFICA cistelles'); <?php echo $gvis; ?>"/>	
					</td>
				</form>
				<?php
				//Cierre commentario
				if ($gvis==0) {
					echo "-->";
				} 
				?>
			</tr>

			<?php
		}

		echo "</table></div>";
		$cc++;
		if ($cc==7) {
			$cc=0;
		}
	}
}
	
?>
</div>
<div class="u-mt-1 u-text-center">
<?php
if ($gnumfact!="")
{

}
else
{
echo ''.$button.'';
} ?>
</div>
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
