<?php

session_start();

include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE LOWER(email) = LOWER(?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_name"] = $user["name"];

            header("Location: index.php");
            exit();

        } else {

            $error = "Incorrect password.";

        }

    } else {

        $error = "User not found.";

    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>NewsTech - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
            outline: none;
        }
    </style>

</head>

<body>

<div class="container mt-5">

    <h1 class="text-center">Login</h1>

    <p class="text-center">
        Login to your NewsTech account.
    </p>

    <div class="row justify-content-center mt-4">

        <div class="col-md-5">

            <form action="login.php" method="POST">

                <label>Email</label>

                <input type="email"
                       name="email"
                       class="form-control mb-3"
                       placeholder="Enter your email"
                       required>

                <label>Password</label>

                <input type="password"
                       name="password"
                       class="form-control mb-3"
                       placeholder="Enter your password"
                       required>

                <button type="submit" class="btn border rounded">
                    Login
                </button>

            </form>

            <?php if ($error != "") { ?>

                <p class="text-center fw-bold mt-3">
                    <?php echo htmlspecialchars($error); ?>
                </p>

            <?php } ?>

            <p class="mt-3 text-center">
                Don't have an account?
                <a href="signup.php">Sign Up</a>
            </p>

            <p class="text-center mt-3">
                Are you an admin?
                <a href="admin_login.php">Admin Login</a>
            </p>

        </div>

    </div>

</div>

</body>

</html>
```