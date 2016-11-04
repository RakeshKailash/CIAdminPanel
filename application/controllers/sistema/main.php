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
		
	}

	public function index ()
	{
		if (! $this->usuario_model->isLogged()) {
			return redirect('sistema/login');
		}

		$data['atualizacoes'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$data['secoes'] = $this->secoes_sistema->getInfo();
		$data['registro'] = $this->secoes_sistema->getInfo(1)[0];

		$this->load->view('sistema/home', $data);
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
		$data['id_secao'] = $this->session->session_id;
		$data['id_usuario'] = $_SESSION['id'];
		$data['login'] = $_SESSION['login'];
		$data['inicio'] = $_SESSION['inicio'];

		$this->sessions_model->insert($data);

		$this->session->sess_destroy();
		redirect('/sistema/login');
	}

	public function viewUpdate ($id=null)
	{
		if ($id === null)
		{
			$retorno = (object) array('count' => null);
			echo json_encode($retorno);
		}

		$this->db->set('visualizada', 'true');
		$this->db->where('id', $id);
		if (! $this->db->update('atualizacoes'))
		{
			$retorno = (object) array('count' => null);
			echo json_encode($retorno);
		}

		$count = count($this->atualizacoes_sistema->retrieveUnviewed());
		$retorno = (object) array('count' => $count);
		echo json_encode($retorno);
	}

}