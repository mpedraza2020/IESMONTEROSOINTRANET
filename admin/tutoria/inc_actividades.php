<?php if (! defined('INC_TUTORIA')) die ('<h1>Forbidden</h1>'); ?>

<!-- ACTIVIDADES EXTRAESCOLARES -->

<h3>Actividades extraescolares</h3>

<?php $meses = array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'); ?>
<?php $grupo = str_replace('-', '', $_SESSION['mod_tutoria']['unidad']); ?>
<?php $result = mysqli_query($db_con, "SELECT DISTINCT MONTH(fecha) AS mes FROM actividades WHERE grupos LIKE '%$grupo-%' ORDER BY MONTH(fecha) ASC"); ?>
<?php if (mysqli_num_rows($result)): ?>
<?php while ($row = mysqli_fetch_array($result)): ?>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="text-center"><?php echo $meses[$row['mes']]; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $result1 = mysqli_query($db_con, "SELECT * FROM actividades WHERE MONTH(fecha)='".$row['mes']."' AND grupos LIKE '%$grupo-%' ORDER BY fecha ASC"); ?>
		<?php while ($row1 = mysqli_fetch_array($result1)): ?>
		<tr>
			<td>
				<div class="pull-right"><?php echo strftime('%e %b',strtotime($row1[7])); ?></div>
				<p><a href="det_actividades.php?id=<?php echo $row1[0]; ?>"><?php echo $row1[2]; ?></a></p>
				<?php echo $row1[4]; ?>
			</td>
		</tr>
		<?php endwhile; ?>
		<?php mysqli_free_result($result1); ?>
	</tbody>
</table>
<?php endwhile; ?>
<?php mysqli_free_result($result); ?>

<?php else: ?>

<br>
<p class="lead text-muted">No hay actividades extraescolares registradas para esta unidad.</p>
<br>

<?php endif; ?>

<!-- FIN ACTIVIDADES EXTRAESCOLARES -->
