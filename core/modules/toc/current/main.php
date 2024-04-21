<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
# if (APP::isView())
# if (TAB_TYPE == "sel") return;

// ***********************************************************
$ini = new ini(TAB_HOME);
$tit = $ini->title();
$uid = $ini->UID();

// ***********************************************************
$tit = HTM::href("?pge=$uid", $tit);
$loc = PGE::dir();

$sel = ""; if (TAB_HOME == $loc)
$sel = "sel";

?>

<div class="toc mnu topic <?php echo $sel; ?>">
<?php echo $tit; ?>
</div>
