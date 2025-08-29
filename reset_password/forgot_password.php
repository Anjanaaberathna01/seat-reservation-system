<?php
session_start();
include("../includes/connect.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST['email']);
    $conn = (new database())->connect();

    // Check if email exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['reset_email'] = $email;
        $_SESSION['otp'] = $otp;

        // Send email with OTP
        $subject = "Password Reset OTP - Seat Reservation System";
        $message_body = "Hello,\n\nYour OTP for resetting your password is: $otp\n\nThis OTP will expire in 10 minutes.";
        $headers = "From: noreply@seatreservation.com";

        if (mail($email, $subject, $message_body, $headers)) {
            header("Location: reset_password/sverify_otp.php");
            exit();
        } else {
            $message = "<span style='color:red;'>❌ Failed to send OTP. Please try again later.</span>";
        }
    } else {
        $message = "<span style='color:red;'>⚠️ Email not registered!</span>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        justify-content: center;
        align-items: center;
    }

    form {
        background: #fff;
        padding: 30px 25px;
        border-radius: 12px;
        box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
        text-align: center;
        width: 100%;
        max-width: 350px;
    }

    h2 {
        margin-bottom: 15px;
        color: #003c8f;
        font-size: 22px;
        font-weight: 600;
    }

    /* Input */
    input[type="email"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0 20px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: 0.3s;
    }

    input[type="email"]:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 4px rgba(74, 144, 226, 0.3);
    }

    /* Button */
    button {
        width: 100%;
        padding: 12px;
        background: #4a90e2;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #003c8f;
    }

    /* Message Styling */
    .message {
        font-size: 14px;
        margin-bottom: 15px;
        padding: 8px;
        border-radius: 6px;
    }

    .message.error {
        background: #ffe0e0;
        color: #d9534f;
    }

    .message.success {
        background: #e0ffe5;
        color: #28a745;
    }
    </style>
</head>

<body>
    <h2>Forgot Password</h2>
    <?php if (!empty($message))
        echo $message; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your registered email" required>
        <button type="submit">Send OTP</button>
    </form>
</body>

</html>