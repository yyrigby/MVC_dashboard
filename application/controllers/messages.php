<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {

	public function user_info($user_id)
	{
		if(!$this->session->userdata('logged_in'))
		{
			redirect('/signin');
			die();
		}
		else{
		$this->load->model('user');
		$user_info = $this->user->get_user_info($user_id);
		$message_html = $this->list_messages($user_id);
		$user_info['messages'] = $message_html;
		$this->load->view('navbar');
		$this->load->view('user_information', $user_info);
		}
	}

	public function post_message()
	{
		$this->load->model('message');
		$message_data = $this->input->post();
		$message_data['writer_id'] = $this->session->userdata('id');
		$this->message->post_message($message_data);
		redirect('users/show/' . $message_data['profile_id']);
	}

	public function post_comment()
	{
		$this->load->model('message');
		$comment_data = $this->input->post();
		$comment_data['writer_id'] = $this->session->userdata('id');
		$this->message->post_comment($comment_data);
		redirect('users/show/' . $comment_data['profile_id']);
	}

	public function list_messages($profile_id) {
		$this->load->model('message');
		$messages = $this->message->grab_messages($profile_id);
		$comments = $this->message->grab_comments($profile_id);
		$message_html = "";
		foreach($messages as $message){
			$diff_msg = $this->time_elapsed_string($message['created_at']);
			$message_html = $message_html . 
			"<div class='message'>
				<p>" . $message['writer_first_name'] . " " . $message['writer_last_name'] . " wrote<span class='time'>" . $diff_msg . " </span></p>
				<p class='message_content'>" . $message['content'] . "</p>
				<div class='comment'>";

			// append all the existing comments for the message
			foreach($comments as $comment) {
				if($comment['message_id'] == $message['id'])
				{	
					$diff_cmt = $this->time_elapsed_string($comment['created_at']);
					$message_html = $message_html . 
					"<p>" . $comment['writer_first_name'] . " " . $comment['writer_last_name'] . " wrote<span class='time'>" . $diff_cmt . "</span></p>
					<p class='comment_content'>" . $comment['content'] . "</p>";
				}
			}

			$message_html = $message_html . 
					"<form class='leave_comment' action='/message/leave_comment' method='post'>
						<textarea name='content' class='leave_comment'></textarea>
						<input type='submit' class='btn_green' value='Post'>
						<input type='hidden' name='profile_id' value='" . $message['profile_id'] . "'>
						<input type='hidden' name='message_id' value='" . $message['id'] . "'>
					</form>
				</div>
			</div>";
		}
		return $message_html;
	}

	function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);
	    if($diff->d > 1)
	    {
	    	return date('F jS, Y', strtotime($datetime));
	    }

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

}

?>