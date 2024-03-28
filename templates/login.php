<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <form class="form-control" action="login_process.php" method="post">
        <p class="title">Login</p>
        <div class="input-field">
            <input class="input" type="text" id="username" name="username" required />
            <label class="label" for="input">Username</label>
        </div>
        <div class="input-field">
            <input class="input" type="password" id="password" name="password" required />
            <label class="label" for="input">Password</label>
        </div>
        <p>Don't have an account? &nbsp;<a class="registerlink" href="register.php">Register here</a></p>
        <button class="submit-btn" type="submit">Sign In</button>
    </form>
</body>

</html>