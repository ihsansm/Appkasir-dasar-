<!-- cek koneksi terhubung/tidak -->
<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "db_chatgpt";
    $conn = "";

    $conn = mysqli_connect($host,
                $user,
                      $password,
                       $dbname);
    if($conn){
        echo"You are connected!";
    }
    else{
        echo"Could not connect!";
    }

?>