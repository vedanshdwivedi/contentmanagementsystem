<?php require_once("../includes/sessions.php");  ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $layout_context = "public" ?>
<?php include("../includes/layouts/header.php"); ?>

<?php //Find Default Page for a subject
  function find_default_page($subject_id){
	  $page_set = find_pages_for_subject($subject_id, true);
	  if($first_page = mysqli_fetch_assoc($page_set)){
		  return $first_page;
	  }else{
		  return null;
	  }
  }
?>

<?php 
    if(isset($_GET["subject"])){
		$current_subject = find_subject_by_id($_GET["subject"]);
		$current_page = find_default_page($current_subject["id"]);
		
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
	 <?php echo public_navigation($current_subject, $current_page); ?>
	 </div>	 
	 <div id="page">
	     
		  <?php
		  if($current_subject && $current_subject["visible"]==1){
			  echo "<h2>Manage Subject</h2>";
			  
			  echo "Menu Name : ";
			  echo htmlentities($current_subject["menu_name"]). "<br />";
			  
			  }elseif($current_subject && $current_subject["visible"] == 0 ){
				  redirect_to("index.php");
			  }elseif($current_page && $current_page["visible"] == 1 ){
				  echo "<h2>".$current_page["menu_name"]."</h2>";
				   echo nl2br(htmlentities($current_page["content"])); ?><br />
				</div>
				<br /><br />
				
				<?php
		    
			  }elseif($current_page && $current_page["visible"] == 0 ){
				  redirect_to("index.php");
			  }
			  else{
				  echo "<br />WELCOME !!!";
			  }
			  ?>
	 </div>
  </div>
  
 
 <?php include("../includes/layouts/footer.php"); ?>
 
 
