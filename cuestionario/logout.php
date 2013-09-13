<? 
session_start();
$url	= $_REQUEST['url']?	$_REQUEST['url']	:	"./index.php";
$_SESSION['usuarioECO']		= NULL;
$_SESSION['usuarioCall_SS']	= NULL;
$_SESSION['origen_SS']		= NULL;

//session_destroy();
//session_unset();
//$parametros_cookies = session_get_cookie_params();
//setcookie(session_name(),0,1, $parametros_cookies["path"]);
?>
<script>location.href="<?=$url?>"; </script>
