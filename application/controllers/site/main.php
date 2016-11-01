<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		$this->load->model('site/imagens_model', 'imagens_site');
		$this->load->model('site/contatos_model');
	}

	public function index ()
	{
		$this->load->view('site/home');
		// $result = $this->secoes_site->getInfo2(1);
		// var_dump($result);
	}

	public function servicos ()
	{
		$this->load->view('site/servicos');
	}

	public function empresa ()
	{
		$this->load->view('site/empresa');
	}

	public function imagens ()
	{
		$this->load->view('site/imagens');
	}

	public function contato ()
	{
		$this->load->view('site/contato');
	}
}