<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php require_once("../includes/validation_functions.php"); ?>
<?php 
   $username = "";
   if(isset($_POST["submit"])){
	   //Process the form
	   
	   //validations
	   $required_fields=array("username", "password");
	   validate_presences($required_fields);
	   
	  
	   
	   if(empty($errors)){
		   //Attempt Login
		   $username = $_POST["username"];
		   $password = $_POST["password"];
		   $found_admin = attempt_login($username, $password);
		   
		   
		   if($found_admin){
			   //success
			   //Mark user as logged in
			   $_SESSION["admin_id"] = $found_admin["id"];
			   $_SESSION["username"] = $found_admin["username"];
			   redirect_to("admin.php");
		   }else{
			   //failure
			   $_SESSION["message"] = "Username/Password Incorrect";
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
		  <h2> Login </h2><br />
		  <form action="login.php" method="post">
		     <p>
			     Username : <input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
			 </p>
			 <p>
			     Password : <input type="password" name="password" value="" />
			 </p>
			 <br />
			 <input type="submit" name="submit" value="Submit">
		  <form>
		  <br />
		  
		  
	 </div>
  </div>


<?php include("../includes/layouts/footer.php"); ?>