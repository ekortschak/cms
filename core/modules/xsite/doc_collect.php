<?php
# collect sub pages for printable output

$loc = PGE::dir(); if (! $loc) return;
$arr = FSO::dirs($loc);

// ***********************************************************
// show container
// ***********************************************************
PRN::load($loc);

$kap = new chapter();
$kap->init($loc);
$kap->show();

$cnt = 0;

// ***********************************************************
// show collection
// ***********************************************************
foreach ($arr as $dir => $itm) {
	if (FSO::isHidden($dir)) continue;

	PGE::load($dir);
	PRN::load($dir);

	$kap = new chapter();
	$kap->init($dir);
	$kap->addPic();
	$kap->show();
}

?>
