<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
		date_default_timezone_set('America/Sao_Paulo');
	}


}