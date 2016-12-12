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
		$this->load->library('session');
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

	function sendMail()
	{
		$data['name'] = $this->input->post('nome') ? $this->input->post('nome') : "";
		$data['from'] = $this->input->post('email') ? $this->input->post('email') : "";
		$data['subject'] = $this->input->post('assunto') ? $this->input->post('assunto') : "";
		$data['message'] = $this->input->post('mensagem') ? $this->input->post('mensagem') : "";

		$result = $this->contatos_model->sendMail($data);

		$retorno = array('status' => $result['status'], 'message' => $result['message']);
		echo json_encode($retorno);
	}
}