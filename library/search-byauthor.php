 <?php

	include('config/db_connect.php');
	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}
 	$author = '';


?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center" >Search for a Book by Author</h4>
		<form class="white" action="search-authorresult.php" method="POST">
			<label>Enter Author Names</label>
			<input type="text" name="author" value="<?php echo htmlspecialchars($author) ?>">
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>