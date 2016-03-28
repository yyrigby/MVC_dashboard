<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	// Loading home page
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			redirect('/dashboard');
		}
		$this->load->view('navbar_home');
		$this->load->view('home');
	}

	// loading sign in page
	public function signin()
	{
		if($this->session->userdata('logged_in'))
		{
			redirect('/dashboard');
		}
		$this->load->view('navbar_home');
		$this->load->view('signin');
	}

	// loading registration page
	public function register()
	{
		if($this->session->userdata('logged_in'))
		{
			redirect('/dashboard');
		}
		$this->load->view('navbar_home');
		$this->load->view('register');
	}

	// loads regular dashboard if user is not admin.
	public function dashboard()
	{
		if(!$this->session->userdata('logged_in'))
		{
			redirect('/signin');
			die();
		}
		if($this->session->userdata('user_level') && $this->session->userdata('user_level') == 9)
		{
			redirect('/dashboard/admin');
			die();
		}
		else{
		$table = $this->list_users();
		$this->load->view('navbar');
		$this->load->view('user_dashboard', $table);
		}
	}

	// gets list of users and compiles a table depending on the user_level
	public function list_users()
	{
		$this->load->model('user');
		$user_list = $this->user->get_all_users();
		$user_level = array('9' => 'admin', '1' => 'normal');
		$table_row = "";
		$admin_table = "";
		foreach($user_list as $user)
		{
			$user_table = "<tr>
					<td>" . $user['id'] . "</td>
					<td><a href='/users/show/" . $user['id'] . "'>" . $user['first_name'] . " " . $user['last_name'] . "</a></td>
					<td>" . $user['email'] . "</td>
					<td>" . $user['created_at'] . "</td>
					<td>" . $user_level[$user['user_level']] . "</td>";
			if($this->session->userdata('user_level') == 9)
			{
				$admin_table = "<td><a href='../admin/edit/" . $user['id'] . "'>edit</a> | <a href='/admin/remove/" . $user['id'] . "'>remove</a></td>";
			}
			$table_row = $user_table . $admin_table . "</tr>" . $table_row;
		}
		$table = array('table' => $table_row);
		return $table;
	}

	// loads admin dashboard for admins and sends normal users to regular dashboard
	public function admin_dashboard()
	{
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
		$table = $this->list_users();
		$this->load->view('navbar');
		$this->load->view('admin_dashboard', $table);
		}
	}

	//loads admin add new user page
	public function add_new()
	{
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
		$this->load->view('navbar');
		$this->load->view('admin_add_user');
		}
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

	//loads admin's user edit page
	public function admin_edit($val)
	{
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
			$user_info = $this->user->get_user_info($val);
			$this->load->view('navbar');
			$this->load->view('admin_edit_user', $user_info);
		}
	}


}
