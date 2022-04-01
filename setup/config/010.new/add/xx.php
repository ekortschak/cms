<?php

incCls("input/selector.php");

$sel = new selector();
$dir = $sel->input("dir.new", "project1");
$act = $sel->show();

if (! $act) return;

// ***********************************************************
// define dirs
// ***********************************************************
$app = rtrim(APP_DIR, DIR_SEP);
$cms = rtrim(APP_FBK, DIR_SEP);
$top = dirname($app);
$dir = FSO::join($top, $dir);

FSO::force($dir);

// ***********************************************************
// copy files from CMS
// ***********************************************************
FSO::copy("$cms/index.php",  "$dir/index.php");
FSO::copy("$cms/config.php", "$dir/config.php");
FSO::copy("$cms/x.edit.php", "$dir/x.edit.php");
FSO::copy("$cms/x.sync.php", "$dir/x.sync.php");
FSO::copy("$cms/x.css.php",  "$dir/x.css.php");
FSO::copy("$cms/robots.txt", "$dir/robots.txt");

FSO::copyDir("$cms/config", $dir);

// ***********************************************************
// copy pages from CMS
// ***********************************************************
FSO::copyDir("$cms/pages/home", "$dir/pages");

?>
