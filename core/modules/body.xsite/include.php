<?php

# included by > item.php
# $dir is not inherited

$loc = ENV::getPage();
$txt = APP::gcSys($loc);
# $txt = APP::lookup($txt);

// ***********************************************************
if (! $txt) $txt = NV;
echo $txt;

?>
