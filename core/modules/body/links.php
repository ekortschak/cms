
<ul>
<?php

$ini = new ini();
$arr = $ini->getValues("url");

foreach ($arr as $key => $val) {
	$val = VEC::explode($val, ";", 2);
	$inf = $val[0];
	$lnk = $val[1];

	$lnk = HTM::href($lnk, $inf, "_blank");
	$xxx = HTW::tag($lnk, "p");
}

?>
</ul>
