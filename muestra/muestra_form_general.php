<?
include("../ctl_login_admin.php");
include("sql_muestra_form_general.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK rel="stylesheet" href="sstyle.css" type="text/css">
</HEAD>
<BODY style="margin-top:0px !important; padding-top:0px; background-color:#FFFFFF;">
<FORM name='index' action='encuesta.php' method='post'>
<? include("../menu_admin.php"); ?>
<TABLE width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#FFFFFF">
 <TR>
  <TD>
   <TABLE width="100%" cellspacing="0" cellpadding="2" align='center' border="0">
    <TR>
	 <TD width="10%" align="left"><IMG src='/imagenes/logoEcopetrolgnn2.jpg' height="70" border='0'></TD>
	 <TD align='left' valign='middle'><div style='font-family: Arial, Helvetica, sans-serif; font-size: 20px; color:#336666; font-weight: bold; margin-left:10px;'>Control de Muestra preguntas Generales</div></TD>
	</TR>
   </TABLE>
  </TD>
 </TR>
 <TR>
  <TD>
	<TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
	  <TR>
	   <TD width="10" nowrap="nowrap">&nbsp;</TD>
	   <TD nowrap="nowrap"><IMG src='/imagenes/barra_colores.jpg' width='100%' height='8'></TD>
	   <TD width="10" nowrap="nowrap">&nbsp;</TD>
	  </TR>
	</TABLE>
  </TD>
 </TR>
 <TR>
  <TD>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style='border:1px solid #CED7EC;'>
	 <TR height='20' style='background-color:#DDDDDD'>
	  <TD width="2%" align='left'><div class='padding5' style='color:#5F5F5F;'><B>Ítem</B></div></TD>
	  <TD width="2%" align='center'><div class='padding5' style='color:#5F5F5F;'><B>Id</B></div></TD>
	  <TD align='left'><div class='padding5' style='color:#5F5F5F;'><B>Servicio</B></div></TD>
	  <TD width="10%" align='center'><div class='padding5' style='color:#5F5F5F;'><B>Muestra</B></div></TD>
	  <TD width="10%" align='center' nowrap="nowrap"><div class='padding5' style='color:#5F5F5F;'><B>Realizadas</B></div></TD>
	  <TD width="10%" align='center'><div class='padding5' style='color:#5F5F5F;'><B>Pend.</B></div></TD>
	 </TR>
	 <?=$filasMuestra?>
	</TABLE>
  </TD>
 </TR>
 <TR>
  <TD align="right"><div class="padding5">Porcentaje de avance general <B><?=$porcentajeTotal?>%</B></div></TD>
 </TR>
</TABLE>
</FORM>
</BODY>
</HTML>
