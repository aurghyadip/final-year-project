<?php
	include_once 'core_functions.php';
	
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

	function totalBooks($isbn, $con)
	{
		$result = mysqli_query($con, "SELECT * from booksdb where isbn13 IN ('$isbn');");
		$row = mysqli_fetch_array($result);
		if($row['isbn13']==$isbn)
        {
          echo $row['copies'];
        }
        else 
        {
          echo '<span class="bg-danger text-white">N/A</span>';
        }
	}

	function ifAvailable($isbn,$con)
	{
		$result = mysqli_query($con, "SELECT * from booksdb where isbn13 IN ('$isbn');");
		$row = mysqli_fetch_array($result);
		if($row['copies'] == $row['rented'])
		{
			echo "0";
		}
		else
		{
			$available = $row['copies'] - $row['rented'];
			echo $available;
		}
	}

	function rentBook($isbn, $student, $con) 
	{
		mysqli_query($con,"
			UPDATE booksdb
			SET rented = rented - 1
			WHERE isbn13 like '%{$isbn}%;'
		");

	}

	function getBookInsight($isbn, $con)
	{
		$query = "SELECT st_name, due_date FROM rent, studentdb
			WHERE rent.isbn13 = $isbn
			AND rent.st_id = studentdb.st_id;
		";
		$result = mysqli_query($con, $query);
		while($row=mysqli_fetch_array($result))
		{
			echo "<td>".$row['st_name']."</td>";
			echo "<td>".$row['due_date']."</td>";
		}
	}

?>