<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to handle system messages ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/MSG.php");

MSG::add($msg xxx, "xxx"); // xxx will be replaced by "xxx"
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
public static function check($silent, $msg, $prm = "") {
	if ($silent) return;
	self::add("msg", $msg, $prm);
}
public static function add($msg, $prm = "") {
	self::storeXl("msg", $msg, $prm);
}
public static function err($msg, $prm = "") {
	self::storeXl("err", $msg, $prm);
}
public static function raw($sql, $prm = "") { // no translation
	self::store("err", $sql, $prm);
}

public static function now($msg, $prm = "") {
	self::storeXl("msg", $msg, $prm);
	self::show();
}

// ***********************************************************
private static function storeXl($tag, $msg, $prm = "") {
	$msg = DIC::get($msg);
	self::store($tag, $msg, $prm);
}

private static function store($tag, $msg, $prm = "") {
	$msg = trim($msg); if (! $msg) return;
	if (isset(self::$msg[$msg])) return;
	self::$msg[$tag][$msg] = $prm;
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
private static function collect($tag, $sec) {
	$arr = VEC::get(self::$msg, $tag); if (! $arr) return "";
	$out = "";

	$tpl = new tpl();
	$tpl->read("design/templates/msgs/msgs.tpl");

	foreach ($arr as $msg => $prm) {
		$msg = self::prepare($msg, $prm);
		$xxx = $tpl->set("item", $msg);
		$out.= $tpl->gc("item");
	}
	$xxx = $tpl->set("items", $out);
	return $tpl->gc("msgs.show");
}

private static function prepare($msg, $prm) {
	if (strlen($prm) > 30) $prm = "<br/>\n$prm";

	$out = htmlspecialchars($msg);
	$out = str_ireplace("xxx", $prm, $out);
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************

?>
