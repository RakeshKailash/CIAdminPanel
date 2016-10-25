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
	}

	public function index() {
		// $user_logged = $this->session->userdata();
		// if (isset($user_logged['login']) && $user_logged['login'] != null) {
		// 	$this->load->view('sistema/home', $user_logged);
		// } else {
		// 	redirect('/sistema/login');
		// }

		if ($this->usuario_model->isLogged()) {
			$this->load->view('sistema/home');
		} else {
			redirect('sistema/login');
		}
	}

	public function login() {

		if ($this->usuario_model->isLogged()) {
			redirect('sistema');
		} else {
			$this->load->view('sistema/login');

			$user = $this->input->post('login');
			$password = $this->input->post('senha');
			$details = null;

			if ($user != null && $password != null) {
				$login = $this->usuario_model->login($user, $password);

				if ($login != false) {
					$data = $this->session->userdata();
					redirect('sistema');
				} else {
					$details = array('error' => "<p>Erro no login</p>");
					$this->load->view('sistema/login', $details);
				}

			} else {
				$this->load->view('sistema/login');
			}
		}

	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('/sistema/login');
	}

}