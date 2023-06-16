<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for quick editing options

*/

incCls("editor/iniWriter.php");

QED::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class QED {
	private static $pge = false;

public static function init() {
	QED::$pge = ENV::getPage();
}

// ***********************************************************
// methods
// ***********************************************************
public static function setPbr($value) {
	$ini = new iniWriter();
	$ini->read(QED::$pge);
	$ini->set(CUR_LANG.".pbreak", $value);
	$ini->save();
	return $value;
}

public static function clearPbr() {
	$fil = APP::find(QED::$pge); if (! $fil) return;
	$txt = APP::read($fil); if (! $txt) return;
	$txt = PRG::replace($txt, '<hr class="pbr">(\s*?)', "");
	return APP::write($fil, $txt);
}

public static function hasPbr() {
	$fil = APP::find(QED::$pge); if (! $fil) return false;
	$txt = APP::read($fil); if (! $txt) return false;
	return STR::contains($txt, '<hr class="pbr">');
}


// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
