<div id="footer"> Copyright&copy; <?php echo date("M Y"); ?>  Widget Corp by Vedansh</div>
</body>
</html>
<?php 
  //5. Close database connection
  if(isset($connection)){
  mysqli_close($connection);
  }
?>
