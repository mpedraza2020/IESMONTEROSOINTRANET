<?php
require('../../bootstrap.php');


$profesor = $_SESSION['profi'];

if (isset($_POST['n_dia'])) {$n_dia = $_POST['n_dia'];} elseif (isset($_GET['n_dia'])) {$n_dia = $_GET['n_dia'];} else{$n_dia="";}
if ($n_dia == 'Lunes') {	$dia = '1';}
if ($n_dia == 'Martes') { $dia = '2';}
if ($n_dia == 'Mi�rcoles') {	$dia = '3';}
if ($n_dia == 'Jueves') {	$dia = '4';}
if ($n_dia == 'Viernes') {	$dia = '5';}

include("../../menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2><?php echo $n_dia; ?> <small>Consulta de aulas libres</small></h2>
		</div>
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<div class="col-sm-12">
				
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
							<?
							$hr = mysqli_query($db_con,"select hora_inicio, hora_fin from tramos where hora < '7'");
							while ($hor = mysqli_fetch_array($hr)) {
								echo "<th>$hor[0] - $hor[1]</th>";
							}
							?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php for($i = 1; $i < 7; $i++): ?>
								<td>
								<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_aula, n_aula FROM horw WHERE a_aula NOT LIKE 'B%' AND a_aula NOT LIKE 'G%' AND a_aula NOT LIKE '' AND a_aula NOT LIKE 'ACO%' AND a_aula NOT LIKE 'DI%' ORDER BY n_aula ASC"); ?>
								<?php while ($row = mysqli_fetch_array($result)): ?>
								<?php $grupo = mysqli_query($db_con, "SELECT a_grupo FROM horw where a_aula = '$row[0]' AND dia='$dia' AND hora='$i' AND a_grupo NOT LIKE 'B%' AND a_grupo NOT LIKE 'G%' ORDER BY a_grupo ASC"); ?>

								<?php $asig = mysqli_fetch_array($grupo); ?>
								<?php if($asig['a_grupo'] == ''): ?>
									<p><a href="hor_aulas.php?aula=<?php echo $row['n_aula']; ?>"><?php echo $row['n_aula']; ?></a></p>
								<?php endif; ?>
								<?php endwhile; ?>
								</td>
								<?php endfor; ?>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="hidden-print">
					<a class="btn btn-primary" href="#" onclick="javascript:print();">Imprimir</a>
					<a class="btn btn-default" href="chorarios.php">Volver</a>
				</div>
			
			</div>
			
		</div>
		
	</div>

<?php include("../../pie.php"); ?>

</body>
</html>
