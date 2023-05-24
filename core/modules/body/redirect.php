<?php

if (VMODE == "view") {
	$dir = PGE::get("props.trg"); if (! is_dir($dir))
	$dir = PFS::getPath($dir);
	$xxx = ENV::setPage($dir);
}

// ***********************************************************
// show new content
// ***********************************************************
$txt = APP::gcSys($dir); if (! $txt) $txt = NV;

echo $txt;

PGE::restore();

?>
