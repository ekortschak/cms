<?php

if (! STR::features("view.pres.toc", VMODE)) return;
if (TAB_TYPE == "sel") return;

// ***********************************************************
$ini = new ini(TAB_HOME);
$tit = $ini->getTitle();
$uid = $ini->getUID();

// ***********************************************************
$tit = HTM::href("?pge=$uid", $tit);

$sel = ""; if (TAB_HOME == PGE::$dir)
$sel = "sel";

?>

<div class="toc mnu topic <?php echo $sel; ?>">
<?php echo $tit; ?>
</div>