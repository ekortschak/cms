<?php

dbg($dir);

#$loc = ENV::getPage();
$txt = APP::gc($dir);
#$txt = APP::lookup($txt);

// ***********************************************************
if (! $txt) $txt = NV;
echo $txt;

?>
