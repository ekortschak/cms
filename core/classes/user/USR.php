<?php
/* ***********************************************************
// INFO
// ***********************************************************
user related functionality

*/

USR::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class USR {
	private static $dat = array();

public static function init() {
	$usr = ENV::get("crdu", "www");
	$pwd = ENV::get("crdp", "www");
	USR::read();

	if (! USR::isUser($usr, $pwd)) {
		$mod = "logout";
		$usr = "www"; $pwd = "www";
	}
	CFG::set("CUR_USER", $usr);
	CFG::set("CUR_PASS", $pwd);

	CFG::set("FS_LOGIN", USR::isUser());
	CFG::set("FS_ADMIN", USR::isAdmin());

	ENV::set("crdu", $usr);
	ENV::set("crdp", $pwd);
}

// ***********************************************************
// check permissions
// ***********************************************************
public static function isAdmin($usr = CUR_USER, $pwd = CUR_PASS) {
	if (IS_LOCAL) return true;
	return USR::chkUser("admin", $usr, $pwd);
}
public static function isUser($usr = CUR_USER, $pwd = CUR_PASS) {
	if ($usr == "www") return true;

	$out = USR::chkUser("user",  $usr, $pwd); if ($out) return true;
	return USR::chkUser("admin", $usr, $pwd);
}

private static function chkUser($grp, $usr, $pwd) {
	$chk = VEC::get(USR::$dat, "$grp.$usr"); if (! $chk) return false;
	$chk = STR::maskPwd($chk);
	$pwd = STR::maskPwd($pwd);
	return ($chk == $pwd);
}

// ***********************************************************
// reading config files
// ***********************************************************
private static function read($fil = "config/users.ini") {
	$fil = APP::file($fil); $grp = "";
	$arr = file($fil);

	foreach ($arr as $lin) {
		$lin = STR::dropComments($lin);

		if (   STR::contains($lin, "[")) $grp = STR::between($lin, "[", "]");
		if ( STR::misses($lin, "=")) continue;

		$usr = STR::before($lin, "=");
		$pwd = STR::after($lin, "=");

		USR::$dat["$grp.$usr"] = $pwd;
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
