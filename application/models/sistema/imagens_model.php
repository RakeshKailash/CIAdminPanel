<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagens_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function replaceSectionImg ($secao=1, $campo=null)
	{

		$caminho_pasta = str_replace('\\', DIRECTORY_SEPARATOR, FCPATH);
		if ($campo) {

			$config_upload['upload_path'] = $caminho_pasta . 'images/uploads/sections/';
			$config_upload['allowed_types'] = 'gif|jpg|jpeg|png';
			$config_upload['max_size'] = '5120';
			$config_upload['max_width'] = '0';
			$config_upload['max_height'] = '0';
			$config_upload['encrypt_name'] = true;

			$this->load->library('upload', $config_upload);

			if (! $this->upload->do_upload($campo)) {
				throw new UploadImagensException($this->upload->display_errors());
			}

			$info_img = $this->upload->data();
		
		} else {
			$info_img = array('file_name' => null, 'file_size' => 0);
		}
		
		$this->db->select('imagens.id, imagens.caminho');
		$this->db->from('imagens');
		$this->db->join('secoes', "secoes.id = $secao AND imagens.id = secoes.imagem");

		$img_anterior = $this->db->get()->result()[0];

		unlink($caminho_pasta . $img_anterior->caminho);

		$info_retorno['imagem']['nome'] = $info_img['file_name'];
		$info_retorno['imagem']['tamanho'] = $info_img['file_size'];
		$info_retorno['imagem']['caminho'] = $info_img['file_name'] != null ? ('images/uploads/sections/' . $info_img['file_name']) : null;

		$data_insert = array('nome' => $info_img['file_name'], 'tamanho' => $info_img['file_size'], 'caminho' => $info_retorno['imagem']['caminho']);

		$this->db->where('id', $img_anterior->id);
		$update_img = $this->db->update('imagens', $data_insert);

		if ( ! $update_img) {
			// $info_retorno['error']['count']++;
			return false;
		}

		$info_retorno['imagem']['id'] = $img_anterior->id;
		

		return $info_retorno;
	}

	public function fillGallery ($campo=null)
	{

		$caminho_pasta = str_replace('\\', "/", FCPATH);

		$config_upload['upload_path'] = $caminho_pasta . 'images/uploads/gallery';
		$config_upload['allowed_types'] = 'gif|jpg|jpeg|png';
		$config_upload['max_size'] = '50000';
		$config_upload['max_width'] = '0';
		$config_upload['max_height'] = '0';
		$config_upload['encrypt_name'] = true;

		$this->load->library('upload', $config_upload);

		$count = count($_FILES[$campo]['name']);

		if ($count <= 0) {
			return array("ABC");
		}

		for ($i = 0; $i < $count; $i++) {
			$_FILES['imagem_up']['name'] = $_FILES[$campo]['name'][$i];
			$_FILES['imagem_up']['type'] = $_FILES[$campo]['type'][$i];
			$_FILES['imagem_up']['tmp_name'] = $_FILES[$campo]['tmp_name'][$i];
			$_FILES['imagem_up']['error'] = $_FILES[$campo]['error'][$i];
			$_FILES['imagem_up']['size'] = $_FILES[$campo]['size'][$i];

			if (!$this->upload->do_upload('imagem_up')) {
				 return array('status' => 'error', 'mensagem' => $this->upload->display_errors());
			}

			$data['nome'] = $this->upload->data('file_name');
			$data['caminho'] = 'images/uploads/gallery/' . $this->upload->data('file_name');
			$data['tamanho'] = $this->upload->data('file_size');

			$this->db->insert('galeria', $data);
		}

		return $this->getGalleryContent();
	}

	public function getGalleryContent ()
	{
		$this->db->select('id, titulo, texto, caminho');
		$imagens = $this->db->get('galeria')->result();

		return $imagens;
	}

	public function getSingleImg ($id=1)
	{
		$this->db->where('id', $id);
		$result = $this->db->get('galeria')->result()[0];

		return $result;
	}

	public function download ($images=null)
	{
		if ($images === null)
		{
			return array('warning' => 'error', 'mensagem' => "Nenhuma imagem selecionada para download.", 'link' => null);
		}

		$ids = $images;
		$this->db->select('nome');
		$this->db->where_in('id', $ids);
		$imagesDb = $this->db->get('galeria')->result();

		// return $imagesDb;

		$caminho_imgs = str_replace('\\', "/", FCPATH) . 'images/uploads/gallery/';
		$caminho_pasta = str_replace('\\', "/", FCPATH) . 'files/user_download/';

		$zip_name =  'Imagens sistema '.date('d-m-Y H_i\h', time()).'.zip';

		$zip = new ZipArchive;
		$zip->open(($caminho_pasta . $zip_name), ZipArchive::CREATE);


		foreach ($imagesDb as $imagem)
		{

			if (! ($handle = opendir($caminho_imgs)))
			{
				return array('status' => 'error', 'mensagem' => "Erro ao preparar imagens para download.", 'link' => null);
			}

			while (false !== ($entry = readdir($handle)))
			{
				if ($entry == $imagem->nome)
				{
					if (! file_exists($caminho_imgs . $entry))
					{
						return array('status' => 'error', 'mensagem' => "Erro ao preparar imagens para download.", 'link' => null);
					}

					$zip->addFile(($caminho_imgs . $entry), $entry);
				}
			}

			closedir($handle);
		}

		$zip->close();

		header('Content-type: application/zip');
		header('Content-Disposition: attachment; filename="' . $zip_name . '"');
		header("Content-length: " . filesize($caminho_pasta . $zip_name));
		readfile($caminho_pasta . $zip_name);

		$data['nome'] = $zip_name;
		$data['caminho'] = $caminho_pasta . $zip_name;
		$data['tamanho'] = filesize($data['caminho']);
		$data['idArquivos'] = implode('|', $images);
		$data['dataDownload'] = time();
		$data['idUsuario'] = $_SESSION['id'];

		if (! $this->db->insert('arquivos_download', $data))
		{
			return false;
		}

		$idArquivo = $this->db->insert_id();

		unlink($caminho_pasta . $zip_name);
	}
}