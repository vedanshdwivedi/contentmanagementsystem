<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>



<?php  //current page and subject for navigation
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
	$id = $_GET["page"];
?>
<?php
//subject ID was missing in database
//or subject couldn't be found
   if(!$current_page){
	   redirect_to("manage_content.php");
   }
?>

<?php 

if(isset($_POST['submit'])){
	
	$id = $_GET["page"];
	//validations
	$required_fields = array("menu_name", "position", "visible", "content");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validation_max_length($fields_with_max_lengths);
	
	if(empty($errors)){
		//Perform Update
	
	
	//Process the form
	$id =(int) $_GET["page"];
	$subject_id = (int) $_GET["subject_id"];
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position =(int) $_POST["position"];
	$visible =(int) $_POST["visible"];
	$content = mysql_prep($_POST["content"]);
	
	//Perform Database Query
	$query = "UPDATE pages SET ";
	$query .= "menu_name = '{$menu_name}', ";
	$query .= "position = {$position}, ";
	$query .= "visible = {$visible}, ";
	$query .= "content = '{$content}' ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1;";
	
	$result = mysqli_query($connection, $query);
	
	if($result && mysqli_affected_rows($connection) == 1 ){
		//success
		$_SESSION["message"] = "Page Edited";
		redirect_to("manage_content.php");
	}else{
		//failure
		$message = "Page Edit failure";
		//echo $query;
		//echo mysqli_affected_rows($connection);
		
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
	     <h2> Edit Page : <?php echo htmlentities($current_page["menu_name"]); ?></h2>
	     <form action="edit_page.php?page=<?php echo urlencode($id); ?>&subject_id=<?php echo urlencode($current_page["subject_id"]); ?>" method="post" >
		 <p>Menu name: 
		    <input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]); ?>" />
		 </p>
		 <p>Position: 
		    <select name="position">
			<?php 
			    $subject_id = $_GET["subject_id"]; 
			    $page_set = find_pages_for_subject($subject_id);
				$count = mysqli_num_rows($page_set);
				for($i=1; $i <= ($count); $i++){
					echo "<option value=\"{$i}\""; 
					if($current_page["position"] == $i ){
						echo " selected ";
					}
					echo ">{$i}</option>";
				}
			?>
			</select>
		 </p>
		 <p>Visible:
		    <input type="radio" name="visible" value="0" <?php if($current_page["visible"] == 0){
				echo "checked";
			} ?> />No
		    &nbsp;
		    <input type="radio" name="visible" value="1" <?php if($current_page["visible"] == 1){
				echo "checked";
			} ?> />Yes
		 </p>
		 <p>
		     Content: <br />
			 <textarea id="content" name="content"  rows="20" cols="80" ><?php echo htmlentities($current_page["content"]); ?></textarea>
		 </p>
		    <input type="submit" name="submit" value="Update Page" />
		 </form>
		 <br />
		 <a href="manage_content.php">Cancel</a>
		 &nbsp;
		 &nbsp;
		 
		 <a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure ?');">Delete Page</a>
		 
	 </div>
  </div>
  
 
 <?php include("../includes/layouts/footer.php"); ?>
 
 
