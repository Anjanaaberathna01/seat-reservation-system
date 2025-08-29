<?php
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $admin_name = trim($_POST['admin_name']);
    $password = trim($_POST['password']);

    if ($admin_name === "admin" && $password === "000") {
        $_SESSION['admin_name'] = $admin_name;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $message = "Invalid Admin Name or Password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f0f2f5;
        margin: 0;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 80px);
        /* subtract header height */
    }

    .login-box {
        background: #fff;
        padding: 30px;
        width: 350px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .login-box h2 {
        margin-bottom: 20px;
        color: #0542c5;
    }

    .login-box label {
        display: block;
        text-align: left;
        font-weight: bold;
        margin: 10px 0 5px;
        color: #333;
    }

    .login-box input {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .login-box button {
        width: 100%;
        padding: 12px;
        background: #0542c5;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }

    .login-box button:hover {
        background: #032b7a;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>
    <!-- Admin Header -->
    <?php include("admin_header.php"); ?>

    <!-- Login Form -->
    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>
            <?php if (!empty($message))
                echo "<p class='error-message'>$message</p>"; ?>
            <form method="POST" action="">
                <label for="admin_name">Admin Name</label>
                <input type="text" id="admin_name" name="admin_name" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>

</body>

</html>