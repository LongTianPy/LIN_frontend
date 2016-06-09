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

    // Receiving information from uploaded file
    $file = $_FILES['file']['name'];
    $type = $_FILES['file']['size'];
    $temp = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];

    // Getting name of Genome by removing extension from file
    $name = explode('.', $file)[0];
    $name .= time();

    // Destination file to insert new Fasta file
    $fileDest = '/home/linproject/Workspace/Zika/';


    session_start();
    $count = $_SESSION['Count'];

    $attribute_string = "";
    for($i = 1; $i <= $count; $i++) {
      $attribute_string .= $_POST["Attribute_$i"];
      if($i < $count) {
        $attribute_string .= "^^";
      }
    }

    // Moving the uploaded file into the destination
    if(move_uploaded_file($temp, $fileDest.$file)) {

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

        // Posting Interest ID to keep user information kept in frontend
        session_start();
        $Interest_ID =  $_SESSION["Interest_ID"];

        // Getting curr
        $sql = "SELECT COUNT(*) FROM Submission";
        $result = $conn->query($sql);
        $Submission_ID = $result->fetch_assoc()["COUNT(*)"] + 1;
    }

    // Changing directory to run the backend script
    chdir("../../../..");
    chdir("/home");

    // Receiving User ID
    $User_ID = $_SESSION['User_ID'];
    $sql = "select * from User where User_ID = $User_ID";
    $result = $conn->query($sql);
    $email = $result->fetch_assoc()['Email'];


    // Python command to run the backend. First parameter - name of file. 
    // Second parameter - User ID
    $cmd = 'python /home/linproject/Projects/LIN_proto/workflow.py -i '.$file.' -u '.$User_ID.' -s '.$Submission_ID.' -t '.$attribute_string;

    echo $cmd;
    // Running the backend
//    $out = shell_exec($cmd.' 2>&1');



    // $sql = "select max(Genome_ID) from Genome";
    // $result = $conn->query($sql);
    // $Genome_ID = $result->fetch_assoc()['max(Genome_ID)'];

    // $url = "http://128.173.74.68/linSite/result.php?Genome_ID=".$Genome_ID;
    // echo $url;
    // mail('granth6@vt.edu', 'test', 'hello', 'From: ');


?>
