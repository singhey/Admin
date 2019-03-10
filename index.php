<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
</head>
<body>
	<?php
		require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/common.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/connection.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/functions.php');
		if($_SERVER['REQUEST_METHOD']==='POST'){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$db = $_POST['database'];
			$result = _query("SELECT * FROM admin where username = '$username' AND password = '$password' AND db = '$db' ");
			if(mysqli_num_rows($result) == 1){
				$_SESSION['admin_name'] = $username;
				$_SESSION['database'] = $db;
			}else{
				echo "<p style='text-align:center;color:red'>ACCESS DENIED</p>";
			}
		}
		if(!isset($_SESSION['admin_name'])):
	?>
		<!-- login form for admin -->
		<style type="text/css">
			* {
				box-sizing: border-box;
			}

			body {
				padding: 0;
				margin: 0;
				background: #C9C9C9;
				color: #fff;
				font-family: 'Ubuntu', sans-serif;
			}
			a{
				text-decoration: none;
			}
			#wrapper {
				width: 430px;
				background: url('/admin/assets/img/background.jpg');
				margin: 25px auto;
				padding: 64px;
				background-size: cover;
				position: relative;
				z-index: 1;
				box-shadow: 0px 15px 20px 0px rgba(128, 128, 128, 0.76);
			}

			#wrapper:before {
				content: "";
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				background: rgba(0, 0, 0, .64);
				z-index: -1;
			}

			#table {
				margin-bottom: 6em;
			}

			#table a {
				text-transform: uppercase;
				margin-right: 40px;
				padding: 11px 4px;
				color: #bbb;
				cursor: pointer
			}

			#table a.active {
				border-bottom: 1.5px solid #1061EE;
				color: #fff;
			}

			label {
				display: block
			}

			form {
				margin-bottom: 3.3em;
			}

			.form-group {
				position: relative;
				margin-bottom: 16px;
			}

			.form-group label {
				display: block;
				margin-bottom: 6px;
				font-size: 14px;
				margin-left: 14px;
				color: #bbb;
			}

			input {
				width: 100%;
				background: rgba(0, 0, 0, 0.42);
				outline: none;
				padding: 10px 14px;
				color: #fff;
				border: none;
				border-radius: 36px;
				font-family: 'Ubuntu', sans-serif;
				font-size: 16px;
				transition: background 0.5s ease-in-out;
			}
			span#showpwd {
			    position: absolute;
			    top: 32px;
			    right: 16px;
			    cursor: pointer;
			}
			input:focus {
				background: rgba(0, 0, 0, 0.6);
			}

			input[type="submit"] {
				background: #1061EE;
				margin-top: 14px;
				cursor: pointer;
			}

			#checkbox {
				color: #fff;
				cursor: pointer;
				font-size: 16px
			}

			#checkbox input+.text:before {
				content: "\f096";
				display: inline-block;
				font: normal normal normal 14px/1 FontAwesome;
				font-size: inherit;
				text-rendering: auto;
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
				margin-right: 6px;
				width: 1em;
			}

			#checkbox input:checked+.text:before {
				content: "\f14a";
				color: #1061ee;
				animation: scalecheck 0.1s
			}

			#checkbox input {
				display: none;
			}

			@-webkit-keyframes scalecheck {
				0% {
					transform: scale(0);
				}
				90% {
					transform: scale(1.4);
				}
				100% {
					transform: scale(1);
				}
			}

			.hr {
				height: 1.4px;
				background: rgba(128, 128, 128, 0.51);
				border-radius: 17px;
				margin-bottom: 33px;
			}

			#froget-pass {
				text-align: center;
				color: #bbb;
				margin: 0;
				display: block;
			}

			@media screen and (max-width :490px) {
				body {
					display: table;
					width: 100%;
				}
				#wrapper {
					width: auto;
					height: 100vh;
					margin: 0;
					display: table-cell;
					vertical-align: middle;
				}
			}

			@media screen and (max-width :490px) {
				#wrapper {
					padding: 28px;
				}
			}
		</style>
		<div id="wrapper">
			<div id="table">
				<a class="active" style="">Sign in</a>
			</div>
			<div id="signin">
				<form action="#" method="POST">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" id="username" autofocus name="username">
					</div>
					<div class="form-group">
						<label for="pass">Password</label>
						<input type="password" id="pass" name="password">
					</div>
					<div class="form-group">
						<label for="username">Database</label>
						<input type="text" id="username" autofocus name="database">
					</div>
					<div class="form-group">
						<input type="submit" value="Sign in">
					</div>
				</form>
			</div>
		</div>
	<?php
			exit;
		endif;
		#user looged in now display table and ask to click
	?>
	<link rel="stylesheet" type="text/css" href="/admin/assets/css/index.css">
	<div class="all-wrapper">
		<h1>Tables</h1>
		<?php
			$tables = _query("SHOW tables");
			while($t = $tables->fetch_assoc()):
				$key = 'Tables_in_'.$_SESSION['database'];
		?>
		<div class="_holder"><a href="/admin/sql.php?table=<?php echo $t[$key]; ?>&pos=0"><?php echo $t[$key]; ?></a></div>
		<?php 
			endwhile;
		?>
	</div>
</body>
</html>