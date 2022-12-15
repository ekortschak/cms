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
	CFG::set("STD_LANG", current(STR::toArray(LANGUAGES)));
	CFG::set("CUR_LANG", ENV::get("lang", STD_LANG));

	$usr = ENV::get("crdu", "www");
	$pwd = ENV::get("crdp", "www");	$mod = ENV::get("vmode", "view");

	self::read();
	if (! self::isUser($usr, $pwd)) $mod = "logout";

	if (($mod == "logout")) {
		$usr = "www"; $pwd = "www";
	}
	CFG::set("CUR_USER", $usr);
	CFG::set("CUR_PASS", $pwd);

	CFG::set("FS_LOGIN", self::isUser());
	CFG::set("FS_ADMIN", self::isAdmin());

	ENV::set("crdu", $usr);
	ENV::set("crdp", $pwd);

	if (STR::begins($mod, "log")) ENV::set("vmode", "view");
}

// ***********************************************************
// check permissions
// ***********************************************************
public static function isAdmin($usr = CUR_USER, $pwd = CUR_PASS) {
	if (IS_LOCAL) return true;
	return self::chkUser("admin", $usr, $pwd);
}
public static function isUser($usr = CUR_USER, $pwd = CUR_PASS) {
	if ($usr == "www") return true;

	$out = self::chkUser("user",  $usr, $pwd); if ($out) return true;
	return self::chkUser("admin", $usr, $pwd);
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
