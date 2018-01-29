<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		$this->load->model('site/imagens_model', 'imagens_site');
		$this->load->model('site/analise_model', 'analise_site');
		$this->load->model('site/ferramentas_model', 'ferramentas_site');
	}

	public function index ()
	{
		$info['itens'] = $this->secoes_site->getSections();
		$info['secao_info'] = $this->secoes_site->getSections(3)[0];
		$info['comentarios'] = $this->secoes_site->getComments(3);
		$info_survey['enquete'] = $this->ferramentas_site->getRunningSurvey();
		$info['enquetes'] = $this->load->view('site/common/enquetes', $info_survey, true);
		$this->load->view('site/empresa/empresa', $info);
		$this->analise_site->insert_access(3);
	}

}