<?php

$arr = PFS::getData("dat");

foreach ($arr as $key => $val) {
	DBG::vector($val, $key);
}

?>
