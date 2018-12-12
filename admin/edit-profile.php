<?php

session_start();
//error_reporting(0);



include('include/config.php');
include('include/checklogin.php');
//include('include/checkTimeout.php');
//check_login();

$username = $_SESSION['username'];


error_reporting(E_ALL);
ini_set("display_errors", 1);

if(isset($_POST['updateReg']))
{


//$sql=mysqli_query($con,"Update users set fullName='$fname',address='$address',city='$city',gender='$gender' where id='".$_SESSION['id']."'");
$password = $_POST['password'];



$stmt = $con->prepare("Update users set password=:hashedpwd, salt=:salt where username=:usernameForDb");

// if($stmt)
// {

	//$stmt->bind_param("ssss", $username, $hashedpwd, $active, $salt);


	$options = [
										 'cost' => 11,
										 'salt' =>  mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
							];//got this random generator for http://php.net/manual/en/function.password-hash.php
	$salt = $options['salt'];
	$hashedpwd = password_hash($password, PASSWORD_BCRYPT, $options);


	$stmt->bindParam(":usernameForDb", $username);
	$stmt->bindParam(":salt", $salt);


	$stmt->bindParam(":hashedpwd", $hashedpwd);

							 // $stmt->bindParam(":event", $event);

	$stmt->execute();
	if($stmt)
	{
echo "Password for ".$username." updated successfully";

//LOG Updated profile
		$uip=$_SERVER['REMOTE_ADDR'];
		$status=0;
	 $role = "user";
	 $date_now =  date('m/d/Y h:i:s a', time());


	 $event = "Password Updated for User ".$username." ";
	 $usernameForDb = $_SESSION['username'];
	 echo $usernameForDb;

	 // mysqli_query($con,"insert into log (username,userip,status) values('".$_SESSION['username']."','$uip','$status')");

		$stmt2 = $con->prepare("insert into logs (role,username,userip,event,date_posted) values(:role,:usernameForDb, :uip,:event,:date_posted)");
		//$stmt->bind_param("ssss", $username, $hashedpwd, $active, $salt);

								 $stmt->bindParam(":role", $role);
								 $stmt->bindParam(":usernameForDb",$usernameForDb);
								 $stmt->bindParam(":uip", $uip);
							 //	 $stmt->bindParam(":status", $status);
							 $stmt->bindParam(":date_posted", $date_now);

								 $stmt->bindParam(":event", $event);

		$stmt->execute();
	}






// $msg="Your Profile was updated Successfully";


//}

}
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
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />


	</head>
	<body>
		<div id="app">
<?php include('include/sidebar.php');?>
			<div class="app-content">


				<?php include('../headerMain.php');?>
						<script src="assets/js/regFormUpdate.js"></script>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">User | Edit Profile</h1>
																	</div>
								<ol class="breadcrumb">
									<li>
										<span>User </span>
									</li>
									<li class="active">
										<span>Edit Profile</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
<h5 style="color: green; font-size:18px; ">
<?php //if($msg) {  htmlentities($msg);}?> </h5>
									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Edit Profile</h5>
												</div>
												<div class="panel-body">
									<?php
//$sql=mysqli_query($con,"select * from users where id='".$_SESSION['id']."'");
//while($data=mysqli_fetch_array($sql))
$active = "1";

$sql = "select * from users  where username=:username and active = :active";
$stmt = $con->prepare($sql);
$stmt->bindParam(":username", $username);
$stmt->bindParam(":active", $active);

$stmt->execute();
//while($data =$stmt->fetchAll(PDO::FETCH_ASSOC))
$result =$stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $data):

//{
?>
	<form role="form" name="edit" method="post" action="edit-profile.php">


<div class="form-group form-actions">
		<span class="input-icon">
															<label for="fnameEdit">
																 User Name
															</label>
	<!-- <input type="text" name="fname" class="form-control" value="<?php//  htmlentities($data['username']);?>"> -->
	<input type="text" name="fnameEdit" class="form-control" value="<?php echo  $username;?>">

		</div>


		<div class="form-group form-actions">
		<span class="input-icon">






				<div class="form-group">
																			<!-- <label class="control-label col-sm-3" for="pwd">Password:</label> -->
					<label for="Password">New Pasword:</label>

																			<!-- <div class="col-sm-6"> -->
																					<input type="password" class="form-control errortxt" id="pwd" name="Password" placeholder="Enter New password" data-toggle="tooltip" title="Ensure that you enter a combination of at least ten characters, containing lowercase and uppercase letters, numbers, and special characters">
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
																					<input type="password" class="form-control errortxt" id="repwd" name="repwd" placeholder="Re-Enter New password">
																					<span class="error"><?php if(isset($repwderr))echo $repwderr;?></span>


																			<!-- </div> -->

																			<label class="control-label error" for="repwd" id="repwdErr"></label>
																		</div>




																		<!-- <button type="submit" name="submitReg" id="submitReg" class="btn btn-o btn-primary">
																		Register
																		</button> -->






																</div>

														<button type="submit" name="update" id="updateReg" class="btn btn-o btn-primary">
															Update
														</button>

															</form>

															<br>
															<br>



	<!-- <form method="post" action="login.php">


														<button type="submit" id="delete" name="delete" class="deleter">

															<!-- <a  id="delete" class="deleter" href="login.php" name="delete" class="btn btn-o btn-danger" onclick="confirmDelete()">Delete Profile</a> -->
															<!-- <a id="delete" class="deleter" href="login.php" name="delete" class="btn btn-o btn-danger">Delete Profile</a> -->



														 <!-- Delete Profile -->
														<!-- </button> -->

													<!-- </form> -->
<script>
// function	confirmDelete()
// {
// var r = confirm("Confirm Delete??");
// if (r == true) {
//
// } else {
// 	// document.getElementById("delete").addEventListener("click", function(event){
// 	//     event.preventDefault()
// 	return false;
// }
//
//  // return confirm("Are you sure you want to delete?");
//
// }

// function	confirmDelete()
// {
// if (confirm("Are you sure you want to delete?"))
// {
// return true;
//
// }
// else {
// 	return false;
// }
//
// }
</script>

<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
    $("button.deleter").click(function(e){
        if(!confirm('Are you sure?')){
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>



													<!-- </form> -->
	<?php endforeach ?>
												</div>
											</div>
										</div>

											</div>
										</div>
									<div class="col-lg-12 col-md-12">
											<div class="panel panel-white">


											</div>
										</div>
									</div>
								</div>

						<!-- end: BASIC EXAMPLE -->






						<!-- end: SELECT BOXES -->

					</div>
				</div>
			</div>
			<!-- start: FOOTER -->
	<?php include('include/footer.php');?>
			<!-- end: FOOTER -->

			<!-- start: SETTINGS -->
	<?php include('include/setting.php');?>

			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
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
		<script src="assets/js/form-elements.js"></script>
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
