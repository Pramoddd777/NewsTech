<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>NewsTech</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<!-- Navigation Bar -->

<nav class="navbar navbar-light py-3">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            NewsTech
        </a>

        <div>

            <a href="index.php" class="text-dark text-decoration-none me-3">
                Home
            </a>

            <?php if (isset($_SESSION["admin_name"])) { ?>

                <a href="admin.php" class="text-dark text-decoration-none me-3">
                    Admin Dashboard
                </a>

                <a href="logout.php" class="text-dark text-decoration-none">
                    Logout
                </a>

            <?php } elseif (isset($_SESSION["user_name"])) { ?>

                <a href="admin_login.php" class="text-dark text-decoration-none me-3">
                    Admin Login
                </a>

                <a href="logout.php" class="text-dark text-decoration-none">
                    Logout
                </a>

            <?php } else { ?>

                <a href="login.php" class="text-dark text-decoration-none me-3">
                    Login
                </a>

                <a href="signup.php" class="text-dark text-decoration-none me-3">
                    Sign Up
                </a>

                <a href="admin_login.php" class="text-dark text-decoration-none">
                    Admin Login
                </a>

            <?php } ?>

        </div>

    </div>

</nav>

<!-- Main Content -->

<div class="container mt-5">

    <?php
    if (isset($_SESSION["user_name"])) {
        echo "<p class='text-center'>Welcome, "
             . htmlspecialchars($_SESSION["user_name"])
             . "</p>";
    } elseif (isset($_SESSION["admin_name"])) {
        echo "<p class='text-center'>Welcome, "
             . htmlspecialchars($_SESSION["admin_name"])
             . "</p>";
    }
    ?>

    <h1 class="text-center fw-bold">
        Latest News
    </h1>

    <p class="text-center text-secondary">
        Read the latest technology news and updates.
    </p>

    <div class="row justify-content-center mt-4">

        <!-- Laptop News -->

        <div class="col-md-5 mb-4">

            <div class="card shadow-sm h-100">

                <img src="images/Minimalist Laptop Workspace.png"
                     class="card-img-top"
                     style="height: 250px; object-fit: cover;"
                     alt="Technology News">

                <div class="card-body">

                    <h5 class="card-title">
                        Latest Technology News
                    </h5>

                    <p class="card-text">
                        New laptops are becoming faster and more powerful.
                        Modern technology provides better performance and
                        battery life. These improvements are useful for
                        students and professionals.
                    </p>

                </div>

            </div>

        </div>

        <!-- iPhone News -->

        <div class="col-md-5 mb-4">

            <div class="card shadow-sm h-100">

                <img src="images/iPhone Technology News.png"
                     class="card-img-top"
                     style="height: 250px; object-fit: cover;"
                     alt="iPhone News">

                <div class="card-body">

                    <h5 class="card-title">
                        Latest iPhone News
                    </h5>

                    <p class="card-text">
                        New iPhones are bringing improved performance
                        and features. Modern iPhones offer better cameras
                        and battery life. These improvements provide a
                        better experience for users.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Footer -->

<footer class="bg-light text-center py-3 mt-4">

    <p class="mb-0">
        NewsTech
    </p>

</footer>

</body>

</html>
```