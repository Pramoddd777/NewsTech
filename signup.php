
<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check whether passwords match
    if ($password != $confirm_password) {

        echo "Passwords do not match.";

    } else {

        // Hash the password before saving it
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password)
                VALUES ('$name', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {

            echo "Account created successfully!";

        } else {

            echo "Error: " . mysqli_error($conn);

        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>NewsTech - Sign Up</title>

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

    <h1 class="text-center">Sign Up</h1>

    <p class="text-center">
        Create your NewsTech account.
    </p>

    <div class="row justify-content-center mt-4">

        <div class="col-md-5">

            <form action="signup.php" method="POST">

                <label>Name</label>

                <input type="text"
                       name="name"
                       class="form-control mb-3"
                       placeholder="Enter your name"
                       required>

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
                       placeholder="Enter password"
                       required>

                <label>Confirm Password</label>

                <input type="password"
                       name="confirm_password"
                       class="form-control mb-3"
                       placeholder="Confirm password"
                       required>

                <button type="submit" class="btn border rounded">
                    Sign Up
                </button>

            </form>

            <p class="mt-3">
                Already have an account?
                <a href="login.php">Login</a>
            </p>

        </div>

    </div>

</div>

</body>

</html>
