<?php

incCls("other/counter.php");
incCls("tables/htm_table.php");

// ***********************************************************
// show description
// ***********************************************************
$obj = new counter();
$arr = FSO::fdtree(TAB_HOME);

foreach ($arr as $fil => $nam) {
	if (is_dir($fil)) $obj->count("DIRS");
	else {
		$ext = FSO::ext($fil);
		$obj->count($ext);
	}
}

$typ = DIC::get("file.type");

$tbl = new htm_table();
$tbl->addArray($obj->getData());
$tbl->setProp("Key", "head", $typ);
$tbl->setProp("Value", "head", "Count");
$tbl->setProp("Value", "align", "right");
$tbl->show();

?>
