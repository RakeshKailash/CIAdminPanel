<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contatos_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function retrieve ($id = null)
	{
		if ($id != null) {
			$this->db->where('id', $id);
		}

		$result = $this->db->get('contatos')->result();

		return $result;
	}

	public function sendMail ($data=null)
	{
		if (!$data)
		{
			$result = array('status' => 'error', 'message' => '<p>Erro nas informações preenchidas, tente novamente!</p>');
			return $result;
		}

		foreach ($data as $item) {
			if (empty($item) || $item == "")
			{
				$result = array('status' => 'warning', 'message' => '<p>Preencha todos os campos para enviar a mensagem!</p>');
				return $result;
			}
		}

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'marcelo.boemeke@gmail.com',
			'smtp_pass' => 'markonoha031098',
			'mailtype' => 'html',
			'charset' => 'utf8',
			'wordwrap' => TRUE);
		$mensagem = "";

		$mensagem .= "<h2>".$data['subject']."</h2>";
		$mensagem .= "<p><b>Autor: </b> ".$data['name']."</p>";
		$mensagem .= "<p><b>Data: </b> ".date('d/m/Y\, \à\s H:i:s', time())."</p>";
		$mensagem .= "<p><b>E-mail: </b> ".$data['from']."</p>";
		$mensagem .= "<h4>Mensagem enviada através do formulário de contato no seu <a href='".base_url('site')."'>Site</a> </h4><br><br>";
		$mensagem .= "<h3>".$data['message']."</h3>";

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from($data['from']);
		$this->email->to($this->retrieve(1)[0]->email);
		$this->email->subject($data['subject']);
		$this->email->message($mensagem);

		$result = array('status' => 'success', 'message' => '<p>Mensagem enviada com sucesso!</p>');
		if (! $this->email->send())
		{
			$result = array('status' => 'error', 'message' => '<p>' . show_error($this->email->print_debugger()) . '</p>');
		}

		return $result;
	}

}