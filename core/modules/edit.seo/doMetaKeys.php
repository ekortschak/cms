<?php

$loc = PFS::getLoc();
$lng = CUR_LANG;

// ***********************************************************
// get info
// ***********************************************************
$ini = new ini($loc);
$dat = $ini->get("$lng.meta");
$wht = "keys";

// ***********************************************************
$inc = FSO::join(__DIR__, "doMeta.php");
$inc = APP::relPath($inc);

include $inc;

?>
