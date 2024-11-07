<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <form action="/forgot-password" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
