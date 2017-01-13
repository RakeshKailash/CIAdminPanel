<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function insert ($data = null)
	{
		if ($data == null) {
			return false;
		}

		$data['fim'] = time();

		if(! $this->db->insert('sessions', $data)) {
			return false;
		}


		$this->session->record_id = $this->db->insert_id();
		return $this->db->insert_id();
	}

	public function refresh_info ()
	{
		$this->db->set('fim', time());
		$this->db->where('id', $_SESSION['record_id']);

		if (! $this->db->update('sessions'))
		{
			return false;
		}

		return true;
	}

}