<?php

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

  // Receiving Interest Selection entered into the frontend in interest.php
  $interest_select = $_POST['interest_select'];


  // Generating SQL command to get all Interests
  $sql = "SELECT * FROM Interest";
  $result = $conn->query($sql);

  $Interest_ID = "";
  $Interest_Name = "";
  $Attribute_IDs = "";

  // Receiving information from the Database for the Interest selected
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if(strcmp($interest_select, $row["InterestName"]) == 0) {
        $Interest_ID = $row["Interest_ID"];
        $Interest_Name = $row["InterestName"];
        $Attribute_IDs = $row["Attribute_IDs"];
      }
    }
  }
  // Parsing Attribute ID lists as an array of attributes
  $AttributeID_List = explode(', ', $Attribute_IDs);

  $Interest_Name = htmlspecialchars($Interest_Name);

  // Generating the redirect string for uploading page
  $redirect_string = 'Location:upload.php?Interest_ID='.$Interest_ID.'&InterestName='.$Interest_Name;

  // Posting User ID to keep user information kept in frontend
  session_start();
  $User_ID =  $_SESSION["User_ID"];

  // Posting Attributes in redirect string so that they will be received in upload.php
  for($i = 0; $i < count($AttributeID_List); $i++) {
    $sql = 'SELECT * FROM Attribute WHERE Attribute_ID = ' . $AttributeID_List[$i];
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $AttributeName_List[$i] = $row["AttributeName"];
        $redirect_string = $redirect_string.'&Attribute_'.$i.'='.$AttributeName_List[$i];
      }
    }
  }
  // Proceding to next page
  header($redirect_string);

?>
