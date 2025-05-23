<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request AQI Details</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: rgb(255, 255, 255);
            background-color: #f4f4f4;
            height: 100vh;
            margin: 0;
        }

        .user-info {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            text-align: center;
            z-index: 100;
        }

        .user-info div {
            margin: 5px 0;
            color: #000;
            font-size: 14px;
        }

        .username {
            font-weight: 600;
            font-size: 16px;
        }

        .user-email {
            font-size: 12px;
            opacity: 0.7;
        }

        .logout-btn {
            padding: 6px 15px;
            background:red;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            margin-top: 8px;
            transition: background 0.3s ease;
        }

        .logout-btn:hover {
            background-color: red;
        }

        .border-container {
            padding: 20px;
            width: 450px;
            height: 450px;
            text-align: center;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin: 50px auto;
            backdrop-filter: blur(10px);
            border-radius: 15px;
        }

        .request-box {
            padding: 20px;
            width: 300px;
            text-align: left;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #2b7f51;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }

        .request-box>h3 {
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            margin: 14px auto 15px;
            position: relative;
            width: max-content;
            color: #ffffff;
            font-weight: 500;
        }

        .request-box>h3::after {
            content: '';
            height: 3px;
            width: 100%;
            position: absolute;
            bottom: -4px;
            left: 0;
            border-radius: 10px;
            transition: width 100ms;
        }

        .request-box>h3:hover::after {
            width: 0;
        }

        .data-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin: 20px auto 0;
            font-size: 14px;
            max-width: 400px;
            width: 100%;
        }

        .data-list div {
            display: grid;
            grid-template-columns: 1fr 2fr;
            align-items: left;
            color: #fff;
            margin: 0 auto;
            width: 100%;
        }

        .data-list span:first-child {
            font-weight: 600;
            text-align: left;
        }

        .data-list span:last-child {
            text-align: left;
        }

        .back-button {
            margin-top: 15px;
            padding: 8px 20px;
            border: none;
            background: #5DBCD2;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .confirm-button {
            width: 150px;
            padding: 6px 12px;
            margin-bottom: 10px;
            border: none;
            color: #031229;
            border-radius: 1000px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14;
            background: #d7dddf;
            background-size: 200%;
            cursor: pointer;
            transition: background-position 0.4s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .confirm-button:hover {
            background-position: right center;
            color: #070707;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .confirm-box {
            display: flex;
            margin-top: 10px;
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
           
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
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
    <div class="user-info">
        <?php if (isset($_SESSION['name']) && isset($_SESSION['email'])): ?>
            <div class="username"><?php echo htmlspecialchars($_SESSION['name']); ?></div>
            <div class="email"><a href="./user_info.php"><?php echo htmlspecialchars($_SESSION['email']); ?></a></div>
            <button class="logout-btn" onclick="logout()">Logout</button>
        <?php endif; ?>
    </div>

    <div class="border-container">
        <div class="request-box" id="request-box">
            <h2>Request AQI Details</h2>
            <form class="checkbox-list" onsubmit="return validateCheckboxes()" method="post" action="showaqi.php"
                required>
                <label><input type="checkbox" id="15" value="15" name="city[]"> Tokyo, Japan</label><br>
                <label><input type="checkbox" id="20" value="20" name="city[]"> Istanbul, Turkey</label><br>
                <label><input type="checkbox" id="19" value="19" name="city[]"> Mexico City, Mexico</label><br>
                <label><input type="checkbox" id="2" value="2" name="city[]"> Moscow, Russia</label><br>
                <label><input type="checkbox" id="9" value="9" name="city[]"> Sao Paulo, Brazil</label><br>
                <label><input type="checkbox" id="16" value="16" name="city[]"> Paris, France</label><br>
                <label><input type="checkbox" id="3" value="3" name="city[]"> Lagos, Nigeria</label><br>
                <label><input type="checkbox" id="6" value="6" name="city[]"> Sydney, Australia</label><br>
                <label><input type="checkbox" id="13" value="13" name="city[]"> Berlin, Germany</label><br>
                <label><input type="checkbox" id="4" value="4" name="city[]"> Bangkok, Thailand</label><br>
                <label><input type="checkbox" id="5" value="5" name="city[]"> Beijing, China</label><br>
                <label><input type="checkbox" id="10" value="10" name="city[]"> Jakarta, Indonesia</label><br>
                <label><input type="checkbox" id="12" value="12" name="city[]"> Dubai, United Arab Emirates</label><br>
                <label><input type="checkbox" id="18" value="18" name="city[]"> Rome, Italy</label><br>
                <label><input type="checkbox" id="1" value="1" name="city[]"> Los Angeles, United States</label><br>
                <label><input type="checkbox" id="7" value="7" name="city[]"> Delhi, India</label><br>
                <label><input type="checkbox" id="14" value="14" name="city[]"> Cairo, Egypt</label><br>
                <label><input type="checkbox" id="8" value="8" name="city[]"> New York, United States</label><br>
                <label><input type="checkbox" id="11" value="11" name="city[]"> Toronto, Canada</label><br>
                <label><input type="checkbox" id="17" value="17" name="city[]"> London, United Kingdom</label><br><br>
                <div class="confirm-box"><button type="submit" class="confirm-button">Confirm</button></div>
            </form>

        </div>
    </div>

    <div id="limit-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <p>You can't choose more than 10 cities.</p>
            <button onclick="closeLimitModal()">OK</button>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                // Redirect to logout page or perform logout action
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>

</html>