<?php 
include("db.php");
include 'login_require_session.php';


$successMsg = "";


$nameErr  = $descriptionErr = $priceErr =  "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];


    $valid = true;


    if (empty($_POST["name"])) {
        $nameErr = "Product name is required";
        $valid = false;
      } 
    
    if (empty($_POST["description"])) {
        $descriptionErr = "Please provide product description.";
        $valid = false;

      }

      if (empty($_POST["price"])) {
        $priceErr = "Please provide product price.";
        $valid = false;
      }



if($valid){
    try {
        $sql = "INSERT INTO Product (name, description, price)
        VALUES ('$name', '$description', '$price')";
        $conn->exec($sql);
        $_SESSION['successMsg'] = "Product Successfully Added!";
        header("Location: index.php");
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
      
}
      $conn = null;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Add New Product</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $productId; ?>" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value="<?= $name; ?>" >
                <span class="text-danger"><?php echo $nameErr;?></span>

            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" rows="3"><?= $description; ?></textarea>
                <span class="text-danger"><?php echo $descriptionErr;?></span>

            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" name="price" value="<?= $price ?>" step="0.01">
                <span class="text-danger"><?php echo $priceErr;?></span>

            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
            <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9WXhUptEr8+/2Q0E7rQZq5h5WhiZ/A15Lz9A2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
