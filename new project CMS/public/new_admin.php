<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php require_once("../includes/validation_functions.php"); ?>
<?php 
   if(isset($_POST["submit"])){
	   //Process the form
	   
	   //validations
	   $required_fields=array("username", "password");
	   validate_presences($required_fields);
	   
	   $fields_with_max_lengths = array("username" => 30);
	   validation_max_length($fields_with_max_lengths);
	   
	   if(empty($errors)){
		   //Perform Creation
		   $username = mysql_prep($_POST["username"]);
		   $hashed_password = password_encrypt($_POST["password"]);
		   
		   $query = "INSERT INTO admins (";
		   $query .= " username, hashed_password ";
		   $query .= ") VALUES ( ";
		   $query .= " '{$username}', '{$hashed_password}' ";
		   $query .= ") ;";
		   
		   $result = mysqli_query($connection, $query);
		   if($result){
			   //success
			   $_SESSION["message"] = "Admin Created";
			   redirect_to("manage_admins.php");
		   }else{
			   //failure
			   $_SESSION["message"] = "Admin Creation Failed";
		   }
		   
		   
		   
	   }else{
		  echo "Errors are present";
		   //redirect_to("new_admin.php");
		  
	   }
	   
   }else{
	   //GET Request
	   //redirect_to("new_admin.php");
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
		  <h2> Create Admin </h2><br />
		  <form action="new_admin.php" method="post">
		     <p>
			     Username : <input type="text" name="username" value="" />
			 </p>
			 <p>
			     Password : <input type="password" name="password" value="" />
			 </p>
			 <br />
			 <input type="submit" name="submit" value="Create Admin">
		  <form>
		  <br />
		  <br />
		  <a href="manage_admins.php">Cancel</a>
		  
	 </div>
  </div>


<?php include("../includes/layouts/footer.php"); ?>