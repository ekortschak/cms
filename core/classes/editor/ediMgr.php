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
incCls("editor/ediMgr.php");

$edi = new ediMgr();
$edi->read($fil);
$edi->show($tool);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ediMgr {
	private $typ = "text";
	private $edt = array();
	private $fil = false;

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function read($file) {
	$this->fil = $file;
	$this->typ = $this->findType($this->fil);
	$this->edt = $this->findList($this->typ);
}

public function getType()    { return $this->typ; }
public function getEditors() { return $this->edt; }

// ***********************************************************
// methods
// ***********************************************************
private function findType($file) {
	$ext = FSO::ext($file, true); $ext = ".$ext.";

	if (STR::contains(".php.",         $ext)) return "code";
	if (STR::contains(".ini.btn.def.", $ext)) return "ini";
	if (STR::contains(".dic.",         $ext)) return "dic";
	if (STR::contains(".css.",         $ext)) return "css";
	if (STR::contains(".png.jpg.gif.", $ext)) return "pic";

	if (STR::contains(".htm.", $ext)) {
#		$htm = APP::read($file);
#		if (STR::contains($htm, "<?php")) return "code";
		return "html";
	}
	return "text";
}

private function findList($typ) {
	if ($typ == "code") return $this->getArr("code,xtern,text");
	if ($typ ==	"html") return $this->getArr("html,xtern,ck4,ck5,code");
	if ($typ == "ini")  return $this->getArr("ini,text");
	if ($typ == "dic")  return $this->getArr("dic,text");
	return array();
}

// ***********************************************************
// display
// ***********************************************************
public function show($tool = NV) {
	if ($tool == NV) $tool = key($this->edt);
	if (! $tool) $tool = "text";

	if ($tool == "ini")   return $this->showCom("editIni");
	if ($tool == "dic")   return $this->showCom("editDic");
	if ($tool == "css")   return $this->showCss("editCss");
	if ($tool == "xtern") return $this->showCom("editXtern", $tool);
	if ($tool == "pic")   return $this->showCom("editPic",   $tool);

	return $this->showCom("editText",  $tool);
}

// ***********************************************************
public function showCom($cls, $tool = "text") {
	incCls("editor/$cls.php");

	$edt = new $cls();
	$edt->edit($this->fil);
	$edt->suit($tool);
	$edt->show();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getArr($items) {
	$out = array(); $arr = STR::toArray($items);
	$dat = array(
		"html"  => "Intern", "ini" => "Ini-Editor", "text" => "Text",
		"code"  => "Code",   "dic" => "Dic-Editor", "ck4"  => "CK-Editor 4.x",
		"xtern" => "Extern", "css" => "Css-Editor", "ck5"  => "CK-Editor 5.x",
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
