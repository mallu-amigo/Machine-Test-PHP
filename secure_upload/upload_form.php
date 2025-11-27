<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Files</title>
<link rel="stylesheet" href="css/upload_form.css">
</head>
<body>

<div class="container">
    <h2>Upload Files Here</h2>

    <form id="uploadForm" enctype="multipart/form-data">
        <label>Select File:</label>
        <input type="file" id="fileInput" name="file" accept=".pdf,.jpg,.png,.docx" required>
        <button type="submit">Upload</button>
    </form>
</div>

<script src="js/upload_form.js"></script>
</body>
</html>
