<?php
  // New user registration page client for frontend. Enters username (email), 
  // First Name, Last Name, Institution, and Password (with confirmation)
  // into form, validates information and places new user into database.


  $error_message = "";
  $num_nulls = 0;

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

  // Receiving form data entered into the frontend in register.html
  $user_userName = $_POST['user_userName'];
  $user_lastname = $_POST['user_lastname'];
  $user_firstname = $_POST['user_firstname'];
  $user_institute = $_POST['user_institute'];
  $user_password1 = $_POST['user_password1'];
  $user_password2 = $_POST['user_password2'];

  // Checks if password is entered correctly. Password must 
  // be confirmed with re-entry and must be greater than 7
  // characters long.
  function password_validate($password1, $password2) {
    $message = "";
    if($password1 == null) {
      $message .= "Password field empty. ";
    }
    if($password2 == null) {
      $message .= "Password confirmation field empty. ";
    }
    if(strlen($password1) <= 7) {
      $message .= "Password needs to be at least 7 characters long. ";
    }
    if(strcmp($password1, $password2) != 0) {
      $message .= "Password confirmation does not match. ";
    }
    return $message;
  }

  // Checks if any of the form entries are null. If so, the error message 
  // string will be appended to.
  if($user_firstname == null) {
    $error_message .= "First name field empty. ";
  }
  if($user_lastname == null) {
    $error_message .= "Last name field empty. ";
  }

  if($user_institute == null) {
    $error_message .= "Institute field empty. ";
  }

  // Checks if userName entry is valid
  if($user_userName == null) {
    $error_message .= "Username field empty. ";
    if(filter_var($user_username, FILTER_VALIDATE_EMAIL) == false) {
      $error_message .= "Not a valid email address. ";
    }
  }
  
  // Generating a User ID for new registered user
  $sql = "SELECT COUNT(*) FROM User";
  $result = $conn->query($sql);
  $user_ID = $result->fetch_assoc()["COUNT(*)"] + 1;

  $error_message .= password_validate($user_password1, $user_password2);

  // If there has been an error in form entry (indicated if the error message
  // has content or not), the page will redirect back to register.html
  if(strlen($error_message) > 0) {
    session_start();
    $_SESSION['error_message_register'] = $error_message;
    $error_message = "";
    header('location:register.html');
  }
  // Form is valid.
  else {
    // Getting current date of registration
    $time_stamp = date("Y/m/d");
    // Hashing password by using PHP hash function for protection
    $user_password = password_hash($user_password1, PASSWORD_BCRYPT, array('cost' => 10));

    // Entering new user into Database
    $sql = "INSERT INTO User (User_ID, LastName, FirstName,
        Institute, RegistrationDate, Username, Password, Email) VALUES ('$user_ID',
        '$user_lastname', '$user_firstname', '$user_institute', '$time_stamp', '$user_userName', '$user_password', '$user_userName')";
    if ($conn->query($sql) === TRUE) {
      $_SESSION['user_firstname'] = $user_firstname;
      header('location:interest.php?user_firstname='.$user_firstname.'&User_ID='.$user_ID);
    } 
    else {
      // Displaying error message
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
?>

