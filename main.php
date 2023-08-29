<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
</head>
<body>
    <h1>User Registration</h1>
    <form action="create_user.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="role">Role:</label>
        <input type="text" id="role" name="role" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>