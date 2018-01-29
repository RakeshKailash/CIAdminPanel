<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ferramentas_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getRunningSurvey ($id=null) {
		// if (!$id) {
		// 	return false;
		// }

		$select_query = "SELECT 
		enquetes.id,
		enquetes.titulo,
		enquetes.descricao,
		DATE_FORMAT(
		enquetes.data_inicio,
		'%Y-%m-%d'
		) AS data_inicio,
		DATE_FORMAT(enquetes.data_final, '%Y-%m-%d') AS data_final,
		enquetes.status 
		FROM
		enquetes 
		WHERE enquetes.`status` = 2
		AND enquetes.`data_inicio` <= NOW() 
		AND enquetes.`data_final` >= NOW()
		ORDER BY enquetes.`data_criacao` DESC
		LIMIT 1";

		$query = $this->db->query($select_query);

		if (! $query)
		{
			return false;
		}

		$result = $query->result()[0];

		$options_query = "SELECT 
		o.`id`,
		o.`descricao`,
		o.`numero`,
		COUNT(r.`num_opcao`) AS votos
		FROM
		opcoes_enquetes AS o 
		LEFT JOIN respostas_enquetes AS r 
		ON r.`id_enquete` = ".$result->id." AND r.`num_opcao` = o.`numero`
		WHERE o.id_enquete = ".$result->id." 
		GROUP BY o.`numero`
		ORDER BY o.`id`, o.`numero`";

		$opcoes = $this->db->query($options_query)->result();
		$result->opcoes = $opcoes;

		$count_query = "SELECT 
		COUNT(num_opcao) AS total_resp 
		FROM
		respostas_enquetes 
		WHERE id_enquete = ".$result->id." 
		AND num_opcao > 0 ";

		$total_resp = $this->db->query($count_query)->result()[0];
		$result->total_resp = $total_resp->total_resp;

		$ip = $_SERVER['REMOTE_ADDR'];

		$voted_query = "SELECT 
		COUNT(id) AS votado 
		FROM
		respostas_enquetes 
		WHERE id_enquete = ".$result->id."
		AND ip_participante = '$ip'";

		$voted = $this->db->query($voted_query)->result()[0];

		$result->votado = $voted->votado;

		return $result;
	}

}