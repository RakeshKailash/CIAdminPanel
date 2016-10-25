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
		$this->db->select('secoes.nome, secoes.conteudo, imagens.caminho, secoes.icone, secoes.link');
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

}