<?php
$user_fullname = $_POST['ufullname'];
$user_email = $_POST['uemail'];
$user_password = $_POST['upassword'] ?? '';
$user_dob = $_POST['udob'] ?? '';
$user_country = $_POST['ucountry'] ?? '';
$user_gender = $_POST['ugender'] ?? '';
$user_selectedColor = $_POST['ucolor'] ?? '#1F3D6B';

$country_names = [
    'australia' => 'Australia',
    'argentina' => 'Argentina',
    'brazil' => 'Brazil',
    'bangladesh' => 'Bangladesh',
    'england' => 'England',
    'india' => 'India',
    'pakistan' => 'Pakistan',
    'united-states' => 'United States'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <title>Registration Confirmation</title>
    <style>
        .confirmation-container {
            width: 80%;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            font-family: 'Montserrat', sans-serif;
            background-color: #2b7f51;
            color: #fff;
        }
        
        h1 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .data-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .data-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        .submit-button {
            width: 150px;
            padding: 6px 12px;
            margin-top: 30px;
            border: none;
            color: #031229;
            border-radius: 1000px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            background: #d7dddf;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        
        .submit-button:hover {
            background: #c0c6c8;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h1>Confirm Registration</h1>
        
        <div class="data-item">
            <span class="data-label">Full Name:</span>
            <?php echo $user_fullname; ?>
        </div>
        
        <div class="data-item">
            <span class="data-label">Email:</span>
            <?php echo $user_email; ?>
        </div>
        
        <div class="data-item">
            <span class="data-label">Date of Birth:</span>
            <?php echo $user_dob; ?>
        </div>
        
        <div class="data-item">
            <span class="data-label">Country:</span>
            <?php echo $country_names[$user_country]; ?>
        </div>
        
        <div class="data-item">
            <span class="data-label">Gender:</span>
            <?php echo $user_gender; ?>
        </div>
        
        <div class="data-item">
            <span class="data-label">Color:</span>
            <?php echo $user_selectedColor; ?>
        </div>
        
        <button type="submit" class="submit-button">Confirm</button>
    </div>
</body>
</html>