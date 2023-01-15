<?php

$loc = ENV::getPage();

// ***********************************************************
$xxx = ENV::set("lookup", true);
// ***********************************************************
$txt = APP::gc($loc);
$txt = APP::lookup($txt);

if (EDITING == "view")
$txt = STR::replace($txt, '<hr class="pbr">', "");

// ***********************************************************
if (! $txt) $txt = NV;
echo $txt;

?>
