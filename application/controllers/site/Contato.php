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
		$this->load->library('Emails/Site/EmailContato', '', 'email_contato');
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
		$nome = $this->input->post('nome') ? $this->input->post('nome') : "";
		$email = $this->input->post('email') ? $this->input->post('email') : "";
		$assunto = $this->input->post('assunto') ? $this->input->post('assunto') : "";
		$mensagem = $this->input->post('mensagem') ? $this->input->post('mensagem') : "";

		if ($this->email_contato->sendEmail($nome, $email, $assunto, $mensagem)) {
			$retorno = array('status' => "error", 'message' => "Erro ao enviar a mensagem");
			echo json_encode($retorno);			
		}

		// $result = $this->contatos_model->sendMail($data);

		$retorno = array('status' => "success", 'message' => "Mensagem enviada com sucesso!");
		echo json_encode($retorno);
	}
}