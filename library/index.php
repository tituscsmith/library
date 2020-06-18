<?php 
	
	include('config/db_connect.php');
	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: login.php");
	    exit;
	}
	
	
	// $sql = 'SELECT * FROM books WHERE NOT EXISTS (SELECT * FROM checks_out WHERE checks_out.ID = books.ID) AND books.ratings_count > 100 ORDER BY average_rating DESC LIMIT 20';
	$sql = 'SELECT * FROM books WHERE books.at_status = "Library" AND books.ratings_count > 100 ORDER BY average_rating DESC LIMIT 20';

	// get the result set (set of rows)
	$result = mysqli_query($conn, $sql);

	// fetch the resulting rows as an array
	$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// free the $result from memory (good practise)
	mysqli_free_result($result);

	// close connection
	mysqli_close($conn);


?>

<!DOCTYPE html>
<html>
	<?php include('templates/header.php'); ?>

	<h4 class="center grey-text">Available Books!</h4>

	<div class="container">
		<div class="row">

			<?php foreach($books as $book): ?>

				<div class="col s6 m4">
					<div class="card z-depth-0">
						<img src="img/books.png"class="book">
						<div class="card-content center">
							<h6><?php echo htmlspecialchars($book['title']); ?></h6>
						</div>
						<div class="card-action center-align">
							<a class="brand-text" href="details.php?ID=<?php echo $book['ID'] ?>">Details</a>
						</div>

					</div>
				</div>

				
			<?php endforeach; ?>

		</div>
	</div> <!--  -->
	<?php include('templates/footer.php'); ?>

</html>