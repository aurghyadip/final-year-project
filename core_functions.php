<?php
	/**
	* Functions that are useful in core applications
	* 	i.e. rertrieving data from Google Books API.
	* 
	* Do not add any functions here.
	*/

	/**
	* Get the book class from the Google Books API.
	* 
	* @param string $isbn
	* 	**Description :** Takes ISBN10 or ISBN13 of a
	* 	book retrieved from the `$_GET["ISBN"]` as input.
	* @return stdClass
	*/
	function getBook($isbn)
	{
		$gbooks = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:".$isbn);
		$gbooks = json_decode($gbooks);
		$book = $gbooks->items[0]->volumeInfo;
		return $book;
	}

	/**
	* Get Title of the book from API.
	* 
	* @param stdClass $book
	* **Description :** Takes the stdClass that is returned from
	* 	the function `getBook()`.
	* @return string
	*/
	function getBookTitle($book)
	{
		if(property_exists($book, 'title'))
		{
			return $book->title;
		}
	}

	/**
	* Get Subtitle of the book from API.
	* 
	* @param stdClass $book 
	* **Description :** Takes the stdClass that is returned from
	* 	the function `getBook()`.
	* @return string
	*/
	function getBookSubtitle($book)
	{
		if(property_exists($book, 'subtitle'))
		{
			return $book->subtitle;
		}
	}

	/** 
	* Get Authors of the book from API, puts them in an array.
	* 
	* @param stdClass $book
	* **Description :** Takes the stdClass that is returned from
	* 	the function `getBook()`.
	* @return array
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

	/**
	* Get Description of the book from API.
	*
	* @param stdClass $book
	* **Description :** Takes the stdClass that is returned from
	* 	the function `getBook()`.
	* @return string
	*/
	function getBookDescription($book)
	{
		if(property_exists($book, 'description'))
		{
			return $book->description;
		}
	}

	/** 
	* Get the link for the thumbnail of cover of the book from API. 
	*
	* @param stdClass $book
	* **Description :** Takes the stdClass that is returned from
	* 	the function `getBook()`.
	* @return string
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