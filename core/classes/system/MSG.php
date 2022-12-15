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
	self::reset();
}

public static function reset() {
	self::$msg["msg"] = array();
	self::$msg["err"] = array();
}

// ***********************************************************
// store messages
// ***********************************************************
public static function add($msg, $prm = NV) {
	self::store("msg", $msg, $prm);
}
public static function err($msg, $prm = NV) {
	self::store("err", $msg, $prm);
}
public static function sql($msg, $sql) { // no translation
	$txt = "$msg<br>\n$sql";
	self::$msg["err"][$msg] = $txt;
}

public static function now($msg, $prm = NV) {
	self::add($msg, $prm);
	self::show();
}

// ***********************************************************
private static function store($div, $msg, $prm) {
	$msg = trim($msg); if (! $msg) return;
	if (isset(self::$msg[$msg])) return;

	$prm = self::chkParm($msg, $prm);
	$txt = DIC::get($msg).$prm;

	self::$msg[$div][$msg] = $txt;
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
	$msg = self::collect("err", "error");
	$msg.= self::collect("msg", "msgs");
	$xxx = self::reset();
	echo $msg;
}

public static function long($msg) {
	$tpl = new tpl();
	$tpl->read("design/templates/msgs/tales.tpl");
	$tpl->show($msg);
}

public static function startup() {
	$cnt = count(self::$msg["msg"]);
	$cnt+= count(self::$msg["err"]); if (! $cnt) return;

	HTM::tag("msg.start", "h3");
	self::show();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function collect($div, $sec) {
	$arr = VEC::get(self::$msg, $div); if (! $arr) return "";
	$out = "";

	$tpl = new tpl();
	$tpl->read("design/templates/msgs/msgs.tpl");

	foreach ($arr as $msg => $txt) {
#		$txt = htmlspecialchars($txt);
		$xxx = $tpl->set("item", $txt);
		$out.= $tpl->gc("item");
	}
	$xxx = $tpl->set("items", $out);
	return $tpl->gc("$sec.show");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************

?>
