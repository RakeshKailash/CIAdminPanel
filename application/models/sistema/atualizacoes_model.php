<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atualizacoes_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		date_default_timezone_set('America/Sao_Paulo');
	}

	function insert ($data=null)
	{
		if (!isset($data['titulo']) && !isset($data['usuario']) && !isset($data['tipo']))
		{
			return false;
		}

		$data['data'] = time();

		$insert = $this->db->insert('atualizacoes', $data);

		if ( ! $insert )
		{
			return false;
		}

		return true;

	}

	function retrieve ($id=null, $limit=null) {

		$this->db->select('atualizacoes.id, atualizacoes.titulo, atualizacoes.tipo, atualizacoes.data, usuarios.nome, usuarios.imagem');
		$this->db->from('atualizacoes');
		$this->db->join('usuarios', 'usuarios.id = atualizacoes.usuario');
		$this->db->order_by('id', 'DESC');

		if ($limit != null) 
		{
			$this->db->limit($limit);
		}

		if ($id != null)
		{
			$this->db->where('atualizacoes.id', $id);
		}

		$atualizacoes = $this->db->get();

		if ( ! $atualizacoes )
		{
			return null;
		}

		return $atualizacoes->result();

	}

}