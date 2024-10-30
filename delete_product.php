<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM Product WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Product not found!";
        exit();
    }
} else {
    echo "No product ID provided!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {
        $stmt = $conn->prepare("DELETE FROM Product WHERE id = ?");
        $stmt->execute([$productId]); 
       
        header("Location: index.php");
        exit(); 
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage(); 
    }
      
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-danger">Confirm Product Deletion</h2>
        <p class="text-center">Are you sure you want to delete this product?</p>
        
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body text-center">
                <h5 class="card-title">Product Name: <?php echo htmlspecialchars($product['name']); ?></h5> 
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $productId; ?>" method="post">
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9WXhUptEr8+/2Q0E7rQZq5h5WhiZ/A15Lz9A2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
