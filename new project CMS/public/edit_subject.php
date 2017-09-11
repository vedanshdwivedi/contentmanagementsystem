<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>



<?php 
    if(isset($_GET["subject"])){
		$current_page = null;
		$current_subject = find_subject_by_id($_GET["subject"]);
	} elseif (isset($_GET["page"])){
		$current_page = find_pages_by_id($_GET["page"]);
		$current_subject = null;
	}else {
		$current_page = null;
		$current_subject = null;
	} 
	
?>
<?php
//subject ID was missing in database
//or subject couldn't be found
   if(!$current_subject){
	   redirect_to("manage_content.php");
   }
?>

<?php 

if(isset($_POST['submit'])){
	
	$id = $current_subject["id"];
	//validations
	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validation_max_length($fields_with_max_lengths);
	
	if(empty($errors)){
		//Perform Update
	
	
	//Process the form
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position =(int) $_POST["position"];
	$visible =(int) $_POST["visible"];
	
	//Perform Database Query
	$query = "UPDATE subjects SET ";
	$query .= "menu_name = '{$menu_name}', ";
	$query .= "position = {$position}, ";
	$query .= "visible = {$visible} ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1;";
	
	$result = mysqli_query($connection, $query);
	
	if($result && mysqli_affected_rows($connection) >= 0 ){
		//success
		$_SESSION["message"] = "Subject Edited";
		redirect_to("manage_content.php");
	}else{
		//failure
		$message = "Subject Edit failure";
		
	}
	}	
}else {
	//Probably a GET request
	
}

?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

  <div id="main">
     <div id="navigation">
	 <?php echo navigation($current_subject, $current_page); ?>
        </div>	 
	 <div id="page">
	 <?php //message is just a variable, doesn't use SESSIONS 
	     if(!empty($message)){
			 echo "<div class=\"message\">".htmlentities($message)."</div>";
		 }
	 ?>
	
	 <?php echo form_errors($errors); ?>
	     <h2> Edit Subject : <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
	     <form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post" >
		 <p>Menu name: 
		    <input type="text" name="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]); ?>" />
		 </p>
		 <p>Position: 
		    <select name="position">
			<?php 
			  $subject_set = find_all_subjects(false);
			  $subject_count=mysqli_num_rows($subject_set);
			    for($count=1; $count<=$subject_count; $count++){
					echo "<option value=\"{$count}\"";
					if($current_subject["position"] == $count ){
						echo " selected";
					}
					echo ">{$count}</option>";
				}
			?>
			</select>
		 </p>
		 <p>Visible:
		    <input type="radio" name="visible" value="0" <?php if($current_subject["visible"] == 0){
				echo "checked";
			} ?> />No
		    &nbsp;
		    <input type="radio" name="visible" value="1" <?php if($current_subject["visible"] == 1){
				echo "checked";
			} ?> />Yes
		 </p>
		    <input type="submit" name="submit" value="Edit Subject" />
		 </form>
		 <br />
		 <a href="manage_content.php">Cancel</a>
		 &nbsp;
		 &nbsp;
		 <a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure ?');">Delete Subject</a>
	 </div>
  </div>
  
 
 <?php include("../includes/layouts/footer.php"); ?>
 
 
