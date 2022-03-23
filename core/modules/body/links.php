
<ul>
<?php

$ini = new ini();
$arr = $ini->getValues("url");

foreach ($arr as $key => $val) {
	$val = VEC::explode($val, ";", 2);
	$inf = $val[0];
	$lnk = $val[1];
	echo "<li><a href='$lnk' target='_blank'>$inf</a></li>\n";
}

?>
</ul>
