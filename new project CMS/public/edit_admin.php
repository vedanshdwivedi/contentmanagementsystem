<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
$id = $_GET["id"];
$admin = find_admin_by_id($id);
if(!$admin){
	redirect_to("manage_admin.php");
}

?>

<?php 

   if(isset($_POST["submit"])){
	   //Process the form
	   
	   //validations
	   $required_fields=array("username", "password");
	   validate_presences($required_fields);
	   
	   $fields_with_max_lengths = array("username" => 30);
	   validation_max_length($fields_with_max_lengths);
	   
	   if(empty($errors)){
		   //Perform update
		   
		   $id = $admin["id"];
		   $username = mysql_prep($_POST["username"]);
		   $password = mysql_prep($_POST["password"]);
		   
		   
		   $username = mysql_prep($_POST["username"]);
		   $hashed_password = password_encrypt($_POST["password"]);
		   
		   $query = "UPDATE admins SET";
		   $query .= " username = '{$username}', ";
		   $query .= "hashed_password = '{$password}' ";
		   $query .= "WHERE id = {$id} ";
		   $query .= "LIMIT 1; ";
		   
		   
		   $result = mysqli_query($connection, $query);
		   if($result){
			   //success
			   $_SESSION["message"] = "Admin Updated";
			   redirect_to("manage_admins.php");
		   }else{
			   //failure
			   $_SESSION["message"] = "Admin Updation Failed";
			   redirect_to("manage_admins.php");
		   }
		   
		   
		   
	   }else{
		   
		redirect_to("new_admin.php");
	   }
	   
   }else{
	   //GET Request
   }
?>




<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
     <div id="navigation">
	     &nbsp;
     </div>	 
	 <div id="page">
	     <?php echo message(); 
		       echo form_errors($errors);
		 ?>
		  <h2> Edit Admin : <?php echo htmlentities($admin["username"]); ?></h2><br />
		  <form action="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>" method="post">
		     <p>
			     Username : <input type="text" name="username" value="<?php echo htmlentities($admin["username"]); ?>" />
			 </p>
			 <p>
			     Password : <input type="password" name="password" value="" />
			 </p>
			 <br />
			 <input type="submit" name="submit" value="Edit Admin">
		  <form>
		  <br />
		  <br />
		  <a href="manage_admins.php">Cancel</a>
		  
	 </div>
  </div>




<?php include("../includes/layouts/footer.php"); ?>