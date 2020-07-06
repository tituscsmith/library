<?php

	include('config/db_connect.php');

	$title = $authorName = $average_rating = $isbn = $publisherName = $language = $numPages = $pubDate = $ratings_count = '';
	$errors = array('pubDate' => '', 'language' => '','title' => '', 'numPages' => '', 'authorName' => '', 'publisherName' => '','isbn' => '', 'average_rating' => '', 'ratings_count' => '');
	session_start();

	//Make sure logged in
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
	    header("location: index.php");
	    exit;
	}
	if(isset($_POST['submit'])){
		
		// check title
		if(empty($_POST['title'])){
			$errors['title'] = 'A title is required';
		} else{
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors['title'] = 'Title must be letters and spaces only';
			}
		}
		// check publisherName
		if(empty($_POST['publisherName'])){
			$errors['publisherName'] = 'A publisherName is required';
		} else{
			$publisherName = $_POST['publisherName'];
			// if(!preg_match('/^[a-zA-Z\s]+$/', $publisherName)){
			// 	$errors['publisherName'] = 'Title must be letters and spaces only';
			// }
		}
		// check authorName
		if(empty($_POST['authorName'])){
			$errors['authorName'] = 'An author name is required';
		} else{
			$authorName = $_POST['authorName'];

		}
		if(empty($_POST['average_rating'])){
			$errors['average_rating'] = 'An average rating is required';
		} else{
			$average_rating = $_POST['average_rating'];
		}
		if(empty($_POST['pubDate'])){
			$errors['pubDate'] = 'A publisher date is required';
		} else{
			$pubDate = $_POST['pubDate'];
			
		}
		if(empty($_POST['language'])){
			$errors['language'] = 'A language is required';
		} else{
			$language = $_POST['language'];
		}
		if(empty($_POST['isbn'])){
			$errors['isbn'] = 'An isbn is required';
		} else{
			$isbn = $_POST['isbn'];
			
		}
		if(empty($_POST['ratings_count'])){
			$errors['ratings_count'] = 'A ratings count is required';
		} else{
			$ratings_count = $_POST['ratings_count'];
		}
		if(empty($_POST['numPages'])){
			$errors['numPages'] = 'Number of Pages is required';
		} else{
			$numPages = $_POST['numPages'];
		}

		if(array_filter($errors)){
			echo 'errors in form';
		} else {
			// escape sql chars
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$authorName = mysqli_real_escape_string($conn, $_POST['authorName']);
			$publisherName = mysqli_real_escape_string($conn, $_POST['publisherName']);
			$isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
			$average_rating = mysqli_real_escape_string($conn, $_POST['average_rating']);
			$ratings_count = mysqli_real_escape_string($conn, $_POST['ratings_count']);
			$language = mysqli_real_escape_string($conn, $_POST['language']);
			$pubDate = mysqli_real_escape_string($conn, $_POST['pubDate']);
			$numPages = mysqli_real_escape_string($conn, $_POST['numPages']);

			

			$sql = "INSERT INTO books (books.title, books.average_rating, books.isbn, books.ratings_count, books.publisherName, books.language, books.publication_date, books.num_pages) VALUES('$title', '$average_rating', '$isbn', '$ratings_count', '$publisherName', '$language', '$pubDate', '$numPages')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				//header('Location: index.php');
			} else {
				echo 'query error1: '. mysqli_error($conn);
			}

			$sql = "SELECT books.ID FROM books WHERE books.isbn = '$isbn'";

			// get the result set (set of rows)
			$result = mysqli_query($conn, $sql);

			
			// fetch the resulting rows as an array
			$data = mysqli_fetch_assoc($result);

			// free the $result from memory (good practise)
			mysqli_free_result($result);


//			print_r($data);

			$ID = $data['ID'];
																				//$data['ID']
			$sql = "INSERT INTO writes(writes.bookID, writes.authorName) VALUES ('$ID', '$authorName')";
			
			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else {
				echo 'query error2: '. mysqli_error($conn);
			}
		}

		
			// close connection
			mysqli_close($conn);

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Add a Book</h4>
		<form class="white" action="add.php" method="POST">
			<label>Book Title</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
			<div class="red-text"><?php echo $errors['title']; ?></div>
			<label>Average Rating</label>
			<input type="text" name="average_rating" value="<?php echo htmlspecialchars($average_rating) ?>">
			<div class="red-text"><?php echo $errors['average_rating']; ?></div>
			<label>Rating count</label>
			<input type="text" name="ratings_count" value="<?php echo htmlspecialchars($ratings_count) ?>">
			<div class="red-text"><?php echo $errors['ratings_count']; ?></div>
			<label>ISBN</label>
			<input type="text" name="isbn" value="<?php echo htmlspecialchars($isbn) ?>">
			<div class="red-text"><?php echo $errors['isbn']; ?></div>
			<label>Language</label>
			<input type="text" name="language" value="<?php echo htmlspecialchars($language) ?>">
			<div class="red-text"><?php echo $errors['language']; ?></div>
			<label>Publication Date</label>
			<input type="text" name="pubDate" value="<?php echo htmlspecialchars($pubDate) ?>">
			<div class="red-text"><?php echo $errors['pubDate']; ?></div>
			<label>Author Name</label>
			<input type="text" name="authorName" value="<?php echo htmlspecialchars($authorName) ?>">
			<div class="red-text"><?php echo $errors['authorName']; ?></div>
			<label>Publisher Name</label>
			<input type="text" name="publisherName" value="<?php echo htmlspecialchars($publisherName) ?>">
			<div class="red-text"><?php echo $errors['publisherName']; ?></div>
			<label>Number of Pages</label>
			<input type="text" name="numPages" value="<?php echo htmlspecialchars($numPages) ?>">
			<div class="red-text"><?php echo $errors['numPages']; ?></div>
			
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>
<?php include('templates/footer.php'); ?>

</html>