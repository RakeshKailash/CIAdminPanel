<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		$this->load->model('site/imagens_model', 'imagens_site');
		$this->load->model('site/analise_model', 'analise_site');
	}

	public function index ()
	{
		$info['secao_info'] = $this->secoes_site->getSections(2)[0];
		$info['itens'] = $this->secoes_site->getSections();
		$this->load->view('site/servicos/servicos', $info);
		$this->analise_site->insert_access(2);
	}

}