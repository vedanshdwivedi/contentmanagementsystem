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
	 <br />
	 <a href="admin.php">&laquo; Main Menu</a><br/>
	 <?php echo navigation($current_subject, $current_page); ?>
	 <br />
	 <a href="new_subject.php">+ Add a Subject</a>
	 <br />
        </div>	 
	 <div id="page">
	     <?php echo message(); ?>
		  <?php
		  if($current_subject){
			  echo "<h2>Manage Subject</h2>";
			  
			  echo "Menu Name : ";
			  echo htmlentities($current_subject["menu_name"]). "<br />";
			  ?>
			  
			  <?php
                 echo "Position : ";
			     echo $current_subject["position"]. "<br />";
				  echo "Visible : ";
			     echo $current_subject["visible"] == 1 ? 'yes' : 'no' ;
			  ?> <br /><br />
			  <a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">
			  Edit Subject </a>
			  <div id="add_page">
			     <br />  <div style="margin-top: 2em; border-top: 1px solid #000000; " >
				 <h3>Pages in this Subject : </h3>
				 <ul>
				 <?php 
				     $page_set = find_pages_for_subject($current_subject["id"]);
					 while($page = mysqli_fetch_assoc($page_set)){
						 echo "<li>";
						 $safe_page_id = urlencode($page["id"]);
						 echo "<a href=\"manage_content.php?page={$safe_page_id}\">";
						 echo htmlentities($page["menu_name"]);
						 echo "</a></li>";
					 }
					 
					 
				 ?>
				 <ul>
				 <br /><br />
				 <a href="new_page.php?subject=<?php echo urlencode($current_subject["id"]);  ?>">
				 + Add Pages to this Subject 
				 </a>
				 <br /> 
			  </div>
			  </div>
			  
			  <?php
			  }elseif($current_page){
				   echo "<h2>Manage Page</h2>";
				
				echo "Menu Name : ";
		        echo htmlentities($current_page["menu_name"])."<br />";
			    echo "Position : ";
			    echo $current_page["position"]. "<br />";
				echo "Visible : ";
			    echo $current_page["visible"] == 1 ? 'yes' : 'no' ;
				
				?>
				<br />
				Content: 
				<br />
				<div class="view">
				    <?php  echo nl2br(htmlentities($current_page["content"])); ?><br />
				</div>
				<br /><br />
				<a href="edit_page.php?page=<?php echo urldecode($current_page["id"]); ?>&subject_id=<?php echo urlencode($current_page["subject_id"]); ?>">Edit Page</a>
				<?php
		    
			  }else{
				  echo "Please select a subject or a page.";
			  }
			  ?>
	 </div>
  </div>
  
 
 <?php include("../includes/layouts/footer.php"); ?>
 
 
