<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ferramentas_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getSurvey ($id=null) {
		if ($id)
		{
			$this->db->where('enquetes.`id`', $id);
		}

		$this->db->order_by('enquetes.`data_criacao`', 'DESC');
		$this->db->select('enquetes.id, enquetes.titulo, enquetes.descricao, usuarios.nome AS autor, usuarios.imagem AS img_autor, enquetes.data_criacao, enquetes.data_inicio, enquetes.data_final, enquetes.ultima_modif, enquetes.status');

		$this->db->join('usuarios', 'usuarios.id = enquetes.autor');

		$query = $this->db->get('enquetes');

		if (! $query)
		{
			return false;
		}

		$results = $query->result();

		foreach ($results as &$result) {
			$this->db->select('descricao, numero');
			$this->db->where('id_enquete', $result->id);
			$this->db->order_by('numero', 'ASC');

			$query = $this->db->get('opcoes_enquetes');

			if (!$query) {
				return false;
			}

			$opcoes = $query->result();
			$result->opcoes = $opcoes;
		}

		return $results;
	}

	public function saveSurvey($data=null, $idEnquete=null)
	{
		if (! $data)
		{
			return false;
		}

		if (! $idEnquete || $idEnquete < 1)
		{
			$data['autor'] = $_SESSION['id'];
			if (! $this->insertSurvey($data))
			{
				return false;
			}

			return true;
		}

		if (! $this->updateSurvey($data, $idEnquete))
		{
			return false;
		}

		return true;

	}

	private function insertSurvey ($data=null)
	{
		if (! $this->db->insert('enquetes', $data))
		{
			return false;
		}

		return true;
	}

	private function updateSurvey ($data=null, $id=null)
	{
		$this->db->set($data);
		$this->db->where('id', $id);

		if (! $this->db->update('enquetes'))
		{
			return false;
		}

		return true;
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