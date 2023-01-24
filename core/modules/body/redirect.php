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
$pge = FSO::join(APP_DIR, $dir);
ENV::setPage($pge);

$txt = APP::gc($dir); if (! $txt) $txt = NV;
echo $txt;

ENV::setPage($loc);

?>
