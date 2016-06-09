<!-- 
  interest.php

  HMTL page to select an interest in the frontend. Contains a welcome message, 
  and a form, with an option selection to choose an interest, and a submit 
  button
-->
<html>
  <head>
  </head>
  <body>
    <?php
   	 // Hello Message
	 echo '<h2>Hello '.$_GET["user_firstname"].'</h2>';
    ?>
    <form action = "interestClient.php" method = "post">
      <select id = "interest_select" name = "interest_select">
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

          // Generating SQL command to get all Interests
          $sql = "SELECT * FROM Interest";
          $result = $conn->query($sql);

          // For each Interest, displaying the Interest name as an option in the "Select" in the Form
          if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              // Wrapping the echo'ed message in option tags, which HTML will read as their proper keywords.
              echo '<option id = "'.$row["InterestName"].'" value = "'.$row["InterestName"].'">'.$row["InterestName"].'</option>';
            }
          }
	      ?>
      </select>
      <div>
        <input id = "submit" type = "submit" value = "submit">
      </div>

      <?php
        session_start();
        // Posting User ID to keep user information kept in frontend
        $_SESSION["User_ID"] = $_GET["User_ID"];
      ?>
    </form>
  </body>
</html>
