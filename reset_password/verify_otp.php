<?php
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $entered_otp = trim($_POST['otp']);

    if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
        // OTP correct → redirect to reset password
        header("Location: reset_password.php");
        exit();
    } else {
        $message = "<span style='color:red;'>❌ Invalid OTP. Try again!</span>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Verify OTP</title>
    <link rel="stylesheet" href="auth.css">

</head>

<body>
    <h2>Verify OTP</h2>
    <?php if (!empty($message))
        echo $message; ?>
    <form method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit">Verify</button>
    </form>
</body>

</html>