<?php

	/**
	 * Gets the volumeInfo object from the Gppgle Books API
	 *
	 * @param      string  $isbn   ISBN from the $_GET['isbn']
	 *
	 * @return     stdClass  book object for further usage
	 */
	function getBook($isbn)
	{
		$gbooks = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:".$isbn);
		$gbooks = json_decode($gbooks);
		$book = $gbooks->items[0]->volumeInfo;
		return $book;
	}


	/**
	 * Gets the Book Title from the Google Books API
	 *
	 * @param      stdClass  $book   The book object that is returned by getBook()
	 *
	 * @return     string  Title of the book(if available)
	 */
	function getBookTitle($book)
	{
		if(property_exists($book, 'title'))
		{
			return $book->title;
		}
	}

	
	/**
	 * Gets the subtitle of the book from the Google Books API
	 *
	 * @param      stdClass  $book   book object returned by getBook()
	 *
	 * @return     string  The subtitle of the book.
	 */
	function getBookSubtitle($book)
	{
		if(property_exists($book, 'subtitle'))
		{
			return $book->subtitle;
		}
	}


	/**
	 * Gets the authors of the book and puts them into a PHP array
	 *
	 * @param      stdClass  $book   book object returned by getBook()
	 *
	 * @return     array   Array of authors.
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
	 * Gets the book description from Google Books API.
	 *
	 * @param      stdClass  $book   book object returned by getBook()
	 *
	 * @return     string    Description of the book(if available)
	 */
	function getBookDescription($book)
	{
		if(property_exists($book, 'description'))
		{
			return $book->description;
		}
	}


	/**
	 * Gets the link of the thumbnail of the cover of the book
	 *
	 * @param      stdClass  $book   book object returned by getBook()
	 *
	 * @return     string  Link to the image
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