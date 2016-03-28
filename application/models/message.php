<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Model {
	public function grab_messages($user_id)
	{
		$query = "SELECT messages.id, messages.content, messages.profile_id, messages.writer_id, writer.first_name as 'writer_first_name', writer.last_name as 'writer_last_name', messages.created_at
			FROM messages
			JOIN users writer ON messages.writer_id = writer.id 
			WHERE messages.profile_id = ? ORDER BY messages.created_at DESC";
		return $this->db->query($query, $user_id)->result_array();
	}

	public function grab_comments($user_id)
	{
		$query = "SELECT comments.id, comments.content, comments.message_id, comments.profile_id, comments.writer_id, writer.first_name as 'writer_first_name', writer.last_name as 'writer_last_name', comments.created_at
			FROM comments
			JOIN users writer ON comments.writer_id = writer.id 
			WHERE comments.profile_id = ? ORDER BY comments.created_at ASC";
		return $this->db->query($query, $user_id)->result_array();
	}

	public function post_message($message_data)
	{
		$query = "INSERT INTO messages (content, created_at, updated_at, profile_id, writer_id) VALUES (?, NOW(), NOW(), ?, ?)";
		$array = array('content' => $message_data['content'],
						'profile_id' => $message_data['profile_id'],
						'writer_id' => $message_data['writer_id']);
		$this->db->query($query, $array);
	}

	public function post_comment($comment_data)
	{
		$query = "INSERT INTO comments (content, created_at, updated_at, message_id, profile_id, writer_id) VALUES (?, NOW(), NOW(), ?, ?, ?)";
		$array = array('content' => $comment_data['content'],
						'message_id' => $comment_data['message_id'],
						'profile_id' => $comment_data['profile_id'],
						'writer_id' => $comment_data['writer_id']);
		$this->db->query($query, $array);
	}

}

?>