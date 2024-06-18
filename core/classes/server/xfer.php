<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for uploading files to server via xfer

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("server/xfer.php");

$srv = new xfer($visOnly);
$srv->act()

*/

incCls("server/SSL.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class xfer {
	private $visOnly = true;

function __construct($visOnly = true) {
	$this->visOnly = $visOnly;
}

// ***********************************************************
// bulk execution methods
// ***********************************************************
public function act() {
	$prm = ENV::getParm("p");
	$prm = SSL::decrypt($prm);
	$lst = STR::toAssoc($prm, "&");

	$act = VEC::get($lst, "w");
	$md5 = VEC::get($lst, "c"); if (! SSL::isValid($md5)) $act = "md5";
	$fso = VEC::get($lst, "f"); if (! $fso) $act = "err";

	if ($fso == ".") $fso = APP_DIR;

 // retrieving info
	if ($act == "get") return $this->sendList($fso);
	if ($act == "ver") return $this->send(VERSION);
	if ($act == "md5") return $this->send("ERROR: md5");
	if ($act == "err") return $this->send("ERROR: no file");
	if ($act == "tst") return $this->send("Testing");

 // bulk operations
	if ($act == "ren") return $this->do_ren  ($fso);
	if ($act == "mkd") return $this->do_mkDir($fso);
	if ($act == "rmd") return $this->do_rmDir($fso);
	if ($act == "dpf") return $this->do_kill ($fso);
	if ($act == "mod") return $this->do_touch($fso);

 // single file operations
	if ($act == "dwn") return $this->sendFile($fso);
	if ($act == "cpf") return $this->upload  ($fso);
	return false;
}

// ***********************************************************
// return requested info
// ***********************************************************
private function sendFile($fso) {
	$out = APP::read($fso);
	return $this->send($out);
}

private function send($txt) {
	$out = APP::read("LOC_LAY/default/min.tpl");
	$out = STR::replace($out, "<!VAR:content!>", $txt);
	die($out);
}

// ***********************************************************
// return a directory tree as d|f;yyyy.mm.dd;;file.ext;md5
// ***********************************************************
private function sendList($dir) {
	$out = $this->files($dir);
	return $this->send($out);
}

public function files($dir) {
	if ($dir == ".") $dir = APP_DIR; if (! is_dir($dir)) return false;

	$arr = FSO::fdTree($dir, "*", $this->visOnly);
	$out = "";

	foreach ($arr as $fso => $nam) {
		if (! $fso) continue;
		$out.= $this->info($fso, $dir);
	}
	return $out;
}

// ***********************************************************
private function info($fso, $root) {
	$dir = FSO::norm($root);
	$itm = STR::afterX($fso, $dir.DIR_SEP, "");

	$pfx = $this->prefix($fso, $root);
	$dat = $this->fdate($fso);
	$md5 = FSO::hash($fso);

	return "$pfx;$dat;;$itm;$md5\n";
}

// ***********************************************************
private function prefix($fso, $root) {
	$chk = realpath($fso);
	$lnk = STR::begins($chk, $root);

	if (is_file($fso))
	return ($lnk) ? "f": "l";
	return ($lnk) ? "d": "L";
}

private function fdate($fso) {
	if (is_dir($fso)) return 1;
	if (filesize($fso) < 1) return 0;
	return filemtime($fso);
}

// ***********************************************************
// react to upload request
// ***********************************************************
private function upload($fso) {
	$fil = $_FILES['file_contents']['tmp_name'];

	$res = move_uploaded_file($fil, $fso);
	$this->send($res > 0);
}

// ***********************************************************
// execute bulk commands
// ***********************************************************
private function do_mkDir($lst) { return $this->exec("force", $lst); }
private function do_rmDir($lst) { return $this->exec("rmDir", $lst); }
private function do_kill ($lst) { return $this->exec("kill",  $lst); }

private function exec($fnc, $lst) {
	$arr = STR::split($lst, ";");

	foreach ($arr as $fso) {
		if ($fso) FSO::$fnc($fso);
	}
	$this->send(1);
}

// ***********************************************************
private function do_ren($lst) { // rename dirs or files
	$arr = STR::split($lst, ";"); $cnt = 0;

	foreach ($arr as $itm) {
		$prp = STR::split($itm, " => "); if (count($prp) < 2) continue;
		$old = $prp[0]; if (! $old) continue;
		$new = $prp[1]; if (! $new) continue;
		$cnt+= FSO::rename($old, $new);
	}
	$this->send($cnt);
}

// ***********************************************************
private function do_touch($inf) {
	$arr = STR::split($lst, ";");

	foreach ($arr as $itm) {
		$fso = STR::before($inf, ":"); if (! $fso) continue;
		$tim = STR::after( $inf, ":");
		$cnt+= touch($fso, $tim);
	}
	$this->send(1);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
