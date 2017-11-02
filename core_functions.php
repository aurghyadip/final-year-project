<?php
	/* Get Title of the book from API, also escapes errors */
	function getBookTitle($book)
	{
		if(property_exists($book, 'title'))
		{
			return $book->title;
		}
	}

	/* Get Subtitle of the book from API, also escapes errors */
	function getBookSubtitle($book)
	{
		if(property_exists($book, 'subtitle'))
		{
			return $book->subtitle;
		}
	}

	/* 
	*	Get Authors of the book from API, puts them in an array.
	*	Escapes errors also.
	*/
	function getBookAuthors($book)
	{
		$output = array();
		foreach($book->authors as $author)
		{
			array_push($output, $author);
		}
		return $output;
	}

	/* Get Description of the book from API, also escapes errors */
	function getBookDescription($book)
	{
		if(property_exists($book, 'description'))
		{
			return $book->description;
		}
	}

	/* 
	*	Get the link for the thumbnail of cover of the book from API. 
	*	Also escapes errors.
	*/
	function getBookImage($book)
	{
		if(property_exists($book, 'imageLinks'))
		{
			$imageLinks = $book->imageLinks;
			if(property_exists($imageLinks, 'thumbnail'))
			{
				return $imageLinks->thumbnail;
			}
		}
	}
?>