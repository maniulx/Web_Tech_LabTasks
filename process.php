<?php
$user_fullname = $_POST['ufullname'];
$user_email = $_POST['uemail'];
$user_password = $_POST['upassword'] ?? '';
$user_dob = $_POST['udob'] ?? '';
$user_country = $_POST['ucountry'] ?? '';
$user_gender = $_POST['ugender'] ?? '';
$user_selectedColor = $_POST['ucolor'] ?? '#1F3D6B';
$avatarURL = '';

if (isset($_FILES['uavatar']) && $_FILES['uavatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'images/';
    $ext = pathinfo($_FILES['uavatar']['name'], PATHINFO_EXTENSION);
    $emailPrefix = preg_replace('/[^a-zA-Z0-9]/', '_', strstr($user_email, '@', true));
    $avatarName = $emailPrefix . '.' . $ext;
    $avatarURL = $uploadDir . $avatarName;
    move_uploaded_file($_FILES['uavatar']['tmp_name'], $avatarURL);
}

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

function register_to_db($user_fullname, $user_email, $user_password, $user_dob, $user_country, $user_gender, $user_selectedColor, $avatarURL)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "aqi";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        return "Connection failed: " . $conn->connect_error;
    }

    $sql = "INSERT INTO users (ufullname, uemail, upassword, udob, ucountry, ugender, ucolor, uimage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $user_fullname, $user_email, $user_password, $user_dob, $user_country, $user_gender, $user_selectedColor, $avatarURL);

    if ($stmt->execute()) {
        $msg = "Registration successful!";
    } else {
        $msg = "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    return $msg;
}

if (isset($_POST['avatarURL']) && !empty($_POST['avatarURL'])) {
    $avatarURL = $_POST['avatarURL'];
}

if (isset($_POST['confirm'])) {
    $registration_message = register_to_db(
        $user_fullname,
        $user_email,
        $user_password,
        $user_dob,
        $user_country,
        $user_gender,
        $user_selectedColor,
        $avatarURL
    );
}
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        .submit-button,
        .back-button {
            width: 150px;
            padding: 6px 12px;
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
            background-color: rgb(27, 115, 216);
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .back-button:hover {
            background-color: #d32f2f;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .button-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 350px;
            margin: 30px auto 0 auto;
            gap: 0;
            flex-direction: row;
        }

        .avatar-container {
            display: flex;
            align-items: center;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 300px;
            margin: 0 auto;
        }

        .modal-content p {
            margin: 0 0 15px;
            color: #333;
        }

        .modal-content button {
            padding: 10px 20px;
            border: none;
            background: #5DBCD2;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="confirmation-container" id="confirmation-container">
        <h1>Confirm Registration</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="data-item">
                <span class="data-label">Full Name:</span>
                <?php echo htmlspecialchars($user_fullname); ?>
                <input type="hidden" name="ufullname" value="<?php echo htmlspecialchars($user_fullname); ?>">
            </div>

            <div class="data-item">
                <span class="data-label">Email:</span>
                <?php echo htmlspecialchars($user_email); ?>
                <input type="hidden" name="uemail" value="<?php echo htmlspecialchars($user_email); ?>">
            </div>

            <div class="data-item">
                <span class="data-label">Date of Birth:</span>
                <?php echo htmlspecialchars($user_dob); ?>
                <input type="hidden" name="udob" value="<?php echo htmlspecialchars($user_dob); ?>">
            </div>

            <div class="data-item">
                <span class="data-label">Country:</span>
                <?php echo htmlspecialchars($country_names[$user_country]); ?>
                <input type="hidden" name="ucountry" value="<?php echo htmlspecialchars($user_country); ?>">
            </div>

            <div class="data-item">
                <span class="data-label">Gender:</span>
                <?php echo htmlspecialchars($user_gender); ?>
                <input type="hidden" name="ugender" value="<?php echo htmlspecialchars($user_gender); ?>">
            </div>

            <div class="data-item">
                <span class="data-label">Color:</span>
                <?php echo htmlspecialchars($user_selectedColor); ?>
                <input type="hidden" name="ucolor" value="<?php echo htmlspecialchars($user_selectedColor); ?>">
            </div>

            <div class="data-item">
                <div class="avatar-container">
                    <span class="data-label">Avatar:</span><br>
                    <?php if ($avatarURL): ?>
                        <img src="<?php echo htmlspecialchars($avatarURL); ?>" alt="Avatar"
                            style="max-width:100px;max-height:100px;border: radius 5px;border:.5px solid #fff;">
                    <?php else: ?>
                        <span>No avatar uploaded.</span>
                    <?php endif; ?>
                </div>
            </div>

            <input type="hidden" name="upassword" value="<?php echo htmlspecialchars($user_password); ?>">
            <input type="hidden" name="avatarURL" value="<?php echo htmlspecialchars($avatarURL); ?>">

            <div class="button-row">
                <button type="button" class="back-button" onclick="history.back();">Back</button>
                <button type="submit" class="submit-button" name="confirm"
                    onclick="showRegSuccessModal()">Confirm</button>
            </div>
        </form>
    </div>
    <div id="registration-done-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <p>Registration Successful</p>
            <button onclick="closeRegSuccessModal()">OK</button>
        </div>
    </div>
    <?php if (!empty($registration_message) && $registration_message === "Registration successful!"): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('registration-done-modal').style.display = 'flex';
                document.getElementById('confirmation-container').style.filter = 'blur(4px)';
            });
        </script>
    <?php endif; ?>
    <script src="script.js"></script>

</body>

</html>