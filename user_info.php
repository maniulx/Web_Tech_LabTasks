<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_email'])) {
    echo "<p>You are not logged in. Please <a href='index.php'>login</a> to access this page.</p>";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aqi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_email = $_SESSION['user_email'];

$sql = "SELECT * FROM users WHERE uemail = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_info = $result->fetch_assoc();
} else {
    echo "<p>User not found in the database.</p>";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Information</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f0f8ff;
      color: #333;
      padding: 20px;
    }
    .user-info-container {
      max-width: 600px;
      margin: 30px auto;
      padding: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    h1 {
      text-align: center;
      color: #2b7f51;
      margin-bottom: 20px;
    }
    .data-item {
      margin-bottom: 12px;
      font-size: 16px;
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid #ddd;
      padding-bottom: 6px;
    }
    .data-label {
      font-weight: 600;
      color: #1F3D6B;
    }
    .avatar-img {
      max-width: 120px;
      max-height: 120px;
      border-radius: 8px;
      border: 2px solid #2b7f51;
    }
    .button-row {
      text-align: center;
      margin-top: 20px;
    }
    button {
      padding: 10px 25px;
      background-color: #2b7f51;
      color: white;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #1f5c39;
    }
  </style>
</head>
<body>
  <div class="user-info-container">
    <h1>User Information</h1>
    <div class="data-item">
      <span class="data-label">Full Name:</span>
      <span><?= htmlspecialchars($user_info['ufullname']) ?></span>
    </div>
    <div class="data-item">
      <span class="data-label">Email:</span>
      <span><?= htmlspecialchars($user_info['uemail']) ?></span>
    </div>
    <div class="data-item">
      <span class="data-label">Date of Birth:</span>
      <span><?= htmlspecialchars($user_info['udob']) ?></span>
    </div>
    <div class="data-item">
      <span class="data-label">Country:</span>
      <span><?= htmlspecialchars($user_info['ucountry']) ?></span>
    </div>
    <div class="data-item">
      <span class="data-label">Gender:</span>
      <span><?= htmlspecialchars($user_info['ugender']) ?></span>
    </div>
    <div class="data-item">
      <span class="data-label">Color:</span>
      <span><?= htmlspecialchars($user_info['ucolor']) ?></span>
    </div>
    <div class="data-item" style="flex-direction: column; align-items: flex-start;">
      <span class="data-label">Avatar:</span>
      <?php if (!empty($user_info['uimage'])): ?>
        <img src="<?= htmlspecialchars($user_info['uimage']) ?>" alt="Avatar" class="avatar-img" />
      <?php else: ?>
        <span>No avatar uploaded.</span>
      <?php endif; ?>
    </div>
    <div class="button-row">
      <button onclick="window.location.href='index.php'">Back to Home</button>
    </div>
  </div>
</body>
</html>
