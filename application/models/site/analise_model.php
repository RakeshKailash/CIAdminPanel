<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analise_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function insert_access ($idSecao=null)
	{
		$origin = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;

		$data['idOrigem'] = $origin ? $this->get_origin_info($origin) : 1;
		$data['idSecao'] = $idSecao ? $idSecao : 1;

		$this->db->insert('acessos', $data);

	}

	function get_origin_info ($origin)
	{
		if (! $origin)
		{
			return 1;
		}

		if (strstr($origin, 'www.google.com'))
		{
			return 2;
		}

		if (strstr($origin, 'www.bing.com'))
		{
			return 3;
		}

		if (strstr($origin, 'busca.uol.com.br'))
		{
			return 4;
		}

		if (strstr($origin, 'www.facebook.com') || strstr($origin, 'm.facebook.com') || strstr($origin, 'www.messenger.com'))
		{
			return 5;
		}

		if (strstr($origin, 'twitter.com'))
		{
			return 6;
		}

		return 1;
	}

}