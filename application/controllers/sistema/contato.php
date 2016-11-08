<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/imagens_model');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
		$this->load->model('sistema/contatos_model');
		$this->load->library('form_validation');
		if (! $this->usuario_model->isLogged()) {
			redirect('sistema/login');
		}
	}

	public function index() 
	{
		redirect('sistema/contato/editar');
	}

	public function editar ()
	{
		$info['registro'] = $this->secoes_sistema->getInfo(5)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['contato'] = $this->contatos_model->retrieve(1);
		$info['atualizacoes'] = $this->atualizacoes_sistema->retrieve(null, 5);

		$this->load->view('sistema/contato/editar', $info);
	}

	public function update()
	{
		$this->form_validation->set_rules('telefone', 'Telefone', 'required');
		$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors('<p>', '</p>'));
			redirect('sistema/contato/editar');
		}

		$celular = $this->input->post('celular');
		$email = $this->input->post('email');
		$telefone = $this->input->post('telefone');
		
		$texto_contato = "<div id='contato_div'><p>Telefone: " . str_replace('_', '', $telefone) . "</p>";

		
		if ($celular) {
			$texto_contato .= "<p>Celular: " . str_replace('_', '', $celular) . "</p>";
		}

		$texto_contato .= "<p>E-mail: " . $email . "</p>";
		$texto_contato .= "</div>";

		$dados['telefone'] = str_replace(array('(', ')', '_', '-', ' '), "", $telefone);
		$dados['celular'] = str_replace(array('(', ')', '_', '-', ' '), "", $celular);
		$dados['email'] = $email;

		$dados_secao['conteudo'] = $texto_contato;
		
		$has_form = !! $this->input->post('form_email');
		
		$dados['has_form'] = $has_form ? $has_form : '0';

		if ($dados['telefone'] != null || $dados['has_form'] != null || $dados['celular'] != null || $dados['email'] != null) {
			$this->contatos_model->update($dados);

			$this->secoes_sistema->update($dados_secao, 5);

			$atualizacao['titulo'] = "Seção 'Contato' alterada";
			$atualizacao['usuario'] = $_SESSION['id'];
			$atualizacao['tipo'] = "Alteração de Informações/Conteúdo";
			

			$this->atualizacoes_sistema->insert($atualizacao);

		}

		$this->session->set_flashdata('success', "<p>Seção atualizada com sucesso!</p>");
		redirect('sistema/contato/editar');
	}
}