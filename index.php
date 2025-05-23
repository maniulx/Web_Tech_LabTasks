<?php
$login_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login-email'], $_POST['login-pass'])) {
  $conn = new mysqli("localhost", "root", "", "aqi");
  if ($conn->connect_error) {
    $login_message = "Database connection failed.";
  } else {
    $email = $_POST['login-email'];
    $password = $_POST['login-pass'];
    $stmt = $conn->prepare("SELECT upassword FROM users WHERE uemail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_password);
    if ($stmt->fetch()) {
      if ($db_password === $password) {
        $login_message = "Login successful!";
      } else {
        $login_message = "Incorrect password.";
      }
    } else {
      $login_message = "No user found with this email.";
    }
    $stmt->close();
    $conn->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="./style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
</head>

<body>
  <div class="header">
    <img
      src="https://marketplace.canva.com/EAFaFUz4aKo/3/0/1600w/canva-yellow-abstract-cooking-fire-free-logo-tn1zF-_cG9c.jpg"
      alt="company logo" class="logo" />
    <h4 class="company-title">Cooking360</h4>
  </div>
  <div id="main-container" class="main-container">
    <div class="left-panel">
      <div class="top-left-panel">
        <div class="user-reg">
          <h4>Registration</h4>
          <div class="reg-details">
            <form action="process.php" method="POST" id="reg-form" enctype="multipart/form-data">
              <label for="ufullname">Full Name</label><br>
              <input type="text" id="ufullname" name="ufullname" placeholder="e.g., John Doe" required><br>
              <span id="ufullname-error" class="error-message"></span>

              <label for="uemail">Email</label><br>
              <input type="email" id="uemail" name="uemail" placeholder="e.g., example@example.com" required><br>
              <span id="uemail-error" class="error-message"></span>

              <label for="upassword">Password</label><br>
              <input type="password" id="upassword" name="upassword" placeholder="Create a strong password"
                required><br>
              <span id="upassword-error" class="error-message"></span>

              <label for="ucpassword">Confirm Password</label><br>
              <input type="password" id="ucpassword" name="ucpassword" placeholder="Re-enter your password"
                required><br>
              <span id="ucpassword-error" class="error-message"></span>

              <label for="udob">Date of Birth</label><br>
              <input type="date" id="udob" name="udob" required><br>
              <span id="udob-error" class="error-message"></span>

              <label for="ucountry">Country</label><br>
              <select name="ucountry" id="ucountry" required>
                <option value="" disabled selected>Select a country</option>
                <option value="australia">Australia</option>
                <option value="argentina">Argentina</option>
                <option value="brazil">Brazil</option>
                <option value="bangladesh">Bangladesh</option>
                <option value="england">England</option>
                <option value="india">India</option>
                <option value="pakistan">Pakistan</option>
                <option value="united-states">United States</option>
              </select><br />

              <label for="uavatar">Upload Your Avatar</label><br>
              <input type="file" id="uavatar" name="uavatar" accept=".png, .jpg, .jpeg, image/png, image/jpeg"
                required><br>
              <span id="uavatar-error" class="error-message"></span>

              <div>
                <label for="ucolor" class="color-label">Choose a color:</label>
                <input type="color" id="ucolor" name="ucolor" value="#1F3D6B" aria-label="Choose Color" /><br />
              </div>
              <fieldset>
                <legend>Gender</legend>
                <input type="radio" id="male" value="Male" name="ugender" required aria-label="Male" />
                <label for="male">Male</label>
                <input type="radio" id="female" value="Female" name="ugender" aria-label="Female" />
                <label for="female">Female</label>
              </fieldset>
              <br />

              <input type="checkbox" id="termandcondition" required />
              <label for="termandcondition"><a href="https://example.com" target="_blank">I agree to the terms &
                  conditions.</a></label><br />
              <button type="submit" class="reg-button" onclick="return validate()">
                Register
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="bottom-left-panel">
        <div class="login">
          <h4>Login</h4>
          <div class="login-details">
            <form action="index.php" method="POST" id="login-form">
              <label for="login-email"></label><br>
              <input type="email" id="login-email" name="login-email" placeholder="Enter Email" required><br>
              <span id="login-email-error" class="error-message"></span>

              <label for="login-pass"></label><br>
              <input type="password" id="login-pass" name="login-pass" placeholder="Enter Password" required><br>
              <span id="login-pass-error" class="error-message"></span>
              <button type="submit" class="login-button">
                Log In
              </button>
            </form>
            <?php if (!empty($login_message)): ?>
              <script>
                document.addEventListener('DOMContentLoaded', function () {
                  <?php if ($login_message === "Login successful!"): ?>
                    showLoginSuccess();
                  <?php elseif ($login_message === "Incorrect password."): ?>
                    showLoginFailed("Incorrect password.");
                  <?php else: ?>
                    showLoginFailed("No user found with this email.");
                  <?php endif; ?>
                });
              </script>
            <?php endif; ?>
            <p>Don't have an account? <a href="#register">Register</a></p>
            <p>Forgot your password? <a href="#reset">Reset</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="right-panel">
      <div class="table-container">
        <table id="home-aqi-table" class="aqi-table">
          <caption>Top 5 Cities with the Worst Air Quality</caption>
          <thead>
            <tr>
              <th>City</th>
              <th>AQI</th>
            </tr>
          </thead>
          <tbody style="filter: blur(4px);">
            <tr>
              <td>Kuwait City, Kuwait</td>
              <td>312</td>
            </tr>
            <tr>
              <td>Dhaka, Bangladesh</td>
              <td>149</td>
            </tr>
            <tr>
              <td>Santiago, Chile</td>
              <td>134</td>
            </tr>
            <tr>
              <td>Baghdad, Iraq</td>
              <td>112</td>
            </tr>
            <tr>
              <td>Kolkata, India</td>
              <td>105</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div id="login-success-modal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
      <p>Login Successful</p>
      <button onclick="closeLoginSuccess()">OK</button>
    </div>
  </div>
  <div id="login-failed-modal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
      <p id="login-failed-msg"></p>
      <button onclick="closeLoginFailed()">OK</button>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>