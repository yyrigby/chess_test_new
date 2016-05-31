<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		// $this->load->view('header');
		$this->load->view('index');
	}

	public function notate_game()
	{
		$this->output->enable_profiler();
		$this->load->view('header');
		$this->load->view('notate_page');
	}

	public function paste_pgn()
	{
		$this->output->enable_profiler();
		$this->load->view('header');
		$this->load->view('paste_pgn');
	}

	public function profile()
	{
		// $this->output->enable_profiler();
		$this->load->view('header');
		$this->load->view('edit_profile');
	}

	// loading sign in page
	public function signin()
	{
		if($this->session->userdata('logged_in'))
		{
			redirect('/my_games');
		}
		$this->load->view('navbar_home');
		$this->load->view('signin');
	}

	// loading registration page
	public function register()
	{
		if($this->session->userdata('logged_in'))
		{
			redirect('/my_games');
		}
		$this->load->view('navbar_home');
		$this->load->view('register');
	}

	//loads user's personal edit profile page
	public function edit_profile()
	{
		if(!$this->session->userdata('logged_in'))
		{
			redirect('/signin');
			die();
		}
		else{
			$this->load->model('user');
			$user_info = $this->user->get_user_info($this->session->userdata('id'));
			$this->session->set_userdata('email',$user_info['email']);
			$this->session->set_userdata('first_name',$user_info['first_name']);
			$this->session->set_userdata('last_name',$user_info['last_name']);
			$this->load->view('navbar');
			$this->load->view('user_edit_profile');
		}
	}

}

// To do:
// 1. Add "saving..." image while saving to the database.
// 2. "Are you sure you want to leave the page?" if game is not saved.
// 3. add ajax to validation.