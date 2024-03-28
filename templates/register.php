<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <form class="form-control" action="register_process.php" method="post">
        <p class="title">Register</p>
        <div class="input-field">
            <input class="input" type="text" id="username" name="username" required />
            <label class="label" for="input">Username</label>
        </div>
        <div class="input-field">
            <input class="input" type="password" id="password" name="password" required />
            <label class="label" for="input">Password</label>
        </div>
        <div class="input-field">
            <input class="input" type="password" id="confirm_password" name="confirm_password" required />
            <label class="label" for="input">Confirm Password</label>
        </div>
        <div class="input-field">
            <select id="role" name="role">
                <option value="user" class="option">User</option>
                <option value="admin" class="option">Admin</option>
            </select>
        </div>
        <p>Already have an account? &nbsp;<a class="registerlink" href="login.php">Log in here</a></p>
        <button class="submit-btn" type="submit">Register</button>
    </form>
</body>

</html>