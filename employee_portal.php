<?php
include("db.php");
include 'login_require_session.php';
include 'session.php';

$username = $_SESSION['email'];



if (isset($_SESSION['successMsg'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['successMsg'] . "</div>";
    unset($_SESSION['successMsg']); 
}

$stmt = $conn->prepare("SELECT leave_from, leave_to, reason, status, request_date FROM leave_histories WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$leave_history = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
        
        <div class="mt-3">
            <a href="apply_leave.php" class="btn btn-success">Apply For Leave.</a> 
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
