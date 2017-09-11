<?php
    //1. Create a database connection
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="vd";
    $dbname="LESSON";
    $connection=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    //Test if connection occured
    if(mysqli_connect_errno()){
    	die("Database connection failed".mysqli_connect_error()."(".mysqli_connect_errno().")");
    }
?>


