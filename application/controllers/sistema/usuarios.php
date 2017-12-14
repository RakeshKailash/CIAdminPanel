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
		// $this->usuario_model->passRecoverCreate($_SESSION['id']);
		$this->load->view('sistema/usuarios/controle_usuarios', $info);
	}

	public function get_info ($userId=null)
	{
		if (! $userId)
		{
			$result = array('status' => false);
			echo json_encode($result);
			return false;
		}

		$usuario = $this->usuario_model->getUser($userId);

		if (! $usuario) {
			$result = array('status' => false);
			echo json_encode($result);
			return false;
		}

		$result = array('status' => 1, 'user' => $usuario[0]);
		echo json_encode($result);
	}

	public function update_current ()
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

		$emailExists = $this->db->get('usuarios')->result()[0]->email ? true : false;

		if ($emailExists)
		{
			$result = array('warning' => 'O campo E-mail já existe, ele deve ser único');
			$this->session->set_flashdata($result);
			return redirect(base_url('sistema/usuarios'));
		}

		if (! $this->form_validation->run())
		{
			$result = array('warning' => validation_errors());
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
				$result = array('status' => 'Ocorreu um erro inesperado. Tente novamente.');
				$this->session->set_flashdata($result);
				return redirect(base_url('sistema/usuarios'));
			}
		}

		$atualizacao['titulo'] = "Usuário \"".$_SESSION['nome']."\" alterou suas informações";
		$atualizacao['usuario'] = $_SESSION['id'];
		$atualizacao['tipo'] = "Alteração de Conta de Usuário";
		$this->atualizacoes_sistema->insert($atualizacao);

		$this->session->set_flashdata($result);
		return redirect(base_url('sistema/usuarios'));

	}

	// public function update_another ()
	// {
	// 	if (! $this->usuario_model->isLogged()) {
	// 		redirect('sistema/login');
	// 	}

	// 	$tipoUsuario = $this->input->post('tipo_usuario');
	// 	$id = $this->input->post('id_usuario_modal');

	// 	$result = $this->usuario_model->updateUserType($id, $tipoUsuario);
	// 	$usuario = $this->usuario_model->getUser($id)[0];

	// 	$atualizacao['titulo'] = "Usuário '".$_SESSION['nome']."' alterou as informações do usuário '".$usuario->nome."'";
	// 	$atualizacao['usuario'] = $_SESSION['id'];
	// 	$atualizacao['tipo'] = "Alteração de Conta de Usuário";

	// 	$this->atualizacoes_sistema->insert($atualizacao);

	// 	$this->session->set_flashdata($result);
	// 	return redirect(base_url('sistema/usuarios'));
	// }

	public function create ()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name_usuario_modal', 'Nome', 'required');
		$this->form_validation->set_rules('birth_usuario_modal', 'Data de Nascimento', 'required');
		$this->form_validation->set_rules('login_usuario_modal', 'Nome de Usuário', 'required|alpha_numeric|is_unique[usuarios.login]');
		$this->form_validation->set_rules('email_usuario_modal', 'E-mail', 'required|valid_email');
		$this->form_validation->set_rules('pass_usuario_modal', 'Senha', 'required|alpha_numeric|min_length[8]');
		$this->form_validation->set_rules('repass_usuario_modal', 'Repita a Senha', 'required|matches[pass_usuario_modal]');

		if (!$this->form_validation->run()) {
			if (! $this->form_validation->run())
			{
				$result = array('warning' => validation_errors('<p>','</p>'));
				$this->session->set_flashdata($result);
				return redirect('sistema/usuarios');
			}
		}

		$dataNascimento = DateTime::createFromFormat('d/m/Y', $_POST['birth_usuario_modal']);
		$dataNascimento = $dataNascimento->format('Y-m-d');

		$data['nome'] = $_POST['name_usuario_modal'];
		$data['sobrenome'] = $_POST['surname_usuario_modal'];
		$data['dataNascimento'] = $dataNascimento;
		$data['login'] = $_POST['login_usuario_modal'];
		$data['email'] = $_POST['email_usuario_modal'];
		$data['senha'] = $_POST['pass_usuario_modal'];

		$insert_user = $this->usuario_model->createUser($data);

		if (!$insert_user) {
			$result = array('error' => '<p>Ocorreu um erro, tente novamente.</p>');
			$this->session->set_flashdata($result);
			return redirect(base_url('sistema/usuarios'));
		}

		$usuario = $this->usuario_model->getUser($insert_user)[0];

		$atualizacao['titulo'] = "Usuário \"".$_SESSION['nome']."\" criou o usuário \"".$usuario->nome."\"";
		$atualizacao['usuario'] = $_SESSION['id'];
		$atualizacao['tipo'] = "Criação de Usuário";
		$this->atualizacoes_sistema->insert($atualizacao);

		$result = array('success' => '<p>Usuário criado com sucesso.</p>');
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

	public function update_current_password ()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('newpass_usuario_modal', 'Nova Senha', 'required|matches[newpass_confirm_usuario_modal]|min_length[8]');
		$this->form_validation->set_rules('newpass_confirm_usuario_modal', 'Confirme a Nova Senha', 'required');
		$this->form_validation->set_rules('oldpass_usuario_modal', 'Senha Antiga', 'required');

		if (! $this->form_validation->run())
		{
			$return = array('warning' => validation_errors('<p>', '</p>'));
			$this->session->set_flashdata($return);
			return redirect('sistema/usuarios');
		}

		$newpass = $this->input->post('newpass_usuario_modal');
		$newpass_confirm = $this->input->post('newpass_confirm_usuario_modal');
		$oldpass = $this->input->post('oldpass_usuario_modal');
		$userid = $this->input->post('id_usuario_modal');

		if (! $this->usuario_model->verif_password($userid, $oldpass))
		{
			$return = array('error' => '<p>O campo Senha Antiga não confere com a sua senha. Se você esqueceu, saia da conta e solicite a Recuperação de Senha.</p>');
			$this->session->set_flashdata($return);
			return redirect('sistema/usuarios');
		}

		$this->session->set_flashdata('verif_user', true);

		if (! $this->usuario_model->updatePassword($userid, $newpass))
		{
			$return = array('error' => '<p>Ocorreu um erro. Por favor, tente novamente.</p>');
			$this->session->set_flashdata($return);
			return redirect('sistema/usuarios');
		}

		$return = array('success' => '<p>Senha alterada com sucesso!</p>');
		$this->session->set_flashdata($return);
		return redirect('sistema/usuarios');
	}

	public function delete ($ids) {
		// $userid = !empty($id) ? $id : $_POST['id_usuario_modal'];

		// if (empty($userid) || $userid < 1 || ! is_numeric($userid)) {
		// 	$return = array('error' => '<p>Erro ao excluir usuário</p>');
		// 	$this->session->set_flashdata($return);
		// 	return redirect('sistema/usuarios');
		// }

		// $usuario = $this->usuario_model->getUser($userid)[0];

		// if (! $this->usuario_model->deleteUser($userid)) {
		// 	$return = array('error' => '<p>Erro ao excluir usuário</p>');
		// 	$this->session->set_flashdata($return);
		// 	return redirect('sistema/usuarios');
		// }

		// $atualizacao['titulo'] = "Usuário \"".$_SESSION['nome']."\" excluiu o usuário \"".$usuario->nome."\"";
		// $atualizacao['usuario'] = $_SESSION['id'];
		// $atualizacao['tipo'] = "Exclusão de Usuário";
		// $this->atualizacoes_sistema->insert($atualizacao);

		// $return = array('success' => '<p>Usuário excluído com sucesso!</p>');
		// $this->session->set_flashdata($return);
		// return redirect('sistema/usuarios');

		if($ids == null) {
			if (! isset($_POST['id_usuario_modal'])) {
				$this->session->set_flashdata('error', "<p>Erro desconhecido. Tente novamente!</p>");
				return redirect('sistema/usuarios');
			}

			$ids = $_POST['id_usuario_modal'];
		}

		if (strpos($ids, "_") !== false) {
			$ids = explode("_", $ids);
		} else {
			$ids = array(0 => $ids);
		}

		foreach ($ids as $id) {
			if (! $this->usuario_model->deleteUser($id)) {
				$this->session->set_flashdata('error', "<p>Erro ao excluir o(s) usuário(s)</p>");
				return redirect('sistema/usuarios');
			}
		}

		$atualizacao['titulo'] = "Usuário \"".$_SESSION['nome']."\" excluiu um ou mais usuários";
		$atualizacao['usuario'] = $_SESSION['id'];
		$atualizacao['tipo'] = "Exclusão de Usuários";

		$this->atualizacoes_sistema->insert($atualizacao);

		$this->session->set_flashdata('success', "<p>Exclusão realizada com sucesso!</p>");
		return redirect('sistema/usuarios');

	}
}