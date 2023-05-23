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

public static function init() {}

// ***********************************************************
// methods
// ***********************************************************
public static function setPbr($value) {
	$ini = new iniWriter();
	$ini->read(CUR_PAGE);
	$ini->set(CUR_LANG.".pbreak", $value);
	$ini->save();
	return $value;
}

public static function clearPbr() {
	$fil = APP::find(CUR_PAGE); if (! $fil) return;
	$txt = APP::read($fil); if (! $txt) return;
	$txt = PRG::replace($txt, '<hr class="pbr">(\s*?)', "");
	return APP::write($fil, $txt);
}

public static function hasPbr() {
	$fil = APP::find(CUR_PAGE); if (! $fil) return false;
	$txt = APP::read($fil); if (! $txt) return false;
	return STR::contains($txt, '<hr class="pbr">');
}


// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
