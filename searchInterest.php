<html>
  <head>
  </head>
  <body>
    <form action = "interestClient.php" method = "post">
      <select id = "interest_select" name = "interest_select">
        <?php
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

          $sql = "SELECT * FROM Interest";
          $result = $conn->query($sql);

          if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
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
        $_SESSION["User_ID"] = $_GET["User_ID"];
//	echo '<p>'.$_GET["User_ID"].'</p>';
         ?>
    </form>
  </body>
</html>
