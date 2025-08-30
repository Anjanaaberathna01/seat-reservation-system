<?php
session_start();
include("includes/connect.php"); // DB connection
$message = "";

// Google API
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId("769560818838-7hfshpt06rb57g74o4sql7hl6ec0qobv.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/seat_reservation_system/google-callback.php");
$client->addScope("email");
$client->addScope("profile");

$login_url = $client->createAuthUrl();

// Normal login
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
                $_SESSION['user_email'] = $user['email'];
                header("Location: dashboard.php");
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
    <title>Seat Reservation | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 360px;
            animation: fadeIn 1s ease-in-out;
            text-align: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-box h2 {
            margin-bottom: 15px;
            color: #333;
        }

        .login-box form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            /* Equal gap between inputs */
        }

        .login-box input,
        .login-box button,
        .google-btn {
            width: 100%;
            /* same width */
            padding: 12px;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
        }

        .login-box input {
            border: 1px solid #ccc;
            transition: all 0.3s ease;
        }

        .login-box input:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
        }

        .login-box button {
            border: none;
            background: #667eea;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-box button:hover {
            background: #5563d8;
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: #444;
            border: 1px solid #ccc;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .google-btn img {
            width: 20px;
            margin-right: 10px;
        }

        .google-btn:hover {
            background: #f7f7f7;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .register-link {
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
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

            <form method="POST" onsubmit="return validateForm();">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button type="submit">Log In</button>
            </form>

            <div style="text-align:center; margin-top:15px;">
                <a class="google-btn" href="<?php echo htmlspecialchars($login_url); ?>">
                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
                    Sign in with Google
                </a>
            </div>

            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a><br>
                <a href="change_password.php">Forgot Password</a>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();

            if (email === "" || password === "") {
                alert("Please fill in both fields!");
                return false;
            }
            if (password.length < 1) {
                alert("Password must be at least 6 characters long!");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>