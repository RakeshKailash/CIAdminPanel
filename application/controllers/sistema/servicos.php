<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos extends CI_Controller {

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

	public function index() 
	{
		redirect('sistema/servicos/editar');
	}

	public function editar ()
	{
		$info['registro'] = $this->secoes_sistema->getInfo(2)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['atualizacoes'] = $this->atualizacoes_sistema->retrieve(null, 5);

		$this->load->view('sistema/servicos/editar', $info);
	}

	public function update ()
	{
		$campo = 'imagem';

		$has_img = !! $this->input->post('has_img');

		if (! $has_img) {
			$campo = null;
		}

		$upload_result = $this->imagens_model->replaceSectionImg(2, $campo);

		$dados['conteudo'] = $this->input->post('conteudo');
		$dados['icone'] = $this->input->post('icone');

		if ($dados['conteudo'] != null || $dados['icone'] != null) {
			$this->secoes_sistema->update($dados, 2);

			$atualizacao['titulo'] = "Seção 'Serviços' alterada";
			$atualizacao['usuario'] = $_SESSION['id'];
			$atualizacao['tipo'] = "Alteração de Conteúdo";

			$this->atualizacoes_sistema->insert($atualizacao);
		}

		redirect('/sistema/servicos/editar');
	}

}