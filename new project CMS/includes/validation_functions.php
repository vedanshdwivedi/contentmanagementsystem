<?php

$errors = array();

function fieldname_as_text($fieldname){
	$fieldname = str_replace("_", " ", $fieldname);
	$fieldname = ucfirst($fieldname);
	return $fieldname;
}

//presence
function has_presence($value){
	return isset($value) && $value != "";
}

//validate presence
function validate_presences($required_fields){
	global $errors;
	foreach($required_fields as $field){
		$value = trim($_POST[$field]);
		if(!has_presence($value)){
			$errors[$field] = fieldname_as_text($field). " can't be blank";
		}
	}
	
}

//string length
//max length
function has_max_length($value, $max_length){
	return strlen($value) <= $max_length;
}

//validate max length
function validation_max_length($fields_with_max_length){
	global $errors;
	//Expects an associative array
	foreach($fields_with_max_length as $field => $max){
		$value = trim($_POST[$field]);
		if(!has_max_length($value, $max)){
			$errors[$field] = fieldname_as_text($field). " is too long";
		}
	}
}


//inclusion in a set
function has_inclusion_in($value, $set){
	return in_array($value, $set);
}




?>