<?php
include("db.php");
include 'login_require_session.php';
include 'session.php';

$username = $_SESSION['email'];

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: employee_portal.php"); // Redirect to the login page
    exit();
}



// Fetch leave requests
try {
    $stmt = $conn->prepare("SELECT history_id, leave_from, leave_to, reason, status, u.username 
                             FROM leave_histories lh 
                             JOIN users u ON lh.user_id = u.id 
                             WHERE status = 'pending'"); // Only fetch pending requests
    $stmt->execute();
    $leave_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching leave requests: " . $e->getMessage();
    $leave_requests = [];
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
        <h2 class="text-center">Welcome to the Admin page!</h2>
        

        <h4 class="mt-4">Manage Leave application:</h4>
        
        <?php if (empty($leave_requests)): ?>
            <div class="alert alert-info" role="alert">
                No pending leave requests available.
            </div>
        <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Leave From</th>
                    <th>Leave UpTo</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leave_requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['history_id']); ?></td>
                        <td><?= htmlspecialchars($request['username']); ?></td>
                        <td><?= htmlspecialchars($request['leave_from']); ?></td>
                        <td><?= htmlspecialchars($request['leave_to']); ?></td>
                        <td><?= htmlspecialchars($request['reason']); ?></td>
                        <td>
                            <a href="accept_leave.php?id=<?= $request['history_id']; ?>" class="btn btn-success btn-sm" onclick="return confirmAction('accept')">Accept</a>
                            <a href="reject_leave.php?id=<?= $request['history_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirmAction('reject')">Reject</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
        
        <div class="mt-3">
            <a href="add_employee.php" class="btn btn-success">Add New Employee</a>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>
    </div>
    

</script>
<script>
        function confirmAction(action) {
            return confirm(`Are you sure you want to ${action} this leave request?`);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
