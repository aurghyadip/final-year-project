<?php
	function getBookTitle($book)
	{
		if(property_exists($book, 'title'))
		{
			echo $book->title;
		}
	}

	function getBookSubtitle($book)
	{
		if(property_exists($book, 'subtitle'))
		{
			echo $book->subtitle;
		}
	}

	function getBookAuthors($book)
	{
		foreach($book->authors as $author)
		{
			echo "<br>".$author;
		}
	}

	function getBookDescription($book)
	{
		if(property_exists($book, 'description'))
		{
			echo $book->description;
		}
	}

	function getBookImage($book)
	{
		if(property_exists($book, 'imageLinks'))
		{
			$imageLinks = $book->imageLinks;
			if(property_exists($imageLinks, 'thumbnail'))
			{
				echo $imageLinks->thumbnail;
			}
		}
	}
?>