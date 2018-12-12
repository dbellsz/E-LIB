<?php
// define('DB_SERVER','localhost');
// define('DB_USER','root');
// define('DB_PASS' ,'');
// define('DB_NAME', 'elibrary');
// $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// // Check connection
// if (mysqli_connect_errno())
// {
//  echo "Failed to connect to MySQL: " . mysqli_connect_error();
// }
?>


<?php


    //connecting the mysql server
    $DSN ="mysql:host=localhost;dbname=elibrary";//server name
    $usernamedb="root";
    $passworddb="";
    $con=new PDO ($DSN,$usernamedb,$passworddb);

    if (!$con)
        {
        $e ='Could not connect: '. mysql_error();

        }

    else
        {
        $e = "connected successfully";
        }

        ?>
