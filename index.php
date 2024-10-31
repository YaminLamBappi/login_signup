<?php

include("db.php");

include 'login_require_session.php';
include 'session.php';

$username = $_SESSION['email'];

$productstmt = $conn->prepare("SELECT * FROM Product");
$productstmt->execute();

$products = $productstmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['successMsg'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['successMsg'] . "</div>";
    unset($_SESSION['successMsg']); // Clear the message after displaying
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Welcome to the home page, <?php echo $_SESSION['email']; ?>!</h2>
        
        <h4 class="mt-4">All available products:</h4>


        
        <table class="table table-bordered mt-3">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <th scope="row"><?php echo $product['id']; ?></th>
                    <td style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-width: 150px;"><?php echo $product['name']; ?></td>
                    <td style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-width: 150px;">
                        <?php echo $product['description']; ?> </td>
                    <td>$<?php echo $product['price']; ?></td>
                    <td>
                        <a href= "update_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">Update</a>

                        <form action="delete_product.php?id=<?php echo $product['id']; ?>" method="post" style="display:inline;">
                                <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete(this); return false;">Delete</a>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="mt-3">
            <a href="add_product.php" class="btn btn-success">Add New Product</a>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>
    </div>
    
    <script>
function confirmDelete(link) {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        link.parentElement.submit(); // Submit the form if confirmed
    }
}
</script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9WXhUptEr8+/2Q0E7rQZq5h5WhiZ/A15Lz9A2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
