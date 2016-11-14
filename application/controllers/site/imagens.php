<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagens extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		$this->load->model('site/imagens_model', 'imagens_site');
		$this->load->model('site/analise_model', 'analise_site');
	}

	public function index ()
	{
		$info['itens'] = $this->secoes_site->getSections();
		$info['secao_info'] = $this->secoes_site->getSections(4)[0];
		$this->load->view('site/imagens/imagens', $info);
		$this->analise_site->insert_access(4);
	}

}