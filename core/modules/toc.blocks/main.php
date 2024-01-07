<?php

DBG::file(__FILE__);

// ***********************************************************
// show blocks
// ***********************************************************
$arr = APP::folders("blocks");

foreach ($arr as $dir => $nam) {
	echo APP::gcSys($dir);
}

?>
