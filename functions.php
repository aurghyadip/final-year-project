<?php
	
	include_once 'core_functions.php';
	
	/**
	*	Selects the ISBN13 from the
	*	Google Books API, if an user
	*	enters ISBN10 for a book, the
	*	function still feeds the correct
	*	ISBN13 number to all the data 
	*	retrieving functions. SO, no
	*	incompatibility issue occurs.
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
	*	Returns the total number
	*	of a said book in the whole
	*	library.
	*	If not available, returns N/A.
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
	*	Checks if a book is available or not.
	*	If it is available, returns the number
	*	of the copies available.
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
	* 	Function that executes the
	*	Renting functionality of a
	*	said book by identifying it
	* 	with the ISBN13 and renting.
	*	The rent date is set to
	*	timestamp, and the default
	* 	due date should be a month
	*	from the rent date.
	* 	Function should also exclude
	*	non working days.
	*/

	//WORK IN PROGRSS ____ DO NOT USE THIS FUNCTION
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
	* 	Returns the Book Insight
	* 	Who has taken the book and
	* 	the due dates of the books,
	* 	to check at a glance, for if
	* 	a book is available in the
	*	library.
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