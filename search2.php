<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Hello Bulma!</title>
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css"> -->
	</head>
	
	<body>
  		<?php
  			$con = mysqli_connect("localhost","aurghya","aurghya","books");
		
			$isbn = $_GET["isbn"];
			$gbooks = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:".$isbn);
			$gbooks = json_decode($gbooks);
		
			$book = $gbooks->items[0]->volumeInfo;
			$isbn13 = $book->industryIdentifiers[1]->identifier;
			$result = mysqli_query($con, "SELECT * FROM booksdb
    		WHERE isbn13 LIKE '%{$isbn13}%'");
    		var_dump($result);

			$row = mysqli_fetch_array($result);
        	if($row['isbn13']==$isbn13 && $row['copies']>=1) {
        		echo "Available <strong>".$row['copies']." Copies</strong> <br>";
        	}
        	else {
        		echo '<span style="background:red; color:white;">Not Available</span><br>';
        	}
    		mysqli_close($con);
			// var_dump($book);
		?>
		
	</body>
</html>