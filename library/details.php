<?php 

	include('config/db_connect.php');
			session_start();

	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: index.php");
	    exit;
	}


	if(isset($_POST['checkout'])){
		$ID_to_checkout = mysqli_real_escape_string($conn, $_POST['ID_to_checkout']);

		$user = $_SESSION['username']; 

		$sql = "SELECT COUNT(*) FROM books WHERE books.at_status = '$user'";

		$result = mysqli_query($conn, $sql);
		$countArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		if($countArray[0] && $countArray[0]>=10){
				//echo "Greater than 10";
				// echo "<script type='text/javascript'>alert('Max books reached!');</script>";
				// sleep(5);
				header('Location: max-error.php');
				return;
			}


		else {
			echo 'query error: '. mysqli_error($conn);
		}

		$sql = "UPDATE books SET books.at_status = '$user' WHERE books.ID = $ID_to_checkout";
	//	$sql3 = "INSERT INTO  checks_out VALUES (4, '$x')";

		if(mysqli_query($conn, $sql)){
				header('Location: index.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}
	if(isset($_POST['delete'])){
		$ID_to_delete = mysqli_real_escape_string($conn, $_POST['ID_to_delete']);

		$user = $_SESSION['username']; 

		$sql = "DELETE FROM books WHERE books.ID = $ID_to_delete";
	//	$sql3 = "INSERT INTO  checks_out VALUES (4, '$x')";

		if(mysqli_query($conn, $sql)){
				header('Location: index.php');
			//header('Location: index.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}

	// check GET request ID param
	if(isset($_GET['ID'])){
		
		// escape sql chars
		$ID = mysqli_real_escape_string($conn, $_GET['ID']);

		// $sql = "SELECT * FROM books WHERE NOT EXISTS (SELECT * FROM checks_out WHERE checks_out.ID = books.ID) AND ID = $ID";
		$sql = "SELECT * FROM books WHERE books.at_status = 'Library' AND ID = $ID";

		// get the query result
		$result = mysqli_query($conn, $sql);

		// fetch result in array format
		$book = mysqli_fetch_assoc($result);
		$bookID = $book['ID'];
	//	$sql = "SELECT author.name FROM authors WHERE books.ID  = 'Library' AND ID = $ID";
		//$sql = "SELECT authors.name FROM authors INNER JOIN books ON books.authorID = authors.ID WHERE books.ID = $ID";
		$sql = "SELECT writes.authorName FROM writes INNER JOIN books ON books.ID = writes.bookID WHERE writes.bookID= $bookID";
		$result = mysqli_query($conn, $sql);
		
		//Loop through and get all authors
		while($data = mysqli_fetch_assoc($result)){
			$row[] = $data;
		};

		mysqli_free_result($result);
		mysqli_close($conn);

	}

?>

<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>

	<div class="container center grey-text">
		<?php if($book): ?>
			<h3><strong><?php echo $book['title']; ?></strong></h4>

							<h5>Authors:</h5>

			<!-- Authors -->
			<?php foreach($row as $author): ?>
				<h6><?php print htmlspecialchars($author['authorName']); ?></h6>
			<?php endforeach; ?>
			<h5><?php echo $book['num_pages']; ?> Pages - Rating: <?php echo $book['average_rating']; ?>/5</h4>
			<h5>Date: <?php echo $book['publication_date']; ?></h4>
			<h5>Published by: <?php echo $book['publisherName']; ?><br><br></h4>

					<!-- Admin view -->

			         <?php if(isset($_SESSION["admin"]) && $_SESSION["admin"] == true): ?>

			<form style = "display: inline;" action="details.php" method="POST">
				<input type="hidden" name="ID_to_checkout" value="<?php echo $book['ID']; ?>">
				<input type="submit" name="checkout" value="Remove this book from Circulation!" class="btn brand z-depth-0">
			</form>
			
			<form style = "display: inline;" action="details.php" method="POST">
				<input type="hidden" name="ID_to_delete" value="<?php echo $book['ID']; ?>">
				<input type="submit" name="delete" value="Delete Permanently" class="btn brand z-depth-0">
			</form>
			<form style = "display: inline;" action="update.php?ID=<?php echo $book['ID'] ?>" method="POST">
				<input type="hidden" name="ID_to_update" value="<?php echo $book['ID']; ?>">
				<input type="submit" name="update" value="Update Information" class="btn brand z-depth-0">
			</form>
						<!-- User View -->

					    <?php else: ?>
					    	<form style = "display: inline;" action="details.php" method="POST">
				<input type="hidden" name="ID_to_checkout" value="<?php echo $book['ID']; ?>">
				<input type="submit" name="checkout" value="Checkout this book!" onclick="return confirm('Confirm Checkout');" class="btn brand z-depth-0">
			</form>
			

						<?php endif; ?>
			






		<?php else: ?>
			<h5>No such book is currently available.</h5>
		<?php endif ?>
	</div>

	<?php include('templates/footer.php'); ?>

</html>