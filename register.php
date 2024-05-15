<?php
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $role = 'member';

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        $error = 'Failed to prepare the statement for checking existing username.';
    } else {
        $stmt->execute(['username' => $username]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $error = 'Username already exists. Please choose a different username.';
        } else {
            $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
            $stmt = $pdo->prepare($sql);

            if (!$stmt) {
                $error = 'Failed to prepare the statement for inserting new user.';
            } else {
                try {
                    $stmt->execute(['username' => $username, 'password' => $hashed_password, 'role' => $role]);
                    header('Location: login.php');
                    exit;
                } catch (PDOException $e) {
                    $error = 'Error: ' . $e->getMessage();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Register - MTC IIT</title>
</head>
<body>
<header>
        <div class="logo-container">
            <img src="images/logo.png" alt="MTC IIT Logo" class="logo">
        </div>
        <h1 class="header-title">Register</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>    
    <section class="register">
        <h2>Create a New Account</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Register</button>
        </form>
    </section>
</body>
</html>
