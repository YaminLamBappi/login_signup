<?php
session_start();
include 'db.php'; 

include 'login_require_session.php';


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
