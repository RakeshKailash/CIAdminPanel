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

	public function retrieveAllBy ($filters=array(null))
	{
		if (empty($filters))
		{
			return false;
		}

		foreach ($filters as $filter => $value)
		{

			$data = $this->translateDate($value)[0];

			switch ($filter)
			{
				case 'dateY':
				$this->db->where("DATE_FORMAT(`data`, '%Y') = '$value'"); // By Year
				break;
				case 'datem':
				$this->db->where("DATE_FORMAT(`data`, '%m') = $value"); // By Month (number)
				break;
				case 'dateM':
				$this->db->where("DATE_FORMAT(`data`, '%M') = '$data'"); // By Month (name)
				break;
				case 'dated':
				$this->db->where("DATE_FORMAT(`data`, '%d') = '$value'"); // By Day (number)
				break;
				case 'dateW':
				$this->db->where("DATE_FORMAT(`data`, '%W') = '$data'"); // By Day (name)
				break;
				case 'datew':
				$this->db->where("DATE_FORMAT(`data`, '%w') = $value"); // By Day (week based number)
				break;
				case 'dateYmd':
				$this->db->where("DATE_FORMAT(`data`, '%Y-%m-%d') = '$value'"); // By Day (week based number)
				break;
				case 'timeH':
				$this->db->where("TIME_FORMAT(TIME(`data`), '%H') = '$value'"); // By Hour
				break;
				case 'timei':
				$this->db->where("TIME_FORMAT(TIME(`data`), '%i') = '$value'"); // By Minutes
				break;
				case 'times':
				$this->db->where("TIME_FORMAT(TIME(`data`), '%s') = '$value'"); // By Hour
				break;
				case 'timeHis':
				$this->db->where("TIME_FORMAT(TIME(`data`), '%H:%i:%s') = '$value'"); // By Hour
				break;
				case 'section':
				$this->db->where("idSecao = $value"); // By Hour
				break;
				case 'origin':
				$this->db->where("idOrigem = $value"); // By Hour
				break;
				default:
				break;
			}

		}

		$query = $this->db->get('acessos');
		$result['count'] = $query->num_rows();
		$result['list'] = $query->result();

		return (object) $result;
	}


	function translateDate ($dates='')
	{
		$dates = array($dates);

		$days = array();
		$months = array();

		$days['en'] = array('Sunday', 'Sun', 'Monday', 'Mon', 'Tuesday', 'Tue', 'Wednesday', 'Wed', 'Thursday', 'Thu', 'Friday', 'Fri', 'Saturday', 'Sat');
		$days['pt'] = array('Domingo', 'Dom', 'Segunda', 'Seg', 'Terça', 'Ter', 'Quarta', 'Qua', 'Quinta', 'Qui', 'Sexta', 'Sex', 'Sábado', 'Sab');

		$months['en'] = array('January', 'February', 'March', 'April', 'May', 'June', 'Jule', 'August', 'September', 'October', 'November', 'December');
		$months['pt'] = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

		foreach ($dates as &$date) {
			$date = str_replace($days['pt'], $days['en'], $date);
			$date = str_replace($months['pt'], $months['en'], $date);
		}

		return $dates;
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