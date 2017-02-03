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
		$this->db->select('postagens.id, postagens.titulo, postagens.conteudo, postagens.capa, usuarios.nome AS autor, postagens.dataCriacao, postagens.ultimaVersao, postagens.listar, postagens.acessos');

		$this->db->join('usuarios', 'usuarios.id = postagens.autor');

		$query = $this->db->get('postagens');

		if (! $query)
		{
			return false;
		}

		return $query->result();
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