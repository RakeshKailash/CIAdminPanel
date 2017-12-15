<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function caminho_pasta () {
		return str_replace('\\', DIRECTORY_SEPARATOR, FCPATH);
	}

	public function uploadFile ($campo=null)
	{
		if (! $campo) {
			return false;
		}

		$path = "images/uploads/users_files/".$_SESSION['login'];
		$idsInsert = array();

		if (!is_dir($path))
		{
			mkdir($path);
		}

		$config_upload['upload_path'] = $this->caminho_pasta()."/temp/".$path;
		$config_upload['allowed_types'] = 'gif|jpg|jpeg|png';
		$config_upload['max_size'] = '0';
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

			if (! $this->upload->do_upload('imagem_up')) {
				throw new Exception($this->upload->display_errors());
				return false;
			}

			// Testando compressão de imagem
			$imagename = $_FILES['imagem_up']['name'];
			$target = $this->caminho_pasta().$path;

			$imagepath = $imagename;
          $save = $target."/". $imagepath; //This is the new file you saving
          $file = $this->caminho_pasta()."/temp/".$path."/".$imagepath; //This is the original file

          list($width, $height) = getimagesize($file); 

          $tn = imagecreatetruecolor($width, $height);

          //$image = imagecreatefromjpeg($file);
          $info = getimagesize($target);
          if ($info['mime'] == 'image/jpeg'){
          	$image = imagecreatefromjpeg($file);
          }elseif ($info['mime'] == 'image/gif'){
          	$image = imagecreatefromgif($file);
          }elseif ($info['mime'] == 'image/png'){
          	$image = imagecreatefrompng($file);
          }

          imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height);
          imagejpeg($tn, $save, 60);

          echo "Large image: ".$imagepath;die;
			// Fim dos testes

          $info_file = $this->upload->data();

          $file['nome'] = $info_file['file_name'];
          $file['tamanho'] = $info_file['file_size'];
          $file['autor'] = $_SESSION['id'];
          $file['caminho'] = $path.'/'.$info_file['file_name'];
          $file['data_upload'] = time();

          $insert = $this->db->insert('uploads', $file);

          if (! $insert)
          {
          	return false;
          }

          array_push($idsInsert, $this->db->insert_id());
      }

      return $idsInsert;
  }

  public function deleteFiles ($ids=null)
  {
  	if (! $ids)
  	{
  		return false;
  	}

  	$userId = $_SESSION['id'];

  	if (! is_array($ids))
  	{
  		$this->db->select('caminho');
  		$this->db->where("uploads.`id` = $ids AND uploads.`autor` = $userId");

  		$file = $this->db->get('uploads')->result()[0];
  		if (! unlink($this->caminho_pasta() . $file->caminho))
  		{
  			return false;
  		}

  		$this->db->where("uploads.`id` = $ids AND uploads.`autor` = $userId");
  		if (! $this->db->delete('uploads'))
  		{
  			return false;
  		}

  		return true;
  	}

  	foreach ($ids as $fileId) {
  		$this->db->select('caminho');
  		$this->db->where("uploads.`id` = $fileId AND uploads.`autor` = $userId");

  		$file = $this->db->get('uploads')->result()[0];
  		if (! unlink($this->caminho_pasta() . $file->caminho))
  		{
  			return false;
  		}

  		$this->db->where("uploads.`id` = $fileId AND uploads.`autor` = $userId");
  		if (! $this->db->delete('uploads'))
  		{
  			return false;
  		}
  	}

  	return true;
  }

  public function getFiles ($fileId=null)
  {
  	$this->db->select('uploads.`id`, uploads.`nome`, uploads.`tamanho`, uploads.`autor` AS id_autor, usuarios.`nome` AS autor, uploads.`caminho`, uploads.`data_upload`');
  	$this->db->join('usuarios', 'usuarios.`id` = uploads.`autor`');

  	if ($fileId)
  	{
  		$this->db->where("uploads.`id` = $fileId");
  	}

  	$query = $this->db->get('uploads');

  	if (! $query)
  	{
  		return false;
  	}

  	return $query->result();
  }

}