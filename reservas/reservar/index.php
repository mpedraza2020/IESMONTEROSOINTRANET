<?php
require('../../bootstrap.php');


$pr = $_SESSION['profi'];


include("../../menu.php");
include("../menu.php");

if (isset($_GET['month'])) { $month = $_GET['month']; $month = preg_replace ("/[[:space:]]/", "", $month); $month = preg_replace ("/[[:punct:]]/", "", $month); $month = preg_replace ("/[[:alpha:]]/", "", $month); }
if (isset($_GET['year'])) { $year = $_GET['year']; $year = preg_replace ("/[[:space:]]/", "", $year); $year = preg_replace ("/[[:punct:]]/", "", $year); $year = preg_replace ("/[[:alpha:]]/", "", $year); if ($year < 1990) { $year = 1990; } if ($year > 2035) { $year = 2035; } }
if (isset($_GET['today'])) { $today = $_GET['today']; $today = preg_replace ("/[[:space:]]/", "", $today); $today = preg_replace ("/[[:punct:]]/", "", $today); $today = preg_replace ("/[[:alpha:]]/", "", $today); }

$month = (isset($month)) ? $month : date("n",time());
$year = (isset($year)) ? $year : date("Y",time());
$today = (isset($today))? $today : date("j", time());
$daylong = date("l",mktime(1,1,1,$month,$today,$year));
$monthlong = date("F",mktime(1,1,1,$month,1,$year));
$dayone = date("w",mktime(1,1,1,$month,1,$year))-1;
$numdays = date("t",mktime(1,1,1,$month,1,$year));
$alldays = array('Lun','Mar','Mié','Jue','Vie','Sáb','Dom');
$next_year = $year + 1;
$last_year = $year - 1;
    if ($daylong == "Sunday")
	{$daylong = "Domingo";}
    elseif ($daylong == "Monday")
	{$daylong = "Lunes";}
    elseif ($daylong == "Tuesday")
	{$daylong = "Martes";}
    elseif ($daylong == "Wednesday")
	{$daylong = "Mércoles";}
    elseif ($daylong == "Thursday")
	{$daylong = "Jueves";}
    elseif ($daylong == "Friday")
	{$daylong = "Viernes";}
    elseif ($daylong == "Saturday")
	{$daylong = "Sábado";}


    if ($monthlong == "January")
	{$monthlong = "Enero";}
    elseif ($monthlong == "February")
	{$monthlong = "Febrero";}
    elseif ($monthlong == "March")
	{$monthlong = "Marzo";}
    elseif ($monthlong == "April")
	{$monthlong = "Abril";}
    elseif ($monthlong == "May")
	{$monthlong = "Mayo";}
    elseif ($monthlong == "June")
	{$monthlong = "Junio";}
    elseif ($monthlong == "July")
	{$monthlong = "Julio";}
    if ($monthlong == "August")
	{$monthlong = "Agosto";}
    elseif ($monthlong == "September")
	{$monthlong = "Septiembre";}
    elseif ($monthlong == "October")
	{$monthlong = "Octubre";}
    elseif ($monthlong == "November")
	{$monthlong = "Noviembre";}
    elseif ($monthlong == "December")
	{$monthlong = "Diciembre";}
if ($today > $numdays) { $today--; }

// Estructura de la Tabla
?>

<div class="container">

	<div class="page-header">
	  <h2>Sistema de Reservas <small> Reserva de <?php echo $servicio; ?></small></h2>
	</div>

	<?php if (isset($_GET['mens'])): ?>
	<?php if ($_GET['mens'] == 'actualizar'): ?>
		<div class="alert alert-success">
			La reserva se ha actualizado correctamente.
	  </div>
	<?php elseif ($_GET['mens'] == 'insertar'): ?>
		<div class="alert alert-success">
			La reserva se ha realizado correctamente.
		</div>
	<?php endif; ?>
	<?php endif; ?>

 <div class="row">

	<div class="col-sm-5">
	<?php
	$mes_sig = $month+1;
	$mes_ant = $month-1;
	$ano_ant = $ano_sig = $year;
	if ($mes_ant == 0) {
		$mes_ant = 12;
		$ano_ant = $year-1;
	}
	if ($mes_sig == 13) {
		$mes_sig = 1;
		$ano_sig = $year+1;
	}

	//Nombre del Mes
	echo "<table class=\"table table-bordered table-centered\"><thead><tr>";
	echo "<th><h4><a href=\"".$_SERVER['PHP_SELF']."?servicio=$servicio&year=".$ano_ant."&month=".$mes_ant."\"><span class=\"fas fa-arrow-circle-left fa-fw fa-lg\"></span></a></h4></th>";
	echo "<th colspan=\"5\"><h4>".$monthlong.' '.$year."</h4></th>";
	echo "<th><h4><a href=\"".$_SERVER['PHP_SELF']."?servicio=$servicio&year=".$ano_sig."&month=".$mes_sig."\"><span class=\"fas fa-arrow-circle-right fa-fw fa-lg\"></span></a></h4></th>";
	echo "</tr><tr>";


	//Nombre de DÃ­as
	foreach($alldays as $value) {
	  echo "<th>
	  $value</th>";
	}
	echo "</tr></thead><tbody><tr>";


	//DÃ­as vacÃ­os
	if ($dayone < 0) $dayone = 6;
for ($i = 0; $i < $dayone; $i++) {
	  echo "<td>&nbsp;</td>";
	}

	//DÃ­as
	for ($zz = 1; $zz <= $numdays; $zz++) {
	  if ($i >= 7) {  print("</tr><tr>"); $i=0; }

	  // Enlace
	  $enlace = $_SERVER['PHP_SELF'].'?year='.$year.'&today='.$zz.'&month='.$month.'&servicio='.$servicio;

	  // Mirar a ver si hay alguna ctividad en el dÃ­as
	  $result_found = 0;
	  if ($zz == $today) {
	    echo '<td class="calendar-today"><a href="'.$enlace.'">'.$zz.'</a></td>';
	    $result_found = 1;
	  }

	  // Enlace
	  $enlace = $_SERVER['PHP_SELF'].'?year='.$year.'&today='.$zz.'&month='.$month.'&servicio='.$servicio;

	  if ($result_found != 1) {
			//Buscar actividad para el dóa y marcarla
			$sql_currentday = "$year-$month-$zz";

	    $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7, event8, event9, event10, event11, event12, event13, event14 FROM `reservas` WHERE eventdate = '$sql_currentday' and servicio='$servicio';";
					$eventExec = mysqli_query($db_con, $eventQuery );
			if (mysqli_num_rows($eventExec)>0) {
				while ( $row = mysqli_fetch_array ( $eventExec ) ) {
	        echo '<td class="calendar-orange"><a href="'.$enlace.'">'.$zz.'</a></td>';
					$result_found = 1;
				}
			}
			else{
			$sql_currentday = "$year-$month-$zz";
			$fest = mysqli_query($db_con, "select distinct fecha, nombre from $db.festivos WHERE fecha = '$sql_currentday'");
			if (mysqli_num_rows($fest)>0) {
			$festiv=mysqli_fetch_array($fest);
				       echo '<td class="calendar-red">'.$zz.'</td>';
					$result_found = 1;
					}
			}

		}

	  if ($result_found != 1) {
	    echo '<td><a href="'.$enlace.'">'.$zz.'</a></td>';
	  }

	  $i++; $result_found = 0;
	}

	$create_emptys = 7 - (($dayone + $numdays) % 7);
	if ($create_emptys == 7) { $create_emptys = 0; }

	if ($create_emptys != 0) {
	  echo "<td colspan=\"$create_emptys\">&nbsp;</td>";
	}

	echo "</tr></tbody>";
	echo "</table>";
	echo "";
	?>
	</div>

	<div class="col-sm-7">

		<div class="well">
    <?php
  echo "<form method=\"post\" action=\"jcal_post.php?servicio=$servicio&year=$year&today=$today&month=$month\" name=\"jcal_post\">";
	echo "<legend>Reserva para el $daylong, $today de $monthlong</legend><br />";
$sql_date = "$year-$month-$today";
$semana = date( mktime(0, 0, 0, $month, $today, $year));
$hoy = getdate($semana);
$numero_dia = $hoy['wday'];
$eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7, event8, event9, event10, event11, event12, event13, event14, html FROM reservas WHERE eventdate = '$sql_date' and servicio='$servicio'";
$eventExec = mysqli_query($db_con, $eventQuery);
while($row = mysqli_fetch_array($eventExec)) {
  $event_event1 = stripslashes($row["event1"]);
  if (stristr($event_event1, '||') == true) {
    $exp_event_event1 = explode("||", $event_event1);
    $event_event1_profesor = $exp_event_event1[0];
    $event_event1_observacion = $exp_event_event1[1];
  }
  else {
    $event_event1_profesor = $event_event1;
  }
  $event_event2 = stripslashes($row["event2"]);
  if (stristr($event_event2, '||') == true) {
    $exp_event_event2 = explode('||', $event_event2);
    $event_event2_profesor = $exp_event_event2[0];
    $event_event2_observacion = $exp_event_event2[1];
  }
  else {
    $event_event2_profesor = $event_event2;
  }
  $event_event3 = stripslashes($row["event3"]);
  if (stristr($event_event3, '||') == true) {
    $exp_event_event3 = explode('||', $event_event3);
    $event_event3_profesor = $exp_event_event3[0];
    $event_event3_observacion = $exp_event_event3[1];
  }
  else {
    $event_event3_profesor = $event_event3;
  }
  $event_event4 = stripslashes($row["event4"]);
  if (stristr($event_event4, '||') == true) {
    $exp_event_event4 = explode('||', $event_event4);
    $event_event4_profesor = $exp_event_event4[0];
    $event_event4_observacion = $exp_event_event4[1];
  }
  else {
    $event_event4_profesor = $event_event4;
  }
  $event_event5 = stripslashes($row["event5"]);
  if (stristr($event_event5, '||') == true) {
    $exp_event_event5 = explode('||', $event_event5);
    $event_event5_profesor = $exp_event_event5[0];
    $event_event5_observacion = $exp_event_event5[1];
  }
  else {
    $event_event5_profesor = $event_event5;
  }
  $event_event6 = stripslashes($row["event6"]);
  if (stristr($event_event6, '||') == true) {
    $exp_event_event6 = explode('||', $event_event6);
    $event_event6_profesor = $exp_event_event6[0];
    $event_event6_observacion = $exp_event_event6[1];
  }
  else {
    $event_event6_profesor = $event_event6;
  }
  $event_event7 = stripslashes($row["event7"]);
  if (stristr($event_event7, '||') == true) {
    $exp_event_event7 = explode('||', $event_event7);
    $event_event7_profesor = $exp_event_event7[0];
    $event_event7_observacion = $exp_event_event7[1];
  }
  else {
    $event_event7_profesor = $event_event7;
  }
  $event_event8 = stripslashes($row["event8"]);
  if (stristr($event_event8, '||') == true) {
    $exp_event_event8 = explode('||', $event_event8);
    $event_event8_profesor = $exp_event_event8[0];
    $event_event8_observacion = $exp_event_event8[1];
  }
  else {
    $event_event8_profesor = $event_event8;
  }
  $event_event9 = stripslashes($row["event9"]);
  if (stristr($event_event9, '||') == true) {
    $exp_event_event9 = explode('||', $event_event9);
    $event_event9_profesor = $exp_event_event9[0];
    $event_event9_observacion = $exp_event_event9[1];
  }
  else {
    $event_event9_profesor = $event_event9;
  }
  $event_event10 = stripslashes($row["event10"]);
  if (stristr($event_event10, '||') == true) {
    $exp_event_event10 = explode('||', $event_event10);
    $event_event10_profesor = $exp_event_event10[0];
    $event_event10_observacion = $exp_event_event10[1];
  }
  else {
    $event_event10_profesor = $event_event10;
  }
  $event_event11 = stripslashes($row["event11"]);
  if (stristr($event_event11, '||') == true) {
    $exp_event_event11 = explode('||', $event_event11);
    $event_event11_profesor = $exp_event_event11[0];
    $event_event11_observacion = $exp_event_event11[1];
  }
  else {
    $event_event11_profesor = $event_event11;
  }
  $event_event12 = stripslashes($row["event12"]);
  if (stristr($event_event12, '||') == true) {
    $exp_event_event12 = explode('||', $event_event12);
    $event_event12_profesor = $exp_event_event12[0];
    $event_event12_observacion = $exp_event_event12[1];
  }
  else {
    $event_event12_profesor = $event_event12;
  }
  $event_event13 = stripslashes($row["event13"]);
  if (stristr($event_event13, '||') == true) {
    $exp_event_event13 = explode('||', $event_event13);
    $event_event13_profesor = $exp_event_event13[0];
    $event_event13_observacion = $exp_event_event13[1];
  }
  else {
    $event_event13_profesor = $event_event13;
  }
  $event_event14 = stripslashes($row["event14"]);
  if (stristr($event_event14, '||') == true) {
    $exp_event_event14 = explode('||', $event_event14);
    $event_event14_profesor = $exp_event_event14[0];
    $event_event14_observacion = $exp_event_event14[1];
  }
  else {
    $event_event14_profesor = $event_event14;
  }
}

if($_SESSION['profi'] == 'conserje' or stristr($_SESSION['cargo'],'1') == TRUE){$SQL = "select distinct nombre from $db.departamentos order by nombre";}
else{$SQL = "select distinct nombre from $db.departamentos where nombre = '". $_SESSION['profi'] ."'";}

if($servicio){
$eventQuery2 = "SELECT hora1 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0) == 1) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>1ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event1_profesor)) { echo "<label>1ª hora</label> &nbsp;&nbsp; <select name=\"day_event1\" class=\"form-control\"><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event1_profesor)) {
    echo "<label>1ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event1\"  value=\"$event_event1_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event1_obs\" rows=\"2\" maxlength=\"190\">$event_event1_observacion</textarea>";
    echo "</div>";
  }
	else{
    echo "<label>1ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event1_profesor'></div>";
    if (isset($event_event1_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event1_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event1_profesor\" name=\"day_event1\">";
  }
}}
	echo '</div>';


if($servicio){$eventQuery2 = "SELECT hora2 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "<label>2ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
		echo '<div class="form-group">';
if (empty($event_event2_profesor)) { echo "<label>2ª hora</label> &nbsp;&nbsp; <select name=\"day_event2\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event2_profesor)) {
    echo "<label>2ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event2\"  value=\"$event_event2_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event2_obs\" rows=\"2\" maxlength=\"190\">$event_event2_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>2ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event2_profesor'></div>";
    if (isset($event_event2_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event2_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event2_profesor\" name=\"day_event2\">";
  } }	}
	echo '</div>';


if($servicio){$eventQuery2 = "SELECT hora3 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "<label>3ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
		echo '<div class="form-group">';
if(empty($event_event3_profesor)) { echo "<label>3ª hora</label> &nbsp;&nbsp; <select name=\"day_event3\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {

	if(mb_strtolower($pr) == mb_strtolower($event_event3_profesor)) {
    echo "<label>3ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event3\"  value=\"$event_event3_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event3_obs\" rows=\"2\" maxlength=\"190\">$event_event3_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>3ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event3_profesor'></div>";
    if (isset($event_event3_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event3_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event3_profesor\" name=\"day_event3\">";
  } }	}
	echo '</div>';


if($servicio){$eventQuery2 = "SELECT hora4 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "<label>4ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
		echo '<div class="form-group">';
if (empty($event_event4_profesor)) { echo "<label>4ª hora</label> &nbsp;&nbsp; <select name=\"day_event4\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event4_profesor)) {
      echo "<label>4ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
      echo "<input class=\"form-control\" type=\"text\" name=\"day_event4\"  value=\"$event_event4_profesor\">";
      echo "<label><small>Observaciones</small></label>";
      echo "<textarea class=\"form-control\" name=\"day_event4_obs\" rows=\"2\" maxlength=\"190\">$event_event4_observacion</textarea>";
      echo "</div>"; }
  else{
    echo "<label>4ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event4_profesor'></div>";
    if (isset($event_event4_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event4_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event4_profesor\" name=\"day_event4\">";
  } }	}
	echo '</div>';


if($servicio){$eventQuery2 = "SELECT hora5 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	if(!(empty($reservado1[0]))) {echo "5 Hora &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
		echo '<div class="form-group">';
if (empty($event_event5_profesor)) { echo "<label>5ª hora</label> &nbsp;&nbsp; <select name=\"day_event5\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event5_profesor)) {
    echo "<label>5ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event5\"  value=\"$event_event5_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event5_obs\" rows=\"2\" maxlength=\"190\">$event_event5_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>5ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event5_profesor'></div>";
    if (isset($event_event5_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event5_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event5_profesor\" name=\"day_event5\">";
  } }	}
	echo '</div>';


if($servicio){$eventQuery2 = "SELECT hora6 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>6ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event6_profesor)) { echo "<label>6ª hora</label> &nbsp;&nbsp; <select name=\"day_event6\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event6_profesor)) {
    echo "<label>6ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event6\"  value=\"$event_event6_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event6_obs\" rows=\"2\" maxlength=\"190\">$event_event6_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>6ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event6_profesor'></div>";
    if (isset($event_event6_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event6_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event6_profesor\" name=\"day_event6\">";
  } }	}
	echo '</div>';


if($servicio){$eventQuery2 = "SELECT hora7 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>7ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event7_profesor)) { echo "<label>7ª hora</label> &nbsp;&nbsp; <select name=\"day_event7\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event7_profesor)) {
    echo "<label>7ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event7\"  value=\"$event_event7_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event7_obs\" rows=\"2\" maxlength=\"190\">$event_event7_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>7ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event7_profesor'></div>";
    if (isset($event_event7_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event7_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event7_profesor\" name=\"day_event7\">";
  } }
	}
	echo '</div>';

if($servicio){$eventQuery2 = "SELECT hora8 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>8ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event8_profesor)) { echo "<label>8ª hora</label> &nbsp;&nbsp; <select name=\"day_event8\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event8_profesor)) {
    echo "<label>8ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event8\"  value=\"$event_event8_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event8_obs\" rows=\"2\" maxlength=\"190\">$event_event8_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>8ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event8_profesor'></div>";
    if (isset($event_event8_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event8_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event8_profesor\" name=\"day_event8\">";
  } }
	}
	echo '</div>';

if($servicio){$eventQuery2 = "SELECT hora9 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>9ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event9_profesor)) { echo "<label>9ª hora</label> &nbsp;&nbsp; <select name=\"day_event9\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event9_profesor)) {
    echo "<label>9ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event9\"  value=\"$event_event9_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event9_obs\" rows=\"2\" maxlength=\"190\">$event_event9_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>9ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event9_profesor'></div>";
    if (isset($event_event9_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event9_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event9_profesor\" name=\"day_event9\">";
  } }
	}
	echo '</div>';

if($servicio){$eventQuery2 = "SELECT hora10 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>10ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event10_profesor)) { echo "<label>10ª hora</label> &nbsp;&nbsp; <select name=\"day_event10\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event10_profesor)) {
    echo "<label>10ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event10\"  value=\"$event_event10_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event10_obs\" rows=\"2\" maxlength=\"190\">$event_event10_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>10ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event10_profesor'></div>";
    if (isset($event_event10_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event10_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event10_profesor\" name=\"day_event10\">";
  } }
	}
	echo '</div>';

if($servicio){$eventQuery2 = "SELECT hora11 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>11ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event11_profesor)) { echo "<label>11ª hora</label> &nbsp;&nbsp; <select name=\"day_event11\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event11_profesor)) {
    echo "<label>11ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event11\"  value=\"$event_event11_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event11_obs\" rows=\"2\" maxlength=\"190\">$event_event11_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>11ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event11_profesor'></div>";
    if (isset($event_event11_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event11_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event11_profesor\" name=\"day_event11\">";
  } }
	}
	echo '</div>';

if($servicio){$eventQuery2 = "SELECT hora12 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>12ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event12_profesor)) { echo "<label>12ª hora</label> &nbsp;&nbsp; <select name=\"day_event12\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event12_profesor)) {
    echo "<label>12ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event12\"  value=\"$event_event12_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event12_obs\" rows=\"2\" maxlength=\"190\">$event_event12_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>12ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event12_profesor'></div>";
    if (isset($event_event12_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event12_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event12_profesor\" name=\"day_event12\">";
  } }
	}
	echo '</div>';

if($servicio){$eventQuery2 = "SELECT hora13 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>13ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event13_profesor)) { echo "<label>13ª hora</label> &nbsp;&nbsp; <select name=\"day_event13\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event13_profesor)) {
    echo "<label>13ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event13\"  value=\"$event_event13_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event13_obs\" rows=\"2\" maxlength=\"190\">$event_event13_observacion</textarea>";
    echo "</div>"; }
  else{
    echo "<label>13ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event13_profesor'></div>";
    if (isset($event_event13_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event13_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event13_profesor\" name=\"day_event13\">";
  } }
	}
	echo '</div>';

if($servicio){$eventQuery2 = "SELECT hora14 FROM reservas_hor WHERE dia = '$numero_dia' and servicio='$servicio'";
$reservado0 = mysqli_query($db_con, $eventQuery2);
if (mysqli_num_rows($reservado0)>0) {
$reservado1 = mysqli_fetch_row($reservado0);
}
}
	echo '<div class="form-group">';
	if(!(empty($reservado1[0]))) {echo "<label>14ª hora</label> &nbsp;&nbsp; <span class='badge badge-warning'>$reservado1[0]</span>"; }
	else
	{
if (empty($event_event14_profesor)) { echo "<label>14ª hora</label> &nbsp;&nbsp; <select name=\"day_event14\" class='form-control'><option></option>";
	$result1 = mysqli_query($db_con, $SQL);
	while($row1 = mysqli_fetch_array($result1)){ $profesor = $row1[0];
	echo "<option>" . $profesor . "</option>";
	} echo "</select>";}
	else {
	if(mb_strtolower($pr) == mb_strtolower($event_event14_profesor)) {
    echo "<label>14ª Hora</label> &nbsp;&nbsp; <div class=\"form-group\">";
    echo "<input class=\"form-control\" type=\"text\" name=\"day_event14\"  value=\"$event_event14_profesor\">";
    echo "<label><small>Observaciones</small></label>";
    echo "<textarea class=\"form-control\" name=\"day_event14_obs\" rows=\"2\" maxlength=\"190\">$event_event14_observacion</textarea>";
    echo "</div>"; }
	else{
    echo "<label>14ª hora</label> &nbsp;&nbsp; <div class=\"form-group\"><input disabled class=\"form-control\" type=\"text\"  value='$event_event14_profesor'></div>";
    if (isset($event_event14_observacion)){
      echo "<textarea disabled class=\"form-control\" rows=\"2\" maxlength=\"190\">$event_event14_observacion</textarea>";
    }
    echo "<input type=\"hidden\" value=\"$event_event14_profesor\" name=\"day_event14\">";
  } }
	}
	echo '</div>';

echo "<input type=\"hidden\" value=\"$year\" name=\"year\">
      <input type=\"hidden\" value=\"$month\" name=\"month\">
      <input type=\"hidden\" value=\"$today\" name=\"today\">
      <input type=\"submit\" class=\"btn btn-primary\" id=\"formsubmit\" value=\"Reservar\">
    </form>";
echo "</div>";
?>
</div>
</div>
</div>

<?php
include("../../pie.php");
?>
</body>
</html>
