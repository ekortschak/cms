<?php

$loc = PFS::getLoc();

if (EDITING == "view") {
	$ini = new ini();
	$dir = $ini->get("props.trg");
	$loc = PFS::getPath($dir);
}

// ***********************************************************
// show new content
// ***********************************************************
$txt = APP::gc($loc); if (! $txt) $txt = NV;
echo $txt;

?>
