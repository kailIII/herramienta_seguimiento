<? 
session_start();
session_unregister("usuario");
session_destroy();
session_unset();
$parametros_cookies = session_get_cookie_params();
setcookie(session_name(),0,1, $parametros_cookies["path"]);
?>
<script>location.href="index.php"; </script>

