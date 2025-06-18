<?php
try {
    $conn = new PDO(
        "pgsql:host=ep-bold-base-a41i2nk1-pooler.us-east-1.aws.neon.tech;dbname=neondb",
        "neondb_owner",
        "npg_vq93TlHhNKko"
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uname = htmlspecialchars(trim($_POST['username'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $pass = $_POST['password'] ?? '';
    $comb = $_POST['combination'] ?? null;
    $progress = $_POST['progress'] ?? null;
    $choose = strtolower(trim($_POST['choose'] ?? ''));
    $gender = $_POST['gender'] ?? '';

    // Upload photo
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            $photo = $targetPath;
        }
    }

    if ($choose === 'student') {
        $sql = "INSERT INTO users (username, email, password, combination, progress, choose, gender, photo) 
                VALUES (:username, :email, :password, :combination, :progress, :choose, :gender, :photo)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $uname,
            ':email' => $email,
            ':password' => $pass,
            ':combination' => $comb,
            ':progress' => $progress,
            ':choose' => $choose,
            ':gender' => $gender,
            ':photo' => $photo
        ]);

        $userId = $conn->query("SELECT currval(pg_get_serial_sequence('users','id'))")->fetchColumn();
        $tableName = "marks_user_" . $userId;

        $conn->exec("CREATE TABLE IF NOT EXISTS $tableName (
            id SERIAL PRIMARY KEY,
            subject VARCHAR(100),
            marks INT DEFAULT 0
        )");

        $subjects = match (strtoupper($comb)) {
            'MPC' => ['Mathematics', 'Physics', 'Computer Science'],
            'MCE' => ['Mathematics', 'Economics', 'Computer Science'],
            'MEG' => ['Mathematics', 'Economics', 'Geography'],
            'PCB' => ['Physics', 'Chemistry', 'Biology'],
            default => ['General Paper', 'English', 'Kinyarwanda']
        };

        $insertMarks = $conn->prepare("INSERT INTO $tableName (subject, marks) VALUES (:subject, 0)");
        foreach ($subjects as $subject) {
            $insertMarks->execute([':subject' => $subject]);
        }

        header("Location: student-dash.php");
        exit();
    } elseif ($choose === 'admin') {
        $verificationCode = bin2hex(random_bytes(16));
        $sql = "INSERT INTO adminusers (username, email, password, gender, choose, status, verification_code, photo)
                VALUES (:username, :email, :password, :gender, :choose, 'active', :code, :photo)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $uname,
            ':email' => $email,
            ':password' => $pass,
            ':gender' => $gender,
            ':choose' => $choose,
            ':code' => $verificationCode,
            ':photo' => $photo
        ]);

        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "Invalid user role selected.";
    }
}
?>
