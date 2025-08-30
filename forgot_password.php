<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If you used Composer
require 'vendor/autoload.php';

// If manual, uncomment below
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST['email']);

    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['reset_email'] = $email;
    $_SESSION['otp'] = $otp;

    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'anjanaaberathna000@gmail.com'; // your Gmail
        $mail->Password = 'your-app-password';   // app password, NOT Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('anjanaaberathna000@gmail.com', 'Seat Reservation System');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Password Reset OTP";
        $mail->Body = "Hello,<br>Your OTP is <b>$otp</b>.<br>This OTP will expire in 10 minutes.";

        $mail->send();
        $message = "<p class='message success'>✅ OTP sent to your email!</p>";
    } catch (Exception $e) {
        $message = "<p class='message error'>❌ OTP sending failed. Error: {$mail->ErrorInfo}</p>";
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
            background: #f5f7fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        form {
            background: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            width: 100%;
            max-width: 380px;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            margin-bottom: 15px;
            color: #003c8f;
            font-size: 22px;
            font-weight: 600;
            text-align: center;
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
            transform: scale(1.03);
        }

        /* Messages */
        .message {
            font-size: 14px;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 8px;
            text-align: left;
            animation: slideIn 0.4s ease;
        }

        .message.error {
            background: #ffe0e0;
            color: #b71c1c;
            border-left: 5px solid #d32f2f;
        }

        .message.success {
            background: #e0ffe5;
            color: #1b5e20;
            border-left: 5px solid #2e7d32;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <?php include("header.php"); ?>

    <div class="content">
        <div>
            <h2>Forgot Password</h2>
            <?php if (!empty($message))
                echo $message; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Enter your registered email" required>
                <button type="submit">Send OTP</button>
            </form>
        </div>
    </div>
</body>

</html>