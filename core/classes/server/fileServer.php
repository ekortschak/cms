<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for uploading files to server via fileSever

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("server/fileServer.php");

$srv = new srvX();
$srv->act()

*/

incCls("server/download.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class srvX {
	private $media = "file"; // file or screen

function __construct() {}

// ***********************************************************
// bulk execution methods
// ***********************************************************
public function act() {
	$dbg = ENV::getParm("d", 0);
	$prm = ENV::getParm("p");
	$prm = SSL::decrypt($prm);
	$lst = STR::toAssoc($prm, "&");

	$md5 = VEC::get($lst, "c"); if (! SSL::isValid($md5)) return;
	$fso = VEC::get($lst, "f"); if (! $fso) return;
	$act = VEC::get($lst, "w");
	$mod = "std";

	if ($fso == ".") $fso = APP_DIR;

	if ($dbg) {
		echo "<pre>"; DBG::vector($lst, "Query Parameter");
		echo "</pre>"; $mod = "debug";
	}

	switch($act) {
		case "get": return $this->getTree($fso, $mod);
		case "ren": return $this->rename ($fso, $mod);
		case "mkd": return $this->makeDir($fso, $mod);
		case "rmd": return $this->dropDir($fso, $mod);
		case "cpf": return; // no bulk copying ...
		case "dpf": return $this->dropFile($fso, $mod);

#		case "mod": // modify mdate
#			$tim = VEC::get($lst, "t");
#			FSO::copy("$fso~", $fso); touch($fso, $tim);
#			FSO::kill("$fso~");
	}
}

// ***********************************************************
// return a directory tree as d|f;yyyy.mm.dd;file.ext;md5
// ***********************************************************
public function getFiles($dir) {
	if (! IS_LOCAL) return "Not local";
	return $this->getTree($dir, "local");
}

private function getTree($dir, $mode = "std") {
	if ($dir == ".") $dir = APP_DIR;

	if (! is_dir($dir)) {
		echo "Error: Missing folder '$dir'";
		return;
	}
	$arr = FSO::fdtree($dir); $out = array("root" => $dir);

	foreach ($arr as $fso => $nam) {
		if (! $fso) continue; $val = $this->getEntry($fso);
		if (! $val) continue; $out[] = $val;
	}
	if ($mode == "local") return $out;
	if ($mode == "std") {
		echo implode("\n", $out);
		return;
	}
	echo "<hr>"; // provide debug info
	echo implode("<br>\n", $out);
	echo "<hr># of files: ".count($out);
}

private function getEntry($fso) {
	if (STR::contains($fso, HIDE)) return "";

	if (  is_dir($fso))  return "d;1;$fso;1";
	if (  is_link($fso)) return "";
	if (! is_file($fso)) return "";

	$dat = filemtime($fso); if (filesize($fso) < 1) $dat = 0;
	$md5 = md5_file($fso);

	return "f;$dat;$fso;$md5";
}

// ***********************************************************
// execute fs commands
// ***********************************************************
private function makeDir($dir, $mod)  { return $this->exec("force", $dir, $mod); }
private function dropDir($dir, $mod)  { return $this->exec("rmDir", $dir, $mod); }
private function dropFile($fil, $mod) {	return $this->exec("kill",  $fil, $mod); }

private function exec($fnc, $fso, $mod = "std") {
	$arr = explode(";", $fso); $cnt = 0;

	foreach ($arr as $fso) {
		$fso = $this->chkPath($fso);

		switch ($mod) {
			case "debug": echo "<li>exec $fnc( $fso );"; break;
			default: $cnt+= (bool) FSO::$fnc($fso);
		}
	}
	return $cnt;
}

private function rename($fso, $mod) { // rename dirs or files
	$arr = explode(";", $fso); $cnt = 0;
	$chk = array(); // already moved dirs

	foreach ($arr as $itm) {
		$prp = explode("|", $itm); if (count($prp) < 3) continue;

		$typ = $prp[0];
		$new = $this->chkPath($prp[1]); if (! $new) continue;
		$old = $this->chkPath($prp[2]); if (! $old) continue;

		if ($typ == "d") {
			$chk[$old] = $new;
		}
		else {
			if ($this->chkRename($chk, $old)) continue;
		}
		if ($mod == "debug") {
			echo "<li>rename $typ: $old => $new";
			continue;
		}
		$cnt+= (bool) FSO::rename($old, $new);
	}
	return $cnt;
}

private function chkRename($arr, $value) {
	foreach ($arr as $key => $val) {
		if (STR::begins($value, $key)) return true;
	}
	return false;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function chkPath($fso) {
	$fso = FSO::clearRoot($fso); if (! $fso) return false;
	$fso = STR::replace($fso, "./", APP_DIR);
	return $fso;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
