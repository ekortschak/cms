<?php

incCls("files/css.php");

$css = new css();
$txt = $css->gc();
$txt = trim($txt); if (! $txt)
$txt = NV;

echo "<pre>";
echo $txt;
echo "</pre>";

?>
