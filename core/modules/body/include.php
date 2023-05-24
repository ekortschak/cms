<?php

$pge = ENV::getPage();

// ***********************************************************
$txt = APP::gcSys($pge);
$txt = APP::lookup($txt);
$txt = ACR::clean($txt);

// ***********************************************************
if (VMODE == "view") {
	$txt = STR::replace($txt, '<hr class="pbr">', "");
}

// ***********************************************************
if (! $txt) $txt = NV;
echo $txt;

?>
