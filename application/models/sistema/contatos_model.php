<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contatos_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function retrieve ($id=null)
	{
		if ($id == null) {
			return $this->db->get('contatos')->result();
		}

		return $this->db->where('id', $id)->get('contatos')->result()[0];
	}

	public function insert ()
	{

	}

	public function update ($data=null, $id=1)
	{
		if ($data == null) {
			return false;
		}

		$sets = array();
		foreach ($data as $key => $value) {
			if ($value != null) {
				$sets[$key] = $value;
			}
		}

		$this->db->where('id', $id);
		$this->db->set($sets);
		if ( ! $this->db->update('contatos')) {
			return false;
		}

		return true;
	}

}