<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php 

if(isset($_POST['submit'])){
	//Process the form
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position =(int) $_POST["position"];
	$visible =(int) $_POST["visible"];
	$subject_id = (int) $_POST["subject_id"];
	$content = mysql_prep($_POST["content"]);
	
	//validations
	$required_fields = array("menu_name", "position", "visible", "content");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validation_max_length($fields_with_max_lengths);
	
	
	if(!empty($errors)){
		$_SESSION["errors"] = $errors;
		redirect_to("new_page.php");
	}
	
	//Perform Database Query
	$query = "INSERT INTO pages (";
	$query .= "subject_id, menu_name, position, visible, content ";
	$query .= ") VALUES (";
	$query .= " {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}' ";
	$query .= ")";
	
	$result = mysqli_query($connection, $query);
	
	if($result){
		//success
		$_SESSION["message"] = "Page Created";
		redirect_to("manage_content.php");
	}else{
		//failure
		$_SESSION["message"] = "Page Creation failure";
		redirect_to("new_page.php");
	}
	
}else {
	//Probably a GET request
	redirect_to("new_page.php");
}

?>


<?php  //5. Close database connection
  if(isset($connection)){
  mysqli_close($connection);
  }
?>