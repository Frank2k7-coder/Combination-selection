<?php
// Connect to PostgreSQL
$conn = pg_connect("host=ep-bold-base-a41i2nk1-pooler.us-east-1.aws.neon.tech dbname=neondb user=neondb_owner password=npg_vq93TlHhNKko");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Check if username is provided
if (isset($_GET['username'])) {
    $username = trim($_GET['username']);

    // Securely delete user with placeholder
    $query = "DELETE FROM users WHERE username = $1";
    $result = pg_query_params($conn, $query, array($username));

    if ($result) {
        // Redirect after successful deletion
        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "Error deleting user: " . pg_last_error($conn);
    }
} else {
    echo "No username provided.";
}
?>
