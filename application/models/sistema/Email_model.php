<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

	private $field_list = array(
		'default_email',
		'default_email_sender',
		'default_email_password',
		'default_email_host',
		'default_email_protocol',
		'default_email_port',
		'default_email_receiver'
	);

	function __construct() {
		parent::__construct();
		$this->load->database();
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function getConfig () {
		$this->db->select('nome, valor');
		$this->db->where_in('nome', $this->field_list);

		$query = $this->db->get('preferencias');

		if (! $query) {
			return false;
		}

		$config_email = array();

		foreach ($query->result() as $config) {
			$config_email[$config->nome] = $config->valor;
		}

		return $config_email;
	}


}