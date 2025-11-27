<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="css/signup_form.css">
<body>
    <div id="component">
        <h2 class="signup-title">Sign Up</h2>

        <form action="signup_process.php" method="POST" id="form">
            <input type="text" id="text" name="email" placeholder="email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit" id="button">Sign Up</button>
        </form>

    </div>


    <script src="js/signup_form.js"></script>
</body>


</html>