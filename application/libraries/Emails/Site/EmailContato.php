<?php

use ProjetoCI\libraries\Emails\EmailBase;

class EmailContato extends EmailBase
{
	function __construct()
	{
		parent::__construct();
	}

	public function sendEmail($user_name, $user_email, $subject, $message)
	{
		$info = compact("user_name", "user_email", "subject", "message");
		$emailBody = $this->ci->load->view('Emails/contato', $info, true);
		
		try {
			$this->email->setFrom($this->config['default_email'], $this->config['default_email_sender']);
			$this->email->AddAddress($this->config['default_email_receiver']);

		    //Content
		    $this->email->isHTML(true);
		    $this->email->Subject = $this->config['default_email_sender'] . " - Nova Mensagem";
		    $this->email->Body    = $emailBody;
		    $this->email->AltBody = strip_tags($emailBody);
		    $this->email->send();

		    return true;
		} catch (Exception $e) {
			return false;
		}
	}
}