<p>Module not yet available.</p>

<?php
return;

DBG::file(__FILE__);

incCls("menus/dropNav.php");
incCls("input/checkList.php");
incCls("editor/idxEdit.php");

// ***********************************************************
// retrieving main page
// ***********************************************************
$loc = PGE::dir();
$uid = PGE::UID();

$buk = BBL::bookFile($uid);
$arr = FSO::files($buk, "*.htm");
$cnt = 1;

if (count($arr) < 1) {
	return MSG::now("no.files", "*.htm");
}

// ***********************************************************
// show editor
// ***********************************************************
MSG::now("not.appliccable");

?>
