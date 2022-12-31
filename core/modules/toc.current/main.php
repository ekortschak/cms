<?php

$ini = new ini(TAB_HOME);
$tit = $ini->getTitle();
$uid = $ini->getUID();

// ***********************************************************
if (EDITING != "view") {
	$tit = HTM::href("?pge=$uid", $tit);
}

?>

<div class="toc mnu lev1" style="margin-top: -5px;">
<?php echo $tit; ?>
</div>
