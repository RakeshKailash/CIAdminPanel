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
	}

	public function index() 
	{
		if ($this->usuario_model->isLogged())
		{
			$this->load->view('sistema/editar_servicos');
		} else {
			redirect('sistema/login');
		}
	}

	public function editar ()
	{
		if ($this->usuario_model->isLogged()) {
			$this->load->view('sistema/editar_imagens');

			// print_r($_FILES['imagens_galeria']);

			if (!empty($_FILES['imagens_galeria']['name'])) {
				$imagens = $this->imagens_model->fillGallery('imagens_galeria');

				$data['conteudo'] = "<div class='galeria_imagens_site'>";

				foreach ($imagens as $imagem) {
					$data['conteudo'] .= "<div class='container_img_gallery'><img src='".base_url($imagem->caminho)."' class='img_gallery' /></div>";
				}

				$data['conteudo'] .= "</div>";

				$this->db->where('id', 4);
				$this->db->update('secoes', $data);

				$atualizacao['titulo'] = "Seção 'Imagens' alterada";
				$atualizacao['usuario'] = $_SESSION['id'];
				$atualizacao['tipo'] = "Acréscimo de novas Imagens";

				$this->atualizacoes_sistema->insert($atualizacao);

				redirect('/sistema/imagens/editar');
			}

		} else {
			redirect('sistema/login');
		}
	}

	public function excluir () {
		if ($this->usuario_model->isLogged())
		{
			
			if(!isset($_GET['id']))
			{
				redirect('sistema/imagens/editar');
			}

			$id = $_GET['id'];

			$this->db->select('caminho');
			$this->db->where('id', $id);
			$imagem = $this->db->get('galeria')->result()[0];

			$caminho_pasta = str_replace('\\', "/", FCPATH);

			if(unlink($caminho_pasta . $imagem->caminho)) {
				if($this->db->delete('galeria', array('id' => $id)))
				{
					$imagens = $this->db->get('galeria')->result();

					$data['conteudo'] = "<div class='galeria_imagens_site'>";

					foreach ($imagens as $imagem) {
						$data['conteudo'] .= "<div class='container_img_gallery'><img src='".base_url($imagem->caminho)."' class='img_gallery' /></div>";
					}

					$data['conteudo'] .= "</div>";

					$this->db->where('id', 4);
					$this->db->update('secoes', $data);

					$atualizacao['titulo'] = "Seção 'Imagens' alterada";
					$atualizacao['usuario'] = $_SESSION['id'];
					$atualizacao['tipo'] = "Exclusão de Imagens";

					$this->atualizacoes_sistema->insert($atualizacao);

					redirect('sistema/imagens/editar');
				}
			}



		} else {
			redirect('sistema/login');
		}
	}

}