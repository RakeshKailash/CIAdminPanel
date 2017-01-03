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
	}

	public function index ()
	{
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}

		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['secoes'] = $this->secoes_sistema->getInfo();
		// $this->usuario_model->passRecoverCreate($_SESSION['id']);
		$this->load->view('sistema/usuarios/controle_usuarios', $info);
	}

	public function getInfo ($userId=null)
	{
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}

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

	public function update_current ()
	{
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}

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

	public function update_another ()
	{
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}

		$tipoUsuario = $this->input->post('tipo_usuario');
		$id = $this->input->post('id_usuario_modal');

		$result = $this->usuario_model->updateUserType($id, $tipoUsuario);

		$this->session->set_flashdata($result);
		return redirect(base_url('sistema/usuarios'));
	}

	public function lost_password ()
	{
		if ($this->usuario_model->isLogged()) {
			return redirect('sistema');
		}

		$email = $this->input->post('email_pass_recover');

		if (! $email)
		{
			$this->session->set_flashdata('warning', '<p>Informe seu E-mail cadastrado, para poder recuperar sua senha!</p>');
			return redirect(base_url('sistema/login'));
		}

		$user = $this->db->select('id')->where('email', $email)->get('usuarios')->result()[0];

		if (! $user)
		{
			$this->session->set_flashdata('error', '<p>Não encontramos nenhum registro para o E-mail informado!</p>');
			return redirect(base_url('sistema/login'));
		}

		if (! $this->usuario_model->passRecoverCreate($user->id))
		{
			$this->session->set_flashdata('error', '<p>Ocorreu um erro, tente novamente.</p>');
			return redirect(base_url('sistema/login'));
		}

		$this->session->set_flashdata('success', '<p>Solicitação realizada com sucesso! Um E-mail com instruções para a redefinição da sua senha foi enviado para o seu E-mail cadastrado</p>');
		return redirect(base_url('sistema/login'));
	}

	public function password_recovery ($token=null)
	{
		if ($this->usuario_model->isLogged()) {
			return redirect('sistema');
		}

		if (! $token)
		{
			return redirect('site');
		}

		$tokenStatus = $this->usuario_model->retrieveToken($token);
		$result[$tokenStatus['status']] = $tokenStatus['message'];

		if ($tokenStatus['status'] != 'success')
		{
			$this->session->set_flashdata($tokenStatus['status'], $tokenStatus['message']);
			return redirect('sistema/login');
		}

		$result['userid'] = $tokenStatus['userid'];

		return $this->load->view('sistema/redefinir_senha', $result);
	}

	public function update_password ()
	{
		if ($this->usuario_model->isLogged()) {
			return redirect('sistema');
		}

		if (! isset($_POST['nova_senha']) || ! isset($_POST['nova_senha_confirmar']) || ! isset($_POST['userid']))
		{
			return redirect('site');
		}

		if ($this->input->post('nova_senha') != $this->input->post('nova_senha_confirmar'))
		{
			$this->session->set_flashdata('warning', '<p>As Senhas digitadas não conferem.</p>');
			return redirect('sistema/main/login');
		}

		$userid = $this->input->post('userid');
		$password = $this->input->post('nova_senha');

		$this->session->set_flashdata('verif_user', true);
		if (! $this->usuario_model->updatePassword($userid, $password))
		{
			$this->session->set_flashdata('error', '<p>Ocorreu um erro, tente novamente.</p>');
			return redirect('sistema/main/login');
		}

		$this->usuario_model->updateTokens($userid, array('disponivel' => 0));

		$this->session->set_flashdata('success', '<p>Senha redefinida com sucesso! Você já pode usar a nova senha para acessar sua conta.</p>');
		return redirect('sistema/main/login');
	}
}