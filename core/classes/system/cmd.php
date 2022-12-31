<?php
/* ***********************************************************
// INFO
// ***********************************************************
Use this to savely execute shell commands

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/cmd.php");

$cli = new cmd();
$ret = $cli->exec($cmd);
$out = $cli->data();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class cmd {
	public $title = "Shell Output";

	private $dat = array();

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function exec($cmd, $desc = NV) {
	if ($desc == NV) $desc = $cmd; if (! $cmd) return;

	$cmd = escapeshellcmd($cmd); $ret = "";
	$this->dat[$desc] = array();
	exec($cmd, $this->dat[$desc], $ret);
	return $ret;
}

public function toString() {
	$out = "";

	foreach ($this->dat as $key => $val) {
		foreach ($val as $lin) {
			$out.= "  $lin\n";
		}
	}
	return $out;
}
public function data() {
	return $this->dat;
}
public function clear() {
	$this->dat = array();
}

// ***********************************************************
// output
// ***********************************************************
public function show() {
	echo $this->gc();
}
public function gc() {
	$out = "";

	foreach ($this->dat as $key => $val) {
		$out.= "<b>$key</b>\n";
		foreach ($val as $lin) {
			$out.= "  $lin\n";
		}
		$out.= "\n";
	}
    return HTM::tag($out, "pre");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
