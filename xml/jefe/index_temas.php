<?php
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}

include("../../menu.php");
?>

<div class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<h2>Administraci�n <small>Temas para la aplicaci�n</small></h2>
</div>

<!-- SCAFFOLDING -->
<div class="row"><!-- COLUMNA IZQUIERDA -->
<div class="col-sm-6 col-sm-offset-3"><br>
<?
if (isset($_POST['tema'])) {
	$tema = $_POST['tema'];
	$file = "../../css/temas/$tema";
	$newfile = '../../css/bootstrap.min.css';

	if (!copy($file, $newfile)) {
		echo "failed to copy $file...\n";
	}
	else{
?>
<div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El tema se ha modificado correctamente. Comprueba los cambios.
</div><br />

<?	
	}
}
?>
<div class="well well-lg">
<form action="index_temas.php" enctype="multipart/form-data"
	method="post">
<div class="form-group"><label>Selecciona el tema</label> <select
	class="form-control" name="tema" onchange="submit()">
	<option><? echo $tema;?></option>
	<?
	$d = dir("../../css/temas/");
	while (false !== ($entry = $d->read())) {
		if (stristr($entry,".css")==TRUE) {
			echo "<option>$entry</option>";
		}
	}
	$d->close();
	?>
</select></div>
<p class="help-block text-justify">
Al construirse sobre <a href="http://getbootstrap.com"><strong>BootStrap</strong></a>, el aspecto que presentan las p�ginas de la Intranet puede ser modificado con temas. Los archivos <strong>CSS</strong> de los temas se encuentran en la carpeta <em>/css/temas/</em>. La aplicaci�n contiene un conjunto de temas ya preparados libres y gratuitos, descargados desde la p�gina de <a href="http://bootswatch.com"><strong>Bootswatch</strong></a>. Puedes colocar nuevos temas en ese directorio, pero recuerda que s�lo funcionan aquellos temas que contienen un �nico archivo <strong>CSS</strong>. 
</p>
</form>
</div>
</div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="thumbnail">
        <a target="_blank" href="../../img/temas/intranet.jpg" target="_blank">
      <img src="../../img/temas/intranet.jpg">
      </a>
      <div class="caption">
        <h3>Tema de la Aplicaci�n</h3>
      </div>
    </div>
    </div>
  <div class="col-sm-6">
        <div class="thumbnail">
        <a target="_blank" href="../../img/temas/bootstrap.jpg">
      <img src="../../img/temas/bootstrap.jpg">
      </a>
      <div class="caption">
        <h3>Tema standard de Bootstrap</h3>
      </div>
    </div>
    </div>
    </div>
<div class="row"> 
  <div class="col-sm-6">
        <div class="thumbnail">
        <a target="_blank" href="../../img/temas/cosmo.jpg">
      <img src="../../img/temas/cosmo.jpg">
      </a>
      <div class="caption">
        <h3>Cosmo</h3>
      </div>
    </div>
    </div>
<div class="row">    
  <div class="col-sm-6">
        <div class="thumbnail">
        <a target="_blank" href="../../img/temas/lumen.jpg">
      <img src="../../img/temas/lumen.jpg">
      </a>
      <div class="caption">
        <h3>Lumen</h3>
      </div>
    </div>
    </div>
</div>
<div class="row"> 
  <div class="col-sm-6">
        <div class="thumbnail">
        <a target="_blank" href="../../img/temas/cerulean.jpg">
      <img src="../../img/temas/cerulean.jpg">
      </a>
      <div class="caption">
        <h3>Cerulean</h3>
      </div>
    </div>
    </div>
  <div class="col-sm-6">
            <div class="thumbnail">
       <a target="_blank" href="../../img/temas/flatly.jpg">     
      <img src="../../img/temas/flatly.jpg">
      </a>
      <div class="caption">
        <h3>Flatly</h3>
      </div>
    </div>
   </div>
  </div>
</div>
</div>
<?php include("../../pie.php");	?>
