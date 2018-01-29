<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	function __construct () {
		parent::__construct();
	}

	public function index() {
		var_dump($this->dh->splitDateRange("26/01/2018 - 02/03/2018"));

	}
}