<!-- 
  upload.php

  HMTL page to upload a genome from local machine into Database and 
  used to input attribute values associated to the genome
-->

<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="http://cdn.wideskyhosting.com/js/jquery.validate.js"></script>
    <script type = "text/javascript" src = "script.js"></script>
    <script>
      $("document").ready(function() {
        $("form").validate()
      })
    </script>
    <style>
      .error {color: red}
    </style>
  </head>
  <body>
    <form action = "uploadClient.php" method = "post" enctype="multipart/form-data">
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

        // Selecting Interest in Database of the Interest selected in interest.php
        $sql = 'SELECT * FROM Interest where InterestName = "'.$_GET["InterestName"].'"';
        $result = $conn->query($sql);

        // Generating text boxes to input Attribute values with Labels
	$count = 0;
        if($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $AttributeID_List = explode(',', $row["Attribute_IDs"]);
	  $i = 1;
          for($i = 1; $i <= count($AttributeID_List); $i++) {
            $sql = 'SELECT * FROM Attribute WHERE Attribute_ID = '.$i;
            $result2 = $conn->query($sql);
            if($result2->num_rows > 0) {
              $row2 = $result2->fetch_assoc();
              // Wrapping the echo'ed message in p and input tags, which HTML 
              // will read as their proper keywords.
              echo '<p>'.$row2["AttributeName"].'</p>';
              echo '<input id = "Attribute" type = "text" name = "Attribute_'.$i.'" 
	        class = "required">';
              echo '<br>';
            }
          }
	  $count = $i - 1;
        }
        // Posting User ID and Interest ID to keep user information kept 
        // in frontend
        session_start();
        $_SESSION["Interest_ID"] = $_GET["Interest_ID"];
        $User_ID =  $_SESSION["User_ID"];
	$_SESSION["Count"] = $count;
      ?>
      <div>
        <p>File Path</p>
        <input id = "file" type = "file" name = "file">
      </div>
      <div>
        <br>
        <input id = "submit" type = "submit" value = "submit">
      </div>
    </form>
  </body>
</html>
