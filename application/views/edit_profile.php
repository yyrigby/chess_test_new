<!DOCTYPE html>
<head>
	<title>Edit Profile</title>
</head>
<body>
	<div class="wrapper">
		<h3>Edit Profile</h3>
		<div class="row">
			<div class="edit_box col-md-6">
				<div id="panel_box" class="panel panel-info">
					<div id="panel_heading" class="signin_heading panel-heading">
						<h3 class="panel-title">Edit Information</h3>
					</div>
					<div class="panel-body">
<?php
			if($this->session->flashdata('error_info') == TRUE){
				echo "<div class='error'>" . $this->session->flashdata('error_info') . "</div>";
			}
			if($this->session->flashdata('confirm_info') == TRUE){
				echo "<div class='confirm'>" . $this->session->flashdata('confirm_info') . "</div>";
			}
?>
						<form action="/users/edit_info" method="post">
							<label>Email Address:</label>
							<input type="text" name="email" value="<?= $this->session->userdata('email') ?>">
							<label>First Name:</label>
							<input type="text" name="first_name" value="<?= $this->session->userdata('first_name') ?>">
							<label>Last Name:</label>
							<input type="text" name="last_name" value="<?= $this->session->userdata('last_name') ?>">
							<input type="submit" class="btn btn_default btn_yellow" value="Save">
							<input type="hidden" name="edit_type" value="info">
						</form>
					</div>
				</div>
			</div>
			<div class="edit_box col-md-6">
				<div id="panel_box" class="panel panel-info">
					<div id="panel_heading" class="signin_heading panel-heading">
						<h3 class="panel-title">Change Password</h3>
					</div>
					<div class="panel-body">
<?php
			if($this->session->flashdata('error_password')){
				echo "<div class='error'>" . $this->session->flashdata('error_password') . "</div>";
			}
			if($this->session->flashdata('confirm_password')){
				echo "<div class='confirm'>" . $this->session->flashdata('confirm_password') . "</div>";
			}
?>
						<form action="/users/update_password" method="post">
							<label>Old Password:</label>
							<input type="password" name="old_password">
							<label>New Password:</label>
							<input type="password" name="new_password">
							<label>Password Confirmation:</label>
							<input type="password" name="confirm_password">
							<input type="submit" class="btn btn_default btn_yellow" value="Update Password">
							<input type="hidden" name="edit_type" value="password">
						</form>
					</div>
				</div>
			</div>
		</div> <!-- End of row -->
	</div>
</body>
</html>