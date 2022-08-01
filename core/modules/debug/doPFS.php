<?php

$arr = PFS::getData("dat");

foreach ($arr as $key => $val) {
	dbg($val, $key);
}

?>
