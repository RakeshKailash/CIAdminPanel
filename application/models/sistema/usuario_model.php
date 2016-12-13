<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
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

		$this->db->select("id, nome, sobrenome, DATE_FORMAT(dataNascimento, '%d/%m/%Y') AS dataNascimento, login, email, imagem, ultimoAcesso, ultimaVerifNotif");

		$result = $this->db->get('usuarios')->result_array()[0];
		$result['inicio'] = time();

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

	private function getUserById ($id=null)
	{
		if (!$id)
		{
			return false;
		}

		$this->db->where('id', $id);

		$this->db->select("id, nome, sobrenome, DATE_FORMAT(dataNascimento, '%d/%m/%Y') AS dataNascimento, login, email, imagem, ultimoAcesso, ultimaVerifNotif");

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
}