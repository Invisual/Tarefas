<?php include('headers.php'); ?>
<title>INVISUAL</title>


<style>
.btn-primary{
	background-color:#2f323a !important;
	-webkit-transition: all .2s ease-in-out;
	-moz-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;
	color:#fff !important;
	border:none !important;
	border-radius:14px !important;
}

.form-control{
    border-radius:14px !important;
}

.btn-primary:hover{
	background-color:#5093e1 !important;
	border:none !important;
}

.account-wall{
	background-color:#fff;
	border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}

body{
	background-color:black;
	background-image: url("img/home.jpg");
	background-size: cover;
	min-height:100vh;
}

</style>


<?php
;
session_start();
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');


if (empty($myControlPanel)) {

	try {

	$myControlPanel = new classes_ControlPanel();

	$myControlPanel->setMyDb(classes_DbManager::ob());

	$myDbManager = $myControlPanel->getMyDb();

	}


	catch (Exception $e) {

		echo $e->getMessage();
		die();
	}
}

if($_SESSION['logged_in']==1){
	header('location:index.php');
}

if(!empty($_POST)){
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	try{
		$log = new classes_UserManager($myControlPanel);
		$logresult = $log->login($username, $password);
	}
	catch (invalidArgumentException $e){
		$e->getMessage();
	}
	
}





?>





<body>




<div class="container">
    <div class="row" style="margin-top:20vh;">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <img class="img-responsive" style="margin:0 auto; padding-top:35px;" src="img/logonew2.png" alt="Logo"/>
                <form class="form-signin" action="" method="POST" style="padding-bottom:35px;">
                <input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
                <input style="margin-top:12px;" type="password" class="form-control" placeholder="Password" name="password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="submit">
                    Sign in</button>
                </form>
            </div>
           
        </div>
    </div>
</div>

</body>

</html>