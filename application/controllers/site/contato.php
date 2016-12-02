<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		$this->load->model('site/imagens_model', 'imagens_site');
		$this->load->model('site/contatos_model');
		$this->load->model('site/analise_model', 'analise_site');
	}

	public function index ()
	{
		$info['itens'] = $this->secoes_site->getSections();
		$info['secao_info'] = $this->secoes_site->getSections(5)[0];
		$info['contato'] = $this->contatos_model->retrieve(1)[0];
		$info['comentarios'] = $this->secoes_site->getComments(5);
		$this->load->view('site/contato/contato', $info);
		$this->analise_site->insert_access(5);
	}

	public function send_email ()
	{
		$data['nome'] = $this->input->post('nome');
		$data['sobrenome'] = $this->input->post('sobrenome');
		$data['email'] = $this->input->post('email');
		$data['telefone'] = $this->input->post('telefone');
		$data['mensagem'] = $this->input->post('mensagem');
	}

}