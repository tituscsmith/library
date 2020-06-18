 <?php

	include('config/db_connect.php');
	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}
 	$publisher = '';


?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center" >Search for a Book Publisher</h4>
		<form class="white" action="search-pubresult.php" method="POST">
			<label>Enter Publisher Name</label>
			<input type="text" name="publisher" value="<?php echo htmlspecialchars($publisher) ?>">
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>