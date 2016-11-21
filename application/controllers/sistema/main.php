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

		$today = date('Y-m-d', time());

		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['registro'] = $this->secoes_sistema->getInfo(1)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['views'] = $this->analise_sistema->retrieveLast();
		$info['viewsToday']['home'] = $this->analise_sistema->retrieveAllBy(array('dateYmd' => $today, 'section' => 1));
		$info['viewsToday']['servicos'] = $this->analise_sistema->retrieveAllBy(array('dateYmd' => $today, 'section' => 2));
		$info['viewsToday']['empresa'] = $this->analise_sistema->retrieveAllBy(array('dateYmd' => $today, 'section' => 3));
		$info['viewsToday']['imagens'] = $this->analise_sistema->retrieveAllBy(array('dateYmd' => $today, 'section' => 4));
		$info['viewsToday']['contato'] = $this->analise_sistema->retrieveAllBy(array('dateYmd' => $today, 'section' => 5));

		$info['viewsSections']['home'] = $this->analise_sistema->retrieveAllBy(array('section' => 1));
		$info['viewsSections']['servicos'] = $this->analise_sistema->retrieveAllBy(array('section' => 2));
		$info['viewsSections']['empresa'] = $this->analise_sistema->retrieveAllBy(array('section' => 3));
		$info['viewsSections']['imagens'] = $this->analise_sistema->retrieveAllBy(array('section' => 4));
		$info['viewsSections']['contato'] = $this->analise_sistema->retrieveAllBy(array('section' => 5));

		$this->load->view('sistema/home', $info);
	}

	public function login ()
	{
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
		// $details = null;

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

		$data = $this->session->userdata();
		return redirect('sistema');
	}

	public function logout ()
	{
		$data['id_usuario'] = $_SESSION['id'];
		$data['login'] = $_SESSION['login'];
		$data['inicio'] = $_SESSION['inicio'];

		$this->usuario_model->logout($data);

		redirect('/sistema/login');
	}

	public function viewNotifications ()
	{
		$result = $this->usuario_model->viewNotifications();
		echo json_encode($result);
	}

}