<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		$this->load->model('site/imagens_model', 'imagens_site');
		$this->load->model('site/analise_model', 'analise_site');
	}

	public function index ()
	{
		$this->load->view('site/empresa/empresa');
		$this->analise_site->insert_access(3);
	}

}