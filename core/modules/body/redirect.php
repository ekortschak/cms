<?php

$loc = PFS::getLoc();

if (EDITING == "view") {
	$ini = new ini();
	$dir = $ini->get("props.trg");

	if (! is_dir($dir))
	$dir = PFS::getPath($dir);
}

// ***********************************************************
// show new content
// ***********************************************************
ENV::setPage(APP_DIR.$dir);

$txt = APP::gc($dir); if (! $txt) $txt = NV;
echo $txt;

ENV::setPage($loc);

?>
