<?php

if (EDITING == "view") {
	$dir = PGE::get("props.trg"); if (! is_dir($dir))
	$dir = PFS::getPath($dir);
}

// ***********************************************************
// show new content
// ***********************************************************
$pge = FSO::join(APP_DIR, $dir);
$xxx = ENV::setPage($pge);
$txt = APP::gc($dir); if (! $txt) $txt = NV;

echo $txt;

ENV::setPage(CUR_PAGE);

?>
