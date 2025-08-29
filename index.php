<?php
session_start();
include("includes/connect.php"); // your DB connection file
$message = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $conn = (new database())->connect();
        $email = mysqli_real_escape_string($conn, $email);

        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $row['email'];
                header("Location: dashboard.php"); // Redirect to dashboard
                exit;
            } else {
                $message = "Incorrect email or password!";
            }
        } else {
            $message = "Incorrect email or password!";
        }
    } else {
        $message = "Please fill in all fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f0f0f0;
        margin: 0;
        padding: 20px 0;
        /* top & bottom padding */
        display: flex;
        flex-direction: column;
    }


    .login-container {
        flex: 1;
        /* take remaining space after header */
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 50px;
    }


    .login-box {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
    }

    .login-box h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-box input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .login-box button {
        width: 100%;
        padding: 10px;
        border: none;
        background: #0542c5;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .login-box button:hover {
        background: #0431a0;
    }

    .error {
        color: red;
        text-align: center;
    }

    @media screen and (max-width: 600px) {
        .login-container {
            margin-top: 30px;
        }
    }
    </style>
</head>

<body>
    <?php include("header.php"); ?>

    <div class="login-container">
        <div class="login-box">
            <h2>Log In</h2>
            <?php if ($message != "") {
                echo "<p class='error'>$message</p>";
            } ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Log In</button>
            </form>
            <p style="text-align:center; margin-top:10px;">
                Don't have an account? <a href="register.php">Register here</a>
            </p>

        </div>
    </div>
</body>

</html>