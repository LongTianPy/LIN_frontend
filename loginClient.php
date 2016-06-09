<?php
  // loginClient.php
  //
  // Login page to the frontend. Username (email) and password required
  //
  // Grant Hughes
  // 20-05-2016

  // Assigning Server and Database name
  $servername = "128.173.74.68";
  $username = "linproject";
  $password = "tcejorpnil";
  $db_name = "LINdb_zika";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $db_name);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $User_ID = "";
  $User_FirstName = "";

  // Receiving Username and password entered into the frontend in login.html
  $User_UserName = $_POST['username'];
  $user_Password = $_POST['user_password'];

  // Generating SQL command to get all Users
  $sql = "SELECT * FROM User";
  $result = $conn->query($sql);
  
  // Comparing username and password to the queries. If there is a match,
  // the frontend will continue to interest.php, otherwise, an error will
  // occur and the user will not sign in.
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      // String comparison with username
      if(strcmp($User_UserName, $row["Username"]) == 0) {
        // Using PHP function to unhash password hash 
        if(password_verify($user_Password, $row["Password"])) {
          $User_ID = $row["User_ID"];
          $User_FirstName = $row["FirstName"];
          // Proceding to next page, saving first name and user id for future pages.
          header('location:interest.php?user_firstname='.$User_FirstName.'&User_ID='.$User_ID);
        }
        else {
          if(isset($_POST['submit']) == false) {
            $_SESSION['error_message_login'] = "Login Failed, please try again.";
          }
          // Remaining in Login page.
          header('location:login.html');
        }
      }
    }
  }
?>
