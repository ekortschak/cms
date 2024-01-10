<?php

$arr = REG::get("js"); if (! $arr) return;
$lin = '<script src="%s"></script>';

foreach ($arr as $scr) {
	echo sprintf("$lin\n", $scr);
}

?>
