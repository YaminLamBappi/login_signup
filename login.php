<?php
session_start();
include 'db.php'; 

if(isset($_SESSION['email'])){
    header('Location:admin_portal.php');
    exit();
}

 $emailErr  = $passwordErr = $wronginput = $noUser =  "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
      } 
    
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
      } 

    $email = $_POST['email'];
    $password = $_POST['password'];
    // print_r($email);exit();

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

    if ($user) {
        if($email == $user['email']) {
            if(password_verify($password, $user['password'])){
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
    
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: admin_portal.php");
                } else {
                    header("Location: employee_portal.php");
                }
                exit();
            } else {
                $wrongPass = "Password is Incorrect.";
                } 

            } else {
                $wronginput = "Email is Incorrect.";
            }
        } else {
        $noUser = "No User Found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Login</h2>
                
                <span class="error"><?php echo $wronginput;?></span>
                

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" value="<?= $email ?>" placeholder="Enter email" >
                        
                        <span class="text-danger" >
                            <?php 
                            if (!empty($emailErr)) {
                                echo $emailErr;
                            } elseif (!empty($noUser)) {
                                echo $noUser;
                            }
                            ?>
                        </span>

                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" >
                        
                        <span class="text-danger" >
                            <?php 
                            if (!empty($passwordErr)) {
                                echo $passwordErr;
                            } elseif (!empty($wrongPass)) {
                                echo $wrongPass;
                            }
                            ?>
                        </span>

                    </div>


                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9WXhUptEr8+/2Q0E7rQZq5h5WhiZ/A15Lz9A2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

