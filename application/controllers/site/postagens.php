<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postagens extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		// $this->load->model('site/imagens_model', 'imagens_site');
		$this->load->model('site/postagens_model', 'postagens_site');
		$this->load->model('site/analise_model', 'analise_site');
	}

	public function index ()
	{
		// $info['itens'] = $this->secoes_site->getSections();
		// $info['secao_info'] = $this->secoes_site->getSections(4)[0];
		// $info['postagens'] = $this->postagens_site->getPosts('postagens.`listar` = 1');
		// $info['comentarios'] = $this->secoes_site->getComments(6);
		// $this->load->view('site/postagens/postagens', $info);
		// $this->analise_site->insert_access(6);
		return redirect('site');
	}

}