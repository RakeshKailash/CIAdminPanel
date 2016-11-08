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

		$insert = $this->db->insert('atualizacoes', $data);

		if ( ! $insert )
		{
			return false;
		}

		return true;

	}

	function retrieve ($id=null, $limit=null)
	{
		$this->db->select('atualizacoes.id, atualizacoes.titulo, atualizacoes.tipo, atualizacoes.data, atualizacoes.usuario, usuarios.nome, usuarios.imagem');
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

		$atualizacoes = $this->db->get()->result();

		if ( ! $atualizacoes || ! $atualizacoes[0]->titulo )
		{
			return null;
		}

		foreach ($atualizacoes as &$atualizacao) {
			$atualizacao->status = ($atualizacao->data > $_SESSION['ultimoAcesso'] && $atualizacao->usuario != $_SESSION['id']) ? 'false' : 'true';
		}

		return $atualizacoes;
	}

	function retrieveUnviewed ($limit=null)
	{
		$this->db->select('atualizacoes.id, atualizacoes.titulo, atualizacoes.tipo, atualizacoes.data, atualizacoes.usuario, usuarios.nome, usuarios.imagem');
		$this->db->from('atualizacoes');
		$this->db->join('usuarios', 'usuarios.id = atualizacoes.usuario');
		$this->db->order_by('atualizacoes.id', 'DESC');

		if ($limit != null) 
		{
			$this->db->limit($limit);
		}

		// $this->db->where('atualizacoes.visualizada', 'false');
		$this->db->where('atualizacoes.data >', $_SESSION['ultimoAcesso']);
		$this->db->where_not_in('atualizacoes.usuario', $_SESSION['id']);

		$atualizacoes = $this->db->get()->result();

		if ( ! $atualizacoes || ! $atualizacoes[0]->titulo )
		{
			return null;
		}

		foreach ($atualizacoes as &$atualizacao) {
			$atualizacao->status = 'false';
		}

		return $atualizacoes;
	}

}