<?
function redondeo($n){

	$entero10 = explode(".",$n);
		if (strlen($entero10[1]) > 2) {
		//redondeo o truncamiento seg�n los casos
		
			if (substr($entero10[1],2,1) > 5){$n = $entero10[0].".". substr($entero10[1],0,2)+0.01;}
		    else {$n = $entero10[0].".". substr($entero10[1],0,2);}
			echo $n;
									}
									
		else {echo $n;}
					}


function tipo()
{
  $tipo = "select distinct tipo from listafechorias";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<OPTION>$tipo2[0]</OPTION>";
        }
}

function medida2($tipofechoria)
{
  $tipo = "select distinct medidas2 from listafechorias where fechoria = '$tipofechoria'";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
$texto = trim($tipo2[0]);
echo "$texto";
        }
}

function fechoria($clase)
{
  $tipofechoria0 = "select fechoria from listafechorias where tipo = '$clase' order by fechoria";
  $tipofechoria1 = mysql_query($tipofechoria0);
  while($tipofechoria2 = mysql_fetch_array($tipofechoria1))
        {
echo "<option>$tipofechoria2[0]</option>";
        }
}

function horario_alumno($grupo)
{
//  include("opt/e-smith/config.php");  
  
   echo "<br /><h3>Horario del Grupo $grupo</h3><br />";
  ?>
<table class="table table-striped" width="95%">
    <tr> 
    <th></th>
    <th>  
      1�</th>
    <th> 
      2�</th>
    <th>
      3�</th>
    <th>
      4�</th>
    <th> 
      5�</th>
    <th> 
      6�</th>
  </tr>
  
<?
// D�as de la semana 
$a=array("1"=>"Lunes","2"=>"Martes","3"=>"Mi�rcoles","4"=>"Jueves","5"=>"Viernes");
foreach($a as $dia => $nombre) {
echo "<tr><th style='background-color:#f6f6f6;border-right:1px solid #ccc'>$nombre</th>";
for($i=1;$i<7;$i++) {
echo "<td>";
$curso = $grupo;
$sqlasig0 = "SELECT distinct  asig, c_asig FROM  horw where a_grupo = '$curso' and dia = '$dia' and hora = '$i'";
$asignaturas1 = mysql_query($sqlasig0);
 while ($rowasignaturas1 = mysql_fetch_array($asignaturas1))
{ 
echo $rowasignaturas1[0]."<br />";
}
echo "</td>";
}
echo "<tr>";
}
echo "</table><hr>";

 echo "<br /><h3>Profesores del Grupo $grupo</h3><br />";
 echo "<ul class='unstyled'>";
 $profe = "SELECT  distinct PROFESOR, MATERIA FROM profesores, alma where alma.unidad = profesores.grupo and alma.unidad = '$grupo'";
 $profeq = mysql_query($profe);
 while($profer = mysql_fetch_array($profeq)){
 echo "<li><i class='fa fa-user'> </i> 
$profer[1] ==>  $profer[0]</li>";}
echo "</ul>";
}

function unidad()
{
 // include("opt/e-smith/config.php");  
  
  $tipo = "select distinct unidad from alma order by unidad";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }
}
/*
function nivel()
{
 // include("opt/e-smith/config.php");  
  
  $tipo = "select distinct NIVEL from alma order by NIVEL";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }
}

function grupo($niveles)
{
 // include("opt/e-smith/config.php");  
  
  $tipo = "select distinct GRUPO from alma where NIVEL = '$niveles' order by GRUPO";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }
}
*/
function variables()
{
foreach($_POST as $key => $val)
{
echo "$key --> $val<br>";
}
}

// Comprueba si es fecha en formato dd/mm/aaaa o dd-mm-aaaa
// false si no true si si lo es
function es_fecha($fec)
{
if (empty($fec))
       return false;
    else
    {
    # Tanto si es con / o con - la convertimos a -
       $fec = strtr($fec,"/","-");
    # la cortamos en trozos  
     if (ereg("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $fec, $fec_ok)) {
     return checkdate($fec_ok[2],$fec_ok[1],$fec_ok[3]);
			} else {
	return false;
			}
    }
#checkdate(mes,dia,a�o); 
}

// DAR LA VUELTA A LA FECHA
function cambia_fecha($fec)
{
    if (empty($fec))
       return "";
    else
    {
    # Tanto si es con / o con - la convertimos a -
       $fec = strtr($fec,"/","-");
    # la cortamos en trozos  
			 $fec_ok=explode("-",$fec);
		# la devolvemos en el orden contrario	 
       return ($fec_ok[2]."-".$fec_ok[1]."-".$fec_ok[0]);
    }
} 


function cambia_fecha_dia_mes($fec)
{
    if (empty($fec))
       return "";
    else
    {
    # Tanto si es con / o con - la convertimos a -
       $fec = strtr($fec,"/","-");
    # la cortamos en trozos  
			 $fec_ok=explode("-",$fec);
		# la devolvemos en el orden contrario	 
       return ($fec_ok[2]."-".$fec_ok[1]);
    }
}


function elmes($m){
$mes["01"] = "enero";
$mes["02"] = "febrero";
$mes["03"] = "marzo";
$mes["04"] = "abril";
$mes["05"] = "mayo";
$mes["06"] = "junio";
$mes["07"] = "julio";
$mes["08"] = "agosto";
$mes["09"] = "septiembre";
$mes["10"] = "octubre";
$mes["11"] = "noviembre";
$mes["12"] = "diciembre";
return $mes[$m];
}

function formatea_fecha($fec){
$fec = strtr($fec,"/","-");
$fec_ok=explode("-",$fec);
return ($fec_ok[2]." de ".elmes($fec_ok[1])." de ".$fec_ok[0]);
}
?>
<?
function formatDate($val)
{
	$arr = explode("-", $val);
	return date("d M Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
	
}
function fecha_actual($valor_fecha){

/*    if($valor_fecha == ""){
*/	$mes = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
                 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
    $dia = array("domingo", "lunes","martes","mi�rcoles","jueves","viernes","s�bado");
	$diames = date("j");
    $nmes = date("n");
    $ndia = date("w");
    $nano = date("Y");
	    echo $diames." de ".$mes[$nmes].", ".$nano;
/*	}
	else{
	$arr = explode("-", $valor_fecha);
    $mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
                 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
    $dia0 = array("domingo", "lunes","martes","mi�rcoles","jueves","viernes","s�bado"); 
	$diames0 = date("j",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	$nmes0 = $arr[1];
	if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}	
   // $ndia0 = $arr[2];
	$ndia0 = date("w",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
    $nano0 = $arr[0];
	echo "$diames0 de ".$mes0[$nmes0].", $nano0";
}	*/
}
function fecha_actual3($valor_fecha){

	$arr0 = explode(" ", $valor_fecha);
	$arr = explode("-", $arr0[0]);
    $mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
                 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
    $dia0 = array("domingo", "lunes","martes","mi�rcoles","jueves","viernes","s�bado"); 
	$diames0 = date("j",mktime($arr[1],$arr[2],$arr[0]));
	$nmes0 = $arr[1];
	if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}	
   // $ndia0 = $arr[2];
	$ndia0 = date("w",mktime($arr[1],$arr[2],$arr[0]));
    $nano0 = $arr[0];
	echo "$diames0 de ".$mes0[$nmes0];
}

function fecha_actual2($valor_fecha){
	$arr0 = explode(" ", $valor_fecha);
	$arr = explode("-", $arr0[0]);
    $mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
                 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
    $dia0 = array("domingo", "lunes","martes","mi�rcoles","jueves","viernes","s�bado"); 
	$diames0 = date("j",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	$nmes0 = $arr[1];
	if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}	
   // $ndia0 = $arr[2];
	$ndia0 = date("w",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
    $nano0 = $arr[0];
	return "$diames0 de ".$mes0[$nmes0].", $nano0";
}

function fecha_sin($valor_fecha){
/*    if($valor_fecha == ""){
	$mes = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
                 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
    $dia = array("domingo", "lunes","martes","mi�rcoles","jueves","viernes","s�bado");
	$diames = date("j");
    $nmes = date("n");
    $ndia = date("w");
    $nano = date("Y");
	    echo "$diames de ".$mes[$nmes].", $nano";
	}
	else{*/
	$arr0 = explode(" ", $valor_fecha);
	$arr = explode("-", $arr0[0]);
    $mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
                 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
	$diames0 = date("j",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	$nmes0 = $arr[1];
	if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}	
   // $ndia0 = $arr[2];
	$ndia0 = date("w",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
    $nano0 = $arr[0];
	echo "$diames0 de ".$mes0[$nmes0].", $nano0";
//}	
}
//Asignacion de ordenadores a alumnos
function posicion($curso,$profi){

$sql=mysql_query("select distinct no_mesa from AsignacionMesasTIC where agrupamiento='$curso' and prof='$profi' order by no_mesa");
while ($sqlr=mysql_fetch_array($sql)){
    $posi=$sqlr[0];
	echo "<option>".$posi."</option>";
}

}

function alumno($curso,$profi){
$sql=mysql_query("select CLAVEAL,no_mesa from AsignacionMesasTIC where agrupamiento='$curso' and prof='$profi' and no_mesa not like ' '");
echo "select CLAVEAL,no_mesa from AsignacionMesasTIC where agrupamiento='$curso' and prof='$profi' and no_mesa not like ' '";
while ($sqlr=mysql_fetch_array($sql)){
$al=mysql_query("select NOMBRE,APELLIDOS from FALUMNOS where CLAVEAL='$sqlr[0]' order by APELLIDOS");
while ($alr=mysql_fetch_array($al)){
	 $nombre=$alr[1] .', '.$alr[0].'-->'.$sqlr[0];
     echo"<option>";
	 echo $nombre;
	 echo "</option>";}}
}

// Eliminar nombre de profesor con may�sculas completo
function eliminar_mayusculas(&$n_profeso) {
	$n_profeso = mb_strtolower($n_profeso);
	$n_profeso = ucwords($n_profeso);
	//return $n_profeso;
	//echo "<span class='text-capitalize'>$minusc</span>";
}
?>
