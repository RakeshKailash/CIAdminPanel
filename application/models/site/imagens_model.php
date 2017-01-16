<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagens_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getGalleryContent () {
		$this->db->select('id, caminho, titulo, texto');
		$imagens = $this->db->get('galeria')->result();

		return $imagens;
	}
}