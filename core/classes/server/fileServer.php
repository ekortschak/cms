<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for uploading files to server via fileSever

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("server/fileServer.php");

$srv = new srvX($visOnly);
$srv->act()

*/

incCls("server/download.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class srvX {
	private $media = "file"; // file or screen
	private $visOnly = true;

function __construct($visOnly = true) {
	$this->visOnly = $visOnly;
}

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
		case "dir": return is_dir($fso);
		case "get": return $this->getTree($fso, $mod);
		case "ren": return $this->do_ren ($fso, $mod);
		case "mkd": return $this->do_mkDir($fso, $mod);
		case "rmd": return $this->do_rmDir($fso, $mod);
		case "cpf": return; // no bulk copying ...
		case "dpf": return $this->do_kill($fso, $mod);

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
#		echo "Error: Missing folder '$dir'";
		return;
	}
	$arr = FSO::fdtree($dir); $out = array("root" => $dir);

	foreach ($arr as $fso => $nam) {
		if (filesize($fso) < 1) continue; // 0 Byte files

		if (! $fso) continue; $val = $this->getEntry($fso);
		if (! $val) continue; $out[] = $val;
	}
	if ($mode == "local") return $out;
	if ($mode == "std") {
		$srv = new download();
		$srv->provide($out); // will end execution
	}
	$this->dump($out); // provide debug info
}

private function getEntry($fso) {
	if ($this->visOnly)
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
private function do_mkDir($dir, $mod)  { return $this->exec("force", $dir, $mod); }
private function do_rmDir($dir, $mod)  { return $this->exec("rmDir", $dir, $mod); }
private function do_kill ($fil, $mod)  { return $this->exec("kill",  $fil, $mod); }

private function exec($fnc, $fso, $mod = "std") {
	$arr = explode(";", $fso); $cnt = 0;

	foreach ($arr as $fso) {
		$fso = $this->chkPath($fso); if (! $fso) continue;

		switch ($mod) {
			case "debug": echo "<li>cmd: $fnc( $fso );"; break;
			default: $cnt+= (bool) FSO::$fnc($fso);
		}
	}
	return $cnt;
}

private function do_ren($fso, $mod) { // rename dirs or files
	$arr = explode(";", $fso); $cnt = 0;

	foreach ($arr as $itm) {
		$prp = explode("|", $itm);      if (count($prp) < 3) continue;
		$typ = $prp[0];                 if ($typ != "d") continue;

		$new = $this->chkPath($prp[1]); if (! $new) continue;
		$old = $this->chkPath($prp[2]); if (! $old) continue;

		if ($mod == "debug") {
			echo "<li>rename $typ: $old => $new";
			continue;
		}
		$cnt+= (bool) FSO::rename($old, $new);
	}
	return $cnt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function chkPath($fso) {
	$fso = APP::relPath($fso); if (! $fso) return false;
	$fso = STR::replace($fso, "./", APP_DIR);
	return $fso;
}

private function dump($out) {
	echo "<hr># of files: ".count($out);
	echo "<hr>"; // provide debug info
	echo implode("<br>\n", $out);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
