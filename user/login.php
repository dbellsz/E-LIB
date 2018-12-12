<?php
session_start();
unset($_SESSION['LAST_ACTIVITY']);



if (isset($_SESSION['login']) )
{
	if( $_SESSION["role"] == "user" )
	{
	header('Location:dashboard.php');
	}
}

// if($_SESSION["role"] == "user")
// {
// header.location('dashboard.php');
//
// }


// $_SESSION['errmsg']="";
include("include/config.php");

// if(isset($_POST['submitReg']))
// {

//
// 	error_reporting(E_ALL);
// 	ini_set("display_errors", 1);
// $username=$_POST['username'];
// $password=$_POST['Password'];
// $active='1';
//
// // $c=$_POST['city'];
// // $gender=$_POST['gender'];
//
// // $sql=mysqli_query($con,"insert into users fullName='$fname',address='$address',city='$city',gender='$gender' where id='".$_SESSION['id']."'");
// //
// //
// // if($sql)
// // {
// // /*$msg="Your Profile updated Successfully";*/
// //
// //
// // }
//
//
// $options = [
// 									 'cost' => 11,
// 									 'salt' =>  mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
// 							 ];//got this random generator for http://php.net/manual/en/function.password-hash.php
// $salt = $options['salt'];
// $hashedpwd = password_hash($password, PASSWORD_BCRYPT, $options);
//
//
// $stmt = $con->prepare("insert into users (username, password, active, salt) VALUES (:username,:hashedpwd,:active,:salt)");
// //$stmt->bind_param("ssss", $username, $hashedpwd, $active, $salt);
// $stmt->bindParam(":username", $username);
// $stmt->bindParam(":hashedpwd", $hashedpwd);
// $stmt->bindParam(":active", $active);
// $stmt->bindParam(":salt", $salt);
//
// $stmt->execute();
//
//
// echo "New User created successfully, You can Login Now";

// $stmt->close();
// $con->close();

// }





if(isset($_POST['delete']))
{


$username = $_SESSION['username'];
$active = "0";

//	$query = "Delete FROM users where username = :username";
	$query = "Update users set active=:active where username=:username";
  $stmt = $con->prepare($query);
  $stmt->bindParam(":username", $username);
  $stmt->bindParam(":active", $active);
  $stmt->execute();
//  $result =$stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($stmt)
{

echo "".$_SESSION['username']." has been successfully Deleted";


//LOG Updated profile
		$uip=$_SERVER['REMOTE_ADDR'];
		$status=0;
	 $role = "user";
	 $date_now =  date('m/d/Y h:i:s a', time());


	 $event = "User ".$username." Deleted Successfully";
	 $usernameForDb = $_SESSION['username'];
	 echo $usernameForDb;

	 // mysqli_query($con,"insert into log (username,userip,status) values('".$_SESSION['username']."','$uip','$status')");

		$stmt = $con->prepare("insert into logs (role,username,userip,event,date_posted) values(:role,:usernameForDb, :uip,:event,:date_posted)");
		//$stmt->bind_param("ssss", $username, $hashedpwd, $active, $salt);

								 $stmt->bindParam(":role", $role);
								 $stmt->bindParam(":usernameForDb",$usernameForDb);
								 $stmt->bindParam(":uip", $uip);
							 //	 $stmt->bindParam(":status", $status);
							 $stmt->bindParam(":date_posted", $date_now);

								 $stmt->bindParam(":event", $event);

		$stmt->execute();


}



}



if(isset($_POST['submit']))
{


	error_reporting(E_ALL);
	ini_set("display_errors", 1);


$loginusername = $_POST['username'];
$loginpwd = $_POST['password'];


	        $querySalt = "select salt FROM users where username = :user";
	        $stmtSalt = $con->prepare($querySalt);
	        $stmtSalt->bindParam(":user", $loginusername);
	        $stmtSalt->execute();
	        $resultSalt =$stmtSalt->fetchAll(PDO::FETCH_ASSOC);
	        //var_dump($resultSalt);

	        if(count($resultSalt) > 0){
	            foreach($resultSalt as $rowsalt){
	                $salt= $rowsalt['salt'];
	            }
	            // var_dump($salt);
	            $options = [
	                            'cost' => 11,
	                            'salt' =>  $salt,
	                        ];//got this  for http://php.net/manual/en/function.password-hash.php


	        $hashedpwd = password_hash($loginpwd, PASSWORD_BCRYPT, $options);
					$active = '1';

	        $query = "SELECT username, password FROM users where username = :username and password = :pwd and active=:active";
	        $stmt = $con->prepare($query);
	        $stmt->bindParam(":username", $loginusername);
	        $stmt->bindParam(":pwd", $hashedpwd);
					$stmt->bindParam(":active", $active);

	        $stmt->execute();
	        $result =$stmt->fetchAll(PDO::FETCH_ASSOC);
	        if (count($result) <= 0)
					{
	            $loginpwderr = urlencode("Incorrect username or password");
						//	$loginpwderr = urlencode("Incorrect username or password");
						  	//echo $loginpwderr;
								// header('location: users_login.php?loginerr='.$loginpwderr);
								$host  = $_SERVER['HTTP_HOST'];
								$_SESSION['username']=$_POST['username'];
								$uip=$_SERVER['REMOTE_ADDR'];
								$status=0;
								$role = "user";
								$date_now =  date('m/d/Y h:i:s a', time());

								$event = "Login Failed";
								$usernameForDb = $_POST['username'];
							//	mysqli_query($con,"insert into doctorslog(username,userip,status) values('".$_SESSION['username']."','$uip','$status')");

								$stmt = $con->prepare("insert into logs (role,username,userip,event,date_posted) values(:role,:usernameForDb, :uip,:event,:date_posted)");
						 	 //$stmt->bind_param("ssss", $username, $hashedpwd, $active, $salt);

						 	 $stmt->bindParam(":role", $role);
						 	 $stmt->bindParam(":usernameForDb",$usernameForDb);
						 	 $stmt->bindParam(":uip", $uip);
							 $stmt->bindParam(":date_posted", $date_now);

						 //	 $stmt->bindParam(":status", $status);
						 	 $stmt->bindParam(":event", $event);

						 	 $stmt->execute();



								$_SESSION['errmsg']="Invalid username or password";
								$extra="login.php";
								$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
								header("location:http://$host$uri/$extra");
								exit();
	        }
	        else{
	        foreach($result as $row){
	          //  $_SESSION['normaluser'] = $row['username'];

						$extra="dashboard.php";

				//		$_SESSION['username']=$_POST['username'];
						$_SESSION['username']=$row['username'];
				//		$_SESSION['id']=$num['id'];
						/*$uip=$_SERVER['REMOTE_ADDR'];
						$status=1;
						$log=mysqli_query($con,"insert into doctorslog(uid,username,userip,status) values('".$_SESSION['id']."','".$_SESSION['username']."','$uip','$status')");*/


						$uip=$_SERVER['REMOTE_ADDR'];
					  $status=0;
					 $role = "user";
					 $event = "Login Successful";
					 $usernameForDb = $_POST['username'];
					 $date_now =  date('m/d/Y h:i:s a', time());

					 // mysqli_query($con,"insert into log (username,userip,status) values('".$_SESSION['username']."','$uip','$status')");

					  $stmt = $con->prepare("insert into logs (role,username,userip,event,date_posted) values(:role,:usernameForDb, :uip,:event,:date_posted)");
					  //$stmt->bind_param("ssss", $username, $hashedpwd, $active, $salt);

					 							 $stmt->bindParam(":role", $role);
					 							 $stmt->bindParam(":usernameForDb",$usernameForDb);
					 							 $stmt->bindParam(":uip", $uip);
					 						 //	 $stmt->bindParam(":status", $status);
					 							 $stmt->bindParam(":event", $event);
												 $stmt->bindParam(":date_posted", $date_now);


					  $stmt->execute();




						$_SESSION['login']=="yes";
						$_SESSION["role"] == "user";
						$host=$_SERVER['HTTP_HOST'];
						$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
						header("location:http://$host$uri/$extra");
						exit();
	            //echo $row['fname'] . ":". $row['fname'];
	            //echo "<a href=login/login.php>test session</a>";
	        }
	        }
	        }
	        else {
	         $loginpwderr = urlencode("Incorrect username or password");
					// echo $loginpwderr;
	           // header('location: users_login.php?loginerr='.$loginpwderr);
						 $host  = $_SERVER['HTTP_HOST'];
						 //$_SESSION['username']=$_POST['username'];
						 $uip=$_SERVER['REMOTE_ADDR'];
						 $status=0;
 						$role = "user";
 						$event = "Login Failed";
 						$usernameForDb = $_POST['username'];
						$date_now =  date('m/d/Y h:i:s a', time());


						// mysqli_query($con,"insert into log (username,userip,status) values('".$_SESSION['username']."','$uip','$status')");

						 $stmt = $con->prepare("insert into logs (role,username,userip,event,date_posted) values(:role,:usernameForDb, :uip,:event,:date_posted)");
						 //$stmt->bind_param("ssss", $username, $hashedpwd, $active, $salt);

 												 	 $stmt->bindParam(":role", $role);
 												 	 $stmt->bindParam(":usernameForDb",$usernameForDb);
 												 	 $stmt->bindParam(":uip", $uip);
 												 //	 $stmt->bindParam(":status", $status);
 												 	 $stmt->bindParam(":event", $event);
													 $stmt->bindParam(":date_posted", $date_now);


						 $stmt->execute();

						 $_SESSION['errmsg']="Invalid username or password";
						 $extra="login.php";
						 $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
						 header("location:http://$host$uri/$extra");
						 exit();
	              // exit;
	        }
	    //}















//
// $ret=mysqli_query($con,"SELECT * FROM users WHERE username='".$_POST['username']."' and password='".md5($_POST['password'])."'");
// $num=mysqli_fetch_array($ret);
// if($num>0)
// {
// $extra="dashboard.php";
// $_SESSION['username']=$_POST['username'];
// $_SESSION['id']=$num['id'];
// /*$uip=$_SERVER['REMOTE_ADDR'];
// $status=1;
// $log=mysqli_query($con,"insert into doctorslog(uid,username,userip,status) values('".$_SESSION['id']."','".$_SESSION['username']."','$uip','$status')");*/
// $_SESSION['login']=="yes";
// $host=$_SERVER['HTTP_HOST'];
// $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
// header("location:http://$host$uri/$extra");
// exit();
// }
// else
// {
// $host  = $_SERVER['HTTP_HOST'];
// $_SESSION['username']=$_POST['username'];
// $uip=$_SERVER['REMOTE_ADDR'];
// $status=0;
// mysqli_query($con,"insert into doctorslog(username,userip,status) values('".$_SESSION['username']."','$uip','$status')");
// $_SESSION['errmsg']="Invalid username or password";
// $extra="login.php";
// $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
// header("location:http://$host$uri/$extra");
// exit();
//}
}
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Users Login</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
	<body class="login">
		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="logo margin-top-30">
				<a href="../../index.html">	<h2> User Login </h2></a>
				</div>

				<div class="box-login">
					<form id="myform" class="form-login" method="post">
						<fieldset>
							<legend>
								Sign in to your account
							</legend>
							<p>
								Please enter your name and password to log in.<br />
								<span style="color:red;"><?php echo $_SESSION['errmsg']; ?><?php echo $_SESSION['errmsg']="";?></span>
							</p>
							<div class="form-group">
								<span class="input-icon">
									<input type="text" class="form-control" name="username" placeholder="Username" required>
									<i class="fa fa-user"></i> </span>
							</div>
							<div class="form-group form-actions">
								<span class="input-icon">
									<input type="password" class="form-control password" name="password" placeholder="Password" required>
									<i class="fa fa-lock"></i>
									 </span>
							</div>
							<div class="form-actions">

								<button type="submit" class="btn btn-primary pull-right" name="submit">
									Login <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>


						</fieldset>
					</form>

					<div class="copyright">
						&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> E Library</span>. <span>All rights reserved</span>
					</div>

				</div>

			</div>
		</div>
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- <script src="vendor/jquery-validation/jquery.validate.min.js"></script> -->

		<script src="assets/js/main.js"></script>

		<script src="assets/js/login.js"></script>


<!--https://jqueryvalidation.org/minlength-method/-->



		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>

	</body>
	<!-- end: BODY -->
</html>
