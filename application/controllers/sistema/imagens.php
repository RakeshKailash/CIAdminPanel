<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagens extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('sistema/secoes_model', 'secoes_sistema');
		$this->load->model('sistema/usuario_model');
		$this->load->model('sistema/imagens_model');
		$this->load->model('sistema/atualizacoes_model', 'atualizacoes_sistema');
		if (! $this->usuario_model->isLogged()) {
			return redirect('sistema/login');
		}
	}

	public function index()
	{
		return redirect('sistema/imagens/editar');
	}

	public function editar ()
	{
		$info['atualizacoes']['todasAtualizacoes'] = $this->atualizacoes_sistema->retrieve();
		$info['atualizacoes']['limitadas'] = $this->atualizacoes_sistema->retrieve(null, 5);
		$info['atualizacoes']['naoVisualizadas'] = $this->atualizacoes_sistema->retrieveUnviewed();
		$info['registro'] = $this->secoes_sistema->getInfo(4)[0];
		$info['secoes'] = $this->secoes_sistema->getInfo();
		$info['imagens_galeria'] = $this->imagens_model->getGalleryContent();

		$this->load->view('sistema/imagens/editar', $info);
	}

	public function add ()
	{
		if (! $_FILES['imagens_galeria']['name'][0]) {
			$this->session->set_flashdata('warning', "<p>Nenhum arquivo selecionado. Nada foi alterado.</p>");
			return redirect('sistema/imagens/editar');
		}

		$imagens = $this->imagens_model->fillGallery('imagens_galeria');

		if (isset($imagens['status']) && $imagens['status'] == false) {
			$this->session->set_flashdata('error', "<p>".$imagens['error']."</p>");
			return redirect('sistema/imagens/editar');
		}

		$atualizacao['titulo'] = "Seção 'Imagens' alterada";
		$atualizacao['usuario'] = $_SESSION['id'];
		$atualizacao['tipo'] = "Acréscimo de novas Imagens";

		$this->atualizacoes_sistema->insert($atualizacao);

		$this->session->set_flashdata('success', "<p>Seção atualizada com sucesso!</p>");
		return redirect('/sistema/imagens/editar');
	}

	public function update ()
	{
		$id = $this->input->post('id_img_modal');
		$titulo = $this->input->post('titulo_img_modal');
		$texto = $this->input->post('legenda_img_modal');

		if (! $id || ! is_numeric($id)) {
			$this->session->set_flashdata('error', "<p>Erro ao atualizar informações de imagem. Tente novamente.</p>");
			return redirect('/sistema/imagens/editar');
		}

		if (! $this->imagens_model->updateInfo($id, $titulo, $texto)) {
			$this->session->set_flashdata('error', "<p>Erro ao atualizar informações de imagem. Tente novamente.</p>");
			return redirect('/sistema/imagens/editar');
		}

		$atualizacao['titulo'] = "Seção 'Imagens' alterada";
		$atualizacao['usuario'] = $_SESSION['id'];
		$atualizacao['tipo'] = "Alteração de Informações de Imagem | ID: " . $id;

		$this->atualizacoes_sistema->insert($atualizacao);

		$this->session->set_flashdata('success', "<p>Imagem atualizada com sucesso!</p>");
		return redirect('/sistema/imagens/editar');
	}

	public function excluir ($ids=null)
	{
		if($ids == null) {
			$this->session->set_flashdata('error', "<p>Erro desconhecido. Tente novamente!</p>");
			return redirect('sistema/imagens/editar');
		}

		if (strpos($ids, "_") !== false) {
			$ids = explode("_", $ids);
		} else {
			$ids = array(0 => $ids);
		}

		foreach ($ids as $id) {
			if (! $this->imagens_model->delete($id)) {
				$this->session->set_flashdata('error', "<p>Erro ao excluir a imagem</p>");
				return redirect('sistema/imagens/editar');
			}
		}

		$atualizacao['titulo'] = "Seção 'Imagens' alterada";
		$atualizacao['usuario'] = $_SESSION['id'];
		$atualizacao['tipo'] = "Exclusão de Imagens| ID: $ids";

		$this->atualizacoes_sistema->insert($atualizacao);

		$this->session->set_flashdata('success', "<p>Exclusão realizada com sucesso!</p>");
		return redirect('sistema/imagens/editar');
	}

	public function getInfo($id=null)
	{
		$imagem = $this->imagens_model->getSingleImg($id);
		echo json_encode($imagem);
	}

	public function download($images=null)
	{
		if ($images === null) {
			$this->session->set_flashdata('warning', "Nenhuma imagem selecionada para download.");
			return redirect('sistema');
		}

		$images = explode("_", $images);
		$resultado = $this->imagens_model->download($images);

		$atualizacao['titulo'] = "Arquivo de download gerado";
		$atualizacao['usuario'] = $_SESSION['id'];
		$atualizacao['tipo'] = "Gerado arquivo '.rar' de Download para seção 'Imagens'";

		$this->atualizacoes_sistema->insert($atualizacao);
	}

}