<? 
session_start();
$url	= $_REQUEST['url'];
$_SESSION['userAdmin']		= NULL;
$_SESSION['usuarioAdmin']	= NULL;
$_SESSION['tipoUsuario']	= NULL;
//session_destroy();
//session_unset();
//$parametros_cookies = session_get_cookie_params();
//setcookie(session_name(),0,1, $parametros_cookies["path"]);
?>
<script>location.href="<?=$url?>"; </script>
