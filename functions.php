<?php
	
	function ifAvailable($isbn,$con)
	{
		$result = mysqli_query($con, "SELECT * from booksdb where isbn13 IN ('$isbn');");
		$row = mysqli_fetch_array($result);
		if($row['copies'] == $row['rented'])
		{
			return 0;
		}
		else
		{
			$available = $row['copies'] - $row['rented'];
			return $available;
		}
	}

	function rentBook($isbn, $student) 
	{
		mysqli_query($con,"
			UPDATE booksdb
			SET rented = rented - 1
			WHERE isbn13 like '%{$isbn}%;'
		");

	}

?>