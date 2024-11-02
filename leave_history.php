<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch leave history for the logged-in user
$stmt = $conn->prepare("SELECT leave_from, leave_to, reason, status, request_date FROM leave_histories WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$leave_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave History</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Your Leave History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Leave From</th>
                    <th>Leave To</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Request Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leave_history as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars($record['leave_from']); ?></td>
                        <td><?= htmlspecialchars($record['leave_to']); ?></td>
                        <td><?= htmlspecialchars($record['reason']); ?></td>
                        <td><?= htmlspecialchars(ucfirst($record['status'])); ?></td>
                        <td><?= htmlspecialchars($record['request_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="employee_portal.php" class="btn btn-secondary mt-3">Back to Portal</a>
    </div>
</body>
</html>
