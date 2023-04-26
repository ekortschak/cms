<?php

$ini = new ini(TAB_HOME);
$tit = $ini->getTitle();
$uid = $ini->getUID();

// ***********************************************************
if (VMODE != "view") {
	$tit = HTM::href("?pge=$uid", $tit);
}

?>

<div class="toc mnu lev1">
<?php echo $tit; ?>
</div>
