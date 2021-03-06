<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ferramentas_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getSurvey ($id=null, $datetime=false) {
		if ($id)
		{
			$this->db->where('enquetes.`id`', $id);
		}

		$date = $datetime ? "enquetes.data_criacao, enquetes.data_inicio, enquetes.data_final" : "DATE_FORMAT(enquetes.data_criacao, '%Y-%m-%d') AS data_criacao, DATE_FORMAT(enquetes.data_inicio, '%Y-%m-%d') AS data_inicio, DATE_FORMAT(enquetes.data_final, '%Y-%m-%d') AS data_final";

		$this->db->order_by('enquetes.`data_criacao`', 'DESC');
		$this->db->select("enquetes.id, enquetes.titulo, enquetes.descricao, usuarios.nome AS autor, usuarios.imagem AS img_autor, $date, enquetes.ultima_modif, enquetes.status");

		$this->db->join('usuarios', 'usuarios.id = enquetes.autor');

		$query = $this->db->get('enquetes');

		if (! $query)
		{
			return false;
		}

		$results = $query->result();

		foreach ($results as &$result) {

			$sql = "SELECT 
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

			$opcoes = $this->db->query($sql)->result();
			$result->opcoes = $opcoes;

			$sql = "SELECT 
			COUNT(num_opcao) AS total_resp 
			FROM
			respostas_enquetes 
			WHERE id_enquete = ".$result->id." 
			AND num_opcao > 0 ";

			$total_resp = $this->db->query($sql)->result()[0];
			$result->total_resp = $total_resp->total_resp;
		}

		return $results;
	}

	public function saveSurvey($data=null, $idEnquete=null, $options=null)
	{
		if (empty($data) || (! $idEnquete && empty($options))) {
			return false;
		}

		if (! $idEnquete || $idEnquete < 1)
		{
			$data['autor'] = $_SESSION['id'];
			$insert = $this->insertSurvey($data);

			if (! $insert) {
				return false;
			}

			if ($options) {
				return $this->insertSurveyOptions($options, $insert);
			}

			return true;
		}

		if (! $this->updateSurvey($data, $idEnquete))
		{
			return false;
		}

		return true;

	}

	private function insertSurveyOptions ($options=null, $survey_id=null) {
		if (!$options || !$survey_id) {
			return false;
		}

		$number = 1;
		$inserted_list = array();
		$option_insert = array('id_enquete' => $survey_id);

		foreach ($options as &$option) {
			$option_insert['numero'] = $number;
			$option_insert['descricao'] = $option;

			$query = $this->db->insert('opcoes_enquetes', $option_insert);

			if (!$query) {
				return false;
			}

			$inserted_list[] = $this->db->insert_id();
			$number++;
		}

		return $inserted_list;
	}

	private function insertSurvey ($data=null)
	{
		if (! $this->db->insert('enquetes', $data))
		{
			return false;
		}

		return $this->db->insert_id();
	}

	private function updateSurvey ($data=null, $id=null)
	{
		$this->db->set($data);
		$this->db->set('ultima_modif', date("Y-m-d H:i:s", time()));
		$this->db->where('id', $id);

		if (! $this->db->update('enquetes'))
		{
			return false;
		}

		return true;
	}

	public function deleteSurvey($id=null)
	{
		if (!$id) {
			return false;
		}

		$this->db->where('id', $id);
		return !!$this->db->delete('enquetes');
	}

	public function updateSurveyOptions ($options=null, $survey_id=null) {
		if (!$options || !$survey_id) {
			return false;
		}

		foreach ($options as $option) {
			if (!isset($option['descricao']) || !isset($option['numero']) || empty($option['descricao']) || empty($option['numero'])) {
				return false;
			}

			$this->db->select('id');
			$this->db->where('id_enquete', $survey_id);
			$this->db->where('numero', $option['numero']);

			$query = $this->db->get('opcoes_enquetes');

			if (!$query) {
				return false;
			}

			$data = array();
			$data['descricao'] = $option['descricao'];
			$data['numero'] = $option['numero'];
			$data['id_enquete'] = $survey_id;

			if ($query->num_rows() > 0) {
				$this->db->set($data);
				$this->db->where('id_enquete', $survey_id);
				$this->db->where('numero', $option['numero']);
				$query = $this->db->update('opcoes_enquetes');
			} else {
				$query = $this->db->insert('opcoes_enquetes', $data);
			}

			$this->db->reset_query();

			if (!$query) {
				return false;
			}
		}

		$this->db->where('numero > '.sizeof($options));
		$this->db->where('id_enquete', $survey_id);
		$query = $this->db->delete('opcoes_enquetes');

		if (!$query) {
			return false;
		}

		return true;
	}

}