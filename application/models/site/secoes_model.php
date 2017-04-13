<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secoes_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getSections ($id=null)
	{
		$this->db->select('secoes.id, secoes.nome, secoes.conteudo, imagens.caminho, secoes.icone, secoes.link, secoes.comentarios');
		$this->db->from('secoes');
		// Provisório: Excluir Postagens da lista de seções
		$this->db->where('secoes.id != 6');
		//
		$this->db->join('imagens', 'imagens.id = secoes.imagem');

		if ($id != null) {
			$this->db->where('secoes.id', $id);
		}

		$secoes = $this->db->get()->result();

		return $secoes;
	}

	public function getComments ($secaoId=0)
	{
		$this->db->where("secaoComentario = $secaoId AND aprovado = 1");
		$this->db->order_by("dataComentario DESC");

		$result = $this->db->get('comentarios')->result();
		return $result;
	}

	public function insertComment ($data=null)
	{
		if (!$data)
		{
			return false;
		}

		if (!$this->db->insert('comentarios', $data))
		{
			return false;
		}

		return true;
	}

	public function getSitePreferences ($prefName=null)
	{
		if ($prefName)
		{
			$this->db->where('nome', $prefName);
		}

		$result = $this->db->get('preferencias')->result();

		if (!$result)
		{
			return false;
		}

		return $result;
	}
}