<?php
# collect sub pages for printable output

$loc = PGE::dir();
$arr = APP::folders($loc);

// ***********************************************************
// show container
// ***********************************************************
$kap = new chapter();
$kap->load("xsite/main.tpl");
$kap->init($loc);
$kap->show();

// ***********************************************************
// show collection
// ***********************************************************
foreach ($arr as $dir => $itm) {
	PGE::load($dir);

	$kap = new chapter();
	$kap->load("xsite/collect.tpl");
	$kap->init($dir);
	$kap->addPic();
	$kap->show();
}

?>
