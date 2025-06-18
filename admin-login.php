<?php
session_start();
$conn = pg_connect("host=ep-bold-base-a41i2nk1-pooler.us-east-1.aws.neon.tech dbname=neondb user=neondb_owner password=npg_vq93TlHhNKko");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $choose   = $_POST['choose'];  // 'admin' or 'student'

    // Choose the correct table
    if ($choose === 'admin') {
        $query = "SELECT * FROM adminusers WHERE username = $1 AND password = $2";
    } else {
        $query = "SELECT * FROM users WHERE username = $1 AND password = $2";
    }

    $result = pg_query_params($conn, $query, [$username, $password]);

    if (pg_num_rows($result) === 1) {
        $row = pg_fetch_assoc($result);

        // Set session values
        $_SESSION['user_id']     = $row['id'];
        $_SESSION['username']    = $row['username'];
        $_SESSION['email']       = $row['email'];
        $_SESSION['choose']      = $row['choose'];       // 'admin' or 'student'

        // Only students have a combination field
        if ($choose === 'student') {
            $_SESSION['combination'] = $row['combination'];
        }
        $_SESSION['loggedin'] = true;
     
        // Redirect
        if ($choose === 'admin') {
            header("Location: admin-dashboard.php");
        } else {
            header("Location: student-dash.php");
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FRANK BACKEND</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <form method="post" action="#">
            <input type="text"    name="username" placeholder="Enter Username" required>
            <br>
            <input type="password" name="password" placeholder="Enter Password" required>
            <br>
            <label for="choose">Are you:</label>
            <br>
            <select id="choose" name="choose">
                <option value="admin">Admin</option>
                <option value="student">Student</option>
            </select>
            <br><br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
