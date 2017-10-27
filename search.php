<?php include_once 'functions.php'; ?>

<?php
  $con = mysqli_connect("localhost","aurghya","aurghya","books");

  $isbn = $_GET["isbn"];
  $gbooks = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:".$isbn);
  $gbooks = json_decode($gbooks);

  $book = $gbooks->items[0]->volumeInfo;
  $isbnID = $book->industryIdentifiers; 
  $isbn13 = (int)isbn13Selector($isbnID);
  $result = mysqli_query($con, "SELECT * FROM booksdb WHERE isbn13 IN (".$isbn13.");");
  // var_dump($result);

  $row = mysqli_fetch_array($result);
  include_once 'templates/head.php';
?>

<div class="row">
  <div class="col-sm">
    <img src="<?php getBookImage($book); ?>" alt="Thumbnail Not Available" class="img-thumbnail">
    <p class="display-4"><?php getBookTitle($book); ?></p>
    <p class="lead"><?php getBookSubtitle($book); ?></p>
  </div>
  <div class="col-sm">
    
  <p>
    <strong>Authors</strong>
    <?php getBookAuthors($book); ?>
  </p>
  <p>
    <strong>ISBN-13</strong><br>
    <?php echo isbn13Selector($isbnID); ?>
  </p>
  </div>
  <div class="col-sm">
    <h4>Description</h4>
    <p class="small" style="text-align: justify;"><?php getBookDescription($book); ?></p>
  </div>
</div>

<div class="row">
  <div class="col-sm">
    <h3>Total Books</h3>
    <p class="display-2">
      <?php totalBooks($isbn13, $con); ?>
    </p>
  </div>
  <div class="col-sm">
    <h3>Available Books</h3>
    <h2 class="display-2"><?php ifAvailable($isbn13,$con) ?></h2>
  </div>
  <div class="col-sm">
    <h3>Books Insight</h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">First Name</th>
          <th scope="col">Due Date</th>
        </tr>
      </thead>
      <tbody>
        <?php getBookInsight($isbn13, $con) ?>
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
<?php include_once 'templates/footer.php'; ?>
<?php mysqli_close($con); ?>