<?php
session_start();

$conn = pg_connect("host=ep-bold-base-a41i2nk1-pooler.us-east-1.aws.neon.tech dbname=neondb user=neondb_owner password=npg_vq93TlHhNKko");

if (!$conn) {
    die("Connection failed.");
}

$username =$_SESSION['username'] ?? 'Admin';

$combination_counts = [];
$query_combination = "SELECT combination, COUNT(*) AS total FROM users GROUP BY combination";
$result_combination = pg_query($conn, $query_combination);

if (!$result_combination) {
    die("Error in SQL query: " . pg_last_error($conn));
}


while ($row = pg_fetch_assoc($result_combination)) {
    $combination_counts[$row['combination']] = $row['total'];
}


$users = [];
$query_users = "SELECT * FROM users";
$result_users = pg_query($conn, $query_users);

if (!$result_users) {
    die("Error in SQL query: " . pg_last_error($conn));
}

while ($user = pg_fetch_assoc($result_users)) {
    $users[] = $user;
}

pg_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
   
    <style>
        body {
            display: flex;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f7fa;
        }

        .sidebar {
            width: 250px;
            background: #1f2a40;
            color: white;
            padding: 20px;
            min-height: 100vh;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 24px;
            border-bottom: 2px solid #34495e;
            padding-bottom: 10px;
        }

        .sidebar a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 12px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        .main-content {
            flex-grow: 1;
            padding: 30px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 230px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            webkit-box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }

        .card h3 {
            color: #2980b9;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #34495e;
            color: white;
            text-align: left;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .search-bar input {
            width: 100%;
            border-radius: 10px;
            height: 40px;
            border: none;
            padding: 0 10px;
            margin-bottom: 10px;
        }

        .search-bar button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 10px;
            background-color: #2980b9;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-bar button:hover {
            background-color: #1f6cab;
        }

        .frank {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .frank img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .frank h2 {
            font-size: 18px;
            color: #ecf0f1;
        }
    </style>

</head>
<body>
  
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <div class="frank">
            <img src="frank.jpg"
                alt="Profile Picture"
                />
            <h2> <?php echo htmlspecialchars($username ?? '');  ?> </h2>
        </div>
        <div class="search-bar">
        <form method="GET" action="search.php">
          <input type="text" name="query" placeholder="Search...">
          <button type="submit">Search</button>
        </form>
            </div>
        <a href="#">Dashboard</a>
        <a href="#">Users</a>
        <a href="#">Notifications</a>
        <a href="inbox.php">Inbox chat</a>
        <a href="#">New Post</a>
        <a href="setting.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main-content">
        
        <h1 style="text-align:center">WELCOME BACK <?php echo htmlspecialchars($username ?? ''); ?> TO ADMIN DASHBOARD</h1>

        <div class="cards">
            <?php foreach ($combination_counts as $combination => $count): ?>
    
                <div class="card">
                    <h3><?php echo htmlspecialchars($combination); ?></h3>
                    <p><?php echo $count; ?> students chose <?php echo htmlspecialchars($combination); ?></p>
                </div>
            <?php endforeach; ?>
            

        <h3>Action Logs</h3>
            
   
        <table>
            <tr>
                <th>Delete</th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Combination</th>
                <th>Gender</th>
                
            </tr>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
    <td>
      <a 
        class="delete-btn" 
        href="delete.php?username=<?php echo htmlspecialchars($user['username'] ?? ''); ?>" 
        onclick="return confirm('Are you sure you want to delete this user?');"
      >
        Delete
      </a>
    </td>

                        
                        <td><?php echo htmlspecialchars($user['id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['username'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['combination'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($user['gender'] ?? ''); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No users registered yet.</td></tr>
            <?php endif; 
            ?>
        </table>
    </div>
</body>
</html>
