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
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['comentarios'] = $this->secoes_sistema->getComments();
		$info['statusSections'] = $this->secoes_sistema->getSectionCommentStatus();
		$this->load->view('sistema/comentarios/gerenciar', $info);
	}

	public function configurar () {
		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['comentarios'] = $this->secoes_sistema->getComments();
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$this->load->view('sistema/comentarios/configurar', $info);
	}

	function deletar ($ids=null)
	{
		if ($ids == null) {
			$this->session->set_flashdata('warning', "Nenhum comentário selecionado para exclusão.");
			redirect(base_url('sistema/Comentarios/gerenciar'));
		}

		$ids = strstr($ids, "_") ? $ids = explode("_", $ids) : array($ids);

		if (! $this->secoes_sistema->deleteComments($ids)) {
			$this->session->set_flashdata('error', "Erro ao excluir o comentário! Tente novamente.");
			redirect(base_url('sistema/Comentarios/gerenciar'));
		}

		$this->session->set_flashdata('success', "Comentário excluído com sucesso!");
		redirect(base_url('sistema/Comentarios/gerenciar'));
	}

	function aprovar ($ids=null)
	{
		if ($ids == null) {
			$this->session->set_flashdata('warning', "Nenhum comentário selecionado para aprovação.");
			redirect(base_url('sistema/Comentarios/gerenciar'));
		}

		$ids = strstr($ids, "_") ? $ids = explode("_", $ids) : array($ids);

		if (! $this->secoes_sistema->changeCommentStatus($ids, 1)) {
			$this->session->set_flashdata('error', "Erro ao aprovar o comentário para exibição! Tente novamente.");
			redirect(base_url('sistema/Comentarios/gerenciar'));
		}

		$this->session->set_flashdata('success', "Comentário aprovado para exibição com sucesso!");
		redirect(base_url('sistema/Comentarios/gerenciar'));
	}

	function desativar ($ids=null)
	{
		if ($ids == null) {
			$this->session->set_flashdata('warning', "Nenhum comentário selecionado para desativar.");
			redirect(base_url('sistema/Comentarios/gerenciar'));
		}

		$ids = strstr($ids, "_") ? $ids = explode("_", $ids) : array($ids);

		if (! $this->secoes_sistema->changeCommentStatus($ids, 0)) {
			$this->session->set_flashdata('error', "Erro ao desativar o comentário! Tente novamente.");
			redirect(base_url('sistema/Comentarios/gerenciar'));
		}

		$this->session->set_flashdata('success', "Comentário desativado com sucesso!");
		redirect(base_url('sistema/Comentarios/gerenciar'));
	}

	public function setSectionStatus ()
	{
		$props = array(2 => 0, 3 => 0, 4 => 0, 5 => 0);
		$values = $_POST['secoes_valores'];

		foreach ($values as $value) {
			$props[$value] = 1;
		}

		print_r($props);

		if (!$this->secoes_sistema->setSectionCommentStatus($props)) {
			$this->session->set_flashdata('error', "Erro ao alterar seção! Tente novamente.");
			redirect(base_url('sistema/Comentarios/gerenciar'));
		}

		$this->session->set_flashdata('success', "Seção alterada com sucesso!");
		redirect(base_url('sistema/Comentarios/gerenciar'));
	}

}