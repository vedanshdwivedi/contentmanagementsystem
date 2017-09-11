<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
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



<div id="main">
     <div id="navigation">
	 <?php echo navigation($current_subject, $current_page); ?>
        </div>	 
	 <div id="page">
	 <?php $subject_id = $_GET["subject"]; ?>
	 <?php echo message(); ?>
	 <?php $errors = errors(); ?>
	 <?php echo form_errors($errors); ?>
	     <h2> Add a Page to "<?php 
             echo $current_subject["menu_name"];
		 ?>"</h2>
	     <form action="create_page.php" method="post" >
		 <p>Menu name:
		    <input type="text" name="menu_name" value="" />
		 </p>
		 <p>Position: 
		    <select name="position">
			<?php 
			    $page_set = find_pages_for_subject($subject_id);
				$count = mysqli_num_rows($page_set);
				for($i=1; $i <= ($count+1); $i++){
					echo "<option value=\"{$i}\">{$i}</option>";
				}
			?>
			</select>
		 </p>
		 
		 <p> Subject Id: 
		     <select name="subject_id">
			     <option value="<?php echo $subject_id; ?>" selected><?php echo $subject_id; ?></option>
			 </select>
		 </p>
		 
		 <p>Visible:
		    <input type="radio" name="visible" value="0" />No
		    &nbsp;
		    <input type="radio" name="visible" value="1" />Yes
		 </p>
		 <p>
		     Content: <br />
			 <textarea id="content" name="content" placeholder="Enter Content for the page" rows="20" cols="80"></textarea>
		 </p>
		    <input type="submit" name="submit" value="Create Page" />
		 </form>
		 <br />
		 <a href="manage_content.php">Cancel</a>
	 </div>
  </div>


<?php include("../includes/layouts/footer.php"); ?>