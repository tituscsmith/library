<?php

	include('config/db_connect.php');

	$authorID = $name  = '';
	$errors = array('authorID' => '',  'name' => '');
	session_start();

	//SESSION Doesn't wor
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
	    header("location: index.php");
	    exit;
	}
	// echo !isset($_SESSION["loggedin"]);
	// echo $_SESSION["admin"];

	if(isset($_POST['submit'])){
		
		// check authorID
		if(empty($_POST['authorID'])){
			$errors['authorID'] = 'A authorID is required';
		} else{
			$authorID = $_POST['authorID'];
			// if(!preg_match('/^[a-zA-Z\s]+$/', $authorID)){
			// 	$errors['authorID'] = 'Author must be letters and spaces only';
			// }
		}
		if(empty($_POST['name'])){
			$errors['name'] = 'A name is required';
		} else{
			$name = $_POST['name'];
			// if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
			// 	$errors['name'] = 'authorID must be letters and spaces only';
			// }
		}

		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$authorID = mysqli_real_escape_string($conn, $_POST['authorID']);
			$name = mysqli_real_escape_string($conn, $_POST['name']);

			$sql = "SELECT * FROM authors WHERE authors.ID = $authorID";
			$result = mysqli_query($conn, $sql);

			//UPDATE or INSERT if not exist
			if(mysqli_num_rows($result))
			{
    			$sql = "UPDATE authors SET authors.name = $name WHERE authors.ID = $authorID";
			}
			else{
				$sql = "INSERT INTO authors VALUES ('$name', $authorID)";
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
		<h4 class="center">Add an author</h4>
		<form class="white" action="add-author.php" method="POST">
			<label>Author ID</label>
			<input type="text" name="authorID" value="<?php echo htmlspecialchars($authorID) ?>">
			<div class="red-text"><?php echo $errors['authorID']; ?></div>
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