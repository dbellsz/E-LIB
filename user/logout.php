<?php
session_start();
include('include/config.php');
//$_SESSION['login']=="";
//date_default_timezone_set('Asia/Kolkata');
//$ldate=date( 'd-m-Y h:i:s A', time () );
//mysqli_query($con,"UPDATE userlog  SET logout = '$ldate' WHERE uid = '".$_SESSION['id']."' ORDER BY id DESC LIMIT 1");

$_SESSION['errmsg']="You have successfully logout";


$uip=$_SERVER['REMOTE_ADDR'];
$status=0;
$role = "user";
$date_now =  date('m/d/Y h:i:s a', time());

$event = "Logout";
$usernameForDb = $_SESSION['username'];
//echo $usernameForDb;

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




//session_unset();
//session_destroy();


?>
<script language="javascript">
document.location="./login.php";
</script>
