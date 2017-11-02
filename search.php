<?php

  include_once 'functions.php'; // convert to require_once in the final build

  // Conncetion with the database
  $con = mysqli_connect("localhost","aurghya","aurghya","books");

  // Get the ISBN Number that the user entered in the field
  $isbn = $_GET["isbn"];

  $book = getBook($isbn);
  
  // getting the ISBN object from the 'book' class
  $isbnID = $book->industryIdentifiers; 
  
  // reference in functions.php
  $isbn13 = isbn13Selector($isbnID);
  
  // Test Purpose Only
  // $result = mysqli_query($con, "SELECT * FROM booksdb WHERE isbn13 IN (".$isbn13.");");
  // var_dump($result);

  $imgLink = getBookImage($book);
  $title = getBookTitle($book); 
  $subtitle = getBookSubtitle($book); 
  $authors = getBookAuthors($book);
  $description = getBookDescription($book); 
  $totalBooks = totalBooks($isbn13, $con); 
  $available = ifAvailable($isbn13,$con);
  $insight = getBookInsight($isbn13, $con); // not working
  mysqli_close($con);

  // making an associative array for outputting the
  // data
  $output = array(
    "title" => $title,
    "subtitle" => $subtitle,
    "authors" => $authors,
    "description" => $description,
    "imgLink" => $imgLink,
    "totalBooks" => $totalBooks,
    "available" => $available,
    "insight" => $insight 
  );

  // encoding the data to json
  $output = json_encode($output);
  echo $output;
?>