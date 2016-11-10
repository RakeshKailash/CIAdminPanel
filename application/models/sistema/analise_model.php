<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analise_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function retrieveLast ($intervalo=7)
	{
		$daysList = array();
		$countList = array();

		for ($i=$intervalo; $i > 0; $i--) {
			$date = date('Y-m-d', strtotime("$i days ago"));
			array_push($daysList, $date);

			$this->db->where("DATE(acessos.data)", $date);
			$result = $this->db->get('acessos')->result();
			array_push($countList, count($result));
		}

		$retorno = array('list' => $daysList, 'count' => $countList, 'limitValue' => $this->getMaxValue($countList));

		return (object) $retorno;
	}

	public function retrieve ($secao=null, $intervaloDias=null)
	{

		$this->db->select('acessos.idAcesso, secoes.nome, origens_acessos.idOrigem, origens_acessos.link, acessos.data');
		$this->db->join('secoes', 'secoes.id = acessos.idSecao');
		$this->db->join('origens_acessos', 'origens_acessos.idOrigem = acessos.idOrigem');
		$this->db->order_by('acessos.data');

		$views = array();
		$count = array();

		if ($secao !== null)
		{
			$this->db->where("acessos.idSecao = $secao");

		}

		if ($intervaloDias !== null)
		{
			for ($i=1; $i <= ($intervaloDias + 1); $i++)
			{ 
				$this->db->where("DATE(acessos.data) = DATE_SUB(CURDATE(), INTERVAL - $i DAY)");
				$result_db = $this->db->get('acessos')->result();
				$result = isset($result_db[0]->data) ? array('data' => $result_db, 'count' => count($result_db)) : array('data' => date('Y-m-d H:m:i', strtotime("$i days ago")), 'count' => 0);
				
				array_push($views, (object) $result['data']);
				array_push($count, $result['count']);
			}

			$retorno = array('count' => $count, 'views' => $views);
			print_r(date('Y-m-d H:m:i', strtotime("7 days ago")));
		} else
		{
			$result = $this->db->get('acessos')->result();
			$retorno = array('count' => count($result), 'views' => $result);
		}

		// print_r($retorno);

		if (! $retorno)
		{
			return false;
		}

		return (object) $retorno;
		// print_r($retorno);
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
		$this->db->select('acessos.idAcesso, secoes.nome, origens_acessos.idOrigem, origens_acessos.link, acessos.data');
	}

	function getMaxValue ($values=null)
	{

		if ($values === null)
		{
			return 0;
		}

		$soma = 0;

		foreach ($values as $value) {
			$soma = $value !== 0 ? ($soma + $value) : $soma + 1;
		}

		$soma = ceil($soma / 10) * 10;

		return $soma;
	}
}