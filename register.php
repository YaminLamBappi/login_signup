<?php
session_start();

include 'db.php'; 

if (isset($_SESSION['email'])) {
    header('Location:index.php');
    exit();
}
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = $username =  "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Initialize validation flags
    $valid = true;

    if (empty($_POST["username"])) {
        $nameErr = "Username is required";
        $valid = false;
    } else {
        $username = $_POST['username'];
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $valid = false;
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $valid = false;
    } else {
        $password = $_POST['password'];
    }

    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Confirm password is required";
        $valid = false;
    } elseif ($_POST["password"] !== $_POST["confirm_password"]) {
        $confirmPasswordErr = "Passwords do not match";
        $valid = false;
    }

    if ($valid) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            $conn->exec($sql);

            header("Location: login.php");
            exit();

        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Register</h2>
                
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $username ?>" placeholder="Your Username">
                        <span class="text-danger"><?php echo $nameErr;?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $email ?>" placeholder="Enter Email">
                        <span class="text-danger"><?php echo $emailErr;?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="text-danger"><?php echo $passwordErr;?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        <span class="text-danger"><?php echo $confirmPasswordErr;?></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="login.php" class="btn btn-link">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9WXhUptEr8+/2Q0E7rQZq5h5WhiZ/A15Lz9A2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
