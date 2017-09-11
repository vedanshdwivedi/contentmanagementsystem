<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/functions.php"); ?>


<?php 

//version 1 : SIMPLE LOGOUT
//session_start();
$_SESSION["admin_id"] = null;
$_SESSION["username"] = null;
redirect_to("login.php");


//version 2 : DESTROY SESSION
//assumes nothing else in session to keep
/*

session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()])){
	setcookie(session_name(), "", time()-42000, '/');
}
session_destroy();
redirect_to("login.php");


*/
?>