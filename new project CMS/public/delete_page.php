<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php 

$current_page = find_pages_by_id($_GET["page"]);
if(!$current_page){
	redirect_to("manage_content.php");
}




 $id = $current_page["id"];
 $query = "DELETE FROM pages WHERE id = {$id} LIMIT 1; ";
 $result = mysqli_query($connection, $query);
	
	if($result && mysqli_affected_rows($connection)){
		//success
		$_SESSION["message"] = "Page Deleted";
		redirect_to("manage_content.php");
	}else{
		//failure
		$_SESSION["message"] = "Page Delete failure";
		redirect_to("manage_content.php?page={$id}");
	}

?>