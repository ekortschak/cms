<?php

$loc = ENV::getPage();

// ***********************************************************
$txt = APP::gc($loc);
$txt = APP::lookup($txt);

if (EDITING == "view") {
	$txt = STR::replace($txt, '<hr class="pbr">', "");
}

// ***********************************************************
if (! $txt) $txt = NV;
echo $txt;

?>
