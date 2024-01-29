<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for quick editing options

*/

incCls("editor/iniWriter.php");

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
	$ini->read(PGE::$dir);
	$ini->set(CUR_LANG.".pbreak", $value);
	$ini->save();
	return $value;
}

public static function clearPbr() {
	$fil = APP::snip(PGE::$dir); if (! $fil) return;
	$txt = APP::read($fil); if (! $txt) return;
	$txt = PRG::replace($txt, '<hr class="pbr">(\s*?)', "");
	return APP::write($fil, $txt);
}

public static function hasPbr() {
	$fil = APP::snip(PGE::$dir); if (! $fil) return false;
	$txt = APP::read($fil); if (! $txt) return false;
	return STR::contains($txt, '<hr class="pbr">');
}


// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
