<?php

$loc = PFS::getLoc();

// ***********************************************************
// get options
// ***********************************************************
incCls("menus/qikLink.php");

$qik = new qikLink();
$xxx = $qik->getVal("opt.overwrite", 0);
$ovr = $qik->gc();

// ***********************************************************
// show list
// ***********************************************************
incCls("files/dirView.php");

$tpl = new dirView();
$tpl->read("design/templates/editor/mnuFiles.tpl");
$tpl->set("curloc", $loc);
$tpl->set("visOnly", false);
$tpl->set("overwrite", $ovr);
$tpl->readTree($loc);
$tpl->show();

?>
