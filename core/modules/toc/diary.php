<?php

incCls("menus/dropDate.php");
incCls("input/button.php");
incCls("editor/iniWriter.php");

// ***********************************************************
$box = new dropDate();
$dat = $box->getYmd();
$xxx = $box->show();

// ***********************************************************
$dir = FSO::join(TAB_HOME, $dat);
$xxx = PGE::load($dir);

if (is_dir($dir)) return;

// ***********************************************************
if (ENV::getParm("diary.act") == "add") {
	$cms = rtrim(FBK_DIR, DIR_SEP);

	FSO::copyDir("$cms/design/setup/diary", $dir);

	$ini = new iniWriter();
	$ini->read($dir);
	$ini->set("props.uid", $dat);
	$ini->save();

	return;
}

HTW::href("?diary.act=add", "Create page", "_self");

?>
