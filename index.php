<?php
// index.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Seat Reservation System - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* General Row Styling */
        .row {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            text-align: center;
        }

        /* First Row (Header) */
        .row:first-child {
            background: #4CAF50;
            color: #fff;
            justify-content: space-between;
            flex-direction: row;
            padding: 20px 40px;
        }

        .row:first-child h1 {
            font-size: 28px;
            font-weight: 700;
        }

        /* Second Row (Content) */
        .row:nth-child(2) {
            background: #2196F3;
            color: #fff;
            justify-content: flex-end;
            padding-left: 80px;
            text-align: right;
        }

        .row.row:nth-child(2) .content {
            max-width: 400px;
            /* keep content compact */
        }

        .row:nth-child(2) h2 {
            font-size: 26px;
            margin-bottom: 15px;
        }

        .row:nth-child(2) p {
            max-width: 600px;
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Third Row (Footer) */
        .row:nth-child(3) {
            background: #FF9800;
            color: #fff;
            font-size: 14px;
        }

        /* Buttons */

        .btn-login {
            background: #fff;
            color: #4CAF50;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login:hover {
            background: #45a049;
            color: #fff;
        }

        .btn-book {
            background: #fff;
            color: #2196F3;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-book:hover {
            background: #1976D2;
            color: #fff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .row:first-child {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .row:first-child h1 {
                font-size: 22px;
            }

            .row:nth-child(2) h2 {
                font-size: 22px;
            }

            .row:nth-child(2) p {
                font-size: 16px;
            }

            .btn {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Row 1 -->
    <div class="row">
        <h1>Seat Reservation System</h1>
        <a href="login.php" class="btn-login">Log In</a>
    </div>

    <!-- Row 2 -->
    <div class="row">
        <h2>Book Your Seat Anytime, Anywhere</h2>
        <div class="content">
            <p>Our system allows you to easily reserve seats online in just a few clicks.
                Select your preferred seat and confirm instantly.</p>
            <a href="resetvations.php" class="btn-book">Book Seat</a>
        </div>
    </div>

    <!-- Row 3 -->
    <div class="row">
        <p>© <?php echo date("Y"); ?> Seat Reservation System. All Rights Reserved.</p>
    </div>
</body>

</html>