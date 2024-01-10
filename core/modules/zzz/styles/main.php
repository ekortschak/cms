<?php

$arr = REG::get("css"); if (! $arr) return;
$lin = '<link rel="StyleSheet" href="%s" type="text/css" />';

foreach ($arr as $stl) {
	echo sprintf("$lin\n", $stl);
}

?>
