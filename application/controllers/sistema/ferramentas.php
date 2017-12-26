<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ferramentas extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/imagens_model');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
		$this->load->model('sistema/ferramentas_model');
		$this->load->library('form_validation');
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}
	}

	public function index ()
	{

	}

	public function enquetes ($id=null) {
		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['enquetes'] = $this->ferramentas_model->getSurvey();

		if ($id) {
			$info['enquete_edit'] = $this->ferramentas_model->getSurvey($id)[0];
		}

		$this->load->view('sistema/ferramentas/enquetes', $info);
	}

	public function updateSurveyOptions ($options=null, $survey_id=null) {
		if ((! $options && ! isset($_POST['options'])) || (!$survey_id && ! isset($_POST['survey_id']))) {
			echo json_encode(false);
			return false;
		}

		$options = empty($options) ? $_POST['options'] : $options;
		$survey_id = empty($survey_id) ? $_POST['survey_id'] : $survey_id;

		if (! $this->ferramentas_model->updateSurveyOptions($options, $survey_id)) {
			echo json_encode(false);
			return false;
		}

		echo json_encode(true);
		return true;
	}

	public function switchSurvey () {
		if ($_SESSION['tipoUsuario'] != 1)
		{
			$result = array(0 => false);
			echo json_encode($result);
			return false;
		}

		if (! isset($_POST['enqueteid']) || ! isset($_POST['status']))
		{
			$result = array(0 => false);
			echo json_encode($result);
			return false;
		}

		$idEnquete = $this->input->post('enqueteid');
		$data['status'] = $this->input->post('status') == 1 ? 2 : 1;

		if (! $this->ferramentas_model->saveSurvey($data, $idEnquete))
		{
			$result = array(0 => false);
			echo json_encode($result);
			return false;
		}

		$result = array(0 => true);
		echo json_encode($result);
		return true;
	}

}