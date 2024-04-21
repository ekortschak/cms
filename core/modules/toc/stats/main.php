<?php

DBG::file(__FILE__);
HTW::vspace(12);

// ***********************************************************
#HTW::xtag("topstats", 'div class="h3"');
// ***********************************************************
incCls("other/counter.php");
incCls("tables/htm_table.php");

$fld = DIC::get("folders");
$typ = DIC::get("file.type");
$anz = DIC::get("count");

// ***********************************************************
// show description
// ***********************************************************
$obj = new counter();
$arr = FSO::fdTree(TAB_HOME);

foreach ($arr as $fil => $nam) {
	if (is_dir($fil)) $obj->count($fld);
	else {
		$ext = FSO::ext($fil);
		$obj->count("*.$ext");
	}
}

$arr = array($fld => 0);
$arr = array_merge($arr, $obj->getData());

$tbl = new htm_table();
$tbl->addArray($arr);
$tbl->setProp("Key", "head", $typ);
$tbl->setProp("Key", "width", 200);
$tbl->setProp("Value", "head", "$anz");
$tbl->setProp("Value", "align", "right");
$tbl->show();

?>

