<?php
session_start();


//error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
//check_login();

	$usernameerr = "";
if(isset($_POST['submitReg']))
{
$active = "1";
	$username = $_POST['username'];

$stmtS = $con->prepare("select username from users where username = :username and active = :active");
$stmtS->bindParam(":username", $username);
$stmtS->bindParam(":active", $active);

$stmtS->execute();
$resultS = $stmtS->fetchAll(PDO::FETCH_ASSOC);


if(count($resultS) > 0) {

	//	$usernameerr = "User name '".$username."' already exists, Please try another";

	$usernameerr =	"<div class='alert alert-danger'>
User name <strong> ".$username."</strong> already exists, Please try another
 </div>";

}
else
{

		error_reporting(E_ALL);
		ini_set("display_errors", 1);
	$username=$_POST['username'];
	$password=$_POST['Password'];
	$active='1';

	// $c=$_POST['city'];
	// $gender=$_POST['gender'];

	// $sql=mysqli_query($con,"insert into users fullName='$fname',address='$address',city='$city',gender='$gender' where id='".$_SESSION['id']."'");
	//
	//
	// if($sql)
	// {
	// /*$msg="Your Profile updated Successfully";*/
	//
	//
	// }


	$options = [
										 'cost' => 11,
										 'salt' =>  mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
								 ];//got this random generator for http://php.net/manual/en/function.password-hash.php
	$salt = $options['salt'];
	$hashedpwd = password_hash($password, PASSWORD_BCRYPT, $options);


	$stmt = $con->prepare("insert into users (username, password, active, salt) VALUES (:username,:hashedpwd,:active,:salt)");
	//$stmt->bind_param("ssss", $username, $hashedpwd, $active, $salt);
	$stmt->bindParam(":username", $username);
	$stmt->bindParam(":hashedpwd", $hashedpwd);
	$stmt->bindParam(":active", $active);
	$stmt->bindParam(":salt", $salt);

	$stmt->execute();

	$usernameerr =	"<div class='alert alert-success'>
New User <strong>".$username."</strong> created successfully, Please proceed to Login page to login with your new credentials
 </div>";
//	echo "New User created successfully, You can Login Now";


}
}
// if(isset($_POST['submitReg']))
// {
//
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
//
// // $stmt->close();
// // $con->close();
//
// }


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User | Edit Profile</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
<!--   		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
 --> 		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
  		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
 		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
<!-- 		<link rel="stylesheet" href="assets/css/styles.css">
 -->		<link rel="stylesheet" href="assets/css/plugins.css">
	 	<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

<?php include('../headerMain.php');?>
		<script src="assets/js/regForm.js"></script>



	</head>
	<body>



				<!-- end: TOP NAVBAR -->

					<div class="container">

	<!-- start: PAGE TITLE -->

							<div class="row">

	 <div class="col-2">

</div>

 <div class="col-8">

<?php
//echo $usernameerr;

?>
	 <!-- <div class="alert alert-danger">
<strong>Success!</strong> Indicates a successful or positive action.
</div> -->

<br>
<?php
echo $usernameerr;
?>
					<!--<div class="col-sm-8">-->
									<h1 class="mainTitle">User |Register </h1>
					<!--</div>-->
								<!-- <ol class="breadcrumb">
									<li>
										<span>User </span>
									</li>
									<li class="active">
										<span>Register User</span>
									</li>
								</ol> -->



						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<!--<div class="container-fluid container-fullw bg-white">-->
						<!--	<div class="row">-->
								<!--<div class="col-md-12">-->
<h5 style="color: green; font-size:18px; ">
</h5>
									<!--<div class="row margin-top-30">-->
										<!--<div class="col-lg-8 col-md-12">-->

											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Register User</h5>
												</div>
												<div class="panel-body">

						<form role="form" name="edit" method="post" action="Register.php">


<div class="form-group">
															<label for="username">
																 Username
															</label>
	<input type="text" name="username" class="form-control" required>
														</div>


<!-- <div class="form-group">
															<label for="Password">
																Password
															</label>
					<input name="Password" type="Password" class="form-control" required>
														</div>
<div class="form-group">
															<label for="confirmPassword">
																 Confirm Password
															</label>
		<input name="confirmPassword" type="Password" class="form-control" required>
														</div> -->


<div class="form-group">
															<!-- <label class="control-label col-sm-3" for="pwd">Password:</label> -->
	<label for="Password"> Pasword:</label>

															<!-- <div class="col-sm-6"> -->
															<input type="password" class="form-control errortxt" id="pwd" name="Password" placeholder="Enter password" data-toggle="tooltip" title="Ensure that you enter a combination of at least ten characters, containing lowercase and uppercase letters, numbers, and special characters .">
																	<span class="error"><?php if(isset($pwderr))echo $pwderr;?></span>
																<div class="progress">
																		<div class="progress-bar"  ></div>
																</div>

																<span><label class="control-label error" for="Password" id="pwdstatus"></label></span>
															<!-- </div> -->

															<label class="control-label error" for="Password" id="pwdErr"></label>
				</div>




														<div class="form-group">
															<!-- <label class="control-label col-sm-3" for="repwd">Re-Enter Password:</label> -->
															<label for="Password"> Re-Enter Pasword:</label>

															<!-- <div class="col-sm-6"> -->
																	<input type="password" class="form-control errortxt" id="repwd" name="repwd" placeholder="Re-Enter password">
																	<span class="error"><?php if(isset($repwderr))echo $repwderr;?></span>


															<!-- </div> -->

															<label class="control-label error" for="repwd" id="repwdErr"></label>
														</div>




														<button type="submit" name="submitReg" id="submitReg" class="btn btn-o btn-primary">
														Register
														</button>

													</form>




												</div>


											</div>
										<!--</div>-->

											<!--</div>-->
										<!--</div>-->
									<!-- <div class="col-lg-12 col-md-12">
											<div class="panel panel-white">


											</div>
										</div> -->
									<!--</div>-->
								<!--</div>-->

						<!-- end: BASIC EXAMPLE -->



						<?php include('include/footer.php');?>

</div>

						<!-- end: SELECT BOXES -->



						</div>


					</div>

			<!-- start: FOOTER -->
			<!-- end: FOOTER -->

			<!-- start: SETTINGS -->
	<!-- <?php //include('include/setting.php');?> -->

			<!-- end: SETTINGS -->



		<!-- start: MAIN JAVASCRIPTS -->

		<script src="vendor/jquery/jquery.min.js"></script>
		<!-- <script src="vendor/bootstrap/js/bootstrap.min.js"></script> -->
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<!-- <script src="assets/js/form-elements.js"></script> -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
