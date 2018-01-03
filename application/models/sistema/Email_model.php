<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function getConfig () {
		$this->db->select('default_email AS email, default_email_sender AS sender, default_email_password AS password, default_email_host AS host, default_email_protocol AS protocol, default_email_port AS port, default_email_receiver AS receiver');

		$query = $this->db->get('preferencias');

		if (! $query) {
			return false;
		}

		return $query->result()[0];
	}


}