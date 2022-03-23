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
}

// ***********************************************************
// methods
// ***********************************************************
public function getEditors($typ) {
	if (is_file($typ))
	$typ = $this->getType($typ);

	if ($typ == "ini") {
		return array(
			"ini"  => "Ini Editor",
			"text" => "Plain Text",
		);
	}
	if ($typ == "code") {
		return array(
			"html" => "Internal Editor",
			"code" => "External Editor",
			"text" => "Plain Text",
			"xdic" => "Translator",
		);
	}
	if ($typ ==	"html") {
		return array(
			"html" => "Internal Editor",
			"code" => "External Editor",
			"text" => "Plain Text",
			"ck4"  => "CK-Editor 4.x",
			"ck5"  => "CK-Editor 5.x",
			"xdic" => "Translator",
		);
	}
	return array();
}

public function getType($file) {
	$ext = FSO::ext($file, true);

	if (STR::contains(".php.", $ext)) return "code";
	if (STR::contains(".ini.", $ext)) return "ini";
	if (STR::contains(".js.txt.csv.sql.tpl.css.dic.log.", $ext)) return "text";
	if (STR::contains(".png.jpg.gif.", $ext)) return "pic";

	if (STR::contains(".htm.", $ext)) {
		$htm = APP::read($file);
		if (STR::contains($htm, "<?php")) return "code";
		return "html";
	}
	return "mime";
}

public function getToolbar($typ) {
	if ($typ == "code") return "code";
	if ($typ == "html") return "html";
	if ($typ == "text") return "html";
	if ($typ == "xdic") return "xdic";
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
public function extEdit($file) {
	$act = ENV::getParm("edit"); if (! $act) return;

	if ($act == "provide") return $this->provide($file);
	if ($act == "update")  return $this->update($file);
}

private function provide($file) {
	$ini = new iniWriter($this->dir);
	$old = $ini->get("props.path"); if ($old == $file) return;
	$xxx = $ini->set("props.path", $file);
	$xxx = $ini->save();

	FSO::copy($file, $this->ext);
}

private function update($file) {
	$ini = new iniWriter($this->dir);
	$chk = $ini->get("props.path");

	if ($chk == $file) FSO::copy($this->ext, $file);
	else MSG::add("path.wrong");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
