
<?php session_start();

	if(isset($_GET["nuevo"])){
		session_unset();
	}	

	if(isset($_SESSION["mat"])){
		$mat=$_SESSION["mat"];		
	}else{
		$mat=iniciar_tablero();
		$_SESSION["puntaje"]=0;
	}

	if(isset($_GET["arriba"])){
		$mat_arriba=arriba($mat);
		$mat_arriba=suma_arriba($mat_arriba);
		$mat_arriba=arriba($mat_arriba);
		if(diferente($mat_arriba,$mat)){
			$mat=nueva_ficha($mat_arriba);		
		}		
	}

	if(isset($_GET["abajo"])){
		$mat_abajo=abajo($mat);
		$mat_abajo=suma_abajo($mat_abajo);
		$mat_abajo=abajo($mat_abajo);
		if(diferente($mat_abajo,$mat)){
			$mat=nueva_ficha($mat_abajo);		
		}		
	}

	if(isset($_GET["derecha"])){
		$mat_derecha=derecha($mat);
		$mat_derecha=suma_derecha($mat_derecha);
		$mat_derecha=derecha($mat_derecha);
		if(diferente($mat_derecha,$mat)){
			$mat=nueva_ficha($mat_derecha);		
		}		
	}

	if(isset($_GET["izquierda"])){
		$mat_izquierda=izquierda($mat);
		$mat_izquierda=suma_izquierda($mat_izquierda);
		$mat_izquierda=izquierda($mat_izquierda);
		if(diferente($mat_izquierda,$mat)){
			$mat=nueva_ficha($mat_izquierda);		
		}			
	}

	if(isset($_GET["prueba"])){
		$mat=nueva_ficha($mat);	
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>2048</title>
</head>
<h1>JUEGA 2048</h1>
<body>
<?php
imprimir_tablero($mat);
echo("</br>");
echo("</br>");
echo("</br>");



$_SESSION["mat"]=$mat;
?>
<form method="$_GET">	
	<?php
	if(!jugada($mat)){
		echo("<h2>DERROTA</h2>");
	}else if(victoria($mat)){
		echo("<h2>VICTORIA</h2>");
	}else{
	?>	
	<button type="submit" name="arriba" value="arriba">arriba</button>
	<button type="submit" name="abajo" value="abajo">abajo</button>	
	<button type="submit" name="izquierda" value="izquierda">izquierda</button>
	<button type="submit" name="derecha" value="derecha">derecha</button>
	<?php
	}
	?>
	
	</br></br></br></br>
	<button type="submit" name="nuevo" value="nuevo">nuevo</button>
</form>

</body>
</html>

<?php
function iniciar_tablero(){
	for ($i=0; $i <4; $i++) {
		for ($j=0; $j <4; $j++) {
			$mat[$i][$j] = 0;    
		}
	}
	$mat=nueva_ficha($mat);
	$mat=nueva_ficha($mat);
	return $mat;
}

function vacias_tablero($mat){
	$n=0;
	for ($i=0; $i <4; $i++) {
		for ($j=0; $j <4; $j++) {
			if($mat[$i][$j] == 0){
				$n++;
			}
		}
	}	
	return $n++;
}

function nueva_ficha($mat){
	if(vacias_tablero($mat)>0){
		do{
			$fila=rand(0,3);
			$columna=rand(0,3);	
		}while($mat[$fila][$columna]!=0);
		$mat[$fila][$columna]=rand(1,2)*2;
		return $mat;	
	}else{
		return $mat;	
	}
	
}

?>
<style>
	.tablita{
		border: 1px solid black;
  		font-size: 36px;  
  		col width="20px";
	}
	.casilla {
			  		
	}
	.cero{
		color: rgb(230,230,230);
		background-color: rgb(230,230,230);
	}
</style>

<?php
function imprimir_tablero($mat){
	echo('<table class=tablita> ');
	echo('<col width="40px" />');
	echo('<col width="40px" />');
	echo('<col width="40px" />');
	echo('<col width="40px" />');
	
	for ($i=0; $i <4; $i++) {	
		echo("<tr>");
		
		for ($j=0; $j <4; $j++) {
			
			if($mat[$i][$j]>0){
				echo("<th style= background-color:rgb(150,".(255-$mat[$i][$j]*5).",150)>");
				echo($mat[$i][$j]."</th>");	
			}else{
				echo("<th class='cero'>0</th>");	
			}
			
		}
		echo("</tr>");
	}
	echo("</table>");
}

function arriba($mat){
	for ($col=0; $col <4; $col++) {
		for($fila=1;$fila<4;$fila++){
			$aux=$fila;
			while($aux>0&&$mat[$aux][$col]>0&&$mat[$aux-1][$col]==0){
				$mat[$aux-1][$col]=$mat[$aux][$col];
				$mat[$aux][$col]=0;
				$aux--;
			}
		}
	}
	return $mat;
}
function suma_arriba($mat){
	for ($col=0; $col <4; $col++) {
		for($fila=1;$fila<4;$fila++){
			$aux=$fila;
			if($aux>0&&$mat[$aux][$col]==$mat[$aux-1][$col]){
				$mat[$aux-1][$col]=$mat[$aux][$col]*2;				
				$mat[$aux][$col]=0;
				$aux--;
			}
		}
	}
	return $mat;
}

function abajo($mat){
	for ($col=0; $col <4; $col++) {
		for($fila=3;$fila>=0;$fila--){
			$aux=$fila;
			while($aux<3&&$mat[$aux][$col]>0&&$mat[$aux+1][$col]==0){
				$mat[$aux+1][$col]=$mat[$aux][$col];
				$mat[$aux][$col]=0;
				$aux++;
			}
		}
	}
	return $mat;
}
function suma_abajo($mat){
	for ($col=0; $col <4; $col++) {
		for($fila=3;$fila>=0;$fila--){
			$aux=$fila;
			if($aux<3&&$mat[$aux][$col]==$mat[$aux+1][$col]){
				$mat[$aux+1][$col]=$mat[$aux][$col]*2;				
				$mat[$aux][$col]=0;
				$aux++;
			}
		}
	}
	return $mat;
}

function derecha($mat){
	for ($fila=0; $fila <4; $fila++) {
		for($col=3;$col>=0;$col--){
			$aux=$col;
			while($aux<3&&$mat[$fila][$aux]>0&&$mat[$fila][$aux+1]==0){
				$mat[$fila][$aux+1]=$mat[$fila][$aux];
				$mat[$fila][$aux]=0;
				$aux++;
			}
		}
	}
	return $mat;
}
function suma_derecha($mat){
	for ($fila=0; $fila <4; $fila++) {
		for($col=3;$col>=0;$col--){
			$aux=$col;
			if($aux<3&&$mat[$fila][$aux]==$mat[$fila][$aux+1]){
				$mat[$fila][$aux+1]=$mat[$fila][$aux]*2;				
				$mat[$fila][$aux]=0;
				$aux++;
			}
		}
	}
	return $mat;
}

function izquierda($mat){
	for ($fila=0; $fila <4; $fila++) {
		for($col=1;$col<4;$col++){
			$aux=$col;
			while($aux>0&&$mat[$fila][$aux]>0&&$mat[$fila][$aux-1]==0){
				$mat[$fila][$aux-1]=$mat[$fila][$aux];
				$mat[$fila][$aux]=0;
				$aux--;
			}
		}
	}
	return $mat;
}

function suma_izquierda($mat){
	for ($fila=0; $fila <4; $fila++) {
		for($col=1;$col<4;$col++){
			$aux=$col;
			if($aux>0&&$mat[$fila][$aux]==$mat[$fila][$aux-1]){
				$mat[$fila][$aux-1]=$mat[$fila][$aux]*2;				
				$mat[$fila][$aux]=0;
				$aux--;
			}
		}
	}
	return $mat;
}

function victoria($mat){
	for ($fila=0; $fila <4; $fila++) {
		for($col=0;$col<4;$col++){
			if($mat[$fila][$col]==2048){
				return true;
			}
		}
	}
	return false;
}

function diferente($mat,$mot){
	for ($fila=0; $fila <4; $fila++) {
		for($col=0;$col<4;$col++){
			if($mat[$fila][$col]!=$mot[$fila][$col]){
				return true;
			}
		}
	}
	return false;
}

function jugada($mat){
	$mat_arriba=arriba($mat);
	$mat_arriba=suma_arriba($mat_arriba);
	$mat_arriba=arriba($mat_arriba);


	$mat_derecha=derecha($mat);
	$mat_derecha=suma_derecha($mat_derecha);
	$mat_derecha=derecha($mat_derecha);

	$mat_izquierda=izquierda($mat);
	$mat_izquierda=suma_izquierda($mat_izquierda);
	$mat_izquierda=izquierda($mat_izquierda);

	$mat_abajo=abajo($mat);
	$mat_abajo=suma_abajo($mat_abajo);
	$mat_abajo=abajo($mat_abajo);


	$jugada=false;

	$r_derecha=diferente($mat, $mat_derecha);
	$r_izquierda=diferente($mat, $mat_izquierda);
	$r_arriba=diferente($mat, $mat_arriba);
	$r_abajo=diferente($mat, $mat_abajo);

	if($r_derecha){
		$jugada=true;
	}
	
	if($r_izquierda){
		$jugada=true;
	}

	if($r_arriba){
		$jugada=true;
	}

	if($r_abajo){
		$jugada=true;
	}
	return $jugada;
}


?>