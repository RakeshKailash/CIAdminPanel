<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/imagens_model');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
		$this->load->model('sistema/uploads_model');
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}
	}

	public function index()
	{
		redirect('sistema/servicos/editar');
	}

	public function editar ()
	{
		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['registro'] = $this->secoes_sistema->getInfo(2)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['uploads'] = $this->uploads_model->getFiles();
		$this->load->view('sistema/servicos/editar', $info);
	}

	public function update ()
	{
		if ($this->input->post('conteudo') == null)
		{
			$this->session->set_flashdata('warning', "<p>Preencha todos os campos para atualizar a seção!</p>");
			return redirect('/sistema/servicos/editar');
		}

		$dados['conteudo'] = $this->input->post('conteudo');
		$campo = 'imagem';

		$has_img = !! $this->input->post('has_img');
		$change_img = $has_img && ! empty($_FILES['imagem']['name']);

		if (! $has_img)
		{
			$campo = null;
			$prevImg = $this->secoes_sistema->getSectionImage(2);
			$this->imagens_model->update($prevImg->id, 'images/uploads/sections', $campo);
		}

		if ($has_img && $change_img)
		{
			$prevImg = $this->secoes_sistema->getSectionImage(2);
			$this->imagens_model->update($prevImg->id, 'images/uploads/sections', $campo);
		}

		if (! $this->secoes_sistema->update($dados, 2))
		{
			$this->session->set_flashdata('error', "<p>Ocorreu um erro, tente novamente!</p>");
			return redirect('/sistema/servicos/editar');
		}

		$atualizacao['titulo'] = "Seção 'Serviços' alterada";
		$atualizacao['usuario'] = $_SESSION['id'];
		$atualizacao['tipo'] = "Alteração de Conteúdo";
		$atualizacao['link'] = "servicos/editar";

		$this->atualizacoes_sistema->insert($atualizacao);

		$this->session->set_flashdata('success', "<p>Seção atualizada com sucesso!</p>");
		return redirect('/sistema/servicos/editar');
	}

}