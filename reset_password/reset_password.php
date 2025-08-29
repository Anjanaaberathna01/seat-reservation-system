<?php
session_start();
include("includes/connect.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $new_password = trim($_POST['new_password']);
    $email = $_SESSION['reset_email'] ?? "";

    if (!empty($email)) {
        $conn = (new database())->connect();
        $update = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("ss", $new_password, $email);

        if ($stmt->execute()) {
            unset($_SESSION['otp']);
            unset($_SESSION['reset_email']);
            $message = "<span style='color:green;'>✅ Password reset successful. You can <a href='index.php'>login</a> now.</span>";
        } else {
            $message = "<span style='color:red;'>❌ Failed to reset password. Try again.</span>";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body>
    <h2>Reset Password</h2>
    <?php if (!empty($message))
        echo $message; ?>
    <form method="POST">
        <input type="password" name="new_password" placeholder="Enter new password" required>
        <button type="submit">Update Password</button>
    </form>
</body>

</html>