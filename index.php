<!-- index.php -->
<?php
session_start();
include 'db_connect.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE student_id = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $student_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        // Redirect based on role (as in script.js)
        if ($user['role'] == 'student') {
            header("Location: bookings1.html");
        } else {
            header("Location: bookings2.html");
        }
        exit();
    } else {
        $error = "Invalid Student ID or Password";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div>
            <img src="logo_icon.png" alt="Logo" class="logo-icon">
        </div>
        <nav>
            <ul>
                <li><a href="#" id="home-link">Home</a></li>
                <li><a href="#" id="bookings-link">My Bookings</a></li>
                <li><a href="#" id="admin-link">Admin</a></li>
            </ul>
        </nav>
        <a href="profile.html"><img src="profile_icon.png" alt="Profile" class="profile-icon"></a>
    </header>
    <div class="login-signup">
        <div class="login-panel">
            <img src="student_login.png" alt="Student Image">
            <div class="placeholders"></div>
        </div>
        <div class="signup-panel">
            <h2>Login</h2>
            <?php if ($error): ?>
                <p style="color: red; margin-left: 180px;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="student_id">Student ID</label>
                <input type="text" id="student_id" name="student_id" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="signup-login.html">Sign up</a></p>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>