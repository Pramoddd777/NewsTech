<?php
session_start();
include "db.php";

if (!isset($_SESSION["admin_name"])) {
    header("Location: admin_login.php");
    exit();
}

$sql = "SELECT * FROM news ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NewsTech - Manage News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .btn {
            background: white;
            color: black;
            border: 1px solid #dee2e6;
        }

        .btn:hover {
            background: #f2f2f2;
            color: black;
        }
    </style>
</head>

<body>
<div class="container mt-5">

    <h1>Manage News</h1>
    <p>View and manage your news articles here.</p>

    <div class="mb-3">
        <a href="add_news.php" class="btn rounded me-2">Add News</a>
        <a href="admin.php" class="btn rounded">Dashboard</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($result && mysqli_num_rows($result) > 0) { ?>

            <?php while ($news = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $news["id"]; ?></td>
                    <td><?php echo htmlspecialchars($news["title"]); ?></td>
                    <td><?php echo htmlspecialchars($news["category"]); ?></td>
                    <td><?php echo htmlspecialchars($news["status"]); ?></td>
                    <td><?php echo htmlspecialchars($news["created_at"]); ?></td>

                    <td>
                        <a href="edit_news.php?id=<?php echo $news["id"]; ?>"
                           class="btn btn-sm rounded me-1">Edit</a>

                        <a href="article.php?id=<?php echo $news["id"]; ?>"
                           class="btn btn-sm rounded me-1">View</a>

                        <form action="delete_news.php" method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('Are you sure you want to delete this news article?');">

                            <input type="hidden" name="id"
                                   value="<?php echo $news["id"]; ?>">

                            <button type="submit" class="btn btn-sm rounded">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>

        <?php } else { ?>
            <tr>
                <td colspan="6" class="text-center">No news articles found.</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>
</body>
</html>
