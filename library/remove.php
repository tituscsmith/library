<!-- <?php 

	include('config/db_connect.php');
			session_start();

	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: index.php");
	    exit;
	}
	// if(isset($_POST['delete'])){

	// 	$bookID_to_delete = mysqli_real_escape_string($conn, $_POST['bookID_to_delete']);

	// 	$sql = "DELETE FROM books WHERE bookID = $bookID_to_delete";

	// 	if(mysqli_query($conn, $sql)){
	// 		header('Location: index.php');
	// 	} else {
	// 		echo 'query error: '. mysqli_error($conn);
	// 	}

	// }

	if(isset($_POST['checkout'])){

		$bookID_to_checkout = mysqli_real_escape_string($conn, $_POST['bookID_to_checkout']);

		$user = $_SESSION['username']; 

		$sql1 = "UPDATE books SET at_status = '$user' WHERE bookID = $bookID_to_checkout";


		if(mysqli_query($conn, $sql1)){
			$sql2 = "UPDATE users SET books_checkedout = books_checkedout + 1 WHERE users.username = '$user'";
			if(mysqli_query($conn, $sql2)){
				header('Location: index.php');
			}
			else{
				echo 'query error: '. mysqli_error($conn);

			}
			//header('Location: index.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}

	// check GET request bookID param
	if(isset($_GET['bookID'])){
		
		// escape sql chars
		$bookID = mysqli_real_escape_string($conn, $_GET['bookID']);

		// make sql
		$sql = "SELECT * FROM books WHERE bookID = $bookID";

		// get the query result
		$result = mysqli_query($conn, $sql);

		// fetch result in array format
		$book = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn);

	}

?> -->

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Remove a book</h4>
		<form class="white" action="add.php" method="POST">
			<label>Book Title</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
			<div class="red-text"><?php echo $errors['title']; ?></div>
			
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>