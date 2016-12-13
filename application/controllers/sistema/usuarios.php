<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/imagens_model');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}
	}

	public function index ()
	{
		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$this->load->view('sistema/usuarios/controle_usuarios', $info);
	}

	public function update ()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email_usuario', 'E-mail', 'required|valid_email');
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('nome_usuario', 'Nome de Usuário', 'required|alpha');
		$this->form_validation->set_rules('data_nascimento', 'Data de Nascimento', 'required');

		$id = $this->input->post('id_usuario');
		$email_usuario = $this->input->post('email_usuario');

		$this->db->select('email');
		$this->db->where("`id` != '$id' AND `email` = '$email_usuario'");

		$emailExists = $this->db->get('usuarios')->result() ? true : false;

		if (! $this->form_validation->run())
		{
			$result = array('status' => 'warning', 'message' => validation_errors());
			echo json_encode($result);
			return false;
		}

		if ($emailExists)
		{
			$result = array('status' => 'warning', 'message' => 'O campo E-mail já existe, ele deve ser único');
			echo json_encode($result);
			return false;
		}

		$dataNascimento = DateTime::createFromFormat('d/m/Y', $this->input->post('data_nascimento'));
		$dataNascimento = $dataNascimento->format('Y-m-d');

		$data['nome'] = $this->input->post('nome');
		$data['sobrenome'] = $this->input->post('sobrenome');
		$data['dataNascimento'] = $dataNascimento;
		$data['login'] = $this->input->post('nome_usuario');
		$data['email'] = $email_usuario;
		$data['imagem'] = $this->input->post('imagem');

		$result = $this->usuario_model->update($id, $data);
		echo json_encode($result);

	}
}