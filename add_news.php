<?php

session_start();
include "db.php";

if (!isset($_SESSION["admin_name"])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $content = trim($_POST["content"]);
    $category = trim($_POST["category"]);
    $image = "";

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] != UPLOAD_ERR_NO_FILE) {

        if ($_FILES["image"]["error"] != UPLOAD_ERR_OK) {
            $message = "Image upload failed.";

        } elseif ($_FILES["image"]["size"] > 5 * 1024 * 1024) {
            $message = "Image size must be less than 5 MB.";

        } else {

            $imageInfo = getimagesize($_FILES["image"]["tmp_name"]);

            if ($imageInfo === false) {
                $message = "Please select a valid image.";

            } else {

                $allowedTypes = [
                    "image/jpeg" => "jpg",
                    "image/png" => "png",
                    "image/webp" => "webp"
                ];

                $imageType = $imageInfo["mime"];

                if (!isset($allowedTypes[$imageType])) {
                    $message = "Only JPG, PNG and WEBP images are allowed.";

                } else {

                    $imageName = uniqid("news_", true) . "." . $allowedTypes[$imageType];
                    $uploadPath = "uploads/" . $imageName;

                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath)) {
                        $image = $imageName;
                    } else {
                        $message = "Unable to upload the image.";
                    }
                }
            }
        }
    }

    if ($message == "") {

        $sql = "INSERT INTO news
                (title, description, content, category, image, status)
                VALUES (?, ?, ?, ?, ?, 'draft')";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $title,
            $description,
            $content,
            $category,
            $image
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "News article saved successfully!";
        } else {
            $message = "Unable to save the article.";

            if ($image != "" && file_exists("uploads/" . $image)) {
                unlink("uploads/" . $image);
            }
        }

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>NewsTech - Add News</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

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

    <h1>Add News Article</h1>

    <p>Enter the details of your news article.</p>

    <?php if ($message != "") { ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php } ?>

    <form action="add_news.php" method="POST" enctype="multipart/form-data">

        <label>News Title</label>

        <input type="text"
               name="title"
               class="form-control mb-3"
               placeholder="Enter news title"
               required>

        <label>Short Description</label>

        <textarea name="description"
                  class="form-control mb-3"
                  placeholder="Enter a short description"
                  rows="3"
                  required></textarea>

        <label>Category</label>

        <select name="category" class="form-select mb-3" required>

            <option value="">Select Category</option>
            <option value="Technology">Technology</option>
            <option value="Business">Business</option>
            <option value="Sports">Sports</option>
            <option value="Entertainment">Entertainment</option>
            <option value="Science">Science</option>

        </select>

        <label>News Image</label>

        <input type="file"
               name="image"
               class="form-control mb-3"
               accept=".jpg,.jpeg,.png,.webp">

        <p class="text-secondary">
            Optional. Allowed formats: JPG, PNG and WEBP. Maximum size: 5 MB.
        </p>

        <label>Full Article</label>

        <textarea name="content"
                  class="form-control mb-3"
                  placeholder="Write the full article here"
                  rows="8"
                  required></textarea>

        <button type="submit" class="btn rounded me-2">
            Save as Draft
        </button>

        <a href="admin.php" class="btn rounded">
            Back to Dashboard
        </a>

    </form>

</div>

</body>
</html>