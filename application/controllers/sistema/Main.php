<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
		$this->load->model('sistema/sessions_model');
		$this->load->model('sistema/analise_model', 'analise_sistema');
	}

	public function index ()
	{
		if (! $this->usuario_model->isLogged()) {
			return redirect('sistema/login');
		}

		$info['info_views'] = $this->analise_sistema->getChartsInfo();

		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['registro'] = $this->secoes_sistema->getInfo(1)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();

		$this->load->view('sistema/home', $info);
	}

	public function login ()
	{
		if ($this->usuario_model->isLogged()) {
			return redirect('sistema');
		}

		$this->load->view('sistema/login');
	}

	public function logar ()
	{
		if ($this->usuario_model->isLogged()) {
			return redirect('sistema');
		}

		$this->load->view('sistema/login');

		$user = $this->input->post('login');
		$password = $this->input->post('senha');

		if ($user == null || $password == null) {
			return redirect('sistema/login');
		}

		$login = $this->usuario_model->login($user, $password);

		if (isset($login['error'])) {
			$message = "Erro";

			switch ($login['error']) {
				case 1:
				$message = "Usuário não encontrado";
				break;
				case 2:
				$message = "A Senha digitada está incorreta";
				break;
				default:
				$message = "Erro desconhecido, tente novamente";
				break;
			}

			$this->session->set_flashdata('error', "<p>".$message."</p>");
			redirect('sistema/login');
		}

		$data['id_usuario'] = $_SESSION['id'];
		$data['login'] = $_SESSION['login'];
		$data['inicio'] = $_SESSION['inicio'];

		$insertSession = $this->sessions_model->insert($data);

		if (! $insertSession)
		{
			$this->session->set_flashdata('error', "<p>Erro desconhecido. Tente novamente</p>");
			redirect('sistema/login');
		}

		return redirect('sistema');
	}

	public function logout ()
	{
		$this->usuario_model->logout();

		redirect('/sistema/login');
	}

	public function viewNotifications ()
	{
		$result = $this->usuario_model->viewNotifications();
		echo json_encode($result);
	}

	public function refresh_session ()
	{
		$this->db->set('fim', time());
		$this->db->where('id', $_SESSION['record_id']);
		$this->db->update('sessions');
	}

	public function get_online_users ()
	{
		$this->usuario_model->getOnlineUsers();
	}

	//Custom Statiscs Stuff
	// public function updateStatistics ($dataInicial, $dataFinal) {
	// 	$dataInicial = $this->formatDate($dataInicial);
	// 	$dataFinal = $this->formatDate($dataFinal);

	// 	$result['result'] = $this->analise_sistema->retrieveAllBy(array('custom' => "DATE(`data`) >= '".$dataInicial."' AND DATE(`data`) <= '".$dataFinal."'"));
	// 	$result['status'] = true;
	// 	$result['type'] = 'between';

	// 	echo json_encode($result);

	// }

	private function formatDate($date)
	{
		return implode('-', array_reverse(explode('_', $date)));
	}

}