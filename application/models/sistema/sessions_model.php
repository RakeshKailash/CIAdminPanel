<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
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

		return true;
	}
}