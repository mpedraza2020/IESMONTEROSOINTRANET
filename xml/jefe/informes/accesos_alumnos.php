<?
session_start();

include("../../../config.php");
if ($_SESSION['autentificado']!='1') {
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");	
	exit;
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

$profe = $_SESSION['profi'];

if(!(stristr($_SESSION['cargo'],'1') == TRUE)) {
	header("location:http://$dominio/intranet/salir.php");
	exit;	
}
?>
<?
include("../../../menu.php"); 
$datatables_activado=true;
?>
	
	<div class="container">
	
	<?php
	$query_accesos = mysql_query("SELECT rp.claveal, COUNT(*) AS accesos FROM reg_principal AS rp GROUP BY claveal, pagina HAVING pagina='/notas/control.php' ORDER BY claveal ASC");
	?>
		
		<!-- TITULO DE LA PAGINA -->
		
		<div class="page-header">
			<h2 class="page-title" align="center">Informe de accesos de alumnos a la Intranet</h2>
		</div>
		
		
		<!-- CONTENIDO DE LA PAGINA -->
		
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
			
			    <div class="no_imprimir">
			      <a href="../../index.php" class="btn btn-default">Volver</a>
			      <a href="#" class="btn btn-primary" onclick="print()"><i class="fa fa-print"></i> Imprimir</a>
			      <br><br>
			    </div>
				
				<table class="table table-bordered table-condensed table-striped tabladatos">
					<thead>
						<tr>
							<th>Alumno/a</th>
							<th>Unidad</th>
							<th>Total accesos</th>
							<th>Fecha �ltimo acceso</th>
						</tr>
					</thead>
					<tbody>
					  <?php 
					  while ($row = mysql_fetch_object($query_accesos)):
					  	
					  	$subquery = mysql_query("SELECT CONCAT(apellidos,', ',nombre) AS alumno, unidad FROM alma WHERE claveal=$row->claveal LIMIT 1");
					  	$datos = mysql_fetch_object($subquery);
					  	mysql_free_result($subquery);
					  	
					  	$subquery2 = mysql_query("SELECT fecha FROM reg_principal WHERE claveal=$row->claveal ORDER BY fecha DESC LIMIT 1");
					  	$fecha = mysql_fetch_object($subquery2);
					  	mysql_free_result($subquery2);
					  	
					  	if($datos->alumno != "" && $datos->unidad != ""):
					  ?>
					  	<tr>
					  		<td><?php echo $datos->alumno; ?></td>
								<td><?php echo $datos->unidad; ?></td>
					  		<td><?php echo $row->accesos; ?></td>
								<td><?php echo $fecha->fecha; ?></td>
					  	</tr>
					  <?php 
					  	endif;
					  endwhile;
					  mysql_free_result($query_accesos);
					  ?>
					</tbody>
				</table>
				
			</div><!-- /.col-sm-12 -->
		</div><!-- /.row -->
	  
	</div><!-- /.container -->
	
	<br>

<?php include('../../../pie.php'); ?>
	
</body>
</html>