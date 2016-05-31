<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	// validates post data for adding new users
	public function validate() {
		$errors = "";
		$this->load->library("form_validation");	
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email|is_unique[users.email]");
		$this->form_validation->set_rules("first_name", "First Name", "trim|required");
		$this->form_validation->set_rules("last_name", "Last Name", "trim|required");
		$this->form_validation->set_rules("password", "Password", "trim|required|min_length[8]");
		$this->form_validation->set_rules("confirm_password", "Password Confirmation", "trim|required|matches[password]");
		if($this->form_validation->run() === FALSE)
		{ 
			return validation_errors();
		}
	}

	// after registering new users, it automatically logs in and directs to my_games
	public function register() {
		$this->load->model('user');
		$errors = $this->validate();
		if(!empty($errors))
		{
		     $this->session->set_flashdata('error_register',$errors);
		     redirect('/');
		     die();
		}
		else
		{
			$login_data = $this->add_new_user();
			if($login_data) {
				$session_values = array('first_name' => $login_data['first_name'],
										'last_name' => $login_data['last_name'],
										'email' => $existing_user['email'],
										'user_level' => $login_data['user_level'],
										'logged_in' => TRUE,
										'user_id' => $login_data['id']);
				$this->session->set_userdata($session_values);
			}
			redirect('/my_games');
		}
	}

	// controller that connects to model that adds new users to the database
	public function add_new_user() {
		$user_data = $this->input->post();
		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$user_data['password'] = md5($user_data['password']."".$salt);
		$user_data['salt'] = $salt;
		$login_data = $this->user->add_user($user_data);
		return $login_data;
	}

	// validates the post date, compares the email to database, directs to my_games after setting session if password matches
	public function login() {
		$this->output->enable_profiler();
		$this->load->model('user');
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
		$this->form_validation->set_rules("password", "Password", "trim|required");
		if($this->form_validation->run() === FALSE)
		{
		     $this->session->set_flashdata('error_signin',validation_errors());
		     redirect('/');
		     die();
		}
		else
		{
			$user_data = $this->input->post();
			$existing_user = $this->user->login($user_data['email']);
			$encrypted_password = md5($user_data['password']."".$existing_user['salt']);
			if($existing_user && $existing_user['password'] == $encrypted_password)
			{
				$session_values = array('first_name' => $existing_user['first_name'],
										'last_name' => $existing_user['last_name'],
										'email' => $existing_user['email'],
										'user_level' => $existing_user['user_level'],
										'logged_in' => TRUE,
										'user_id' => $existing_user['id']);
				$this->session->set_userdata($session_values);
				redirect('/my_games');
				die();
			}
			elseif($existing_user && $existing_user['password'] != $user_data['password'])
			{
				$this->session->set_flashdata('error_signin','<p>Email and password does not match</p>');
			}
			elseif(!$existing_user)
			{
				$this->session->set_flashdata('error_signin','<p>User does not exist. Please register.</p>');
			}
			var_dump($user_data);
			var_dump($existing_user);
			var_dump($encrypted_password);
			redirect('/');
		}
	}

	// Log off and go back to home
	public function logoff()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

	public function edit_info() {
		$this->load->model('user');
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
		$this->form_validation->set_rules("first_name", "First Name", "trim|required");
		$this->form_validation->set_rules("last_name", "Last Name", "trim|required");

		if($this->form_validation->run() === FALSE)
		{
		     $this->session->set_flashdata('error_info',validation_errors());
		     redirect('/profile');
		     die();
		}
		else
		{
			$updated_info = $this->input->post();
			$this->user->update_info($updated_info);
			$this->session->set_userdata('email',$updated_info['email']);
			$this->session->set_userdata('first_name',$updated_info['first_name']);
			$this->session->set_userdata('last_name',$updated_info['last_name']);
			$this->session->set_flashdata('confirm_info','<p>The information was successfully updated.</p>');
			redirect('/profile');
		}	
	}

	public function update_password() {
		$this->load->model('user');
		$password_data = $this->input->post();
		$existing_user = $this->user->login($this->session->userdata('email'));
		$encrypted_password = md5($password_data['old_password']."".$existing_user['salt']);
		if($existing_user && $existing_user['password'] !== $encrypted_password)
		{
			$this->session->set_flashdata('error_password', "<p>Wrong password</p>");
		    redirect('/profile');
		    die();
		} else {
			$this->load->library("form_validation");
			$this->form_validation->set_rules("new_password", "Password", "trim|required|min_length[8]");
			$this->form_validation->set_rules("confirm_password", "Password Confirmation", "trim|required|matches[new_password]");
			if($this->form_validation->run() === FALSE)
			{
			    $this->session->set_flashdata('error_password',validation_errors());
			    redirect('/profile');
			    die();
			} else {
				$salt = bin2hex(openssl_random_pseudo_bytes(22));
				$user_data['salt'] = $salt;
				$user_data['password'] = md5($this->input->post('new_password')."".$salt);
				$this->user->update_password($user_data);
				$this->session->set_flashdata('confirm_password','<p>The password was successfully updated.</p>');
				redirect('/profile');
			} 
		}	
	}


}
