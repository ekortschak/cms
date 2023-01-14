<?php
/* ***********************************************************
// INFO
// ***********************************************************
Info für FireFox
#You can change the view Page Source configuration by following these steps:
#Visit about:config in your Firefox web browser.
#Paste view_source.editor.external into the search bar and change the value from false to true by double-clicking on it.
#Paste view_source.editor.path into the search bar and right-click on the value to modify it. A dialogue box will appear. Set the path to your desired editor (/usr/bin/gedit for Gedit) and click OK.
#Now use Ctrl+U or Page Source to open the editor.


// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/ediTools.php");

$ediTools = new ediTools();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ediTools {
	private $dir = ""; // external dir
	private $ext = ""; // externally edited file

function __construct() {
	$lng = CUR_LANG;
	$this->dir = APP::tempDir("edit");
	$this->ext = FSO::join($this->dir, "curEdit.$lng.php");
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
public function getEditors($typ) {
	if (is_file($typ))  $typ = $this->getType($typ);

	if ($typ == "ini")  return $this->getArr("ini,text");
	if ($typ == "code") return $this->getArr("code,xedit,text");
	if ($typ ==	"html") return $this->getArr("html,xtern,ck4,ck5");
	if ($typ == "dic")  return $this->getArr("dic,text");
	if ($typ == "ini")  return $this->getArr("css,text");
	return array();
}

public function getType($file) {
	$ext = FSO::ext($file, true);

	if (STR::contains(".php.", $ext)) return "code";
	if (STR::contains(".ini.", $ext)) return "ini";
	if (STR::contains(".dic.", $ext)) return "dic";
#	if (STR::contains(".css.", $ext)) return "css";
	if (STR::contains(".png.jpg.gif.", $ext)) return "pic";

	if (STR::contains(".htm.", $ext)) {
#		$htm = APP::read($file);
#		if (STR::contains($htm, "<?php")) return "code";
		return "html";
	}
	return "text";
}

public function getToolbar($typ) {
	if ($typ == "code") return "code";
	if ($typ == "html") return "html";
	if ($typ == "text") return "text";
	if ($typ == "dic")  return "dic";
	if ($typ == "css")  return "css";
	return false;
}

public function getPath() {
	return $this->dir;
}

private function getHtml() {
	if (EDITOR == "ck4") return "ck4";
	if (EDITOR == "ck5") return "ck5";
	return "html";
}

// ***********************************************************
// providing and updating externally edited files
// ***********************************************************
public function exec() {
	$act = ENV::getParm("edit"); if (! $act) return;
	$fil = ENV::getParm("file");

	if ($act == "provide") return $this->provide($fil);
	if ($act == "update")  return $this->update($fil);
	if ($act == "clear")   return $this->clear();
}

// ***********************************************************
private function provide($file) {
	if (! is_file($file)) return;
	$cfg = FSO::join($this->dir, "extEdit.ini");

	$ini = new iniWriter("LOC_CFG/xedit.ini");
	$ini->read($cfg);
	$ini->set("props.file", $file);
	$ini->set("props.time", time());
	$ini->save($cfg);

	FSO::copy($file, $this->ext);
}

private function update($file) {
	if (! is_file($file)) return;
	$cfg = FSO::join($this->dir, "extEdit.ini");
	$chk = PGE::prop($cfg, "props.file");

	if ($chk == $file) FSO::copy($this->ext, $file);
	else MSG::add("path.wrong");
}

private function clear() {
	FSO::rmDir($this->dir);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getArr($items) {
	$arr = STR::toArray($items); $out = array();
	$dat = array(
		"html"  => "Intern",
		"code"  => "Intern",
		"xedit" => "Extern",
		"xtern" => "Extern",
		"text"  => "Text",
		"dic"   => "Dictionary",
		"ini"   => "Ini-Editor",
		"css"   => "Css-Editor",
		"ck4"   => "CK-Editor 4.x",
		"ck5"   => "CK-Editor 5.x",
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
