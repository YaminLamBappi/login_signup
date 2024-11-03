<?php
include("db.php");
include 'login_require_session.php';
include 'session.php';

$username = $_SESSION['email'];



if (isset($_SESSION['successMsg'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['successMsg'] . "</div>";
    unset($_SESSION['successMsg']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Welcome to the Employee page.</h2>
                
        
        <div class="mt-3">
            <a href="apply_leave.php" class="btn btn-success">Apply For Leave.</a> 
            <a href="leave_history.php" class="btn btn-success">Leave Applications History.</a>
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
