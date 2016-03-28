<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {
	public function add_user($user_data) {
		$query = "INSERT INTO users (email, first_name, last_name, password, user_level, created_at, updated_at) VALUES (?,?,?,?,?,NOW(),NOW())";
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
			'user_level' => $user_level
			);
		$this->db->query($query, $array);
		$array['id'] = $this->db->insert_id();
		return $array;
	}

	public function login($user_data) {
		$query = "SELECT * FROM users WHERE email = ?";
		$existing_user = $this->db->query($query, $user_data['email'])->row_array();
		if($existing_user['email'] == $user_data['email'])
		{
			return $existing_user;
		}
	}

	public function get_all_users()
	{
		$query = "SELECT * from users ORDER BY id DESC";
		$user_list = $this->db->query($query)->result_array();
		return $user_list;
	}
	
	public function get_user_info($val)
	{
		$query = "SELECT * from users WHERE id = " . $val;
		$user_info = $this->db->query($query)->row_array();
		return $user_info;
	}

	// removes a user from database and all messages and comments written to/by the user
	public function remove_user($user_id)
	{
		// delete comments written to or by the user
		$query = "DELETE from comments WHERE profile_id = " . $user_id . " or writer_id = " . $user_id;
		$this->db->query($query);
		// delete messages written to or by the user
		$query = "DELETE from messages WHERE profile_id = " . $user_id . " or writer_id = " . $user_id;
		$this->db->query($query);
		// delete the user
		$query = "DELETE from users WHERE id = " . $user_id;
		$this->db->query($query);
	}

	public function update_info($updated_info)
	{
		$user_level_query = "";
		if($updated_info['user_id'])
		{
			if($updated_info['user_level'] == "9")
				{ $user_level_query = ", user_level = 9"; }
			else { $user_level_query = ", user_level = 1"; }
		}
		$query = "UPDATE users SET email = ?, first_name = ?, last_name = ?" . $user_level_query . ", updated_at = NOW() WHERE id = ?";
		$id = $this->session->userdata('id');
		if($updated_info['user_id'])
		{
			$id = $updated_info['user_id'];
		}
		$array = array($updated_info['email'], $updated_info['first_name'], $updated_info['last_name'], $id);
		$this->db->query($query, $array);
	}

	public function update_password($password)
	{
		$query = "UPDATE users SET password = ? WHERE id = ?";
		$id = $this->session->userdata('id');
		if($updated_info['user_level'])
		{
			$id = $updated_info['user_level'];
		}
		$array = array($password, $id);
		$this->db->query($query, $array);
	}

	public function update_description($description)
	{
		$query = "UPDATE users SET description = ? WHERE id = ?";
		$array = array($description, $this->session->userdata('id'));
		$this->db->query($query, $array);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */