<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
	public function add_user($user_data) {
		$query = "INSERT INTO users (email, first_name, last_name, password, salt, user_level, created_at, updated_at) VALUES (?,?,?,?,?,?,NOW(),NOW())";
		if($this->db->count_all('users') == 0){ 
			$user_level = 9;
		}
		else { 
			$user_level = 1;
		}
		$array = array(
			'email' => $user_data['email'],
			'first_name' => $user_data['first_name'],
			'last_name' => $user_data['last_name'],
			'password' => $user_data['password'],
			'salt' => $user_data['salt'],
			'user_level' => $user_level
			);
		$this->db->query($query, $array);
		$array['id'] = $this->db->insert_id();
		return $array;
	}

	public function login($email) {
		$query = "SELECT * FROM users WHERE email = ?";
		$existing_user = $this->db->query($query, $email)->row_array();
		if($existing_user['email'] == $email)
		{
			return $existing_user;
		}
	}

	public function update_info($updated_info)
	{
		$query = "UPDATE users SET email = ?, first_name = ?, last_name = ?, updated_at = NOW() WHERE id = ?";
		$id = $this->session->userdata('user_id');
		$array = array($updated_info['email'], $updated_info['first_name'], $updated_info['last_name'], $id);
		$this->db->query($query, $array);
	}

	public function update_password($user_data)
	{
		$query = "UPDATE users SET password = ?, salt = ? WHERE id = ?";
		$id = $this->session->userdata('user_id');
		$array = array('password' => $user_data['password'], 
						'salt' => $user_data['salt'],
						'id' => $id);
		$this->db->query($query, $array);
	}

	public function update_description($description)
	{
		$query = "UPDATE users SET description = ? WHERE id = ?";
		$array = array($description, $this->session->userdata('id'));
		$this->db->query($query, $array);
	}
}
