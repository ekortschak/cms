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
$edi->edit($dir);
*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ediMgr {
	private $fonly = false;

function __construct($filesOnly = false) {
	$this->fonly = (bool) $filesOnly;
}

// ***********************************************************
// display
// ***********************************************************
public function edit($dir, $files = false)   {
	$old = $ful = $dir;

	$box = new dropBox("menu");

	if (is_dir($dir)) {
		if (! $this->fonly)
		$dir = $box->folders($dir); if (! $dir) $dir = $old;
		$ful = $box->files($dir);
	}
	elseif ($files) {
		$ful = $box->getKey("pic.file", $files, $dir);
	}

	$typ = $this->findType($ful);
	$eds = $this->findList($typ);

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
private function findList($typ) {
	if ($typ == "code") return $this->getArr("code,xtern,text");
	if ($typ ==	"html") return $this->getArr("html,xtern,ck4,ck5,code");
	if ($typ == "ini")  return $this->getArr("ini,text");
	if ($typ == "dic")  return $this->getArr("dic,text");
	if ($typ == "pic")  return $this->getArr("pic");

	return array("text" => "text");
}

private function findType($file) {
	$ext = FSO::ext($file, true);

	if (STR::features("php",         $ext)) return "code";
	if (STR::features("ini.btn.def", $ext)) return "ini";
	if (STR::features("dic",         $ext)) return "dic";
	if (STR::features("css",         $ext)) return "css";
	if (STR::features("png.jpg.gif", $ext)) return "pic";
	if (STR::features("ico",         $ext)) return "pic";

	if (STR::features("htm.html",    $ext)) {
#		$htm = APP::read($file);
#		if (STR::contains($htm, "<?php")) return "code";
		return "html";
	}
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
private function getArr($items) {
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

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
