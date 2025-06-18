<?php

session_start();

include 'database.php'; // Connects to PostgreSQL using PDO

if (!isset ($_SESSION['username'])){
  header("Location: login.php");
  exit();
}

try {
  $userQuery = $conn->query("SELECT username FROM users");
  $adminQuery = $conn->query("SELECT username FROM adminusers");
} catch (PDOException $e) {
  die("DB error: " . $e->getMessage());
}

$currentUsername = $_SESSION['username'];

try {
  $userQuery = $conn->prepare("SELECT username FROM users WHERE username != :username");
  $userQuery->execute(['username' => $currentUsername]);

  $adminQuery = $conn->prepare("SELECT username FROM adminusers WHERE username != :username");
  $adminQuery->execute(['username' => $currentUsername]);
} catch (PDOException $e) {
  die("DB error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Inbox</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />
  <style>
   

    body {
      border-radius: 15px;
      background: #f4f7fc;
      color: #2c3e50;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .icons-container {
      display: flex;
      justify-content: center;
      gap: 40px;
      background-color: #2c3e50;
      padding: 15px 0;
      color: white;
      box-shadow: 0 3px 8px rgb(0 0 0 / 0.1);
    }

    .icons-container i {
      display: flex;
      flex-direction: column;
      align-items: center;
      font-size: 22px;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .icons-container i h2 {
      font-weight: 400;
      font-size: 12px;
      margin-top: 6px;
      user-select: none;
    }

    .icons-container i:hover {
      color: #3498db;
    }

    .container {
      display: flex;
      flex: 1;
      height: calc(100vh - 70px);
      overflow: hidden;
    }

    .sidebar {
      width: 280px;
      background-color: #5b5ea4;
      color: white;
      padding: 25px 20px;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 10px rgb(0 0 0 / 0.1);
    }

    .profile {
      margin-bottom: 25px;
    }

    .profile h2 {
      font-weight: 600;
      margin-bottom: 12px;
      font-size: 22px;
      border-bottom: 2px solid #3498db;
      padding-bottom: 8px;
    }

    .profile input[type="text"] {
      width: 100%;
      padding: 10px 15px;
      border-radius: 30px;
      border: none;
      outline: none;
      font-size: 15px;
      transition: box-shadow 0.3s ease;
    }

    .profile input[type="text"]:focus {
      box-shadow: 0 0 8px 2px #3498db;
    }

    .notifications p {
      font-weight: 600;
      margin-bottom: 15px;
      font-size: 18px;
      border-bottom: 1px solid #4b6587;
      padding-bottom: 8px;
    }

    .notifications ul {
      list-style: none;
      max-height: 400px;
      overflow-y: auto;
      padding-right: 5px;
    }

    .notifications li {
      margin-bottom: 10px;
      font-size: 16px;
      line-height: 1.3;
    }

    .notifications li strong {
      color: #74b9ff;
      font-weight: 700;
    }

    .chat-link {
      cursor: pointer;
      color: #dfe6e9;
      padding: 6px 12px;
      border-radius: 20px;
      display: inline-block;
      transition: background-color 0.25s ease, color 0.25s ease;
      user-select: none;
    }

    .chat-link:hover {
      background-color: #0984e3;
      color: white;
    }

    .main-content {
      flex: 1;
      padding: 25px 35px;
      background: white;
      border-radius: 15px 0 0 15px;
      box-shadow: -3px 0 15px rgb(0 0 0 / 0.05);
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }

    .message-box {
      flex-grow: 1;
      border: 2px solid #dfe6e9;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 4px 12px rgb(52 73 94 / 0.1);
      overflow-y: auto;
    }

    #chat-area h3 {
      margin-bottom: 15px;
      font-weight: 700;
      font-size: 24px;
      color: #2d3436;
      border-bottom: 2px solid #3498db;
      padding-bottom: 10px;
    }

    #chat-area p {
      font-size: 16px;
      color: #636e72;
      user-select: none;
    }

    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        height: auto;
      }

      .sidebar {
        width: 100%;
        border-radius: 0 0 15px 15px;
        padding-bottom: 40px;
      }

      .main-content {
        border-radius: 0;
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="icons-container">
    <i class="fa-solid fa-house-laptop"><h2>Home</h2></i>
    <i class="fa-solid fa-magnifying-glass-location"><h2>Explore</h2></i>
    <i class="fa-solid fa-truck-medical"><h2>Support</h2></i>
    <i class="fa-solid fa-message"><h2>Message</h2></i>
    <i class="fa-solid fa-bell"><h2>Notifications</h2></i>
    <i class="fa-solid fa-bars"><h2>More</h2></i>
  </div>

  <div class="container">
    <div class="sidebar">
      <div class="profile">
        <h2><?php echo "Welcome, " . htmlspecialchars($_SESSION['username']); ?></h2>
        <input type="text" placeholder="Search users..." />
      </div>
      <div class="notifications">
        <p>Messages</p>
        <ul>
          <li><strong>Users:</strong></li>
          <?php while ($user = $userQuery->fetch(PDO::FETCH_ASSOC)): ?>
            <li><span class="chat-link" data-username="<?= htmlspecialchars($user['username']) ?>">
              <?= htmlspecialchars($user['username']) ?>
            </span></li>
          <?php endwhile; ?>

          <li><strong>Admins:</strong></li>
          <?php while ($admin = $adminQuery->fetch(PDO::FETCH_ASSOC)): ?>
            <li><span class="chat-link" data-username="<?= htmlspecialchars($admin['username']) ?>">
              <?= htmlspecialchars($admin['username']) ?>
            </span></li>
          <?php endwhile; ?>
        </ul>
      </div>
    </div>

    <div class="main-content">
      <div class="message-box">
        <div id="chat-area">
          <h3>Your messages</h3>
          <p>Click a user to start chatting.</p>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.querySelectorAll('.chat-link').forEach(link => {
      link.addEventListener('click', function () {
        const username = this.dataset.username;
        fetch('load_chat.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: 'to=' + encodeURIComponent(username)
        })
        .then(res => res.text())
        .then(html => {
          document.getElementById('chat-area').innerHTML = html;
        });
      });
    });
  </script>
</body>
</html>
