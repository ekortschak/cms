<?php

// ***********************************************************
HTW::xtag("files.kill");
// ***********************************************************
$fil = ENV::getParm("dpf");
$fil = APP::file($fil);

if ($fil) {
	FSO::kill($dst);
}

$app = FSO::files(APP_DIR);
$cnt = 0;

foreach ($app as $fil => $nam) {
	if (STR::contains($nam, "index.php"))  continue;
	if (STR::contains($nam, "x.css.php"))  continue;

	HTW::button("?dpf=$fil", $nam);
	$cnt++;
}

if ($cnt < 1) {
	echo DIC::get("no.deletable");
	return;
}

?>
