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
		if ($_SESSION['tipoUsuario'] == 1)
		{
			$this->session->set_flashdata('warning', "<p>Você não tem permissão para editar informações do site!</p>");
			return redirect('sistema/postagens');
		}

		$validate = $this->validatePost('titulo', 'conteudo');

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
		if ($_SESSION['tipoUsuario'] == 1)
		{
			$this->session->set_flashdata('warning', "<p>Você não tem permissão para editar informações do site!</p>");
			return redirect('sistema/postagens');
		}

		$validate = $this->validatePost('titulo', 'conteudo');

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
		$this->load->view('sistema/postagens/home', $info);
	}

	public function retrieve ($id=null)
	{
		$posts = $this->postagens_model->getPosts($id)[0];
		echo json_encode($posts);
	}

	public function editar ($id=null)
	{
		if (! $id)
		{
			return redirect('sistema/postagens');
		}

		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['registro'] = $this->secoes_sistema->getInfo(5)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['edit_post'] = $this->postagens_model->getPosts($id)[0];

		$this->load->view('sistema/postagens/editar', $info);
	}

	public function update ()
	{
		if ($_SESSION['tipoUsuario'] == 1)
		{
			$this->session->set_flashdata('warning', "<p>Você não tem permissão para editar informações do site!</p>");
			return redirect('sistema/postagens');
		}

		$validate = $this->validatePost('titulo_post_modal', 'conteudo_post_modal');

		if (! $validate)
		{
			$this->session->set_flashdata('warning', $validate);
			return redirect('sistema/postagens');
		}

		$data['titulo'] = $this->input->post('titulo_post_modal');
		$data['conteudo'] = $this->input->post('conteudo_post_modal');
		$data['listar'] = !!$this->input->post('status_post_modal');
		$id = $this->input->post('id_post');

		if (! $this->postagens_model->savePost($data, $id))
		{
			$this->session->set_flashdata('error', "<p>Erro ao atualizar a Postagem! Tente novamente</p>");
			return redirect('sistema/postagens');
		}

		$this->session->set_flashdata('success', "<p>Postagem alterada com sucesso!</p>");
		return redirect('sistema/postagens');
	}

	public function filterPosts ($orderBy = null)
	{
		if ($orderBy == null)
		{
			echo false;
		}

		$query = $this->postagens_model->orderPosts($orderBy);
		if (!$query)
		{
			echo false;
		}

		echo json_encode($query);
	}

	private function validatePost ($titleField=null, $contentField=null)
	{
		if (! $titleField || ! $contentField)
		{
			return false;
		}

		$this->form_validation->set_rules($titleField, 'Titulo', 'required');
		$this->form_validation->set_rules($contentField, 'Conteúdo', 'required');

		if ($this->form_validation->run() == false)
		{
			return validation_errors('<p>','<p>');
		}

		return true;
	}

}