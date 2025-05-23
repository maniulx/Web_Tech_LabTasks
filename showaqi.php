<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aqi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AQI Data Display</title>
    <style>
        body {
            <?php if (isset($_COOKIE['user_color'])): ?>
                background-color: <?php echo htmlspecialchars($_COOKIE['user_color']); ?>;
            <?php else: ?>
                background-color: #f0f0f0;
            <?php endif; ?>
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .user-info {
            position: absolute;
            top: 20px;
            right: 20px;
            text-align: right;
            color: #333;
            background: rgba(255, 255, 255, 0);
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0);
            min-width: 200px;
        }

        .user-info div {
            margin-bottom: 5px;
        }

        .user-info .username {
            font-weight: bold;
            font-size: 18px;
        }

        .user-info .email {
            color: #666;
            font-size: 14px;
        }

        .user-info form {
            margin-top: 10px;
        }

        .user-info button {
            padding: 8px 16px;
            border: none;
            background-color: #ff3333;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .user-info button:hover {
            background-color: #cc0000;
        }

        .aqi-table {
            margin-top: 120px;
            border-collapse: collapse;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .aqi-table th {
            background-color: #333;
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: bold;
        }

        .aqi-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
        }

        .aqi-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .no-data {
            text-align: center;
            margin-top: 120px;
            color: #666;
            font-size: 18px;
        }
        .user_avatar{
            position: fixed;
            left: 20px;
            top: 20px;

        }
        .user_avatar > img{
            height: 100px;
            width: 100px;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="user_avatar">
        <img src="<?php echo htmlspecialchars($_SESSION['avatar']) ?>" alt="user_avatar" >
    </div>
    <?php if (isset($_SESSION['name']) && isset($_SESSION['email'])): ?>
        <div class="user-info">
            <div class="username"><?php echo htmlspecialchars($_SESSION['name']); ?></div>
            <div class="email"><a href="./user_info.php"><?php echo htmlspecialchars($_SESSION['email']); ?></a></div>
            <form method="post" action="logout.php">
                <button type="submit">Logout</button>
            </form>
        </div>
    <?php endif; ?>

    <?php
    if (isset($_POST['city']) && is_array($_POST['city']) && count($_POST['city']) > 0) {
        $ids = array_map('intval', $_POST['city']);
        $idList = implode(',', $ids);
        $sql = "SELECT * FROM info WHERE id IN ($idList)";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='aqi-table'>
                <tr>
                    <th>Serial No.</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>AQI</th>
                </tr>";
            
            $serial = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$serial}</td>
                    <td>" . htmlspecialchars($row['City']) . "</td>
                    <td>" . htmlspecialchars($row['Country']) . "</td>
                    <td>" . htmlspecialchars($row['Aqi']) . "</td>
                  </tr>";
                $serial++;
            }
            echo "</table>";
        } else {
            echo "<div class='no-data'>No results found.</div>";
        }
    } else {
        echo "<div class='no-data'>No cities selected.</div>";
    }

    $conn->close();
    ?>
</body>

</html>

