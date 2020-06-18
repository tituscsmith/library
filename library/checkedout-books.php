<?php 
	
	include('config/db_connect.php');
	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}
			$user = $_SESSION["username"];

	if(!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
	    // write query for books just checked out by the user
	//$sql = 'SELECT books.title, checks_out.username FROM books, checks_out WHERE checks_out.username = "$user"';
	// $sql = "SELECT books.title, books.ID, checks_out.username FROM books, checks_out WHERE checks_out.ID = books.ID AND checks_out.username = '$user'";
	$sql = "SELECT * FROM books WHERE books.at_status = '$user'";
	}

	else{
		// write query for all book
	// $sql = 'SELECT books.title, books.ID, checks_out.username FROM books, checks_out WHERE checks_out.ID = books.ID ORDER BY average_rating DESC LIMIT 20';
	$sql = "SELECT * FROM books WHERE books.at_status <> 'Library'";
	}
	

	// get the result set (set of rows)
	$result = mysqli_query($conn, $sql);

	// fetch the resulting rows as an array
	$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// free the $result from memory (good practise)
	mysqli_free_result($result);

	if(isset($_POST['checkin'])){
		$ID_to_checkin = mysqli_real_escape_string($conn, $_POST['ID_to_checkin']);
		$sql = "UPDATE books SET at_status = 'Library' WHERE ID = $ID_to_checkin";
		// $sql = "UPDATE checks_out SET username = 'Library' WHERE ID = $ID_to_checkin";
		// $sql = "DELETE FROM checks_out WHERE ID = $ID_to_checkin";
		if(mysqli_query($conn, $sql)){
				header('Location: index.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}
	if(isset($_GET['ID'])){
		
		// escape sql chars
		$ID = mysqli_real_escape_string($conn, $_GET['ID']);
	}


	// close connection
	mysqli_close($conn);

	
?>

<!DOCTYPE html>
<html>
	<?php include('templates/header.php'); ?>

	<h4 class="center grey-text">Checked out books</h4>

	<div class="container">
		<div class="row">
			<?php if($books): ?>
			<?php foreach($books as $book): ?>

				<div class="col s6 m4">
					<div class="card z-depth-0">
						<img src="img/books.png"class="book">
						

						<div class="card-content center">
							<h6><?php echo htmlspecialchars($book['title']); ?></h6>
							<form action="checkedout-books.php" method="POST">
								<input type="hidden" name="ID_to_checkin" value="<?php echo $book['ID']; ?>">
								<input type="submit" name="checkin" value="checkin" class="btn z-depth-0">
							</form>	
													<p style = "text-align:center">Checked out by: <?php echo htmlspecialchars($book['at_status']); ?></p>
					
						</div>


						
						<!-- <div class="card-action">
								<a class="brand-text" href="details.php?ID=<?php echo $book['ID'] ?>">Details
								</a>							
						</div>
						 -->

					</div>
				</div>

				
			<?php endforeach; ?>
			<?php else: ?>
			<h5 style = "text-align: center">You have no books currently checked out...</h5>
			<?php endif ?>

		</div>
	</div> <!--  -->
	<?php include('templates/footer.php'); ?>

</html>