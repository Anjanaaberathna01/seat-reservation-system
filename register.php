<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Form</title>

    <?php
    include("includes/connect.php");

    $db = new database();// create object of your database class
    $conn = $db->connect();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Secure password hashing
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert into DB
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql) or die(mysqli_error($conn));
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        if ($stmt->execute()) {
            echo "<div id='successAlert' 
                 style='position:fixed;top:20px;left:50%;transform:translateX(-50%);
                        background:#4CAF50;color:#fff;padding:10px 20px;
                        border-radius:5px;font-family:Arial,sans-serif;
                        box-shadow:0 4px 8px rgba(0,0,0,0.2);'>
                Registration successful! Please login.
              </div>
              <script>
                setTimeout(function(){
                    window.location.href = 'index.php';
                }, 500); // 0.3 seconds
              </script>";
            exit;
        } else {
            echo "<script>
                alert('Error: " . addslashes($stmt->error) . "');
                window.history.back();
              </script>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-box {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 320px;
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-box label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        .register-box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .register-box button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            align-items: center;
        }

        .register-box button:hover {
            background: #45a049;
        }

        .error {
            color: red;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="register-box">
        <h2>Register</h2>
        <form id="registerForm" action="register.php" method="POST">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <p id="errorMsg" class="error"></p>

            <button type="submit">Register</button>
        </form>
    </div>

    <script>
        document.getElementById("registerForm").addEventListener("submit", function (event) {
            const password = document.getElementById("password").value;
            const errorMsg = document.getElementById("errorMsg");

            // Regex: minimum 8 characters & at least one special character
            const regex = /^(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;

            if (!regex.test(password)) {
                event.preventDefault();
                errorMsg.textContent =
                    "Password must be at least 8 characters and include at least one special character.";
            } else {
                errorMsg.textContent = "";
            }
        });
    </script>
</body>

</html>