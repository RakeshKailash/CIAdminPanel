<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secoes_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getInfo($id = null)
	{
		$this->db->select('secoes.id, secoes.nome, secoes.conteudo, imagens.caminho, secoes.icone, secoes.link, secoes.comentarios');
		$this->db->from('secoes');
		$this->db->join('imagens', 'imagens.id = secoes.imagem');

		if ($id != null) {
			$this->db->where('secoes.id', $id);
		}

		return $this->db->get()->result();
	}

	public function update($data=null, $id=null)
	{
		if ($id != null && $data != null) {
			$sets = array();
			foreach ($data as $key => $value) {
				if ($value != null) {
					$sets[$key] = $value;
				}
			}

			$this->db->where('id', $id);
			$this->db->set($sets);
			if ( ! $this->db->update('secoes')) {
				return false;
			}

			return true;
		} else {
			return false;
		}
	}

	public function getComments ($secaoId=null)
	{
		if ($secaoId)
		{
			$query = "SELECT
			comentarios.`idComentario`,
			comentarios.`nomeAutor`,
			comentarios.`emailAutor`,
			comentarios.`dataComentario`,
			comentarios.`textoComentario`,
			comentarios.`secaoComentario`,
			secoes.`nome` AS `nomeSecao`,
			comentarios.`aprovado`
			FROM
			comentarios
			JOIN secoes
			ON secoes.`id` = comentarios.secaoComentario
			WHERE `secaoComentario` = $secaoId AND aprovado = 1";
		}

		if (!$secaoId)
		{
			$query = "SELECT
			comentarios.`idComentario`,
			comentarios.`nomeAutor`,
			comentarios.`emailAutor`,
			comentarios.`dataComentario`,
			comentarios.`textoComentario`,
			comentarios.`secaoComentario`,
			secoes.`nome` AS `nomeSecao`,
			comentarios.`aprovado`
			FROM
			comentarios
			JOIN secoes
			ON secoes.`id` = comentarios.secaoComentario
			ORDER BY `dataComentario` DESC";

		}

		$result = $this->db->query($query)->result();
		return $result;
	}

	public function deleteComments ($ids=null)
	{
		if (!$ids) {
			return false;
		}

		foreach ($ids as $idComentario) {
			$this->db->where('idComentario', $idComentario);
			$this->db->delete('comentarios');
		}

		return true;
	}

	public function changeCommentStatus ($ids=null, $status=1)
	{
		if (!$ids) {
			return false;
		}

		foreach ($ids as $idComentario) {
			$this->db->where('idComentario', $idComentario);
			$this->db->set('aprovado', $status);
			$this->db->update('comentarios');
		}

		return true;
	}

	// public function approveComments ($ids=null)
	// {
	// 	if (!$ids) {
	// 		return false;
	// 	}

	// 	foreach ($ids as $idComentario) {
	// 		$this->db->where('idComentario', $idComentario);
	// 		$this->db->set('aprovado', 1);
	// 		$this->db->update('comentarios');
	// 	}

	// 	return true;
	// }

	// public function disableComments ($ids=null)
	// {
	// 	if (!$ids) {
	// 		return false;
	// 	}

	// 	foreach ($ids as $idComentario) {
	// 		$this->db->where('idComentario', $idComentario);
	// 		$this->db->set('aprovado', 0);
	// 		$this->db->update('comentarios');
	// 	}

	// 	return true;
	// }

}