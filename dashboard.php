<?php
session_start();
include("includes/connect.php");
$conn = (new database())->connect();

$user_id = $_SESSION['user_id'];
$query = "SELECT email FROM users WHERE id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['user_email'] = $row['email']; // store it for later
}

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background: #f9f9f9;
        margin: 0;
        padding: 0;
    }

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

    /* Email Badge (draggable) */
    .email-badge {
        background: #0542c5;
        color: white;
        padding: 10px 18px;
        border-radius: 30px;
        font-size: 14px;
        cursor: grab;
        user-select: none;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .email-badge:active {
        cursor: grabbing;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    /* Dashboard content */
    .dashboard-content {
        max-width: 1000px;
        margin: 20px auto;
        padding: 20px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
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

    .user-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropbtn {
        color: #333;
        padding: 10px 16px;
        font-size: 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
    }


    /* Dropdown Content */
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        min-width: 180px;
        border-radius: 8px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        z-index: 1;
        padding: 8px 0;
    }

    .dropdown-content a {
        color: #333;
        padding: 10px 16px;
        text-decoration: none;
        display: block;
        font-size: 14px;
        transition: background 0.3s;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    /* Show on hover */
    .user-dropdown:hover .dropdown-content {
        display: block;
    }


    /* Responsive */
    @media (max-width: 900px) {
        .dashboard-content {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 600px) {
        .dashboard-content {
            grid-template-columns: 1fr;
        }

        .dashboard-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }
    </style>
</head>

<body>
    <?php include("header.php"); ?>

    <div class="dashboard-header">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>

        <?php if (isset($_SESSION['user_email'])): ?>
        <div class="user-dropdown">
            <button class="dropbtn">
                👤 <?php echo htmlspecialchars($_SESSION['user_email']); ?>
            </button>
            <div class="dropdown-content" draggable="true">
                <a href="profile.php">👤 Profile</a>
                <a href="change_password.php">🔑 Change Password</a>
                <a href="logout.php">🚪 Log Out</a>
            </div>
        </div>
        <?php else: ?>
        <p style="color: red; font-size: 14px;">⚠️ Email not set</p>
        <?php endif; ?>



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

        <!-- Stats Column -->
        <div class="dashboard-item">
            <div class="item-icon stats-icon">📊</div>
            <h3>Stats</h3>
            <p>Check your reservation history and statistics.</p>
            <a href="stats.php" class="item-btn">View Stats</a>
        </div>
    </div>

    <script>
    // Drag functionality for the email badge
    const badge = document.querySelector('.email-badge');

    badge.addEventListener('dragstart', (e) => {
        e.dataTransfer.setData('text/plain', badge.textContent);
        badge.style.opacity = "0.6";
    });

    badge.addEventListener('dragend', () => {
        badge.style.opacity = "1";
    });
    </script>
</body>

</html>