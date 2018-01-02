<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	function __construct () {
		parent::__construct();
	}

	public function index() {
		// $caminho_pasta = str_replace('\\', "/", FCPATH);
		// $caminho_pasta = $caminho_pasta . 'images/uploads/city - Copia.jpeg';

		// $this->load->library('ImageManipulation', '', 'img');
		// $this->img->squareCrop($caminho_pasta, $caminho_pasta);
	}
}