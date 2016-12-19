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

	public function getInfo ($userId=null)
	{
		if (! $userId)
		{
			$result = array('status' => false);
			echo json_encode($result);
			return false;
		}

		$this->db->where('usuarios.id', $userId);
		$this->db->select(
			"usuarios.id,
			usuarios.nome,
			usuarios.sobrenome,
			DATE_FORMAT(usuarios.dataNascimento, '%d/%m/%Y') AS dataNascimento,
			usuarios.login,
			usuarios.email,
			usuarios.imagem,
			DATE_FORMAT(usuarios.ultimoAcesso, '%d/%m/%Y, às %H:%i:%s') AS ultimoAcesso,
			DATE_FORMAT(usuarios.ultimaVerifNotif, '%d/%m/%Y %H:%i:%s') AS ultimaVerifNotif,
			tipos_usuarios.nome AS tipoUsuario"
		);

		$this->db->join('tipos_usuarios', 'tipos_usuarios.id = usuarios.tipoUsuario');
		$query = $this->db->get('usuarios');

		$result = array('status' => 1, 'user' => $query->result()[0]);
		echo json_encode($result);
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
			$this->session->set_flashdata($result);
			return redirect(base_url('sistema/usuarios'));
		}

		if ($emailExists)
		{
			$result = array('status' => 'warning', 'message' => 'O campo E-mail já existe, ele deve ser único');
			$this->session->set_flashdata($result);
			return redirect(base_url('sistema/usuarios'));
		}

		$dataNascimento = DateTime::createFromFormat('d/m/Y', $this->input->post('data_nascimento'));
		$dataNascimento = $dataNascimento->format('Y-m-d');

		$data['nome'] = $this->input->post('nome');
		$data['sobrenome'] = $this->input->post('sobrenome');
		$data['dataNascimento'] = $dataNascimento;
		$data['login'] = $this->input->post('nome_usuario');
		$data['email'] = $email_usuario;
		$data['imagem'] = 'imagem';
		$data['has_img'] = !!$this->input->post('has_img');
		$data['change_img'] = $data['has_img'] && !empty($_FILES['imagem']['name']);

		$result = $this->usuario_model->update($id, $data);

		if (isset($result['success']))
		{
			if (! $this->usuario_model->refreshUserdata())
			{
				$result = array('status' => 'error', 'message' => 'Ocorreu um erro inesperado. Tente novamente.');
				$this->session->set_flashdata($result);
				return redirect(base_url('sistema/usuarios'));
			}
		}

		$this->session->set_flashdata($result);
		return redirect(base_url('sistema/usuarios'));

	}
}