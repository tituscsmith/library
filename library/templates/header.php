<head>
	<title>Titus's Library</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel = "stylesheet"
         href = "https://fonts.googleapis.com/icon?family=Material+Icons">
      <script type = "text/javascript"
         src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>           
      <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js">
      </script> 
  <style type="text/css">
	  .brand{
	  	background: #cbb09c !important;
	  }
  	.brand-text{
  		color: #cbb09c !important;
  	}
  	form{
      max-width: 460px;
  		margin: 20px auto;
  		padding: 20px;
  	}

    .book{
      width: 75px;
      margin: 40px auto -30px;
      display: block;
      position: relative;
      top: -30px;
    }
    .col{
      height: 300px;
    }
    

  </style>
</head>
<body class="grey lighten-4">

	<nav class="white z-depth-0">
    
    <div class="container">
      <a href="index.php" class="brand-logo brand-text">The Library</a>
      <?php if((isset($_SESSION["admin"]) && $_SESSION["admin"] == true) || (isset($_SESSION["username"]) && $_SESSION["username"] == true)): ?>

          <ul id="nav-mobile" class="right hide-on-small-and-down">
            <ul id = "dropdown-1" class = "dropdown-content">
             <li><a href = "search-bybook.php">Title<!-- <span class = "badge">12</span> --></a></li>
             <li><a href = "search-byauthor.php">Author</a></li>
             <li><a href = "search-bypub.php">Publisher</a></li>

          </ul>
          <ul id="nav-mobile" class="right hide-on-small-and-down">
            <ul id = "dropdown-2" class = "dropdown-content">

            	<?php if(!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true): ?>
             <li><a href = "checkedout-books.php?username=<?php echo htmlspecialchars($_SESSION["username"]); ?>">My Loans</a></li>

              <?php else: ?>
                        
                        <li><a href = "checkedout-books.php?username=<?php echo htmlspecialchars($_SESSION["username"]); ?>">All Loans</a></li>
              <?php endif; ?>
             <li><a href = "reset-password.php">Reset Password</a></li>
              <li><a href = "logout.php">Sign Out</a></li>
          </ul>
          
          

          <a class = "btn dropdown-button" href = "#" data-activates = "dropdown-2"><?php echo htmlspecialchars($_SESSION["username"]); ?>'s Account:
             <i class = "mdi-navigation-arrow-drop-down right"></i></a>

          <a class = "btn dropdown-button" href = "#" data-activates = "dropdown-1">Search by:
             <i class = "mdi-navigation-arrow-drop-down right"></i></a>

             <?php if(isset($_SESSION["admin"]) && $_SESSION["admin"] == true): ?>
            <a class = "btn dropdown-button" href = "#" data-activates = "dropdown-3">Add by:
                        <i class = "mdi-navigation-arrow-drop-down right"></i></a>
          <ul id = "dropdown-3" class = "dropdown-content">
             <li><a href = "add.php">Book</a></li>
              <!-- <li><a href = "add-author.php">Author</a></li>
              <li><a href = "add-publisher.php">Publisher</a></li> -->
          </ul>
          <!--   <li><a href="remove.php" class="btn brand">Remove a Book
              <i class = "mdi-navigation-arrow-drop-down right"></i></a>
            </li> -->
        <?php endif; ?>
  <?php endif; ?>
    </div>

  </nav>
  