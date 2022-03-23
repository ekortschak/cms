<?php
/* ***********************************************************
// INFO
// ***********************************************************
simple ini editor

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/iniMgr.php");

$obj = new iniMgr($tplfile);
$ini->read($fil);
$ini->save($fil);
$ini->show();
*/

incCls("editor/iniWriter.php");
incCls("editor/iniEdit.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniMgr extends iniTpl {


function __construct($tplfile) {

	parent::__construct($tplfile);
	$this->sealed = is_file($tplfile);
}

// ***********************************************************
// display input fields by sections
// ***********************************************************
public function show() {
	$this->prepare(); $lgs = LANGUAGES;

	$sel = new iniEdit();
	$sel->forget();

	foreach ($this->sec as $sec => $txt) {
		if (STR::begins($sec, "dic")) continue;
		if (STR::contains(".$lgs.", ".$sec."))
		$sel->section("<img src='core/icons/flags/$sec.gif' class='flag' />"); else
		$sel->section("[$sec]");

		foreach ($this->vls as $key => $val) {
			if (! STR::begins($key, "$sec.")) continue;

			$qid = STR::replace($key, "$sec.", $sec."[")."]";
			$vls = $this->getList($key);
			$vls = $this->chkVals($vls);
			$val = $this->chkCur($val);

			$sel->addByDefault($qid, $vls, $val);
		}
	}
	$sel->show();
}

// ***********************************************************
// rewriting content
// ***********************************************************
public function save($ful = NV) {
	if ($ful == NV) $ful = $this->file; $out = "";

	$arr = ENV::getPostGrps("val_"); if (! $arr) return;
	$this->setPost($arr);

	foreach ($this->sec as $sec => $txt) {
		$arr = $this->getValues($sec); if (! $arr) continue;
		$out.= "[$sec]\n";

		foreach ($arr as $key => $val) {
			$key = STR::clear($key, "$sec.");
			$val = $this->secure($val);
			$out.= "$key = $val\n";
		}
		$out.= "\n";
	}
$dbg = 0;

	if ($dbg) return dbght($out); // return without saving
	return APP::write($ful, $out);
}

public function setPost($arr) {
	foreach ($arr as $sec => $vls) {
		foreach ($vls as $key => $val) {
			$prp = "$sec.$key"; if (! $this->isKey($prp)) continue;
			$this->set($prp, $val);
		}
	}
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function prepare() {
	$this->set("DIR_NAME", dirname($this->file));

	$tit = $this->getProp("title");
	$hed = $this->getProp("head"); if ($tit == $hed) $hed = "";
	$uid = $this->getProp("UID");

	$this->set("UID", $uid);
	$this->set("NODE_TYPES", $this->validTypes());
	$this->set("TITLE", $tit);
	$this->set("HEAD",  $hed);
}

// ***********************************************************
private function chkVals($val) {
	if ($val == "NODE_TYPES") {
		return $this->get("NODE_TYPES");
	}
	return $val;
}

private function chkCur($val) {
	if ($val == "UID")       return $this->get("UID");
	if ($val == "DIR_NAME")  return $this->get("DIR_NAME");
	if ($val == "GET_TITLE") return $this->get("TITLE");
	if ($val == "GET_HEAD")  return $this->get("HEAD");
	return $val;
}

// ***********************************************************
// securing values
// ***********************************************************
private function secure($val) {
	$val = STR::replace($val, "<?php", "&lt;?php");
	$val = STR::replace($val, "\#", "#");
	$val = STR::replace($val, "#", "\#");
	return $val;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
