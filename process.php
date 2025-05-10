<?php
$user_fullname = $_POST['ufullname'];
$user_email = $_POST['uemail'];
$user_password = $_POST['upassword'];
$user_dob = $_POST['udob'];
$user_country = $_POST['ucountry'];
$user_gender = $_POST['ugender'];
$user_selectedColor = $_POST['ucolor'];

echo "<h1>Confirm Your Data</h1>";
echo "<p>Full Name: $user_fullname</p>";
echo "<p>Email: $user_email</p>";
echo "<p>Date of Birth: $user_dob</p>";
echo "<p>Country: $user_country</p>";
echo "<p>Gender: $user_gender</p>";
echo "<button>Submit</button>";
?>