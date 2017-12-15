<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagens_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('ImageCompress', '', 'img_compress');
	}

	public function replaceSectionImg ($secao=1, $campo=null)
	{
		if (! $secao) {
			return false;
		}

		$path = 'images/uploads/sections/';

		$info_img = $this->uploadImg($path, $campo);

		if (! $info_img) {
			return false;
		}

		$img_anterior = $this->getImg('secoes', $secao);
		$replace = $this->replaceImg($img_anterior, $info_img, $path);

		if (! $replace) {
			return false;
		}

		$info_retorno['imagem'] = $replace;

		return $info_retorno;
	}


	public function replacePostImg ($post=null, $campo=null)
	{
		if (! $post) {
			return false;
		}

		$path = 'images/uploads/posts/';

		$info_img = $this->uploadImg($path, $campo);

		if (! $info_img) {
			return false;
		}

		$img_anterior = $this->getImg('postagens', $post);

		$replace = $this->replaceImg($img_anterior, $info_img, $path);

		if (! $replace) {
			return false;
		}

		$info_retorno['imagem'] = $replace;

		return $info_retorno;
	}

	public function insert ($campo=null, $path='images/uploads/')
	{
		if (! $campo) {
			$imgData['nome'] = null;
			$imgData['tamanho'] = 0;
			$imgData['caminho'] = null;

			return $this->insertImg($imgData);
		}

		$info_img = $this->uploadImg($path, $campo);

		$imgData['nome'] = $info_img['file_name'];
		$imgData['tamanho'] = $info_img['file_size'];
		$imgData['caminho'] = $path . $info_img['file_name'];

		return $this->insertImg($imgData);
	}

	public function update ($imgId=null, $path='images/uploads/', $field=null)
	{
		if (! $imgId) {
			return false;
		}

		$prevImg = $this->getImgs($imgId)[0];

		if (! $field) {
			$query = $this->replaceImg($prevImg, null, $path);
		}

		$newImg = $this->uploadImg($path, $field);
		$query = $this->replaceImg($prevImg, $newImg, $path);

		if (! $query) {
			return false;
		}

		return $query->id;
	}

	public function updateInfo ($imgId=null, $title=null, $caption=null)
	{
		if (! $imgId) {
			return false;
		}

		$sets = array(
			'titulo' => $title,
			'texto' => $caption
		);

		$this->db->where('id', $imgId);
		if (! $this->db->update('galeria', $sets)) {
			return false;
		}

		return true;
	}

	public function delete ($imgId=null)
	{
		if (! $imgId) {
			return false;
		}

		$imagem = $this->getSingleImg($imgId);

		if (! $imagem) {
			return false;
		}

		$caminho_pasta = str_replace('\\', "/", FCPATH);

		if(! unlink($caminho_pasta . $imagem->caminho)) {
			return false;
		}

		if(! $this->db->delete('galeria', array('id' => $imgId))) {
			return false;
		}

		return true;
	}

	public function fillGallery ($campo=null)
	{
		$caminho_pasta = str_replace('\\', "/", FCPATH);
		$caminho_upload = $caminho_pasta . 'images/uploads/gallery/temp/';

		if (!is_dir($caminho_upload)) {
			mkdir($caminho_upload, 0777);
		}

		$config_upload['upload_path'] = $caminho_upload;
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

			$destino = $caminho_pasta.'images/uploads/gallery/'.$this->upload->data('file_name');
			$origem = $caminho_upload.$this->upload->data('file_name');

			$this->img_compress->compress($origem, $destino, 80);

			$data['nome'] = $this->upload->data('file_name');
			$data['caminho'] = 'images/uploads/gallery/' . $this->upload->data('file_name');
			$data['tamanho'] = filesize($destino);

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
		if ($images === null) {
			return array('warning' => 'error', 'mensagem' => "Nenhuma imagem selecionada para download.", 'link' => null);
		}

		$ids = $images;
		$this->db->select('nome');
		$this->db->where_in('id', $ids);
		$imagesDb = $this->db->get('galeria')->result();

		$caminho_imgs = str_replace('\\', "/", FCPATH) . 'images/uploads/gallery/';
		$caminho_pasta = str_replace('\\', "/", FCPATH) . 'files/user_download/';

		$zip_name =  'Imagens sistema '.date('d-m-Y H_i\h', time()).'.zip';

		$zip = new ZipArchive;
		$zip->open(($caminho_pasta . $zip_name), ZipArchive::CREATE);


		foreach ($imagesDb as $imagem) {

			if (! ($handle = opendir($caminho_imgs))) {
				return array('status' => 'error', 'mensagem' => "Erro ao preparar imagens para download.", 'link' => null);
			}

			while (false !== ($entry = readdir($handle))) {
				if ($entry == $imagem->nome) {
					if (! file_exists($caminho_imgs . $entry)) {
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

		if (! $this->db->insert('arquivos_download', $data)) {
			return false;
		}

		$idArquivo = $this->db->insert_id();

		unlink($caminho_pasta . $zip_name);
	}

	private function uploadImg ($path=null, $field=null)
	{
		if (! $path) {
			return false;
		}

		$path_last_char = substr($path, -1);

		if ($path_last_char != '/' && $path_last_char != "\\") {
			$path = $path.'/';
		}

		if ($field) {
			$caminho_pasta = str_replace('\\', DIRECTORY_SEPARATOR, FCPATH);
			$caminho_upload = $caminho_pasta . $path . 'temp/';

			if (!is_dir($caminho_upload)) {
				mkdir($caminho_upload, 0777);
			}

			$config_upload['upload_path'] = $caminho_upload;
			$config_upload['allowed_types'] = 'gif|jpg|jpeg|png';
			$config_upload['max_size'] = '0';
			$config_upload['max_width'] = '0';
			$config_upload['max_height'] = '0';
			$config_upload['encrypt_name'] = true;

			$this->load->library('upload', $config_upload);

			if (! $this->upload->do_upload($field)) {
				// throw new Exception($this->upload->display_errors());
				return false;
			}

			$info_img = $this->upload->data();

			$origem = $caminho_upload.$info_img['file_name'];
			$destino = $caminho_pasta.$path.$info_img['file_name'];

			$this->img_compress->compress($origem, $destino, 80);

		} else {
			$info_img = array('file_name' => null, 'file_size' => 0);
		}

		return $info_img;
	}

	private function getImgs ($id=null)
	{
		if ($id) {
			$this->db->where('imagens.id = ' . $id);
		}

		$this->db->select('imagens.id, imagens.caminho');

		return $this->db->get('imagens')->result();
	}

	private function replaceImg ($prevImg=null, $newImg=null, $path=null)
	{
		if (! $prevImg || ! $path) {
			return false;
		}

		if ($newImg) {
			$caminho_pasta = str_replace('\\', DIRECTORY_SEPARATOR, FCPATH);
			unlink($caminho_pasta . $prevImg->caminho);

			$retorno['nome'] = $newImg['file_name'];
			$retorno['tamanho'] = $newImg['file_size'];
			$retorno['caminho'] = $newImg['file_name'] != null ? ($path . '/' . $newImg['file_name']) : null;
		}

		if (! $newImg) {
			$retorno['nome'] = null;
			$retorno['tamanho'] = 0;
			$retorno['caminho'] = null;
		}

		$data_insert = array('nome' => $newImg['file_name'], 'tamanho' => $newImg['file_size'], 'caminho' => $retorno['caminho']);

		$this->db->where('id', $prevImg->id);
		$update_img = $this->db->update('imagens', $data_insert);

		if ( ! $update_img) {
			return false;
		}

		$retorno['id'] = $prevImg->id;

		return $retorno;
	}

	private function insertImg ($imgInfo=null)
	{
		if (! $imgInfo) {
			return false;
		}

		$query = $this->db->insert('imagens', $imgInfo);

		if (! $query) {
			return false;
		}

		$idImg = $this->db->insert_id();

		if (! $idImg) {
			return false;
		}

		return $idImg;
	}

}