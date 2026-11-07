<?php
session_start();
include "db.php";

if (!isset($_SESSION["admin_name"])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    exit("Invalid news ID.");
}

$id = (int) $_GET["id"];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $content = trim($_POST["content"]);
    $category = trim($_POST["category"]);
    $status = in_array($_POST["status"], ["draft", "published"])
        ? $_POST["status"] : "draft";

    $sql = "UPDATE news SET title=?, description=?, content=?,
            category=?, status=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi",
        $title, $description, $content, $category, $status, $id);

    if (mysqli_stmt_execute($stmt)) {
        $message = "News article updated successfully.";
    } else {
        $message = "Unable to update the article.";
    }

    mysqli_stmt_close($stmt);
}

$stmt = mysqli_prepare($conn, "SELECT * FROM news WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$news = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$news) {
    exit("News article not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>NewsTech - Edit News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
        .btn { background: white; color: black; border: 1px solid #dee2e6; }
        .btn:hover { background: #f2f2f2; color: black; }
    </style>
</head>

<body>
<div class="container mt-5">
    <h1>Edit News Article</h1>

    <?php if ($message != "") echo "<p>" . htmlspecialchars($message) . "</p>"; ?>

    <form method="POST" action="edit_news.php?id=<?php echo $id; ?>">
        <label>News Title</label>
        <input type="text" name="title" class="form-control mb-3"
               value="<?php echo htmlspecialchars($news["title"]); ?>" required>

        <label>Short Description</label>
        <textarea name="description" class="form-control mb-3" rows="3" required><?php
            echo htmlspecialchars($news["description"]);
        ?></textarea>

        <label>Category</label>
        <select name="category" class="form-select mb-3" required>
            <?php
            foreach (["Technology", "Business", "Sports", "Entertainment", "Science"] as $cat) {
                $selected = ($news["category"] == $cat) ? "selected" : "";
                echo "<option value='$cat' $selected>$cat</option>";
            }
            ?>
        </select>

        <label>Full Article</label>
        <textarea name="content" class="form-control mb-3" rows="8" required><?php
            echo htmlspecialchars($news["content"]);
        ?></textarea>

        <label>Status</label>
        <select name="status" class="form-select mb-4">
            <option value="draft" <?php if ($news["status"] == "draft") echo "selected"; ?>>Draft</option>
            <option value="published" <?php if ($news["status"] == "published") echo "selected"; ?>>Published</option>
        </select>

        <button type="submit" class="btn rounded me-2">Update News</button>
        <a href="manage_news.php" class="btn rounded">Back to Manage News</a>
    </form>
</div>
</body>
</html>
