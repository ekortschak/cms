<?php DBG::file(__FILE__); ?>

<ul>
<?php

$arr = PGE::props("url");

foreach ($arr as $key => $val) {
	$val = VEC::explode($val, ";", 2);
	$inf = $val[0];
	$lnk = $val[1];

	$lnk = HTM::href($lnk, $inf, "_blank");
	$xxx = HTW::tag($lnk, "p");
}

?>
</ul>
