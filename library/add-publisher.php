<?php

	include('config/db_connect.php');

	$publisherID = $name  = '';
	$errors = array('publisherID' => '',  'name' => '');
	session_start();

	//SESSION Doesn't wor
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
	    header("location: index.php");
	    exit;
	}
	// echo !isset($_SESSION["loggedin"]);
	// echo $_SESSION["admin"];

	if(isset($_POST['submit'])){
		
		// check publisherID
		if(empty($_POST['publisherID'])){
			$errors['publisherID'] = 'A publisherID is required';
		} else{
			$publisherID = $_POST['publisherID'];
			// if(!preg_match('/^[a-zA-Z\s]+$/', $publisherID)){
			// 	$errors['publisherID'] = 'Author must be letters and spaces only';
			// }
		}
		if(empty($_POST['name'])){
			$errors['name'] = 'A name is required';
		} else{
			$name = $_POST['name'];
			// if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
			// 	$errors['name'] = 'publisherID must be letters and spaces only';
			// }
		}

		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$publisherID = mysqli_real_escape_string($conn, $_POST['publisherID']);
			$name = mysqli_real_escape_string($conn, $_POST['name']);

			$sql = "SELECT * FROM publisher WHERE publisher.ID = $publisherID";
			$result = mysqli_query($conn, $sql);

			//UPDATE or INSERT if not exist
			if(mysqli_num_rows($result))
			{
    			$sql = "UPDATE publisher SET publisher.name = $name WHERE publisher.ID = $publisherID";
			}
			else{
				$sql = "INSERT INTO publisher VALUES ('$name', $publisherID)";
			}

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}

			
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Add an publisher</h4>
		<form class="white" action="add-publisher.php" method="POST">
			<label>Publisher ID</label>
			<input type="text" name="publisherID" value="<?php echo htmlspecialchars($publisherID) ?>">
			<div class="red-text"><?php echo $errors['publisherID']; ?></div>
			<label>Name</label>
			<input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>">
			<div class="red-text"><?php echo $errors['name']; ?></div>

			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>
<?php include('templates/footer.php'); ?>

</html>