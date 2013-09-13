<?php
$dbhost = "localhost";
//$dbuser = "webmaster_cnc";
$dbuser = "ecopetrol_ci2012";
$dbpass = "ecopetrol_ci2012";  

dbConnect("ecopetrol_ci2012");

function dbConnect($db=""){
    global $dbhost, $dbuser, $dbpass;
    $dbcnx = @mysql_connect($dbhost, $dbuser, $dbpass)
        or die("[ADMIN]Lo sentimos: El servidor de DB No esta disponible.");
    if ($db!="" and !@mysql_select_db($db))
        die("[ADMIN]Lo sentimos: Esta Base de datos no esta disponible.");
    return $dbcnx;
}
?>


<?php

/* Comentario prueba */

?>
