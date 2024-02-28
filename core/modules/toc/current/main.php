<?php

if (PFS::isView())
if (TAB_TYPE == "sel") return;

DBG::file(__FILE__);

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
