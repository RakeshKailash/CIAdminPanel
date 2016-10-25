<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secoes_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getSections2 ($id=null) {
		$this->db->select('nome, conteudo, imagem, icone, link');

		if ($id != null) {
			$this->db->where('id', $id);
		}

		$secao = $this->db->get('secoes');


		if ($id != null) {
			$this->db->select('caminho');
			$this->db->where('id', $id);

			$imagem = $this->db->get('imagens');

			foreach ($secao->result_array()[0] as $key => $value) {
				$resultado[0][$key] = $value;
			}

			$resultado[0]['imagem'] = $imagem->resultbase_url($imagem->result_array()[0]['caminho']);
			return $resultado;
		} else {
			return $secao->result_array();
		}

	}

	public function getSections ($id=null) {
		$this->db->select('secoes.nome, secoes.conteudo, imagens.caminho, secoes.icone, secoes.link');
		$this->db->from('secoes');
		$this->db->join('imagens', 'imagens.id = secoes.imagem');

		if ($id != null) {
			$this->db->where('secoes.id', $id);
		}

		$secoes = $this->db->get()->result();

		return $secoes;

	}

}