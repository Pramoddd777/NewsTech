
<?php

session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Find the account using the email
    $sql = "SELECT * FROM users WHERE LOWER(email) = LOWER(?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        // Check the password
        if (password_verify($password, $user["password"])) {

            // Allow only admin accounts
            if ($user["role"] == "admin") {

                $_SESSION["admin_name"] = $user["name"];

                header("Location: admin.php");
                exit();

            } else {

                $error = "You are not an admin.";

            }

        } else {

            $error = "Incorrect password.";

        }

    } else {

        $error = "Admin account not found.";

    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>NewsTech - Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
    </style>

</head>

<body>

<div class="container mt-5">

    <h1 class="text-center">Admin Login</h1>

    <p class="text-center">
        Login to manage NewsTech articles.
    </p>

    <div class="row justify-content-center mt-4">

        <div class="col-md-5">

            <form action="admin_login.php" method="POST">

                <label>Email</label>

                <input type="email"
                       name="email"
                       class="form-control mb-3"
                       placeholder="Enter admin email"
                       required>

                <label>Password</label>

                <input type="password"
                       name="password"
                       class="form-control mb-3"
                       placeholder="Enter admin password"
                       required>

                <button type="submit" class="btn border rounded">
                    Login
                </button>

            </form>

            <?php
            if ($error != "") {
                echo "<p class='text-center fw-bold mt-3'>"
                     . htmlspecialchars($error)
                     . "</p>";
            }
            ?>

            <p class="text-center mt-3">
                <a href="index.php">Back to Home</a>
            </p>

        </div>

    </div>

</div>

</body>

</html>
