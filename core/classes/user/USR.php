<?php
/* ***********************************************************
// INFO
// ***********************************************************
user related functionality

*/

incCls("files/ini.php");

USR::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class USR extends objects {
	private static $dat = array();

public static function init() {
	KONST::set("STD_LANG", current(STR::toArray(LANGUAGES)));
	KONST::set("CUR_LANG", ENV::get("lang", STD_LANG));
	KONST::set("CUR_USER", ENV::get("crdu", "www"));
	KONST::set("CUR_PASS", ENV::get("crdp", "www"));

	self::read();

	KONST::set("FS_LOGIN", self::isUser());
	KONST::set("FS_ADMIN", self::isAdmin());
}

// ***********************************************************
// login to FS
// ***********************************************************
public static function isAdmin($usr = CUR_USER, $pwd = CUR_PASS) {
	if (IS_LOCAL) return true;
	return self::chkUser("admin", $usr, $pwd);
}
public static function isUser($usr = CUR_USER, $pwd = CUR_PASS) {
	if ($usr == "www") return true;

	return self::chkUser("user", $usr, $pwd);
}

private static function chkUser($grp, $usr, $pwd) {
	$chk = VEC::get(self::$dat, "$grp.$usr"); if (! $chk) return false;
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
		if ( ! STR::contains($lin, "=")) continue;

		$usr = STR::before($lin, "=");
		$pwd = STR::after($lin, "=");

		self::$dat["$grp.$usr"] = $pwd;
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
