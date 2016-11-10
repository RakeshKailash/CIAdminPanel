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

		$views = $this->analise_sistema->retrieveLast();

		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['registro'] = $this->secoes_sistema->getInfo(1)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['views'] = $views;

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

	public function viewUpdate ($id=null)
	{
		if ($id === null)
		{
			$retorno = (object) array('count' => null);
			echo json_encode($retorno);
		}

		$update = $this->db->select('visualizada')->where('id', $id)->get('atualizacoes')->result()[0]->visualizada;

		print_r($update);

		if (strstr($update, '|'))
		{
			$updateArray = explode('|', $update);
			$status = in_array($_SESSION['id'], $update) ? null : ('|' . $_SESSION['id']);
		} else {
			$status = ($update === $_SESSION['id']) ? null : ('|' . $_SESSION['id']);
		}

		$this->db->set('visualizada', ($update . $status));
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