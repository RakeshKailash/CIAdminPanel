<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagens extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		$this->load->model('site/imagens_model', 'imagens_site');
		// $this->load->model('site/contatos_model');
	}

	public function index ()
	{
		$this->load->view('site/imagens/imagens');
	}

}