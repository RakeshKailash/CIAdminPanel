<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagens_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function replaceSectionImg ($secao=1, $campo=null) {

		$caminho_pasta = str_replace('\\', "/", FCPATH);
		if ($campo != null) {

			$config_upload['upload_path'] = $caminho_pasta . 'images/uploads';
			$config_upload['allowed_types'] = 'gif|jpg|jpeg|png';
			$config_upload['max_size'] = '5120';
			$config_upload['max_width'] = '0';
			$config_upload['max_height'] = '0';

			$this->load->library('upload', $config_upload);

			if (!($this->upload->do_upload($campo))) {
				return $this->upload->display_errors();
			} else {
				$info_img = $this->upload->data();
			}
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
		$info_retorno['imagem']['caminho'] = $info_img['file_name'] != null ? ('images/uploads/' . $info_img['file_name']) : null;

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

	public function fillGallery ($campo=null) {

		$caminho_pasta = str_replace('\\', "/", FCPATH);

		$config_upload['upload_path'] = $caminho_pasta . 'images/uploads/gallery';
		$config_upload['allowed_types'] = 'gif|jpg|jpeg|png';
		$config_upload['max_size'] = '50000';
		$config_upload['max_width'] = '0';
		$config_upload['max_height'] = '0';

		$this->load->library('upload', $config_upload);

		$count = count($_FILES[$campo]['name']);

		for ($i = 0; $i < $count; $i++) {
			$_FILES['imagem_up']['name'] = $_FILES[$campo]['name'][$i];
			$_FILES['imagem_up']['type'] = $_FILES[$campo]['type'][$i];
			$_FILES['imagem_up']['tmp_name'] = $_FILES[$campo]['tmp_name'][$i];
			$_FILES['imagem_up']['error'] = $_FILES[$campo]['error'][$i];
			$_FILES['imagem_up']['size'] = $_FILES[$campo]['size'][$i];

			if ($this->upload->do_upload('imagem_up')) {
				// $info_img[$i] = $this->upload->data();

				$data['nome'] = $this->upload->data('file_name');
				$data['caminho'] = 'images/uploads/gallery/' . $this->upload->data('file_name');
				$data['tamanho'] = $this->upload->data('file_size');

				$this->db->insert('galeria', $data);
			}
		}

		return $this->getGalleryContent();
	}

	public function getGalleryContent () {
		$this->db->select('id, caminho');
		$imagens = $this->db->get('galeria')->result();

		return $imagens;
	}


}