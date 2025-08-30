<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Form</title>
    <?php
    include("includes/connect.php");

    $db = new database();
    $conn = $db->connect();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql) or die(mysqli_error($conn));
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        if ($stmt->execute()) {
            echo "<div id='successAlert'>
                    Registration successful! Please login.
                  </div>
                  <script>
                    setTimeout(function(){
                        window.location.href = 'index.php';
                    }, 500);
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
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        /* Center form like login */
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 80px);
        }

        .register-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
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

        .register-box h2 {
            margin-bottom: 20px;
            color: #0542c5;
        }

        .register-box label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
            text-align: left;
            color: #333;
        }

        .register-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .register-box button {
            width: 100%;
            padding: 12px;
            background: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        .register-box button:hover {
            background: #3d8b40;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        /* Success Alert */
        #successAlert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
        }

        @media (max-width: 400px) {
            .register-box {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>

    <!-- Registration Form -->
    <div class="register-container">
        <div class="register-box">
            <h2>Register</h2>
            <form id="registerForm" action="register.php" method="POST" onsubmit="return validateForm()">
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
    </div>

    <script>
        function validateForm() {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const errorMsg = document.getElementById("errorMsg");

            if (name.length < 3) {
                errorMsg.textContent = "Full name must be at least 3 characters long.";
                return false;
            }
            if (!email.includes("@") || !email.includes(".")) {
                errorMsg.textContent = "Please enter a valid email.";
                return false;
            }
            if (password.length < 6) {
                errorMsg.textContent = "Password must be at least 6 characters.";
                return false;
            }
            errorMsg.textContent = "";
            return true;
        }
    </script>
</body>

</html>