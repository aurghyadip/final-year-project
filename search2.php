<?php include_once 'functions.php'; ?>
<?php
	$con = mysqli_connect("localhost","aurghya","aurghya","books");

	$isbn = $_GET["isbn"];
	$gbooks = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:".$isbn);
	$gbooks = json_decode($gbooks);

	$book = $gbooks->items[0]->volumeInfo;
	$isbnID = $book->industryIdentifiers; 
	$isbn13 = (int)isbn13Selector($isbnID);
?>