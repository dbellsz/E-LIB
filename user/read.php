<?php
session_start();

$filename = "";
$book_title= "";



include('include/config.php');
include('include/checklogin.php');

error_reporting(E_ALL);
ini_set("display_errors", 1);

// $sql=mysqli_query($con,"select file_path from books where id='".$_SESSION['id']."'");
// while($data=mysqli_fetch_array($sql))
// {
//
//
//
// }

// $sql = "SELECT * FROM books where book_id='2' ";
// $result = $con->query($sql);

$bid = $_GET["bid"];

$query = "SELECT * FROM books where book_id=:bid";
$stmt = $con->prepare($query);
$stmt->bindParam(":bid", $bid);
$stmt->execute();
$result =$stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($result) > 0){
//echo "yes";
foreach($result as $row):

  $filenamez =  $row["file_path"];
  $book_title = $row["book_title"];

endforeach;


 //  while($row = $stmt->fetch(PDO::FETCH_ASSOC))
 //  {
 //
 // $filenamez =  $row["file_path"];
 //
 //  }
}





// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//
//                                         }
//
//                             }
 else
 {

    echo "0 results";
    exit;
}
// $con->close();
// $filename = "uploads/2017-2018 security fundamentals msccyb.pdf";



//echo $filename;
// Let the browser know that a PDF file is coming.

$filename = $filenamez;

// //echo $filename;
//
//LOG READ BOOK Event
    $uip=$_SERVER['REMOTE_ADDR'];
    $status=0;
   $role = "user";
   $date_now =  date('m/d/Y h:i:s a', time());

   $event = "Read Book titled '".$book_title."'";
   $usernameForDb = $_SESSION['username'];
   echo $usernameForDb;

   // mysqli_query($con,"insert into log (username,userip,status) values('".$_SESSION['username']."','$uip','$status')");

    $stmt = $con->prepare("insert into logs (role,username,userip,event,date_posted) values(:role,:usernameForDb, :uip,:event,:date_posted)");
    //$stmt->bind_param("ssss", $username, $hashedpwd, $active, $salt);

                 $stmt->bindParam(":role", $role);
                 $stmt->bindParam(":usernameForDb",$usernameForDb);
                 $stmt->bindParam(":uip", $uip);
                  $stmt->bindParam(":date_posted", $date_now);
               //	 $stmt->bindParam(":status", $status);
                 $stmt->bindParam(":event", $event);

    $stmt->execute();

// The location of the PDF file on the server.

//$filename = "uploads/Anthonia Evbuomwan's CV.pdf";

//Let the browser know that a PDF file is coming.

// header("Content-type: application/pdf");
//
// header("Content-Length: " . filesize($filename));
//
// readfile($filename);

// header('Content-Disposition: inline; filename="'.$filename.'"');
//     header('Content-Type: application/pdf');
//     header('Content-Length: '.filesize($filename));
//
//     readfile($filename);






exit;

?>
