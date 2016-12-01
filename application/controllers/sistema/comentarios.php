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

	function deletar ($ids=null)
	{
		if ($ids == null) {
			$this->session->set_flashdata('warning', "Nenhum comentário selecionado para exclusão.");
			redirect($_SERVER['HTTP_REFERER']);
		}

		$ids = strstr($ids, "_") ? $ids = explode("_", $ids) : array($ids);

		if (! $this->secoes_sistema->deleteComments($ids)) {
			$this->session->set_flashdata('error', "Erro ao excluir o comentário! Tente novamente.");
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->session->set_flashdata('success', "Comentário excluído com sucesso!");
		redirect($_SERVER['HTTP_REFERER']);
	}

	function aprovar ($ids=null)
	{
		if ($ids == null) {
			$this->session->set_flashdata('warning', "Nenhum comentário selecionado para aprovação.");
			redirect($_SERVER['HTTP_REFERER']);
		}

		$ids = strstr($ids, "_") ? $ids = explode("_", $ids) : array($ids);

		if (! $this->secoes_sistema->approveComments($ids)) {
			$this->session->set_flashdata('error', "Erro ao aprovar o comentário para exibição! Tente novamente.");
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->session->set_flashdata('success', "Comentário aprovado para exibição com sucesso!");
		redirect($_SERVER['HTTP_REFERER']);
	}

}