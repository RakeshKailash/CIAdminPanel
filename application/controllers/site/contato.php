<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		$this->load->model('site/imagens_model', 'imagens_site');
		$this->load->model('site/contatos_model');
	}

	public function index ()
	{
		$this->load->view('site/contato');
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