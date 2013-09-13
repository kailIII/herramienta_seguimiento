<?
$idMenu		= $_REQUEST['idMenu']?	$_REQUEST['idMenu']	:	1;
$rowAtrib[$idMenu]	= "border-top:3px solid #D76F19;";
$rowBg[$idMenu]		= " bgcolor='#282828'";
?>
   <TABLE width="100%" cellspacing="0" cellpadding="2" align='center' border="0" style="background-color:#333333">
	 <TR>
	  <TD width="10%" align='right' valign='middle' nowrap="nowrap"><div class="padding2" style='font-size:14px; color:#CCCCCC;'><B>ECOPETROL - Satisfacción de Clientes</B></div></TD>
	  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>
	  <TD width="10%" align='right' valign='middle' nowrap="nowrap" style=" <?=$rowAtrib[1]?>"<?=$rowBg[1]?>><div class="padding5"><a href="../muestra/?idMenu=1"><span style='color:#FFFFFF;'>Muestra por Servicio</span></a></div></TD>
	  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>
	  <TD align='right' valign='middle'>&nbsp;</TD>
	  <TD width="20%" align='right' nowrap="nowrap"><div class="padding2" style='color: #6699CC; font-weight: bold;'>Bienvenid@: <?=$nomUsuario?></div></TD>
	  <TD width="5%" align='right' valign="bottom" nowrap="nowrap"><div><a href="../logout_admin.php?url=/ecopetrol/cliente_interno/muestra/"><img src="/imagenes/icoblg_candado.png" alt="Salir" title="Salir" height="30" border="0" style="margin-right:5px;"></a></div></TD>
	 </TR>
   </TABLE>
