<?php 
  
  function confirm_query($result_set){
	  if(!$result_set){
		  die("Database Query Failed");
	  }
  }
  
  function form_errors($errors=array()){
	$output = "";
	if(!empty($errors)){
		$output .= "<div class=\"errors\"><br />";
		$output .= "Please fix the following errors: ";
		$output .= "<ul>";
		foreach ($errors as $key => $error){
			$output .= "<li>";
			$output .= htmlentities($error);
			$output .= "</li>";
		}
		$output .= "</ul></div>";
	}
	return $output;
}
  
  function find_all_subjects($public=true){
	  global $connection;
	  
	$query="SELECT * FROM subjects  ";
	if($public){
	    $query .= "WHERE visible = 1 ";
	}
	$query .= "ORDER BY position ASC; ";
    $subject_set = mysqli_query($connection, $query);
    confirm_query($subject_set);
	return $subject_set;
  }
  
  function find_all_admins(){
	  global $connection;
	  
	  $query = "SELECT * FROM admins ";
	  $query .= "ORDER BY username ASC; ";
	  $admin_set = mysqli_query($connection, $query );
	  confirm_query($admin_set);
	  return $admin_set;
  }
  
  function find_all_pages(){
	  global $connection;
	  
	  $query = "SELECT * FROM pages ; ";
	  $page_set = mysqli_query($connection, $query);
	  confirm_query($page_set);
	  return $page_set;
  }
  
  function find_pages_for_subject($subject_id, $public=true ){
	  global $connection;
	  
	  $query = "SELECT * ";
			 $query .= "FROM pages ";
			 
			 $query .= "WHERE subject_id = {$subject_id} ";
			 if($public){
			 $query .= "AND visible=1 ";
			 }
			 $query .= "ORDER BY position ASC; ";
			 $page_set = mysqli_query($connection, $query);
			 confirm_query($page_set);
			 return $page_set;
  }

  function redirect_to($new_location){
	  header ("Location: ".$new_location);
	  exit;
  }
  
  //navigation takes 2 arguments
  //current subject array or null
  //current page array or null
  
  function navigation ($subject_array , $page_array){
	   $output = "<ul class=\"subjects\">";
	 
	  $subject_set = find_all_subjects(false); 
   while ($subject=mysqli_fetch_assoc($subject_set)) {
   	
	 $output .= "<li ";
	      if($subject_array && $subject["id"] == $subject_array["id"]) {
	      $output .= "class=\"selected\"";
		  }
		  $output .= ">"; 
		  $output .= "<a href=\"manage_content.php?subject=";
		  $output .= urlencode($subject["id"]);
		  $output .= "\">";
		  $output .= htmlentities($subject["menu_name"]); 
		  $output .= "</a>";
		
		 
		 $page_set=find_pages_for_subject($subject["id"], false );
		 $output .= "<ul class=\"pages\">";
	     while($page=mysqli_fetch_assoc($page_set)){
					
		 $output .= "<li ";
	     if($page_array && $page["id"] == $page_array["id"]) {
	     $output .= "class=\"selected\"";
		  }
		 $output .= ">"; 
	$output .= "<a href=\"manage_content.php?page=";
	$output .= urlencode($page["id"]);
	$output .= "\">";


	 $output .= htmlentities($page["menu_name"]); 
	 $output .= "</a>";
					 $output .= "</li>";
				  } 
				  
				     mysqli_free_result($page_set);
				 
			
		$output .= "</ul>";
	  $output .= "</li>";
	
   }  
      mysqli_free_result($subject_set);
 $output .= "</ul>";
	return $output; 
  }
  
  function find_subject_by_id($subject_id){
	   global $connection;
	  $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
	  $query="SELECT * FROM subjects WHERE id={$safe_subject_id} LIMIT 1 ; ";
    $subject_set=mysqli_query($connection, $query);
    confirm_query($subject_set);
	if($subject = mysqli_fetch_assoc($subject_set)){
		return $subject;
	}else{
	return null;
	}
  }
  
  function find_pages_by_id($page_id){
	  global $connection;
	  $safe_subject_id = mysqli_real_escape_string($connection, $page_id);
	  $query = "SELECT * ";
			 $query .= "FROM pages ";
			 //$query .= "WHERE visible=1 ";
			 $query .= "WHERE id = {$safe_subject_id}; ";
			 //$query .= "ORDER BY position ASC; ";
			 $page_set = mysqli_query($connection, $query);
			 confirm_query($page_set);
			 if($page = mysqli_fetch_assoc($page_set)){
			 return $page; 
			 }else{
				 return null;
			 }
  }
  
  function find_admin_by_id($admin_id){
	  global $connection;
	  $safe_admin_id = mysqli_real_escape_string($connection, $admin_id );
	  $query = "SELECT * FROM admins ";
	  $query .= "WHERE id = {$safe_admin_id} ";
	  $query .= "LIMIT 1;";
	  $admin_set = mysqli_query($connection, $query );
	  confirm_query($admin_set);
	  if($admin = mysqli_fetch_assoc($admin_set)){
		  return $admin;
	  }else{
		  return null;
	  }
	  
  }
  
  function mysql_prep($string){
	  global $connection;
	  $escaped_string = mysqli_real_escape_string($connection, $string);
	  return $escaped_string;
  }
 
  function find_selected_page(){
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
  }

  function public_navigation ($subject_array , $page_array){
	   $output = "<ul class=\"subjects\">";
	 
	  $subject_set = find_all_subjects(); 
   while ($subject=mysqli_fetch_assoc($subject_set)) {
   	
	 $output .= "<li ";
	      if($subject_array && $subject["id"] == $subject_array["id"]) {
	      $output .= "class=\"selected\"";
		  }
		  $output .= ">"; 
		  $output .= "<a href=\"index.php?subject=";
		  $output .= urlencode($subject["id"]);
		  $output .= "\">";
		  $output .= htmlentities($subject["menu_name"]); 
		  $output .= "</a>";
		
		 if($subject_array["id"] == $subject["id"] || $subject["id"] == $page_array["subject_id"] ){
			 
		 
		 $page_set=find_pages_for_subject($subject["id"]);
		 $output .= "<ul class=\"pages\">";
	     while($page=mysqli_fetch_assoc($page_set)){
					
		 $output .= "<li ";
	     if($page_array && $page["id"] == $page_array["id"]) {
	     $output .= "class=\"selected\"";
		  }
		 $output .= ">"; 
	$output .= "<a href=\"index.php?page=";
	$output .= urlencode($page["id"]);
	$output .= "\">";


	 $output .= htmlentities($page["menu_name"]); 
	 $output .= "</a>";
					 $output .= "</li>";
				  } 
				  $output .= "</ul>";
				     mysqli_free_result($page_set);
		 }		 
			
		
	  $output .= "</li>";   //end of the subject
	
   }  
      mysqli_free_result($subject_set);
 $output .= "</ul>";
	return $output; 
  }
 
  function password_encrypt($password){
	  $hash_format = "$2y$10$";   //Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22;    //Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
	  return $hash;
	  
	  
  }
  
  function generate_salt($length){
	  //Not 100% unique, not 100% random but good enough for a salt
	  //MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
	  
	  //Valid Characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
	  //But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string );
	  
	  //Truncate string to correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
	  return $salt;
  }
 
  function password_check($password, $existing_hash){
	  //Existing hash contains format and salt at the start
	  $hash = crypt($password, $existing_hash);
	  if($hash === $existing_hash){
		  return true;
	  }else{
		  return false;
	  }
  }
  
  function find_admin_by_username($username){
	  global $connection;
	  $safe_username = mysqli_real_escape_string($connection, $username );
	  $query = "SELECT * FROM admins ";
	  $query .= "WHERE username = '{$safe_username}' ";
	  $query .= "LIMIT 1;";
	  $admin_set = mysqli_query($connection, $query );
	  confirm_query($admin_set);
	  if($admin = mysqli_fetch_assoc($admin_set)){
		  return $admin;
	  }else{
		  return null;
	  }
	  
  }
  
  function confirm_logged_in(){
	   if(!logged_in()){
		 redirect_to("login.php");
	 }
  }
  
  function logged_in(){
	  return isset($_SESSION["admin_id"]);
  }
  
  function attempt_login($username, $password){
	  $admin = find_admin_by_username($username);
	  if($admin){
		  //found admin, now check password
		  if(password_check($password, $admin["hashed_password"])){
			  //password matches
			  return $admin;
		  }else{
			  //password does not match
			  return false;
		  }
		  
	  }else{
		  //admin not found
		  return false;
	  }
  }
 ?>