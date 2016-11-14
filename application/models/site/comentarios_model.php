<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comentarios_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function insert ($data=null)
	{
		if ($data === null)
		{
			return false;
		}

		if (! $this->db->insert('comentarios', $data)
		{
			return false;
		}

		return true;

	}

}