<?php
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
  $con = mysqli_connect("localhost","aurghya","aurghya","books");

  $isbn = (int)$_GET["isbn"];
  $gbooks = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:".$isbn);
  $gbooks = json_decode($gbooks);

  $book = $gbooks->items[0]->volumeInfo;
  $isbnID = $book->industryIdentifiers; 
  $isbn13 = (int)isbn13Selector($isbnID);
  $result = mysqli_query($con, "SELECT * FROM booksdb WHERE isbn13 IN (".$isbn13.");");
  // var_dump($result);

  $row = mysqli_fetch_array($result);
  // var_dump($row);
  /*if($row['isbn13']==$isbn13 && $row['copies']>=1) {
    echo "Available <strong>".$row['copies']." Copies</strong> <br>";
  }
  else {
    echo '<span style="background:red; color:white;">Not Available</span><br>';
  }
  mysqli_close($con);*/
  // var_dump($book);
  
?>
<?php include_once 'templates/head.php'; ?>
<?php include_once 'functions.php'; ?>
<div class="row">
  <div class="col-sm">
    <img src="<?php echo $book->imageLinks->thumbnail; ?>" class="img-thumbnail">
  </div>
  <div class="col-sm">
    <p class="display-4"><?php echo $book->title; ?></p>
    <p class="lead">
    <?php
      if(property_exists($book, 'subtitle'))
      {
        echo $book->subtitle;
      }
    ?>
  </p>
  <p>
    <strong>Authors</strong>
    <?php
      foreach ($book->authors as $author) 
      {
        echo "<br>".$author;
      }
    ?>
  </p>
  <p>
    <strong>ISBN-13</strong><br>
    <?php echo isbn13Selector($isbnID); ?>
  </p>
  </div>
  <div class="col-sm">
    <h4>Description</h4>
    <p class="small" style="text-align: justify;"><?php echo $book->description; ?></p>
  </div>
</div>

<div class="row">
  <div class="col-sm">
    <h3>Total Books</h3>
    <p class="display-2">
      <?php
        if($row['isbn13']==$isbn13)
        {
          echo $row['copies'];
        }
        else 
        {
          echo '<span class="bg-danger text-white">N/A</span>';
        }
      ?>
    </p>
  </div>
  <div class="col-sm">
    <h3>Available Books</h3>
    <h2 class="display-2"><?php echo ifAvailable($isbn13,$con) ?></h2>
  </div>
  <div class="col-sm">
    <h3>Books Insight</h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
          <th scope="col">Due Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Mark</td>
          <td>Otto</td>
          <td>25-10-2017</td>
        </tr>
        <tr>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>27-10-2017</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-auto">
    <button type="button" class="btn btn-primary">Rent</button>
    <button type="button" class="btn btn-danger">Deposit</button>
  </div>
</div>
</div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
<?php mysqli_close($con); ?>