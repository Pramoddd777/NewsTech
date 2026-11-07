<?php
session_start();

if (!isset($_SESSION["admin_name"])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>NewsTech - Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        .btn {
            background-color: white;
            color: black;
            border: 1px solid #dee2e6;
        }

        .btn:hover {
            background-color: #f2f2f2;
            color: black;
            border-color: #dee2e6;
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <h1>Admin Dashboard</h1>

    <p>
        Welcome,
        <?php echo htmlspecialchars($_SESSION["admin_name"]); ?>!
    </p>

    <p>Manage your NewsTech articles from here.</p>

    <div class="mt-4">

        <a href="add_news.php" class="btn rounded me-2">
            Add News
        </a>

        <a href="manage_news.php" class="btn rounded me-2">
            Manage News
        </a>

        <a href="index.php" class="btn rounded">
            View Website
        </a>

    </div>

</div>

</body>
</html>