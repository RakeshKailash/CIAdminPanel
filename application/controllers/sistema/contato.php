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
	}

	public function index() 
	{
		if ($this->usuario_model->isLogged()) {
			$this->load->view('sistema/editar_empresa');
		} else {
			redirect('sistema/login');
		}
	}

	public function editar ($id)
	{
		if ($this->usuario_model->isLogged()) {
			$this->load->view('sistema/editar_contato');

			$campo = 'imagem';

			if ($this->input->post('has_img_contato') == "false") {
				$campo = null;
			}

			$upload_result = $this->imagens_model->replaceSectionImg(5, $campo);

			$texto_contato = "<div id='contato_div'><p>Telefone: " . str_replace('_', '', $this->input->post('telefone')) . "</p>";

			if ($this->input->post('celular') != null) {
				$texto_contato .= "<p>Celular: " . str_replace('_', '', $this->input->post('celular')) . "</p>";
			}

			if ($this->input->post('email') != null) {
				$texto_contato .= "<p>E-mail: " . str_replace('_', '', $this->input->post('email')) . "</p>";
			}

			$texto_contato .= "</div>";

			$dados['telefone'] = str_replace(array('(', ')', '_', '-', ' '), "", $this->input->post('telefone'));
			$dados['celular'] = str_replace(array('(', ')', '_', '-', ' '), "", $this->input->post('celular'));
			$dados['email'] = $this->input->post('email');

			$dados_secao['conteudo'] = $texto_contato;
			
			$has_form = !! $this->input->post('form_email');


			if ($has_form) {

				$formulario = "<div id='contato_form_site'><form action=" . base_url('site/main/mail') . " method='post'>Nome:* <input type='text' name='nome'><br>Telefone: <input type='text' name='telefone'><br>E-mail:* <input type='text' name='email'><br>Mensagem:*<br><textarea rows='5' name='mensagem' cols='30'></textarea><br><input type='submit' name='submit' value='Enviar'><input type='reset' name='limpar' value='Limpar'></form></div>";

				$dados['form'] = $formulario;
				$dados_secao['conteudo'] .= $formulario;
			} else {
				$dados['form'] = '';
			}

			if ($dados['telefone'] != null || $dados['form'] != null || $dados['celular'] != null || $dados['email'] != null) {
				$this->contatos_model->update($dados);

				$this->secoes_sistema->update($dados_secao, 5);

				$atualizacao['titulo'] = "Seção 'Contato' alterada";
				$atualizacao['usuario'] = $_SESSION['id'];
				$atualizacao['tipo'] = "Alteração de Informações/Conteúdo";

				$this->atualizacoes_sistema->insert($atualizacao);

				redirect('/sistema/contato/editar');
			}


		} else {
			redirect('sistema/login');
		}
	}
}