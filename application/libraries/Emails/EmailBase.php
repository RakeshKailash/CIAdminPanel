<?php

namespace ProjetoCI\libraries\Emails;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailBase
{

	protected $config;
	protected $email;
	protected $ci;


	public function __construct()
	{

        $this->ci = & get_instance();
		$this->ci->load->model('Sistema/Email_model');

		$this->init();
	}

	private function init()
	{
		$this->config = $this->ci->Email_model->getConfig();
		$this->email = new PHPMailer(true);
		try {

			$this->email->CharSet = 'UTF-8';
			$this->email->isSMTP();                                      // Set mailer to use SMTP
			$this->email->SMTPAuth = true;                               // Enable SMTP authentication
			$this->email->Host = $this->config->host;  // Specify main and backup SMTP servers
			$this->email->Username = $this->config->email;                 // SMTP username
			$this->email->Password = $this->config->password;                           // SMTP password
			$this->email->Port = $this->config->port;                                    // TCP port to connect to
			$this->email->SMTPSecure = '';

		} catch (Exception $e) {
			return false;
		}
	}

	protected function send($subject, $emailBody, $emailAddress)
	{
		try {
			// $this->email->SMTPDebug = 2;                                 // Enable verbose debug output
			$this->email->setFrom($this->config->email, $this->config->sender);
			$this->email->addAddress($emailAddress);     // Add a recipient            // Name is optional

		    //Content
		    $this->email->isHTML(true);                                  // Set email format to HTML
		    $this->email->Subject = $this->config->sender;
		    $this->email->Body    = $emailBody;
		    $this->email->AltBody = strip_tags($emailBody);

		    $this->email->send();
			return true;
		} catch (Exception $e) {
		    return false;
			//ver $mail->ErrorInfo;
		}
	}
}
