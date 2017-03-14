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

		if ($validate != true)
		{
			$this->session->set_flashdata('error', $validate);
			return redirect('sistema/postagens');
		}

		$id = $this->input->post('id_postagem');

		$data['titulo'] = $this->input->post('titulo');
		$has_img = !! $this->input->post('has_img');
		$change_img = $has_img && ! empty($_FILES['imagem']['name']);

		if (! $id && $has_img)
		{
			$insertImg = $this->imagens_model->insert('imagem', 'images/uploads/posts/');
			$data['capa'] = $insertImg ? $insertImg : 1;
		}

		if ($id)
		{
			$data['capa'] = 1;
			if ($has_img)
			{
				$post = $this->postagens_model->getPosts($id)[0];
				$replaceImg = $this->imagens_model->update($post->id_capa, 'images/uploads/posts', 'imagem');
				$data['capa'] = $replaceImg ? $replaceImg : 1;
			}
		}

		$data['conteudo'] = $this->input->post('conteudo');
		$data['listar'] = 1;

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
			return redirect('sistema/postagens');
		}

		$id = $this->input->post('id_postagem');
		$data['titulo'] = $this->input->post('titulo');

		$has_img = !! $this->input->post('has_img');
		$change_img = $has_img && ! empty($_FILES['imagem']['name']);

		if (! $id)
		{
			$campo = $has_img ? 'imagem' : null;
			$insertImg = $this->imagens_model->insert($campo, 'images/uploads/posts/');
			$data['capa'] = $insertImg ? $insertImg : null;
		}

		if ($id)
		{
			$post = $this->postagens_model->getPosts($id)[0];
			$data['capa'] = $post->id_capa;

			if ($has_img && $change_img)
			{
				$replaceImg = $this->imagens_model->update($post->id_capa, 'images/uploads/posts', 'imagem');
			}

			if (! $has_img)
			{
				$replaceImg = $this->imagens_model->update($post->id_capa, 'images/uploads/posts', null);
			}

		}

		$data['conteudo'] = $this->input->post('conteudo');
		$data['listar'] = empty($this->input->post('status_post')) ? 0 : $this->input->post('status_post');
		$id = $this->input->post('id_postagem');

		if (! $this->postagens_model->savePost($data, $id))
		{
			$this->session->set_flashdata('error', $validate);
			return redirect('sistema/postagens');
		}

		$this->session->set_flashdata('success', "<p>Postagem salva com sucesso!</p>");
		return redirect('sistema/postagens');
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

		$has_img = !! $this->input->post('has_img');
		$change_img = $has_img && ! empty($_FILES['imagem']['name']);

		if (! $id && $has_img)
		{
			$insertImg = $this->imagens_model->insert('imagem', 'images/uploads/posts/');
			$data['capa'] = $insertImg ? $insertImg : null;
		}

		if ($id)
		{
			$data['capa'] = 1;
			if ($has_img)
			{
				$post = $this->postagens_model->getPosts($id)[0];
				$replaceImg = $this->imagens_model->update($post->id_capa, 'images/uploads/posts', 'imagem');
				if ($replaceImg)
				{
					$data['capa'] = $replaceImg;
				}
			}
		}

		if (! $this->postagens_model->savePost($data, $id))
		{
			$this->session->set_flashdata('error', "<p>Erro ao atualizar a Postagem! Tente novamente</p>");
			return redirect('sistema/postagens');
		}

		$this->session->set_flashdata('success', "<p>Postagem alterada com sucesso!</p>");
		return redirect('sistema/postagens/editar/'.$id);
	}

	public function delete ($id=null) {
		if ($_SESSION['tipoUsuario'] == 1)
		{
			$this->session->set_flashdata('warning', "<p>Você não tem permissão para editar informações do site!</p>");
			return redirect('sistema/postagens');
		}

		if (! $id) {
			$this->session->set_flashdata('error', "<p>Erro desconhecido. Tente novamente.</p>");
			return redirect('sistema/postagens');
		}

		if (! $this->postagens_model->deletePost($id))
		{
			$this->session->set_flashdata('error', "<p>Erro ao excluir postagem. Tente novamente</p>");
			return redirect('sistema/postagens');
		}

		$this->session->set_flashdata('success', "<p>Postagem excluída com sucesso!</p>");
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

	public function switchStatus () {
		if ($_SESSION['tipoUsuario'] == 1)
		{
			$result = array(0 => false);
			echo json_encode($result);
			return false;
		}

		if (! isset($_POST['postid']) || ! isset($_POST['status']))
		{
			$result = array(0 => false);
			echo json_encode($result);
			return false;
		}

		$idPost = $this->input->post('postid');
		$data['listar'] = !$this->input->post('status');

		if (! $this->postagens_model->savePost($data, $idPost))
		{
			$result = array(0 => false);
			echo json_encode($result);
			return false;
		}

		$result = array(0 => true);
		echo json_encode($result);
		return true;
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
			$this->session->set_flashdata('error', validation_errors('<p>','<p>'));
			return false;
		}

		return true;
	}

}