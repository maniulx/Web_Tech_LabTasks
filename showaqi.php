<?php
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
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
if (isset($_POST['city']) && is_array($_POST['city']) && count($_POST['city']) > 0) {
    $ids = array_map('intval', $_POST['city']);
    $idList = implode(',', $ids);
    $sql = "SELECT * FROM info WHERE id IN ($idList)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1' class='aqi-table'>
                <tr><th>Serial No.</th><th>City</th><th>Country</th><th>AQI</th></tr>";
        $serial = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$serial}</td>
                    <td>{$row['City']}</td>
                    <td>{$row['Country']}</td>
                    <td>{$row['Aqi']}</td>
                  </tr>";
            $serial++;
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }
} else {
    echo "No cities selected.";
}

$conn->close();
?>
</body>
</html>
