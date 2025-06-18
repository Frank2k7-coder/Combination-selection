<?php
session_start();
if (!isset($_SESSION['user_id'])) die("Access denied.");

try {
  $conn = new PDO(
    "pgsql:host=ep-bold-base-a41i2nk1-pooler.us-east-1.aws.neon.tech;dbname=neondb",
    "neondb_owner","npg_vq93TlHhNKko",
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
  );
} catch (PDOException $e) {
  die("DB error: ".$e->getMessage());
}

$userId = (int)$_SESSION['user_id'];
$table  = "\"marks_user_{$userId}\"";

// 1) create table if missing
$conn->exec("
  CREATE TABLE IF NOT EXISTS $table (
    id SERIAL PRIMARY KEY,
    subject VARCHAR(100),
    marks INT CHECK (marks BETWEEN 0 AND 100)
  )
");

// 2) save marks
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $subs = $_POST['subjects'] ?? [];
  $mrs = $_POST['marks']    ?? [];
  if (count($subs)!==count($mrs)) die("Data mismatch.");

  $ins = $conn->prepare("INSERT INTO $table (subject,marks) VALUES (:s,:m)");
  foreach ($subs as $i => $sub) {
    $m = (int)$mrs[$i];
    if ($m<0||$m>100) die("Invalid mark for $sub");
    $ins->execute([':s'=>trim($sub),':m'=>$m]);
  }
  header("Location: student-dash.php");
  exit;
}

echo "Invalid request.";
?>
