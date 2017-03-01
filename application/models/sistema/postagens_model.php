<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postagens_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function savePost($data=null, $idPost=null)
	{
		if (! $data)
		{
			return false;
		}

		if (! $idPost || $idPost < 1)
		{
			$data['autor'] = $_SESSION['id'];
			if (! $this->insertPost($data))
			{
				return false;
			}

			return true;
		}

		if (! $this->updatePost($data, $idPost))
		{
			return false;
		}

		return true;

	}

	public function getPosts ($id=null)
	{
		if ($id)
		{
			$this->db->where('postagens.`id`', $id);
		}

		$this->db->order_by('postagens.`dataCriacao`', 'DESC');
		$this->db->select('postagens.id, postagens.titulo, postagens.conteudo, imagens.caminho AS capa, imagens.id AS id_capa, usuarios.nome AS autor, postagens.dataCriacao, postagens.ultimaVersao, postagens.listar, postagens.acessos');

		$this->db->join('usuarios', 'usuarios.id = postagens.autor');
		$this->db->join('imagens', 'imagens.id = postagens.capa');

		$query = $this->db->get('postagens');

		if (! $query)
		{
			return false;
		}

		$result = $query->result();

		if (!$id)
		{
			foreach ($result as &$post) {
				$post->conteudo = strip_tags($post->conteudo);
			}
		}

		return $result;
	}

	public function orderPosts ($order)
	{
		if ($order == null)
		{
			return false;
		}

		switch ($order) {
			case 'newest':
			$this->db->order_by('postagens.`dataCriacao`', 'DESC');
			break;

			case 'oldest':
			$this->db->order_by('postagens.`dataCriacao`', 'ASC');
			break;

			case 'views':
			$this->db->order_by('postagens.`acessos`', 'DESC');
			break;

			case 'updated':
			$this->db->order_by('postagens.`ultimaVersao`', 'DESC');
			break;

			case 'author':
			$this->db->order_by('postagens.`autor`', 'ASC');
			$this->db->order_by('postagens.`acessos`', 'DESC');
			$this->db->order_by('postagens.`id`', 'DESC');
			break;

			case 'status':
			$this->db->order_by('postagens.`listar`', 'DESC');
			$this->db->order_by('postagens.`acessos`', 'DESC');
			$this->db->order_by('postagens.`id`', 'DESC');
			break;

			default:
			$this->db->order_by('postagens.`dataCriacao`', 'DESC');
			break;
		}

		$this->db->select('postagens.id, postagens.titulo, postagens.conteudo, imagens.caminho AS capa, usuarios.nome AS autor, postagens.dataCriacao, postagens.ultimaVersao, postagens.listar, postagens.acessos');

		$this->db->join('usuarios', 'usuarios.id = postagens.autor');
		$this->db->join('imagens', 'imagens.id = postagens.capa');

		$query = $this->db->get('postagens');

		if (! $query)
		{
			return false;
		}

		$result = $query->result();

		foreach ($result as &$post) {
			$post->conteudo = strip_tags($post->conteudo);
		}

		return $result;

	}

	private function insertPost ($data=null)
	{
		if (! $this->db->insert('postagens', $data))
		{
			return false;
		}

		return true;
	}

	private function updatePost ($data=null, $id=null)
	{
		$this->db->set($data);
		$this->db->where('id', $id);

		if (! $this->db->update('postagens'))
		{
			return false;
		}

		return true;
	}

}