<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('site/secoes_model', 'secoes_site');
		$this->load->model('site/imagens_model', 'imagens_site');
		$this->load->model('site/contatos_model');
		$this->load->model('site/analise_model', 'analise_site');
		$this->load->library('session');
	}

	public function index ()
	{
		$info['itens'] = $this->secoes_site->getSections();
		$info['secao_info'] = $this->secoes_site->getSections(1)[0];

		$this->load->view('site/home', $info);
		$this->analise_site->insert_access(1);
	}

	public function enviarComentario () {
		$successMessage = "<p>Comentário enviado! Aguardando aprovação.</p>";
		$data['aprovado'] = 0;

		if ($this->input->post('autor_comentario')) {
			$data['nomeAutor'] = $this->input->post('autor_comentario');
		}

		if ($this->input->post('email_comentario')) {
			$data['emailAutor'] = $this->input->post('email_comentario');
		}

		if (!$this->input->post('mensagem_comentario')) {
			$retorno = array('status' => 'error', 'message' => "<p>Preencha os campos corretamente para enviar um comentário!</p>", 'aprovado' => 0);
			echo json_encode($retorno);
			return false;
		}

		$data['textoComentario'] = !empty($this->input->post('mensagem_comentario')) ? $this->input->post('mensagem_comentario') : null;

		$data['secaoComentario'] = !empty($this->input->post('id_secao')) ? $this->input->post('id_secao') : null;

		$auto_approve = !!$this->secoes_site->getSitePreferences('auto_approve_comments')[0]->valor;
		if ($auto_approve)
		{
			$data['aprovado'] = 1;
			$successMessage = "<p>Comentário publicado! A página será atualizada para exibi-lo.</p>";
		}

		$this->secoes_site->insertComment($data);

		$titulo_atualizacao = ($auto_approve ? "Novo comentário" : "Novo comentário | Aguardando Aprovação");

		$this->load->model('sistema/atualizacoes_model');

		$atualizacao['titulo'] = $titulo_atualizacao;
		$atualizacao['usuario'] = 0;
		$atualizacao['tipo'] = "Comentário Publicado";
		$atualizacao['link'] = "Comentarios/gerenciar";
		$this->atualizacoes_model->insert($atualizacao);

		$retorno = array('status' => 'success', 'message' => $successMessage, 'aprovado' => $data['aprovado']);

		echo json_encode($retorno);
	}
}