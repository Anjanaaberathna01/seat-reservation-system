<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap');


    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 100%;
        margin: 30px auto 20px;
        padding: 0 20px;
    }

    .dashboard-header h1 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }

    /* Log Out Button */
    .logout-btn {
        display: inline-block;
        padding: 8px 16px;
        background: #f44336;
        /* Red color */
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 500;
        transition: background 0.3s;
    }

    .logout-btn:hover {
        background: #d32f2f;
    }

    /* Dashboard content */
    .dashboard-content {
        max-width: 1000px;
        margin: 20px auto;
        padding: 20px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* 3 columns */
        gap: 20px;
    }

    .dashboard-item {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 25px 20px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .dashboard-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .item-icon {
        font-size: 50px;
        margin-bottom: 15px;
    }

    .item-icon.seat-icon {
        color: #4CAF50;
    }

    .item-icon.profile-icon {
        color: #0542c5;
    }

    .item-icon.stats-icon {
        color: #f39c12;
    }

    .dashboard-item h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #333;
    }

    .dashboard-item p {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }

    .item-btn {
        display: inline-block;
        padding: 10px 18px;
        background: #0542c5;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 500;
        transition: background 0.3s;
    }

    .item-btn:hover {
        background: #0431a0;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .dashboard-content {
            grid-template-columns: 1fr 1fr;
            /* 2 columns */
        }
    }

    @media (max-width: 600px) {
        .dashboard-content {
            grid-template-columns: 1fr;
            /* 1 column */
        }
    }



    @media (max-width: 600px) {

        .dashboard-header,
        .dashboard-content {
            margin: 15px;
            padding: 15px;
        }

        .dashboard-header h1 {
            font-size: 20px;
        }
    }
    </style>
</head>

<body>
    <?php include("header.php"); ?>

    <div class="dashboard-header">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <a href="logout.php" class="logout-btn">Log Out</a>
    </div>

    <div class="dashboard-content">
        <!-- Seat Reservation Column -->
        <div class="dashboard-item">
            <div class="item-icon seat-icon">🎟️</div>
            <h3>Seat Reservation</h3>
            <p>Reserve your seats easily for events or shows.</p>
            <a href="seat-reservation.php" class="item-btn">Reserve Now</a>
        </div>

        <!-- Profile Column -->
        <div class="dashboard-item">
            <div class="item-icon profile-icon">👤</div>
            <h3>Profile</h3>
            <p>View and update your personal information.</p>
            <a href="profile.php" class="item-btn">View Profile</a>
        </div>

        <!-- Optional Third Column -->
        <div class="dashboard-item">
            <div class="item-icon stats-icon">📊</div>
            <h3>Stats</h3>
            <p>Check your reservation history and statistics.</p>
            <a href="stats.php" class="item-btn">View Stats</a>
        </div>
    </div>


</body>

</html>