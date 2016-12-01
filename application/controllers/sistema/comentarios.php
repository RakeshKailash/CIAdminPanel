<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comentarios extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/imagens_model');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}
	}

	public function index () {
		$this->load->view('sistema/comentarios/gerenciar');
	}

	public function gerenciar () {
		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['comentarios'] = $this->secoes_sistema->getComments();
		// $info['registro'] = $this->secoes_sistema->getInfo(2)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$this->load->view('sistema/comentarios/gerenciar', $info);
	}

	public function configurar () {
		$this->load->view('sistema/comentarios/configurar');
	}

}