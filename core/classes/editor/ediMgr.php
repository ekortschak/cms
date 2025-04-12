<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to manage file editing in given directory


Info für FireFox
----------------
#You can change the view Page Source configuration by following these steps:
#Visit about:config in your Firefox web browser.
#Paste view_source.editor.external into the search bar and change the value from false to true by double-clicking on it.
#Paste view_source.editor.path into the search bar and right-click on the value to modify it. A dialogue box will appear. Set the path to your desired editor (/usr/bin/gedit for Gedit) and click OK.
#Now use Ctrl+U or Page Source to open the editor.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/ediMgr.php");

$edi = new ediMgr();
$edi->edit($dir, "*.ext");
*/

incCls("menus/dropBox.php");
incCls("editor/editIni.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ediMgr {
	private $fonly = false;

function __construct($filesOnly = false) {
	$this->fonly = (bool) $filesOnly;
	DBG::cls(__CLASS__);
}

// ***********************************************************
// display
// ***********************************************************
private function verify($fso) {
	if (is_dir($fso)) return true;

	MSG::now("not.appliccable");
	MSG::now("dir.missing", $fso);
}

public function edit($fso, $pattern = "*.htm") {
	if (! $this->verify($fso)) return;

	$box = new dropBox("menu");
	$dir = $old = $ful = $fso;

	if (is_dir($fso)) {
		if (! $this->fonly) $fso = $box->dirs($fso);
		if (! $fso) $fso = $old;
	}
	else {
		$dir = dirname($fso);
	}

	$arr = $this->files($dir, $pattern);
	$ful = $box->getKey("pic.file", $arr, $fso);

	$typ = $this->findType($ful);
	$eds = $this->editors($typ);

	$typ = $box->getKey("pic.editor", $eds);
	$xxx = $box->show();

	$cls = $this->findClass($typ);
	incCls("editor/$cls.php");

	$edt = new $cls();
	$edt->suit($typ);
	$edt->grab($ful);
	$edt->edit();
}

// ***********************************************************
// retrieving options
// ***********************************************************
private function editors($typ) {
	if (VMODE == "ebook") return "text";
	
	if ($typ == "none") return array();
	if ($typ == "code") return $this->modes("code,xtern,text");
	if ($typ ==	"html") return $this->modes("html,xtern,ck4,ck5,code");
	if ($typ == "ini")  return $this->modes("ini,text");
	if ($typ == "dic")  return $this->modes("dic,text");
	if ($typ == "pic")  return $this->modes("pic");

	return array("text" => "text");
}

private function findType($file) {
	if (! $file) return "none";      $ext = FSO::ext($file, true);

	if (STR::features("php",         $ext)) return "code";
	if (STR::features("ini.btn.def", $ext)) return "ini";
	if (STR::features("dic",         $ext)) return "dic";
	if (STR::features("css",         $ext)) return "css";
	if (STR::features("png.jpg.gif", $ext)) return "pic";
	if (STR::features("ico",         $ext)) return "pic";
	if (STR::features("htm.html",    $ext)) return "html";
	return "text";
}

private function findClass($typ) {
	$cls = "edit".ucfirst($typ);
	$chk = APP::file("LOC_CLS/editor/$cls.php"); if ($chk) return $cls;
	return "editText";
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function modes($items) {
	$out = array(); $arr = STR::toArray($items);
	$dat = array(
		"code"  => "Code",   "ini" => "Ini-Editor",
		"html"  => "Intern", "dic" => "Dic-Editor", "ck4"  => "CK-Editor 4.x",
		"xtern" => "Extern", "css" => "Css-Editor", "ck5"  => "CK-Editor 5.x",
		"text"  => "Text",   "pic" => "Pic-Editor",
	);
	foreach ($arr as $key) {
		$out[$key] = $dat[$key];
	}
	return $out;
}

private function files($dir, $pattern = "*.htm") {
	$arr = FSO::files($dir, $pattern);

	foreach ($arr as $key => $val) {
		if (STR::misses($pattern, ".ini"))
		if ($val == "page.ini") {
			unset($arr[$key]);
			break;
		}
	}
	return $arr;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
