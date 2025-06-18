<?php
session_start();
if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header("Location: admin-login.php");
    exit;
}
$userId   = (int)$_SESSION['user_id'];
$username = $_SESSION['username'];

$conn = pg_connect(
    "host=ep-bold-base-a41i2nk1-pooler.us-east-1.aws.neon.tech "
  . "dbname=neondb user=neondb_owner password=npg_vq93TlHhNKko"
);
if (!$conn) die("DB connection error.");

// Fetch admin emails
$admin_result = pg_query($conn, "SELECT email FROM adminusers");

// Fetch this user’s marks
$table = "\"marks_user_{$userId}\"";
$res = pg_query($conn, "SELECT subject, marks FROM $table ORDER BY id");
$labels = [];
$data   = [];
while ($row = pg_fetch_assoc($res)) {
    $labels[] = $row['subject'];
    $data[]   = (int)$row['marks'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>

    * {
      box-sizing: border-box;
    }
    .main{
      width:95%
      margin-left:2.5%;
      border-radius:20px;
    }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f9fafb;
      color: #1f2937;
      min-height: 100vh;
      display: flex;
    }

  
    .sidebar {
    
      width: 280px;
      background:#8813ec; /* dark blue-gray */
      color: #cbd5e1;
      padding: 30px 25px;
      display: flex;
      flex-direction: column;
      gap: 20px;
      box-shadow: 3px 0 10px rgba(0,0,0,0.15);
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }
    .sidebar h2 {
      font-size: 28px;
      font-weight: 700;
      letter-spacing: 2px;
      margin-bottom: 25px;
      color: ghostwhite;
      user-select: none;
    }
    .sidebar a, 
    .sidebar label {
      font-weight: 600;
      font-size: 15px;
      color: #cbd5e1;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      transition: color 0.25s ease;
      user-select: none;
    }
    .sidebar a:hover,
    .sidebar label:hover {
      color: #60a5fa;
    }

  
    .icon {
      width: 18px;
      height: 18px;
      fill: currentColor;
      flex-shrink: 2;
    }

    /* Upload form */
    form {
      margin-bottom: 15px;
    }
    #photo {
      border-radius: 50%;
      border: 2px solid #60a5fa;
      cursor: pointer;
      width: 90px;
      height: 90px;
      object-fit: cover;
      display: block;
      margin-bottom: 10px;
      transition: box-shadow 0.3s ease;
    }
    #photo:hover {
      box-shadow: 0 0 10px #60a5fa;
    }
    input[type="submit"] {
      background: #2563eb;
      border: none;
      color: white;
      font-weight: 700;
      padding: 10px 0;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
      user-select: none;
    }
    input[type="submit"]:hover {
      background: #1d4ed8;
    }

    /* Content wrapper */
    .content {
      margin-left: 280px;
      flex-grow: 1;
      padding: 30px 40px;
      display: flex;
      flex-direction: column;
      gap: 30px;
      min-height: 100vh;
      background: #f9fafb;
    }

    /* Topbar */
    .topbar {
      background: white;
      height: 60px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      display: flex;
      align-items: center;
      justify-content: center;
      position: sticky;
      top: 0;
      z-index: 50;
      font-weight: 700;
      font-size: 20px;
      color: #0f172a;
      user-select: none;
      position: relative;
    }
    .topbar form button {
      position: absolute;
      right: 20px;
      background: #ef4444;
      border: none;
      padding: 8px 18px;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .topbar form button:hover {
      background: #b91c1c;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .container{
      background-color:#a328d7;
      border-radius:20px;
      padding:10px;
      color:white;
      font-size:20px;
      font-weight:bold;
      text-align:center;
    }
    .cards {
      display: grid;
      grid-template-columns: repeat(3,2fr);
      gap: 10px;
    }

    /* Cards */
    .card {
      background: white;
      border-radius: 18px;
      box-shadow: 0 12px 24px rgba(0,0,0,0.08);
      padding: 30px 30px 40px;
      display: flex;
      flex-direction: column;
      gap: 18px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      user-select: none;
    }
    .card:hover {
      transform: translateY(-8px);
      backdrop-filter: blur(10px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }
    .card h3 {
      font-weight: 700;
      font-size: 22px;
      color: #1e293b;
      margin: 0;
    }
    .card ul {
      padding-left: 20px;
      margin: 0;
      color: #475569;
      font-weight: 500;
      list-style-type: disc;
    }
    .card ul li {
      margin-bottom: 10px;
      line-height: 1.4;
    }
    .card a {
      color: #2563eb;
      font-weight: 600;
      text-decoration: none;
      user-select: text;
      transition: color 0.3s ease;
    }
    .card a:hover {
      color: #1e40af;
      text-decoration: underline;
    }

    /* Chart canvas */
    #performanceChart {
      max-width: 100%;
      height: auto !important;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    /* Video iframe */
    iframe {
      width: 100%;
      border-radius: 18px;
      box-shadow: 0 10px 24px rgba(0,0,0,0.1);
      aspect-ratio: 16/9;
      border: none;
    }
  </style>
</head>
<body>
  
  <main class="main">
  <aside class="sidebar">
    <h2>Dashboard</h2>

    <form method="post" enctype="multipart/form-data">
      <label for="photo">Upload Photo</label>
      <input type="file" id="photo" name="photo" accept="image/*" />
      <input type="submit" value="Post" />
    </form>

    <a href="#" title="Your Progress">
      <svg class="icon" viewBox="0 0 24 24"><path d="M4 12h16M4 6h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      Your Progress
    </a>
    <a href="#" title="Your Courses">
      <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Your Courses
    </a>
    <a href="#" title="Appointments">
      <svg class="icon" viewBox="0 0 24 24"><path d="M8 7v5l3 3 5-6V7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Appointments
    </a>
    <a href="information.php" title="Enter Marks">
      <svg class="icon" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      Enter Marks
    </a>
    <a href="support.php" title="Support">
      <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path d="M12 8v4l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Support
    </a>
    <a href="inbox.php" title="Chat">
      <svg class="icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Chat
    </a>
  </aside>

  <div class="content">

    <header class="topbar">
      Welcome Back <?php echo htmlspecialchars($username); ?>
      <form action="logout.php" method="post">
        <button type="submit">Logout</button>
      </form>
    </header>
    <div class="container">
      <?php
        date_default_timezone_set("Africa/Kigali");
        $current_time = date("h:i A");
      ?>
      <div class="time">
<?php echo htmlspecialchars($current_time); ?>
      </div>
      <header>
        <h1>Welcome to your dashboard</h1>
        <?php echo htmlspecialchars($username); ?>
      </header>
      </div>
    <div class="cards">
      <section class="card">
        <h3>Your Performance</h3>
        <canvas id="performanceChart" width="400" height="250"></canvas>
      </section>

      <section class="card">
        <h3>Inspirational Video: Wise Decision Making</h3>
        <iframe 
          src="https://www.youtube.com/embed/UN8bJb8biZU" 
          title="How to Make Good Life Decisions" 
          allowfullscreen
        ></iframe>
      </section>

      <section class="card">
        <h3>Book Appointment</h3>
        <p>Contact available admins:</p>
        <ul>
          <?php while ($row = pg_fetch_assoc($admin_result)): ?>
            <li>
              <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
                <?php echo htmlspecialchars($row['email']); ?>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </section>
      <section class="card">
        <h3>Book Appointment</h3>
        <p>Contact available admins:</p>
        <ul>
          <?php while ($row = pg_fetch_assoc($admin_result)): ?>
            <li>
              <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
                <?php echo htmlspecialchars($row['email']); ?>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </section>
      <section class="card">
        <h3></h3>
        <p>Contact available admins:</p>
        <ul>
          <?php while ($row = pg_fetch_assoc($admin_result)): ?>
            <li>
              <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
                <?php echo htmlspecialchars($row['email']); ?>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </section>
      <section class="card">
        <h3>Book Appointment</h3>
        <p>Contact available admins:</p>
        <ul>
          <?php while ($row = pg_fetch_assoc($admin_result)): ?>
            <li>
              <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
                <?php echo htmlspecialchars($row['email']); ?>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </section>
    </div>

  </div>

<script>
  const ctx = document.getElementById('performanceChart').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: <?php echo json_encode($labels); ?>,
      datasets: [{
        label: 'Your Marks',
        data: <?php echo json_encode($data); ?>,
        backgroundColor: [
          '#60a5fa', '#2563eb', '#93c5fd', '#3b82f6', '#1e40af',
          '#a5b4fc', '#6366f1', '#818cf8', '#4338ca', '#c7d2fe'
        ],
        borderRadius: 6,
        borderColor: '#fff',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'right',
          labels: {boxWidth: 15, padding: 15}
        },
        tooltip: {
          enabled: true
        }
      }
    }
  });
</script>
  </main>
</body>
</html>
