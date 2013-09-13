<?
include("../ctl_login_admin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK rel="stylesheet" href="../style.css" type="text/css">
<script language="JavaScript" type="text/javascript" src="ajax/ajax5.js"></script>
</HEAD>
<BODY style="background-color:#FFFFFF">
<FORM name='index' id='index' action='' method='post'>
<INPUT type='hidden' name='cRegInicial' id='cRegInicial' value='0'>
<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#FFFFFF">
 <TR>
  <TD>
  <? //=$sup?>
   <TABLE width="100%" cellspacing="0" cellpadding="2" align='center' border="0">
	 <TR>
	  <TD width="15%" align="left"><IMG src='/imagenes/logoEcopetrolgnn2.jpg' height="75" border='0'></TD>
	  <TD width="15%" align="left" nowrap="nowrap"><div style="font-size:16px; padding:20px;">Cliente Interno</div></TD>
	  <TD width="60%" align='right' valign="bottom"><div style='font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #6699CC; font-weight: bold; margin-left:10px;'>Usuario: <?=$nomUsuario?></div></TD>
	 </TR>
   </TABLE>
  <? //=$inf?>
  </TD>
 </TR>
 <TR>
  <TD>
	<TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
	  <TR>
	   <TD width="10" nowrap="nowrap">&nbsp;</TD>
	   <TD nowrap="nowrap"><IMG src='/imagenes/barra_colores.jpg' width='100%' height='8'></TD>
	   <TD width="10" nowrap="nowrap">&nbsp;</TD>
	</TABLE>
  </TD>
 </TR>
 <TR>
  <TD>
  <? //=$sup?>
	<TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0' style='border:solid; border-color:#CED7EC; border-width:1px;'>
	  <TR>
		<TD align='center'> 
		 <TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
		  <TR height="35">
		   <TD nowrap="nowrap" width="25%" align="left" id="pesta0" style="background-image:url(/imagenes/pesta.gif);">&nbsp;</TD>
		   <TD nowrap="nowrap" width="1%" align="center" style="background-image:url(/imagenes/pesta.gif);"><IMG src='/imagenes/linea.gif' width='1' height='20'></TD>
<!--		   <TD nowrap="nowrap" width="15%" align="center" id="pesta1" style="background-image:url(/imagenes/pesta.gif);">
		   <a href="javascript:con_avance('F');select_pesta('pesta1')">Encuestas</a></TD>
-->		   <TD nowrap="nowrap" width="15%" align="center" id="pesta1" style="background-image:url(/imagenes/pesta.gif);">
		  Encuestas</TD>
		   <TD nowrap="nowrap" width="1%" align="center" style="background-image:url(/imagenes/pesta.gif);"><IMG src='/imagenes/linea.gif' width='1' height='20'></TD>
<!--		   <TD nowrap="nowrap" width="15%" align="center" id="pesta2" style="background-image:url(/imagenes/pesta.gif);">
		   <a href="javascript:con_avance('I');select_pesta('pesta2')">Iniciadas</a></TD>
		   <TD nowrap="nowrap" width="1%" align="center" style="background-image:url(/imagenes/pesta.gif);"><IMG src='/imagenes/linea.gif' width='1' height='20'></TD>
-->		   <TD nowrap="nowrap" width="15%" align="center" id="pesta3" style="background-image:url(/imagenes/pesta.gif);">
		   <a href="javascript:con_avance('P');select_pesta('pesta3')">Pendientes</a></TD>
		   <TD nowrap="nowrap" width="26%" align="right" id="pesta0" style="background-image:url(/imagenes/pesta.gif);"><a href="logout.php?url=index.php"><img src="/imagenes/icoblg_candado.png" alt="Salir" title="Salir" height="30" border="0" style="margin-right:5px;"></a></TD>
		  </TR>
		 </TABLE>
		</TD>
	  </TR>
	  <TR>
		<TD align='center'><div id="div_informe"></div></TD>
	 </TR>
	  <TR>
		<TD align='center'><div id="div_informe_det"></div></TD>
	 </TR>
	  <TR>
		<TD align='center'><div id="div_citas"></div></TD>
	 </TR>
	</TABLE>
  <? //=$inf?>
  </TD>
 </TR>
</TABLE>
</FORM>
<script>
	con_avance('P');
	select_pesta('pesta3');
</script>
</BODY>
</HTML>
