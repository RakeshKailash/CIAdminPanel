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
		if (! $this->usuario_model->isLogged()) {
			return redirect('sistema/login');
		}
	}

	public function index ()
	{
		redirect('sistema/empresa/editar');
	}

	public function editar ()
	{
		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['registro'] = $this->secoes_sistema->getInfo(3)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$this->load->view('sistema/empresa/editar', $info);
	}

	public function update()
	{
		$campo = 'imagem';

		$has_img = !! $this->input->post('has_img');
		$change_img = $has_img && ! empty($_FILES['imagem']['name']);

		if (! $has_img)
		{
			$campo = null;
			$this->imagens_model->replaceSectionImg(3, $campo);
		}

		if ($has_img && $change_img)
		{
			$this->imagens_model->replaceSectionImg(3, $campo);
		}

		$dados['conteudo'] = $this->input->post('conteudo');
		$dados['icone'] = $this->input->post('icone');

		if ($dados['conteudo'] != null || $dados['icone'] != null) {
			$this->secoes_sistema->update($dados, 3);

			$atualizacao['titulo'] = "Seção 'Empresa' alterada";
			$atualizacao['usuario'] = $_SESSION['id'];
			$atualizacao['tipo'] = "Alteração de Conteúdo";
			

			$this->atualizacoes_sistema->insert($atualizacao);

			redirect('/sistema/empresa/editar');
		}
	}

}