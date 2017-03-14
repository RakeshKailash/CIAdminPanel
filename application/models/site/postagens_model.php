<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postagens_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getPosts ($where=null, $limit=0, $orderBy='dataCriacao|DESC')
	{
		$where = (! $where) ? null : "WHERE $where";

		$limit = ($limit == 0) ? null : "LIMIT $limit";

		$orderBy = explode('|', $orderBy);
		$orderBy[0] = 'postagens.`'.$orderBy[0].'`';
		$orderBy = implode(" ", $orderBy);


		$query =
			"SELECT postagens.`id`,
			postagens.`titulo`,
			postagens.`conteudo`,
			imagens.`caminho` AS imagem,
			usuarios.`nome` AS autor,
			postagens.`dataCriacao`,
			postagens.`ultimaVersao`,
			postagens.`listar`,
			postagens.`acessos`,
			postagens.`tags`
			FROM postagens
			JOIN imagens ON imagens.`id` = postagens.`capa`
			JOIN usuarios ON usuarios.`id` = postagens.`autor`
			$where
			ORDER BY $orderBy $limit";

		echo $query;

		$postagens = $this->db->query($query);

		if (! $postagens)
		{
			return false;
		}

		return $postagens->result();
	}

	public function reorderPosts ()
	{

	}
}