<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postagens extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/imagens_model');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
		$this->load->model('sistema/postagens_model');
		$this->load->library('form_validation');
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}
	}

	public function index ()
	{
		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['registro'] = $this->secoes_sistema->getInfo(5)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['postagens'] = $this->postagens_model->getPosts();
		$this->load->view('sistema/postagens/home', $info);
	}

	public function saveAndInsert ()
	{
		$validate = $this->validatePost();

		if (! $validate)
		{
			$this->session->set_flashdata('error', $validate);
			return redirect('sistema/postagens');
		}

		$data['titulo'] = $this->input->post('titulo');
		$data['capa'] = null;
		$data['conteudo'] = $this->input->post('conteudo');
		$data['listar'] = 1;
		$id = $this->input->post('id_postagem');

		$this->postagens_model->savePost($data, $id);
	}

	public function save ()
	{
		$validate = $this->validatePost();

		if (! $validate)
		{
			$this->session->set_flashdata('warning', $validate);
			return redirect('sistema/postagens');
		}

		$data['titulo'] = $this->input->post('titulo');
		$data['capa'] = null;
		$data['conteudo'] = $this->input->post('conteudo');
		$data['listar'] = $this->input->post('save_type');
		$id = $this->input->post('id_postagem');

		if (! $this->postagens_model->savePost($data, $id))
		{
			$this->session->set_flashdata('error', $validate);
			return redirect('sistema/postagens');
		}

		$this->session->set_flashdata('success', "<p>Postagem salva com sucesso!</p>");
		return redirect('sistema/postagens');
	}

	private function validatePost ()
	{
		if ($_SESSION['tipoUsuario'] == 1)
		{
			return "<p>Você não tem permissão para editar informações do site!</p>";
		}

		$this->form_validation->set_rules('titulo', 'Titulo', 'required');
		$this->form_validation->set_rules('conteudo', 'Conteúdo', 'required');

		if ($this->form_validation->run() == false)
		{
			return validation_errors('<p>','<p>');
		}

		return true;
	}

}