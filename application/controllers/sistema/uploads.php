<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/uploads_model');
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}
	}

	public function uploadFiles () {
		if ($_SESSION['tipoUsuario'] == 1) {
			echo 0;
			return false;
		}

		if (! $this->uploads_model->uploadFile('arquivos_upload')) {
			echo 0;
			return false;
		}

		$arquivos = $this->uploads_model->getFiles();

		if (! $arquivos) {
			echo 0;
			return false;
		}

		echo json_encode($arquivos);
		return true;
	}

}