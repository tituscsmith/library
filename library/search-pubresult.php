<?php 
	$publisher = '';
	include('config/db_connect.php');

		// retrieve publisher
		if(empty($_POST['publisher'])){
			$errors['publisher'] = 'A publisher is required';
		} else{
			$publisher = $_POST['publisher'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $publisher)){
				$errors['publisher'] = 'publisher must be letters and spaces only';
			}
		}

	// write query for all books
	//$sql = "SELECT publisher FROM books WHERE publisher LIKE '%color%'";
		$sql = "SELECT books.title, books.ID FROM books INNER JOIN publisher ON books.publisherID = publisher.ID AND publisher.name LIKE '%$publisher%'";

	// get the result set (set of rows)
	$result = mysqli_query($conn, $sql);

	// fetch the resulting rows as an array
	$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

	  // //If no data, retrieve error message
	  // if (empty($books) || empty($publisher)) {
	  // 	$sql = "SELECT publisher, ingredients, id FROM books WHERE id = '-1'";
	  // 	$result = mysqli_query($conn, $sql);
	  // 	$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
	  // }

	 // print_r($books);

	// free the $result from memory (good practise)
	mysqli_free_result($result);

	// close connection
	mysqli_close($conn);


?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<h4 class="center grey-text">Matching Books</h4>

	<div class="container">
		<div class="row">
<!-- Case for where book doesn't exist
 -->			<!-- <?php foreach($books as $book): ?> -->

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

	<!-- 		<?php endforeach; ?> -->

		</div>
	</div>

	<?php include('templates/footer.php'); ?>

</html>