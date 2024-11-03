<?php
session_start();
include 'db.php';

// Check if the user is logged in and is an employee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: admin_portal.php");
    exit();
}

$leave_from = $leave_to = $reason = "";
$leaveErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $valid = true;

    if (empty($_POST["leave_from"])) {
        $leave_from_Err = "Enter dates leave from.";
        $valid = false;
    } else {
        $leave_from = $_POST['leave_from'];
        
    }
    if (empty($_POST['leave_to']) ){
        $leaveErr = 'Enter dates leave upto.';
        $valid = false;
    } else{
        $leave_to = $_POST['leave_to'];
        $reason = $_POST['reason'];
    }
    if (empty($_POST['reason']) ){
        $reasonErr = 'Reason are required.';
        $valid = false;
    } else{
        $reason = $_POST['reason'];
    }

    if ($valid) {
    try {
        $stmt = $conn->prepare("INSERT INTO leave_histories (user_id, leave_from, leave_to, reason, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->execute([$_SESSION['user_id'], $leave_from, $leave_to, $reason]);
       
        $_SESSION['successMsg'] = " <h5>Leave Request Submitted Successfully!</h5>
    <p>Your leave request has been submitted and is awaiting approval.</p>";
        header("Location: employee_portal.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Apply for Leave</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="leave_from">Leave From</label>
                <input type="date" name="leave_from" class="form-control" value="<?= $leave_from; ?>">
                <span class="text-danger"><?php echo $leave_from_Err;?></span>
                </div>
            <div class="form-group">
                <label for="leave_to">Leave To</label>
                <input type="date" name="leave_to" class="form-control" value="<?= $leave_to; ?>">
                <span class="text-danger"><?php echo $leaveErr;?></span>

            </div>
            <div class="form-group">
                <label for="reason">Reason</label>
                <textarea name="reason" class="form-control" rows="3"><?= $reason; ?></textarea>
                <span class="text-danger"><?php echo $reasonErr;?></span>

            </div>
            <button type="submit" class="btn btn-primary">Submit Leave Request</button>
        </form>
        <a href="employee_portal.php" class="btn btn-secondary mt-3">Back to Portal</a>
    </div>
</body>
</html>
