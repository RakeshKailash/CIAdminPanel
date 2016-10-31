<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contatos_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function retrieve ($id = null)
	{
		if ($id != null) {
			$this->db->where('id', $id);
		}

		$result = $this->db->get('contatos')->result();

		return $result;
	}

}