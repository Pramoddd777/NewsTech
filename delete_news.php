<?php
session_start();
include "db.php";

if (!isset($_SESSION["admin_name"])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST" ||
    !isset($_POST["id"]) || !is_numeric($_POST["id"])) {
    header("Location: manage_news.php");
    exit();
}

$id = (int) $_POST["id"];

$stmt = mysqli_prepare($conn, "SELECT image FROM news WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$news = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if ($news) {
    $stmt = mysqli_prepare($conn, "DELETE FROM news WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $image = basename($news["image"] ?? "");
        $path = "uploads/" . $image;

        if ($image != "" && is_file($path)) {
            unlink($path);
        }
    }

    mysqli_stmt_close($stmt);
}

header("Location: manage_news.php");
exit();
?>
