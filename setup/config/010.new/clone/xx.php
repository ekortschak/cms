<?php

incCls("input/selector.php");

$sel = new selector();
$dir = $sel->input("prj.new", "project1");
$xxx = $sel->info("prj.tpl", APP_NAME);
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
// copy files from app
// ***********************************************************
FSO::copy("$app/index.php",  "$dir/index.php");
FSO::copy("$app/config.php", "$dir/config.php");
FSO::copy("$app/x.edit.php", "$dir/x.edit.php");
FSO::copy("$app/x.sync.php", "$dir/x.sync.php");
FSO::copy("$app/x.css.php",  "$dir/x.css.php");
FSO::copy("$app/robots.txt", "$dir/robots.txt");

FSO::copyDir("$app/config",  $dir);
FSO::copyDir("$app/design",  $dir);

FSO::copyDir("$app/core/classes", "$dir/core");
FSO::copyDir("$app/core/modules", "$dir/core");
FSO::copyDir("$app/core/include", "$dir/core");

// ***********************************************************
// copy pages from CMS
// ***********************************************************
FSO::copyDir("$cms/pages/home", "$dir/pages");

?>
