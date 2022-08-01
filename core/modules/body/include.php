<?php

$xxx = ENV::set("lookup", true);

// ***********************************************************
$loc = ENV::getPage();
$txt = APP::gc($loc);
$txt = APP::lookup($txt);

// ***********************************************************
if (! $txt) $txt = NV;
echo $txt;

?>
