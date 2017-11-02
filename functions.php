<?php
	
	include_once 'core_functions.php';
	
	/**
	 * Gets the ISBN13 from the industryIdentifiers in Google Books API. Useful for converting ISBN10 to ISBN13.
	 *
	 * @param      stdClass  $isbn_id  The industryIdentifier class from the Google Books API
	 *
	 * @return     string  returns the ISBN13 as a string to use it.
	 */
	function isbn13Selector($isbn_id)
	{
		foreach($isbn_id as $iid) 
		{
			if($iid->type=='ISBN_13')
			{
				return $iid->identifier;
			}
		}
	}

	/**
	 * Get the number of total copies available for a book in library.
	 *
	 * @param      string  $isbn   ISBN13 of the Book
	 * @param      mysqli_connection_string  $con    Connection string from the mysqli_connect() function
	 *
	 * @return     string  (returns the number of total books available in the library)
	 */
	function totalBooks($isbn, $con)
	{
		$result = mysqli_query($con, "SELECT * from booksdb where isbn13 IN ('$isbn');");
		$row = mysqli_fetch_array($result);
		if($row['isbn13']==$isbn)
        {
          return $row['copies'];
        }
        else 
        {
          return 'N/A';
        }
	}
	
	/**
	 * Checks if a book is availble for renting in the library.
	 *
	 * @param      string          $isbn   ISBN13 of the book in question
	 * @param      mysqli_connection_string          $con    Connection string from the mysqli_connect()
	 *
	 * @return     integer|string  returns the number of the books available to rent. Returns 0 if no book is available.
	 */
	function ifAvailable($isbn,$con)
	{
		$result = mysqli_query($con, "SELECT * from booksdb where isbn13 IN ('$isbn');");
		$row = mysqli_fetch_array($result);
		if($row['copies'] == $row['rented'])
		{
			return "0";
		}
		else
		{
			$available = $row['copies'] - $row['rented'];
			return $available;
		}
	}

	/**
	 * Function to rent a book.
	 * WORK IN PROGRSS____ DO NOT USE THIS FUNCTION
	 *
	 * @param      string  $isbn     ISBN13 of the book
	 * @param      string  $student  studentID maybe, not yet decided
	 * @param      mysqli_connection_string  $con      Connection string from the mysqli_connect()
	 */
	function rentBook($isbn, $student, $con) 
	{
		mysqli_query($con,"
			UPDATE booksdb
			SET rented = rented - 1
			WHERE isbn13 like '%{$isbn}%;'
		");
		// Add user and student id functionality here
		// Also required updation of the rent date
	}

	/**
	 * Gets how many students have taken the book and returns their name and due date
	 *
	 * @param      string  $isbn   ISBN13 of the book
	 * @param      mysqli_connection_string  $con    Connection string from the mysqli_connect()
	 *
	 * @return     array   Associative array of student names and due dates.
	 */
	function getBookInsight($isbn, $con)
	{
		$output = array();
		$query = "SELECT st_name, due_date FROM rent, studentdb
			WHERE rent.isbn13 = $isbn
			AND rent.st_id = studentdb.st_id;
		";
		$result = mysqli_query($con, $query);
		while($row=mysqli_fetch_array($result))
		{
			array_push($output, array(
				"st_name" => $row['st_name'],
				"due_date" => $row['due_date']	
			));	
		}
		return $output;
	}

?>