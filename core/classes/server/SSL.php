<?php
/* ***********************************************************
// INFO
// ***********************************************************
encrypting and decrypting strings

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("server/SSL.php");

SSL::encrypt("whatever");
*/

SSL::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ssl {
#	private static $met = "aes-256-cbc";
	private static $met = "AES-128-CTR";
	private static $key = "dpqerqAu+eglkZmv#<y4M590m v #V";
	private static $len = 16;

	const SEP = "@q@";
	const TIMEOUT = 2500;

public static function init() {
	SSL::$len = openssl_cipher_iv_length(SSL::$met);
}

// ***********************************************************
// methods
// ***********************************************************
public static function encrypt($data) {
#	$ivc = openssl_random_pseudo_bytes($len);
#	$ivc = random_bytes(SSL::$len);
	$ivc = substr(SSL::$key, 0, 16);
    $out = openssl_encrypt($data, SSL::$met, SSL::$key, 0, $ivc);
    return base64_encode($out.SSL::SEP.$ivc);
}

public static function decrypt($data) {
    $dat = base64_decode($data);
    $out = STR::before($dat, SSL::SEP);
    $ivc = STR::after($dat, SSL::SEP, false);
    return openssl_decrypt($out, SSL::$met, SSL::$key, 0, $ivc);
}


public static function md5($text = "kor_cms") {
	$now = SSL::getStamp();
	$key = CFG::iniVal("xfer:upload.masterkey");
	$out = md5("$key.$text.".date("Ym!d", $now));
	return str_pad($now, 32, $out,  STR_PAD_LEFT);
}

public static function isValid($md5) {
	if (IS_LOCAL) return true; $chk = substr($md5, -6);
	if (! $chk) return false;

	$now = SSL::getStamp();
	$dif = $now - $chk;
	return ($dif < SSL::TIMEOUT);
}

private static function getStamp() {
	return substr(time(), 4);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
