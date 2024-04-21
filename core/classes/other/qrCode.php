<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to create QR-Codes using an online service

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/qrCode.php");

$qrc = new qrCode();

$qrc->url($anyurl);
$qrc->save($dir, $spec);
$qrc->send();

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class qrCode {
    private $qrg = 'http://chart.apis.google.com/chart'; // online generator
    private $dat;

// ***********************************************************
// methods
// ***********************************************************
public function url($url = null) {
	$this->dat = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
}

public function text($text) {
	$this->dat = $text;
}

public function email($email = null, $subject = null, $message = null) {
	$this->dat = "MATMSG:TO:{$email};SUB:{$subject};BODY:{$message};;";
}

public function phone($num) {
	$this->dat = "TEL:{$num}";
}

public function sms($num = null, $msg = null) {
	$this->dat = "SMSTO:{$num}:{$msg}";
}

public function contact($name = null, $address = null, $num = null, $email = null) {
	$this->dat = "MECARD:N:{$name};ADR:{$address};TEL:{$num};EMAIL:{$email};;";
}

// ***********************************************************
// action
// ***********************************************************
public function save($dir, $spec, $size = 400) {
	$img = $this->getQR($size);
	$fil = FSO::join($dir, "qr.$spec.png");
	$res = APP::write($fil, $img);
}

public function send($size = 400) {
	$img = $this->getQR($size);
	header("Content-type: image/png");
	print $img;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getQR($size) {
	$con = curl_init();
	curl_setopt($con, CURLOPT_URL, $this->qrg);
	curl_setopt($con, CURLOPT_POST, true);
	curl_setopt($con, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=".urlencode($this->dat));
	curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($con, CURLOPT_HEADER, false);
	curl_setopt($con, CURLOPT_TIMEOUT, 30);

	$img = curl_exec($con);
	curl_close($con);

	if ($img) return $img;
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
