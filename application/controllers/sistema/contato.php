<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/imagens_model');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
		$this->load->model('sistema/contatos_model');
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
		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['registro'] = $this->secoes_sistema->getInfo(5)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['imagens_galeria'] = $this->imagens_model->getGalleryContent();
		$info['contato'] = $this->contatos_model->retrieve(1);
		$this->load->view('sistema/contato/editar', $info);
	}

	public function update()
	{
		if ($_SESSION['tipoUsuario'] != 1)
		{
			$this->session->set_flashdata('error', "<p>Você não tem permissão para editar informações do site!</p>");
			return redirect('sistema/contato/editar');
		}

		$this->form_validation->set_rules('telefone', 'Telefone', 'required');
		$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors('<p>', '</p>'));
			return redirect('sistema/contato/editar');
		}

		$celular = $this->input->post('celular');
		$email = $this->input->post('email');
		$telefone = $this->input->post('telefone');
		$whatsapp = $this->input->post('whatsapp');
		$endereco = $this->input->post('endereco');
		$has_form = !! $this->input->post('form_email');
		$contact_message = $this->input->post('contact_message');
		$has_map = !! $this->input->post('map_google');
		$map_message = $this->input->post('map_message');

		$dados['telefone'] = str_replace(array('(', ')', '_', '-', ' '), "", $telefone);
		$dados['celular'] = str_replace(array('(', ')', '_', '-', ' '), "", $celular);
		$dados['whatsapp'] = str_replace(array('(', ')', '_', '-', ' ', '+'), "", $whatsapp);
		$dados['address'] = $endereco;
		$dados['email'] = $email;
		$dados['has_form'] = $has_form ? $has_form : '0';
		$dados['contact_message'] = $contact_message;
		$dados['has_map'] = $has_map ? $has_map : '0';
		$dados['map_message'] = $map_message;

		$dados_secao['conteudo'] = 'Conteudo';

		if ($dados['telefone'] != null && $dados['email'] != null) {
			$this->contatos_model->update($dados);
			$this->secoes_sistema->update($dados_secao, 5);

			$atualizacao['titulo'] = "Seção 'Contato' alterada";
			$atualizacao['usuario'] = $_SESSION['id'];
			$atualizacao['tipo'] = "Alteração de Informações/Conteúdo";

			$this->atualizacoes_sistema->insert($atualizacao);

		}

		$this->session->set_flashdata('success', "<p>Seção atualizada com sucesso!</p>");
		return redirect('sistema/contato/editar');
	}

}