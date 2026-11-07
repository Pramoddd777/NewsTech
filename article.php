<?php
include "db.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    exit("Invalid news ID.");
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM news WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$news = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$news) {
    exit("Article not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>NewsTech - Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>
<div class="container mt-5">

    <a href="index.php" class="btn btn-outline-dark mb-4">
        Back to Home
    </a>

    <h1><?php echo htmlspecialchars($news["title"]); ?></h1>

    <p class="text-muted">
        <?php echo htmlspecialchars($news["category"]); ?>
        | <?php echo htmlspecialchars($news["created_at"]); ?>
    </p>

    <p class="lead">
        <?php echo htmlspecialchars($news["description"]); ?>
    </p>

    <hr>

    <p><?php echo nl2br(htmlspecialchars($news["content"])); ?></p>

</div>
</body>
</html>
