<?php
	//CHANGE
	include('config/db_connect.php');
	echo '<script>console.log("START")</script>';
	//$id = 5;
	$email = $title = $ingredients = '';
	$errors = array('email' => '', 'title' => '', 'ingredients' => '');

		session_start();

	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: index.php");
	    exit;
	}
	if(isset($_GET['id'])){
		
		// escape sql chars
		$id = mysqli_real_escape_string($conn, $_GET['id']);

	}
	if(isset($_POST['submit'])){
		
		// check email
		if(empty($_POST['email'])){
			$errors['email'] = 'An email is required';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
		}

		// check title
		if(empty($_POST['title'])){
			$errors['title'] = 'A title is required';
		} else{
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors['title'] = 'Title must be letters and spaces only';
			}
		}

		// check ingredients
		if(empty($_POST['ingredients'])){
			$errors['ingredients'] = 'At least one ingredient is required';
		} else{
			$ingredients = $_POST['ingredients'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
				$errors['ingredients'] = 'Ingredients must be a comma separated list';
			}
		}
		
		if(array_filter($errors)){
				echo '<script>console.log("Error2")</script>';
			//echo 'errors in form';
		} else {
			echo '<script>console.log("Else1")</script>';
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
			$sql = "UPDATE pizzas SET title = '$title', email = '$email', ingredients = '$ingredients' WHERE id = '$id'";
			if(mysqli_query($conn, $sql)){
					// success
									echo '<script>console.log("No error")</script>';

					header('Location: index.php');
				} else {
					echo 'query error: '. mysqli_error($conn);
					echo '<script>console.log("Error3")</script>';
				}

			
		}
		echo '<script>console.log("DONE")</script>';

	} // end POST check
	else{
		echo '<script>console.log("POST FAILED")</script>';
	}
			


?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Update this pizza</h4>
		<!-- <form class="white" action="update.php?id=<?php echo $id ?>" method="GET"> -->
			<!-- <form class="white" action="index.php" method="POST"> -->
		<!-- <form class="white" action="update.php" method="POST"> -->
		<form class="white" action="update.php?id=<?php echo $id ?>" method="POST"> 
			<label>Your Email</label>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
			<div class="red-text"><?php echo $errors['email']; ?></div>
			<label>Pizza Title</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
			<div class="red-text"><?php echo $errors['title']; ?></div>
			<label>Ingredients (comma separated)</label>
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
			<div class="red-text"><?php echo $errors['ingredients']; ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>