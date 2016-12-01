<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secoes_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getSections ($id=null)
	{
		$this->db->select('secoes.nome, secoes.conteudo, imagens.caminho, secoes.icone, secoes.link');
		$this->db->from('secoes');
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

}