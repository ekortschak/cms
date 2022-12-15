<?php

// ***********************************************************
$ini = new ini(TAB_HOME);
$tit = $ini->getTitle();
$uid = $ini->getUID();

if (EDITING != "view") {
	$tit = "<a href=\"?pge=$uid\">$tit</a>";
}

?>
<div class="toc mnu lev1" style="margin-top: -5px;">
<?php echo $tit; ?>
</div>
