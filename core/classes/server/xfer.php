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

#incCls("server/download.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class xfer {
	private $media = "file"; // file or screen
	private $visOnly = true;
	private $dbg = 0;

function __construct($visOnly = true) {
	$this->visOnly = $visOnly;
}

// ***********************************************************
// bulk execution methods
// ***********************************************************
public function act() {
	$dbg = ENV::getParm("d", false); $this->dbg = $dbg;
	$prm = ENV::getParm("p");
	$prm = SSL::decrypt($prm);
	$lst = STR::toAssoc($prm, "&");

	$md5 = VEC::get($lst, "c"); if (! SSL::isValid($md5)) return "ERROR";
	$fso = VEC::get($lst, "f"); if (! $fso) return "ERROR";
	$act = VEC::get($lst, "w");

	if ($fso == ".") $fso = APP_DIR;
	$this->dbgParm($lst);

	switch($act) {
		case "ver": return $this->send(VERSION);
		case "get": return $this->getTree($fso, "remote");

 // bulk operations
		case "ren": return $this->do_ren  ($fso);
		case "mkd": return $this->do_mkDir($fso);
		case "rmd": return $this->do_rmDir($fso);
		case "dpf": return $this->do_kill ($fso);

 // single file operations
		case "cpf": return $this->do_copy($upload, $dest); // no bulk copying ...

#		case "mod": // modify mdate
#			$tim = VEC::get($lst, "t");
#			touch($fso, $tim);
	}
}

// ***********************************************************
// return a directory tree as d|f;yyyy.mm.dd;file.ext;md5
// ***********************************************************
public function getFiles($dir) {
	if (! IS_LOCAL) return "Not local";
	return $this->getTree($dir, "local");
}

// ***********************************************************
private function getTree($dir, $mode = "remote") {
	if ($dir == ".") $dir = APP_DIR; if (! is_dir($dir)) return;

	$arr = FSO::fdtree($dir);
	$out = array("root" => $dir);

	foreach ($arr as $fso => $nam) {
		if (! $fso) continue; $val = $this->getEntry($fso, $dir);
		if (! $val) continue; $out[] = $val;
	}
	if ($mode == "local") return $out;

	$this->send(implode("\n", $out));
}

// ***********************************************************
private function getEntry($fso, $root) {
	if ($this->visOnly)
	if (STR::contains($fso, HIDE)) return "";

	$dir = FSO::norm($root);
	$itm = STR::afterX($fso, $dir.DIR_SEP, "");

	if (  is_dir($fso))  return "d;1;$itm;1";
	if (! is_file($fso)) return "";

	$dat = filemtime($fso); if (filesize($fso) < 1) $dat = 0;
	$md5 = FSO::hash($fso);

	return "f;$dat;$itm;$md5";
}

// ***********************************************************
// execute single file commands
// ***********************************************************
private function do_copy($src, $trg) {
}

// ***********************************************************
// execute bulk commands
// ***********************************************************
private function do_mkDir($lst) { return $this->exec("force", $lst); }
private function do_rmDir($lst) { return $this->exec("rmDir", $lst); }
private function do_kill ($lst) { return $this->exec("kill",  $lst); }

private function exec($fnc, $lst) {
	$arr = explode(";", $lst); $cnt = 0;

	foreach ($arr as $fso) {
		$fso = $this->chkPath($fso); if (! $fso) continue;

		switch ($this->dbg) {
			case true: HTW::tag("cmd: $fnc( $fso )", "li"); break;
			default:   $cnt+= (bool) FSO::$fnc($fso);
		}
	}
	$this->send($cnt);
}

// ***********************************************************
private function do_ren($lst) { // rename dirs or files
	$arr = explode(";", $lst); $cnt = 0;

	foreach ($arr as $itm) {
		$prp = explode("|", $itm);      if (count($prp) < 3) continue;
		$typ = $prp[0];                 if ($typ != "d") continue;

		$new = $this->chkPath($prp[1]); if (! $new) continue;
		$old = $this->chkPath($prp[2]); if (! $old) continue;

		if ($this->dbg) {
			HTW::tag("rename $typ: $old => $new", "li");
			continue;
		}
		$cnt+= (bool) FSO::rename($old, $new);
	}
	$this->send($cnt);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function chkPath($fso) {
	$fso = APP::relPath($fso); if (! $fso) return false;
	$fso = STR::replace($fso, "./", APP_DIR);
	return $fso;
}

// ***********************************************************
private function send($txt) {
	$out = APP::read("LOC_LAY/default/min.tpl");
	$out = STR::replace($out, "<!VAR:content!>", $txt);
	die($out);
}

// ***********************************************************
private function dbgParm($inf) {
	if (! $this->dbg) return;

	$out = print_r($inf, true);
	echo "<pre>$out</pre>";
}
// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
