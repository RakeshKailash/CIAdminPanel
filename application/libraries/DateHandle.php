<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DateHandle {

	private $dash_date = "~^(\d{4})-(\d{2})-(\d{2})$~";
	private $bar_date = "~^(\d{4})/(\d{2})/(\d{2})$~";
	private $datetime = "~^(\d{4})-(\d{2})-(\d{2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$~";

	function __construct () {
		date_default_timezone_set("America/Sao_Paulo");
	}

	public function stillValid($date=null)
	{
		if (!$date) {
			return false;
		}

		$test_date = $this->clearDate($date);

		if (! $test_date) {
			throw new Exception("Data com formato inválido", 1);	
		}

		return $test_date >= $this->getCurrentDate() ? true : false;
	}

	public function clearDate($date=null)
	{
		if (!$date) {
			return false;
		}

		$clear = str_replace(" ", "", $date);
		$clear = substr($clear, 0, 10);

		if (strpos($clear, "/")) {
			$clear = array_reverse(explode("/", $clear));
		} else if (strpos($clear, "-")) {
			$clear = explode("-", $clear);
		}

		if (! is_array($clear) || sizeof($clear) != 3) {
			return false;
		}

		if (strlen($clear[0]) != 4 || strlen($clear[1]) != 2 || strlen($clear[2]) != 2) {
			return false;
		}

		$clear = implode("-", $clear);
		return $clear;
	}

	public function dateShowPrepare($date=null)
	{
		if (! $date) {
			return false;
		}

		$date = trim($date);

		return preg_replace("~(\d{4})-(\d{2})-(\d{2})~", '\3/\2/\1', $date);
	}

	public function dateStorePrepare($date=null)
	{
		if (! $date) {
			return false;
		}

		$date = trim($date);

		return preg_replace("~(\d{2})/(\d{2})/(\d{4})~", '\3-\2-\1 00:00:00', $date);
	}

	public function splitDateRange($range=null)
	{
		if (! $range) {
			return false;
		}

		$range = str_replace(" ", "", $range);
		$range = explode("-", $range);

		$range[0] = $this->dateStorePrepare($range[0]);
		$range[1] = $this->dateStorePrepare($range[1]);

		return $range;
	}

	private function getCurrentDate($datetime=false)
	{
		return !!$datetime ? date("Y-m-d h:i:s") : date("Y-m-d");
	}

}