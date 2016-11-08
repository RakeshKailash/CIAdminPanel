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

		$this->db->select('id, nome, login, email, imagem, ultimoAcesso');

		$result = $this->db->get('usuarios')->result_array()[0];
		$result['inicio'] = time();

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

	public function isLogged()
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

}