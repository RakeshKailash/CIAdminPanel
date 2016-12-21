<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function getUser ($id=null)
	{
		$this->db->select("id, nome, sobrenome, DATE_FORMAT(dataNascimento, '%d/%m/%Y') AS dataNascimento, login, email, imagem, ultimoAcesso, ultimaVerifNotif, tipoUsuario");
		if ($id)
		{
			$this->db->where('id', $id);
		}

		$result = $this->db->get('usuarios')->result();
		return $result;
	}

	public function getInfo($login, $password)
	{
		$this->db->where('login', $login);
		$query = $this->db->get('usuarios')->result_array()[0];

		$user_info =  isset($query['login']) ? $query : null;

		if ($user_info == null) {
			return array('error' => 1);
		}

		$verify = password_verify($password, $user_info['senha']);

		if ($verify != true) {
			return array('error' => 2);
		}

		$this->db->where(array(
			'login' => $login,
			'senha' => $user_info['senha']
			));

		$this->db->select("id, nome, sobrenome, DATE_FORMAT(dataNascimento, '%d/%m/%Y') AS dataNascimento, login, email, imagem, ultimoAcesso, ultimaVerifNotif, tipoUsuario");

		$result = $this->db->get('usuarios')->result_array()[0];
		$result['inicio'] = time();

		return $result;
	}

	function updateUserType ($id, $newType)
	{
		if (! $newType || ! $id)
		{
			$result = array('warning' => '<p>Todos os campos devem ser preenchidos para atualizar o usuário!</p>');
			return $result;
		}

		$this->db->set('tipoUsuario', $newType);
		$this->db->where('id', $id);
		if (!$this->db->update('usuarios'))
		{
			$result = array('error' => '<p>Ocorreu um erro. Tente novamente.</p>');
			return $result;
		}

		$result = array('success' => '<p>Usuário atualizado com sucesso!</p>');
		return $result;
	}

	function update ($id=null, $usuario=null)
	{
		if (! $usuario || empty($usuario['nome']) || empty($usuario['dataNascimento']) || empty($usuario['login']) || empty($usuario['email']))
		{
			$result = array('warning' => '<p>Todos os campos devem ser preenchidos para atualizar o usuário!</p>');
			return $result;
		}

		if (! $id)
		{
			$result = array('error' => '<p>Ocorreu um erro. Tente novamente.</p>');
			return $result;
		}

		$result = array('success' => '<p>Usuário atualizado com sucesso!</p>');


		$imgUsuario = $usuario['imagem'];
		$hasImg = $usuario['has_img'];
		$changeImg = $usuario['change_img'];

		unset($usuario['imagem']);
		unset($usuario['has_img']);
		unset($usuario['change_img']);

		if (! $hasImg)
		{
			$this->replaceUserImage($id, null);
		}

		if ($hasImg && $changeImg)
		{
			$this->replaceUserImage($id, $imgUsuario);
		}

		$this->db->where('id', $id);
		if (! $this->db->update('usuarios', $usuario))
		{
			$result = array('error' => '<p>Ocorreu um erro. Tente novamente.</p>');
		}

		return $result;
	}

	public function login($login, $password)
	{
		$userdata = $this->getInfo($login, $password);
		if (isset($userdata['error'])) {
			return $userdata;
		}

		$this->session->set_userdata($userdata);
		return $userdata;
	}

	public function isLogged ()
	{
		$user_logged = $this->session->userdata();
		if (isset($user_logged['login']) && $user_logged['login'] != null) {
			return true;
		}

		return false;
	}

	public function logout ($data=null)
	{
		if ($data === null)
		{
			$this->session->sess_destroy();
			return false;
		}

		if (! $this->sessions_model->insert($data))
		{
			$this->session->sess_destroy();
			return false;
		}

		$this->db->set('ultimoAcesso', date("Y-m-d H:i:s", time()));
		$this->db->where('id', $_SESSION['id']);
		$this->db->update('usuarios');

		$this->session->sess_destroy();
		return true;
	}

	public function viewNotifications ()
	{
		$userId = $_SESSION['id'];
		$tempo = date("Y-m-d H:i:s", time());
		$this->db->set('ultimaVerifNotif', $tempo);
		$this->session->set_userdata('ultimaVerifNotif', $tempo);
		$this->db->where('id', $userId);

		if (! $this->db->update('usuarios'))
		{
			return array('status' => 'Erro');
		}

		return array('status' => 'Sucesso');

	}

	public function refreshUserdata ()
	{
		$userdata = $this->getUserById($_SESSION['id']);

		if (!$userdata)
		{
			return false;
		}

		$_SESSION['id'] = $userdata['id'];
		$_SESSION['nome'] = $userdata['nome'];
		$_SESSION['sobrenome'] = $userdata['sobrenome'];
		$_SESSION['dataNascimento'] = $userdata['dataNascimento'];
		$_SESSION['login'] = $userdata['login'];
		$_SESSION['email'] = $userdata['email'];
		$_SESSION['imagem'] = $userdata['imagem'];
		$_SESSION['ultimoAcesso'] = $userdata['ultimoAcesso'];
		$_SESSION['ultimaVerifNotif'] = $userdata['ultimaVerifNotif'];

		return $userdata;
	}

	public function passRecoverCreate ($userid=null)
	{
		if (! $userid)
		{
			return false;
		}

		$user = $this->getUser($userid)[0];
		$passToken = $userid . $this->randStrGenerate();

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'marcelo.boemekeci@gmail.com',
			'smtp_pass' => 'testpassforci',
			'mailtype' => 'html',
			'charset' => 'utf8',
			'wordwrap' => TRUE);

		$dataHora = time();

		$mensagem = "";
		$mensagem .= "<h2 id='title'>Recuperação de Senha</h2>";
		$mensagem .= "<p class='p_mail'><b>De: </b> Projeto CI</p>";
		$mensagem .= "<p class='p_mail'><b>Data: </b> ".date('d/m/Y\, \à\s H:i:s', $dataHora)."</p>";
		$mensagem .= "<h4>".$user->nome.", você solicitou a recuperação da sua senha. Clique no link abaixo para ser redirecionado à página de redefinição de senha.</h4><br><br>";
		$mensagem .= "<div id='btn_pass'><a href=".base_url('sistema/usuarios/password_recovery/' . $passToken)." title='Recuperar a Senha' style='text-decoration: none; color: #333;'>Recuperar a Senha</a></div>";

		$mensagem .= "</style>";

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from("marcelo.boemeke@gmail.com");
		$this->email->to($user->email);
		$this->email->subject("Recuperação de Senha - Projeto CI");
		$this->email->message($mensagem);

		$result = array('status' => 'success', 'message' => '<p>Mensagem enviada com sucesso!</p>');
		if (! $this->email->send())
		{
			$result = array('status' => 'error', 'message' => '<p>'.show_error($this->email->print_debugger()).'</p>');
		}

		if (! $this->insertToken($passToken, $userid))
		{
			$result = array('status' => 'error', 'message' => '<p>Ocorreu um erro, tente novamente.</p>');
		}

		return $result;
	}

	public function retrieveToken ($token=null)
	{
		if (! $token)
		{
			return false;
		}


		$this->db->select('usuario, data_expira, disponivel');
		$tokenReg = $this->db->get('recuperacao_senha')->result();

		if (count($tokenReg) != 1)
		{
			$retorno = array('status' => 'error', 'message' => '<p>Não foi possível processar a solicitação, tente novamente.</p>');
		}

		if (!$tokenReg[0]->disponivel || date('Y-m-d', strtotime($tokenReg[0]->data_expira)) < date('Y-m-d', time()))
		{
			$retorno = array('status' => 'warning', 'message' => '<p>Esta redefinição de senha já expirou, solicite uma nova.</p>');
		}

		$retorno = array('status' => 'success', 'message' => '<p>Solicitação processada com sucesso! Agora você pode redefinir sua senha.</p>', 'userid' => $tokenReg[0]->usuario);

		return $retorno;
	}

	private function insertToken ($token=null, $userid=null)
	{
		if (! $token || ! $userid)
		{
			return false;
		}

		$query = "INSERT INTO recuperacao_senha (
				token,
				data_criacao,
				data_expira,
				usuario
			)
			VALUES (
				'$token',
				CURRENT_TIMESTAMP,
				DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 24 HOUR),
				$userid
			)";

		if (! $this->db->query($query))
		{
			return false;
		}

		return true;
	}

	private function getUserById ($id=null)
	{
		if (!$id)
		{
			return false;
		}

		$this->db->where('id', $id);

		$this->db->select("id, nome, sobrenome, DATE_FORMAT(dataNascimento, '%d/%m/%Y') AS dataNascimento, login, email, imagem, ultimoAcesso, ultimaVerifNotif, tipoUsuario");

		$query = $this->db->get('usuarios');

		if (! $query)
		{
			return false;
		}

		$result = $query->result_array()[0];

		return $result;
	}

	private function replaceUserImage ($user=null,$field=null)
	{
		if (! $user)
		{
			return false;
		}

		$caminho_pasta = str_replace('\\', DIRECTORY_SEPARATOR, FCPATH);
		if ($field) {
			$config_upload['upload_path'] = $caminho_pasta . 'images/uploads/profile/';
			$config_upload['allowed_types'] = 'gif|jpg|jpeg|png';
			$config_upload['max_size'] = '5120';
			$config_upload['max_width'] = '0';
			$config_upload['max_height'] = '0';
			$config_upload['encrypt_name'] = true;

			$this->load->library('upload', $config_upload);

			if (! $this->upload->do_upload($field)) {
				throw new Exception($this->upload->display_errors());
			}

			$info_img = $this->upload->data();
		} else {
			$info_img = array('file_name' => 'user.png', 'file_size' => 0);
		}

		$this->db->select('imagem');
		$this->db->from('usuarios');
		$this->db->where('id', $user);

		$img_anterior = $this->db->get()->result()[0];

		if ($img_anterior->imagem != 'user.png')
		{
			unlink($caminho_pasta . 'images/uploads/profile/' . $img_anterior->imagem);
		}

		$info_retorno['imagem']['nome'] = $info_img['file_name'];
		$info_retorno['imagem']['tamanho'] = $info_img['file_size'];
		$info_retorno['imagem']['caminho'] = $info_img['file_name'] != null ? ('images/uploads/sections/' . $info_img['file_name']) : null;

		$data_insert = array('imagem' => $info_img['file_name']);

		$this->db->where('id', $user);
		$update_img = $this->db->update('usuarios', $data_insert);

		if ( ! $update_img) {
			return false;
		}

		return $info_retorno;
	}

	private function randStrGenerate ($length=32)
	{
		$charList = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		$randStr = "";
		$randIndex = null;
		$prevIndex = null;

		for ($i=0; $i < $length; $i++) {
			$randIndex = rand(0, 61);

			while ($randIndex == $prevIndex)
			{
				$randIndex = rand(0, 61);
			}

			$randStr .= $charList[$randIndex];
			$prevIndex = $randIndex;
		}

		return $randStr;
	}

	public function updatePassword ($userid=null, $password=null)
	{
		if (! isset($_SESSION['verif_user']) || ! $_SESSION['verif_user'])
		{
			return false;
		}

		if (! $this->changePassword($password, $userid))
		{
			return false;
		}

		return true;
	}

	private function changePassword ($password=null, $userid=null)
	{
		if (! $userid || ! $password)
		{
			return false;
		}

		$newpass = password_hash($password, PASSWORD_BCRYPT);

		$this->db->set('senha', $newpass);
		$this->db->where('id', $userid);

		if (! $this->db->update('usuarios'))
		{
			return false;
		}

		return true;
	}
}