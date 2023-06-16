<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to handle system messages ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/MSG.php");

MSG::add($msg, $val); // $val will be appended to $msg after translation
MSG::err($msg)
MSG::show();
*/

MSG::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class MSG {
	private static $msg = array();

public static function init() {
	MSG::reset();
}

public static function reset() {
	MSG::$msg["msg"] = array();
	MSG::$msg["err"] = array();
}

// ***********************************************************
// store messages
// ***********************************************************
public static function add($msg, $prm = NV) {
	MSG::store("msg", $msg, $prm);
}
public static function err($msg, $prm = NV) {
	MSG::store("err", $msg, $prm);
}
public static function sql($msg, $sql) { // no translation
	$txt = "$msg<br>\n$sql";
	MSG::$msg["err"][$msg] = $txt;
}

public static function now($msg, $prm = NV) {
	MSG::add($msg, $prm);
	MSG::show();
}

// ***********************************************************
private static function store($div, $msg, $prm) {
	$msg = trim($msg); if (! $msg) return;
	if (isset(MSG::$msg[$msg])) return;

	$prm = MSG::chkParm($msg, $prm);
	$txt = DIC::get($msg);

	MSG::$msg[$div][$msg] = $txt.$prm;
}

private static function chkParm($msg, $prm) {
	if ($prm === NV) return "";
	if (strlen(trim($prm)) < 1) return ": '$prm'";
	if (strlen($msg.$prm) > 75) return ":<br>$prm";
	return ": $prm";
}

// ***********************************************************
// display messages
// ***********************************************************
public static function show() {
	$msg = MSG::collect("err", "error");
	$msg.= MSG::collect("msg", "msgs");
	$xxx = MSG::reset();
	echo $msg;
}

public static function long($msg) {
	$tpl = new tpl();
	$tpl->load("msgs/tales.tpl");
	$tpl->show($msg);
}

public static function startup() {
	$cnt = count(MSG::$msg["msg"]);
	$cnt+= count(MSG::$msg["err"]); if (! $cnt) return;

	HTW::xtag("msg.start", "h3");
	MSG::show();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function collect($div, $sec) {
	$arr = VEC::get(MSG::$msg, $div); if (! $arr) return "";
	$out = "";

	$tpl = new tpl();
	$tpl->load("msgs/msgs.tpl");

	foreach ($arr as $msg => $txt) {
#		$txt = htmlspecialchars($txt);
		$xxx = $tpl->set("item", $txt);
		$lin = $tpl->gc("item");
		$out.= $lin;
	}
	$xxx = $tpl->set("items", $out);
	return $tpl->gc("$sec.show");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************

?>
