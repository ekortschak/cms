<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create lists for input objects for ini Files
* e.g. props, title ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("forms/iniEdit.php");

$edi = new iniEdit($tplfile);
$edi->read($inifile);
$edi->addField($prop, $vals, $val);
$edi->show();
*/

incCls("editor/iniWriter.php");
incCls("input/selAuto.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniEdit extends selAuto {
	private $file = false;
	private $tpl = false;

function __construct($tplfile = false) {
	parent::__construct();

	$this->forget();
	$this->tpl = $tplfile;
}

public function read($file) {
	$this->hold("edit.file", $file);
	$this->file = $file;
}

// ***********************************************************
// show editor
// ***********************************************************
public function edit() {
	$fso = $this->file;
	$tpl = $this->getType($fso);

	$ini = new iniWriter($tpl);
	$xxx = $ini->read($fso);
	$arr = $ini->getSecs();

	foreach ($arr as $sec => $txt) {
		if (STR::begins($sec, "dic")) continue;

		$tit = "[$sec]"; if (LNG::isLang($sec))
		$tit = HTM::flag($sec);
		$this->section($tit);

		$typ = $ini->fldType($sec);

		if ($typ == "tarea") { // memo sections
			$val = $this->getSec($sec);
			$this->addField($sec."[tarea]", $val, 15);
		}
		else { // key = value sections
			$arr = $ini->getValues($sec);

			foreach ($arr as $key => $val) {
				$qid = $sec."[$key]";
				$vls = $ini->getChoice("$sec.$key");
				$val = $ini->chkValue($val, $sec);

				$this->addField($qid, $vls, $val);
			}
		}
	}
	$this->show();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getType($fil) {
	if ($this->tpl) return $this->tpl;

	if (STR::ends($fil, "page.ini")) {
		return PGE::type($fil);
	}
	if (STR::ends($fil, ".ini")) {
		$nam = basename($fil);
		$out = STR::replace($nam, ".ini", ".def");
		$out = FSO::join(LOC_CFG, $out);

		if (APP::file($out)) return $out;
	}
	if (APP::file($fil)) {
		$ini = new ini($fil);
		$out = $ini->getType(NV); if ($out !== NV) return $out;
	}
	return NV;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
