<!DOCTYPE html>
<head>
	<title>Al's Chess Notation</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../assets/css/normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/styles.css">
	<script>
	$(document).ready(function() {
		$('#signin_below').click(function(){
			$("html, body").animate({ scrollTop: $(document).height() }, "slow");
		    $('#signin_email').focus();
		});
	});
	</script>
</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<h1>Al's Chess Notations</h1>
			<div class="row">
				<p class="col-sm-6 col-md-8">Welcome! Al's Chess Notation is an online platform that allows you to load/save your pgn and add comments/notes to allow easy self-analysis of your chess games.</p>
			</div>
			<p><a id="signin_below" class="btn btn-primary btn-lg" role="button">Sign in Below</a></p>
			<p><a href="/notate" id="big_button" class="btn btn-primary btn-lg" role="button">Notate without Signing In</a></p>
		</div>
	</div>
	<div class="row">
		<div class="box col-md-6">
			<div id="panel_box" class="panel panel-info">
				<div id="panel_heading" class="signin_heading panel-heading">
					<h3 class="panel-title">Sign in</h3>
				</div>
				<div class="panel-body">
	<?php
		if($this->session->flashdata('error_signin')){
			echo "<div class='error'>" . $this->session->flashdata('error_signin') . "</div>";
		}
		?>
					<form action="/users/signin" method="post">
						<label>Email Address:</label>
						<input id="signin_email" type="text" name="email">
						<label>Password:</label>
						<input type="password" name="password">
						<input type="submit" class="btn btn_default btn_yellow" value="Sign In">
					</form>
				</div>
			</div>
		</div> <!-- End of Wrapper Sign in -->
		<div class="box col-md-6">
			<div id="panel_box2" class="panel panel-info">
				<div id="panel_heading2" class="signin_heading panel-heading">
					<h3 class="panel-title">Register</h3>
				</div>
				<div class="panel-body">
	<?php
		if($this->session->flashdata('error_register')){
			echo "<div class='error'>" . $this->session->flashdata('error_register') . "</div>";
		}
	?>
			<form action="/users/register" method="post">
				<label>Email Address:</label>
				<input type="text" name="email">
				<label>First Name:</label>
				<input type="text" name="first_name">
				<label>Last Name:</label>
				<input type="text" name="last_name">
				<label>Password:</label>
				<input type="password" name="password">
				<label>Password Confirmation:</label>
				<input type="password" name="confirm_password">
				<input type="submit" class="btn btn_default btn_yellow" value="Create">
			</form>
		</div> <!-- End of Wrapper Register -->
	</div>
</body>
</html>