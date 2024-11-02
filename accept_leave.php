<?php
session_start();
include 'db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: employee_portal.php");
    exit();
}

if (isset($_GET['id'])) {
    $history_id = $_GET['id'];

    try {
        // Update the leave request status to accepted
        $stmt = $conn->prepare("UPDATE leave_histories SET status = 'accepted' WHERE history_id = ?");
        $stmt->execute([$history_id]);

        header("Location: admin_portal.php");
        exit();
    } catch (PDOException $e) {
        echo "Error accepting leave: " . $e->getMessage();
    }
} else {
    header("Location: admin_portal.php");
}
