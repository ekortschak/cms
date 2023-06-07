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
	private static $sep = "@q@";
	private static $len = 16;
	private static $timeout = 2500;

public static function init() {
	self::$len = openssl_cipher_iv_length(self::$met);
}

// ***********************************************************
// methods
// ***********************************************************
public static function encrypt($data) {
#	$ivc = openssl_random_pseudo_bytes($len);
#	$ivc = random_bytes(self::$len);
	$ivc = substr(self::$key, 0, 16);
    $out = openssl_encrypt($data, self::$met, self::$key, 0, $ivc);
    return base64_encode($out.self::$sep.$ivc);
}

public static function decrypt($data) {
    $dat = base64_decode($data);
    $out = STR::before($dat, self::$sep);
    $ivc = STR::after($dat, self::$sep, false);
    return openssl_decrypt($out, self::$met, self::$key, 0, $ivc);
}


public static function md5($text = "kor_cms") {
	$now = self::getStamp();
	$key = CFG::getVal("xfer", "upload.masterkey");
	$out = md5("$key.$text.".date("Ym!d", $now));
	return str_pad($now, 32, $out,  STR_PAD_LEFT);
}

public static function isValid($md5) {
	if (IS_LOCAL) return true; $chk = substr($md5, -6);
	if (! $chk) return false;

	$now = self::getStamp();
	$dif = $now - $chk;
	return ($dif < self::$timeout);
}

private static function getStamp() {
	return substr(time(), 4);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
