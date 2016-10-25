<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function getInfo($login, $password) {
		$this->db->where('login', $login);
		$query = $this->db->get('usuarios');

		$encpass =  $query->result_array();

		if (isset($encpass[0]) && $encpass[0] != null) {

			$verify = password_verify($password, $encpass[0]['senha']);
			if ($verify == true) {
				$this->db->where(array(
					'login' => $login,
					'senha' => $encpass[0]['senha']
					));

				$this->db->select('id, nome, login, email, imagem');

				$result = $this->db->get('usuarios');

				// $result->result_array()[0]['senha'] = null;

				return $result->result_array()[0];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function login($login, $password) {
		$userdata = $this->getInfo($login, $password);
		if ($userdata != false) {
			$this->session->set_userdata($userdata);
			return $userdata;
		} else {
			return false;
		}
	}

	public function isLogged() {
		$user_logged = $this->session->userdata();
		if (isset($user_logged['login']) && $user_logged['login'] != null) {
			// $this->load->view("sistema/$target_view", $user_logged);
			return true;
		}
		
		return false;

	}

}