<?php

$ini = new ini(TAB_HOME);
$tit = $ini->getTitle();
$uid = $ini->getUID();

// ***********************************************************
$tit = HTM::href("?pge=$uid", $tit);
$cur = ENV::getPage();

$sel = ""; if ($cur == TAB_HOME)
$sel = "sel";

?>

<div class="toc mnu lev1 <?php echo $sel; ?>">
<?php echo $tit; ?>
</div>
