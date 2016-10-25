<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/imagens_model');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
	}

	public function index() 
	{
		if ($this->usuario_model->isLogged()) {
			$this->load->view('sistema/editar_empresa');
		} else {
			redirect('sistema/login');
		}
	}

	public function editar ()
	{
		if ($this->usuario_model->isLogged()) {
			$this->load->view('sistema/editar_empresa');

			$campo = 'imagem';

			if ($this->input->post('has_img') == "false") {
				$campo = null;
			}

			$upload_result = $this->imagens_model->replaceSectionImg(3, $campo);

			$dados['conteudo'] = $this->input->post('conteudo');
		// $dados['imagem'] = $upload_result['imagem']['id'] != null ? $upload_result['imagem']['id'] : null;
			$dados['icone'] = $this->input->post('icone');

			if ($dados['conteudo'] != null || $dados['icone'] != null) {
				$this->secoes_sistema->update($dados, 3);

				$atualizacao['titulo'] = "Seção 'Empresa' alterada";
				$atualizacao['usuario'] = $_SESSION['id'];
				$atualizacao['tipo'] = "Alteração de Conteúdo";

				$this->atualizacoes_sistema->insert($atualizacao);

				redirect('/sistema/empresa/editar');
			}
		} else {
			redirect('sistema/login');
		}
	}

}