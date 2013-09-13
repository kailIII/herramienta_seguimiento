<?
$color_pie_c	= '336699';
$color_pie_c	= '6699CC';

function porcentaje($t_base, $t_evaluado, $ndecimales=1){
	$porcentaje_t = 0;
	if($t_base > 0){
		$porcentaje_t = round((($t_evaluado/$t_base)*100),$ndecimales);
	}else{
		$porcentaje_t = 0;
	}
	return $porcentaje_t;
}
?>