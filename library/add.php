<?php

	include('config/db_connect.php');

	$title = $authorID = $average_rating = $isbn = $publisherID = $ratings_count = '';
	$errors = array('title' => '', 'authorID' => '', 'publisherID' => '','isbn' => '', 'average_rating' => '', 'ratings_count' => '');
	session_start();

	//SESSION Doesn't wor
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
	    header("location: index.php");
	    exit;
	}
	// echo !isset($_SESSION["loggedin"]);
	// echo $_SESSION["admin"];

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
		// check publisherID
		if(empty($_POST['publisherID'])){
			$errors['publisherID'] = 'A publisherID is required';
		} else{
			$publisherID = $_POST['publisherID'];
			// if(!preg_match('/^[a-zA-Z\s]+$/', $publisherID)){
			// 	$errors['publisherID'] = 'Title must be letters and spaces only';
			// }
		}
		// check authorID
		if(empty($_POST['authorID'])){
			$errors['authorID'] = 'A authorID is required';
		} else{
			$authorID = $_POST['authorID'];
			// if(!preg_match('/^[a-zA-Z\s]+$/', $authorID)){
			// 	$errors['authorID'] = 'Author must be letters and spaces only';
			// }
		}
		if(empty($_POST['average_rating'])){
			$errors['average_rating'] = 'A average_rating is required';
		} else{
			$average_rating = $_POST['average_rating'];
			// if(!preg_match('/^[a-zA-Z\s]+$/', $average_rating)){
			// 	$errors['average_rating'] = 'Title must be letters and spaces only';
			// }
		}

		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$authorID = mysqli_real_escape_string($conn, $_POST['authorID']);
			$publisherID = mysqli_real_escape_string($conn, $_POST['publisherID']);
			$isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
			$average_rating = mysqli_real_escape_string($conn, $_POST['average_rating']);
			$ratings_count = mysqli_real_escape_string($conn, $_POST['ratings_count']);
			//Get ID for authorID and pubID
			//Insert authorID/publisherID
			// create sql

			// $sql = "SELECT MAX(books.ID) FROM books";
			// if(!mysqli_query($conn, $sql)){
			// 	// success
			// 	echo 'query error: '. mysqli_error($conn);
			// } 

			// $result = mysqli_query($conn, $sql);
			// //			print_r($result);

			// // fetch the resulting rows as an array
			// $max = mysqli_fetch_row($result);
			// foreach($max as $maxes){
			// 	$ID = $maxes + 1;
			// }
			// $sql1 = "INSERT INTO authorIDs(name) VALUES($'authorID')";
			// $sql2 = "INSERT INTO publisherID(name) VALUES($'publisherID')";
			


			// print_r($ID);
			// $sql = "INSERT INTO books(ID, title, average_rating, isbn, language_code, num_pages, ratings_count, num_ratings, publication_date, authorID, publisherID) VALUES($ID, '$title', $average_rating, '$language', $num_pages, $ratings_count, $num_ratings, $publication_date, $authorID, $publisherID')";
			$sql = "INSERT INTO books(title, average_rating, isbn, ratings_count, authorID, publisherID) VALUES('$title', $average_rating, $isbn, $ratings_count, $authorID, $publisherID)";

			// $sql2 = "INSERT INTO authorIDs"
			
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
			<label>authorID</label>
			<input type="text" name="authorID" value="<?php echo htmlspecialchars($authorID) ?>">
			<div class="red-text"><?php echo $errors['authorID']; ?></div>
			<label>PublisherID</label>
			<input type="text" name="publisherID" value="<?php echo htmlspecialchars($publisherID) ?>">
			<div class="red-text"><?php echo $errors['publisherID']; ?></div>
			
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>
<?php include('templates/footer.php'); ?>

</html>