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

	// after registering new users, it automatically logs in and directs to dashboard
	public function register() {
		$this->load->model('user');
		$errors = $this->validate();
		if(!empty($errors))
		{
		     $this->session->set_flashdata('error',$errors);
		     redirect('/register');
		     die();
		}
		else
		{
			$login_data = $this->add_new_user();
			if($login_data) {
				$this->session->set_userdata('name', $login_data['first_name'] . " " . $login_data['last_name']);
				$this->session->set_userdata('user_level', $login_data['user_level']);
				$this->session->set_userdata('logged_in', TRUE);
				$this->session->set_userdata('id', $login_data['id']);
			}
			redirect('/dashboard');
		}
	}

	// lets admins add new users and confirms that the user was added
	public function admin_register() {
		$this->load->model('user');
		$errors = $this->validate();
		if(!empty($errors))
		{
		     $this->session->set_flashdata('error',validation_errors());
		     redirect('/users/new');
		     die();
		}
		else
		{
			$added = $this->add_new_user();
			if($added)
			{
				$this->session->set_flashdata('confirm','New user '.$added['first_name'].' was successfully added.');
				redirect('/users/new');
			}
		}
	}

	// controller that connects to model that adds new users to the database
	public function add_new_user() {
		$user_data = $this->input->post();
		$user_data['password'] = md5($user_data['password']);
		$login_data = $this->user->add_user($user_data);
		return $login_data;
	}

	// Allows admin to remove a user
	public function remove_user($user_id) {
		if(!$this->session->userdata('logged_in'))
		{
			redirect('/signin');
			die();
		}
		if($this->session->userdata('user_level') != 9)
		{
			redirect('/dashboard');
			die();
		}
		else{
			$this->load->model('user');
			$this->user->remove_user($user_id);
			redirect('/dashboard');
		}
	}

	// validates the post date, compares the email to database, directs to dashboard after setting session if password matches
	public function login() {
		$this->load->model('user');
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
		$this->form_validation->set_rules("password", "Password", "trim|required");
		if($this->form_validation->run() === FALSE)
		{
		     $this->session->set_flashdata('error',validation_errors());
		     redirect('/signin');
		     die();
		}
		else
		{
			$user_data = $this->input->post();
			$user_data['password'] = md5($user_data['password']);
			$existing_user = $this->user->login($user_data);
			if($existing_user && $existing_user['password'] == $user_data['password'])
			{
				$this->session->set_userdata('name', $existing_user['first_name'] . " " . $existing_user['last_name']);
				$this->session->set_userdata('id', $existing_user['id']);
				$this->session->set_userdata('first_name', $existing_user['first_name']);
				$this->session->set_userdata('last_name', $existing_user['last_name']);
				$this->session->set_userdata('email', $existing_user['email']);
				$this->session->set_userdata('user_level', $existing_user['user_level']);
				$this->session->set_userdata('description', $existing_user['description']);
				$this->session->set_userdata('created_at', $existing_user['created_at']);
				$this->session->set_userdata('logged_in', TRUE);
				redirect('/dashboard');
				die();
			}
			elseif($existing_user && $existing_user['password'] != $user_data['password'])
			{
				$this->session->set_flashdata('error','Email and password does not match');
			}
			elseif(!$existing_user)
			{
				$this->session->set_flashdata('error','User does not exist. Please register.');
			}
			redirect('/signin');
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
		     redirect('/users/edit');
		     die();
		}
		else
		{
			$updated_info = $this->input->post();
			$this->user->update_info($updated_info);
			$this->session->set_userdata('email',$updated_info['email']);
			$this->session->set_userdata('first_name',$updated_info['first_name']);
			$this->session->set_userdata('last_name',$updated_info['last_name']);
			$this->session->set_flashdata('confirm_info','The information was successfully updated.');
			redirect('/users/edit');
		}	
	}

	public function admin_edit_info() {
		$this->load->model('user');
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
		$this->form_validation->set_rules("first_name", "First Name", "trim|required");
		$this->form_validation->set_rules("last_name", "Last Name", "trim|required");

		if($this->form_validation->run() === FALSE)
		{
		     $this->session->set_flashdata('error_info',validation_errors());
		     redirect('/users/edit');
		     die();
		}
		else
		{
			$updated_info = $this->input->post();
			$this->user->update_info($updated_info);
			$this->session->set_userdata('email',$updated_info['email']);
			$this->session->set_userdata('first_name',$updated_info['first_name']);
			$this->session->set_userdata('last_name',$updated_info['last_name']);
			$this->session->set_flashdata('confirm_info','The information was successfully updated.');
			redirect('/admin/edit/' . $updated_info['user_id']);
		}	
	}

	public function update_password() {
		$this->load->model('user');
		$this->load->library("form_validation");
		$this->form_validation->set_rules("password", "Password", "trim|required|min_length[8]");
		$this->form_validation->set_rules("confirm_password", "Password Confirmation", "trim|required|matches[password]");
		if($this->form_validation->run() === FALSE)
		{
		     $this->session->set_flashdata('error_password',validation_errors());
		     redirect('/users/edit');
		     die();
		}
		else
		{
			$password = md5($this->input->post('password'));
			$this->user->update_password($password);
			$this->session->set_flashdata('confirm_password','The password was successfully updated.');
			redirect('/users/edit');
		}	
	}

	public function update_description() {
		$this->load->model('user');
		$description = $this->input->post('description');
		$this->user->update_description($description);
		$this->session->set_userdata('description', $description);
		$this->session->set_flashdata('confirm_description','Your description was successfully updated.');
		redirect('/users/edit');
	}

}
