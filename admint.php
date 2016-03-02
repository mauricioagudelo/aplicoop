<?php

session_start();

if ($_SESSION['image_is_logged_in'] == 'true' ) {

$user = $_SESSION['user'];

include 'config/configuracio.php';

$sel="SELECT tipus FROM usuaris WHERE nom='$user'";
$query=mysql_query($sel) or die ('query failed: '.mysql_error());
list($priv)=mysql_fetch_row($query);

///sólo entramos si somos "super"////

if ($priv=='super')
{

	if ($priv!='user')
	{
	$h1= "";
	}
	else
	{
	$h1= "href=''";
	}

	if ($priv=='admin' OR $priv=='super')
	{
	$h2="href='editfamilies3.php'";
	}
	else
	{
	$h2="href=''";
	}

	if ($priv=='eco' OR $priv=='super')
	{
	$h4="href='moneder_linia.php'";
	$h5="href='devolucions.php'";
	}
	else
	{
	$h4="href=''";
	$h5="href=''";
	}

?>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
		<link rel="stylesheet" type="text/css" href="coope.css" />
		<title>administracio ::: la coope</title>

<style type="text/css">
a:link{color:black; }
a:visited{color:red; }
a:hover{color:white; background-color:orange; font-weight: bold; border: 4px solid orange;}
a:active{color:white; background-color:orange; font-weight: bold;  border: 4px solid orange;}
</style>
</head>

<body>

<div class="pagina" style="margin-top: 10px;">
	<div class="contenidor_1" style="border: 1px solid red;">
	  <p class="h1" style="background: red; text-align: left; padding-left: 20px;">Administraci&oacute;n</p>

<table cellspacing="25" cellpadding="10" style="padding:0 30 0 30;">
<tr>
<td valign="top" align="left" width="33%">
  <p class="cos16">Pedidos</p>
  <ul type="circle">
  <li><a class="cos" href='grups_comandes.php'>Grupos de pedidos y cestas</a></li>
  <li><a class="cos" href='comandes.php'>Lista de pedidos y facturas</a></li>
  <li><a class="cos" <?php echo $h5; ?>>Devoluciones y facturas fuera de proceso</a></li>
  </ul>
  <p class="cos16">Socios/as-Fam&iacute;lias</p>
  <UL type="circle">
  <li><a class="cos" href='families.php'>Lista de Socios/as</a></li>
  <li><a class="cos" <?php echo $h2; ?>>Crear y editar Socios/as</a></li>
  </UL>
  <p class="cos16">Comunicaciones</p>
  <UL type="circle">
  <li><a class="cos" href='notes.php'>Introducir notas en el escritorio</a></li>
  <li><a class="cos" href='cistella_incidencia.php'>Comunicaci&oacute;n de incidencias</a></li>
  </UL>
  <p class="cos16">Monedero</p>
  <UL type="circle">
  <li><a class="cos" <?php echo $h4; ?>>Introducir línea</a></li>
  <li><a class="cos" href="comptes.php">Historia de movimientos</a></li>
  <li><a class="cos" href="moneder_usuari.php">Lista monedero de socios/as</a></li>
  </UL>
  </td>
  
  <td valign="top" align="left" width="33%">
  <p class="cos16">Procesos (de pedido)</p>
  <UL type="circle">
  <li><a class="cos" href='editprocessos.php'>Crear, editar, eliminar procesos (de pedido)</a></li>
  <li><a class="cos" href='associar.php'>Asociar procesos, grupos y categor&iacute;as</a></li>
  </UL>
  <p class="cos16">Grupos</p>
  <UL type="circle">
    <li><a class="cos" href='editgrups.php'>Crear, editar, eliminar grupos</a></li>
  </UL>
   <p class="cos16">Categor&iacute;as y subcategor&iacute;as</p>
  <UL type="circle">
  <li><a class="cos" href='categories.php'>Crear, editar, eliminar categor&iacute;as y subcategor&iacute;as</a></li>
  </UL> 
   <p class="cos16">Estad&iacute;stica</p>
  <UL type="circle">
  <li><a class="cos" href='estat_consum.php'>Estad&iacute;stica de consumo</a></li>
  <li><a class="cos" href='estat_iva.php'>Consumo IVA</a></li>
  </UL>
  </td>
  
  <td valign="top" align="left" width="33%"> 
	<p class="cos16">Productos</p>
  <UL type="circle">
  <li><a class="cos" href='baixa_productes.php'>Activar/desactivar productos</a></li>
  <li><a class="cos" href='productes.php'>Crear, editar, eliminar productos</a></li>
  <li><a class="cos" href='canvi_massiu_productes.php'>Cambiar precios, IVA y margen en listado</a></li>
  </UL>  
  <p class="cos16">Proveedores</p>
  <UL type="circle">
  <li><a class="cos" href='proveidores.php'>Crear, editar, eliminar proveedores</a></li>

  </UL>
   <p class="cos16">Albaranes</p>
  <UL type="circle">
  <li><a class="cos" href='albarans.php'>Crear, editar, eliminar albaranes</a></li>
  </UL>
  
  <p class="cos16">Stock</p>
  <UL type="circle">
  <li><a class="cos" href='inventari2.php'>Ver stock actual</a></li>
  </UL>

</td>
</tr>
</table>
</div>
</div>
</body>
</html>

<<?php 
include 'config/disconect.php';
}
else 
{
header("Location: escriptori2.php"); 
} 

}
else {
header("Location: index.php"); 
}
?>
