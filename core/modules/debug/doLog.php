<?php

$txt = file_get_contents($ful);
$txt = trim($txt); if (! $txt)
$txt = NV;

echo "<pre>";
echo $txt;
echo "</pre>";

?>
